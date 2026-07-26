<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load('sender');
    }

    public function broadcastOn(): array
    {
        // Channel unik per-kombinasi kendaraan + 2 user yang chat
        $userIds = [$this->message->sender_id, $this->message->receiver_id];
        sort($userIds);

        return [
            new PrivateChannel('chat.' . $this->message->vehicle_id . '.' . implode('-', $userIds)),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        return [
            'id'         => $this->message->id,
            'body'       => $this->message->body,
            'sender_id'  => $this->message->sender_id,
            'sender_name' => $this->message->sender->name,
            'created_at' => $this->message->created_at->format('H:i'),
        ];
    }
}