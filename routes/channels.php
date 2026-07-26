<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{vehicleId}.{userIds}', function ($user, $vehicleId, $userIds) {
    $ids = explode('-', $userIds);

    // User cuma boleh "dengerin" channel ini kalau dia salah satu dari 2 orang yang terlibat
    return in_array((string) $user->id, $ids);
});