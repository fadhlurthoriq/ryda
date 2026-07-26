<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Daftar semua percakapan (baik sebagai pembeli maupun penjual)
    public function index() {
        $userId = Auth::id();

        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['vehicle', 'sender', 'receiver'])
            ->latest()
            ->get()
            ->groupBy(function ($message) use ($userId) {
                $otherUserId = $message->sender_id === $userId
                    ? $message->receiver_id
                    : $message->sender_id;

                return $message->vehicle_id . '-' . $otherUserId;
            })
            ->map(function ($group) use ($userId) {
                $lastMessage = $group->first();

                $otherUser = $lastMessage->sender_id === $userId
                    ? $lastMessage->receiver
                    : $lastMessage->sender;

                return (object) [
                    'vehicle'      => $lastMessage->vehicle,
                    'otherUser'    => $otherUser,
                    'lastMessage'  => $lastMessage,
                    'unreadCount'  => $group->where('receiver_id', $userId)->whereNull('read_at')->count(),
                ];
            })
            ->sortByDesc(fn ($conv) => $conv->lastMessage->created_at)
            ->values();

        return view('messages.index', compact('conversations'));
    }

    // Halaman chat 1 thread: kendaraan tertentu + lawan bicara tertentu
    public function show(Vehicle $vehicle, int $otherUserId)
    {
        $userId = Auth::id();

        $messages = Message::where('vehicle_id', $vehicle->id)
            ->where(function ($q) use ($userId, $otherUserId) {
                $q->where(function ($q2) use ($userId, $otherUserId) {
                    $q2->where('sender_id', $userId)->where('receiver_id', $otherUserId);
                })->orWhere(function ($q2) use ($userId, $otherUserId) {
                    $q2->where('sender_id', $otherUserId)->where('receiver_id', $userId);
                });
            })
            ->with(['sender', 'receiver'])
            ->oldest()
            ->get();

        // Tandai pesan masuk sebagai sudah dibaca
        Message::where('vehicle_id', $vehicle->id)
            ->where('sender_id', $otherUserId)
            ->where('receiver_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $otherUser = \App\Models\User::findOrFail($otherUserId);

        return view('messages.show', compact('vehicle', 'messages', 'otherUser'));
    }

    // Kirim pesan baru (dipanggil dari halaman detail kendaraan ATAU dari halaman chat)
    public function store(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'body'        => 'required|string|max:1000',
        ]);

        abort_if(
            $validated['receiver_id'] == Auth::id(),
            403,
            'Tidak bisa mengirim pesan ke diri sendiri.'
        );

        $message = Message::create([
            'vehicle_id'  => $vehicle->id,
            'sender_id'   => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'body'        => $validated['body'],
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return redirect()
            ->route('messages.show', ['vehicle' => $vehicle, 'otherUserId' => $validated['receiver_id']]);
    }
}