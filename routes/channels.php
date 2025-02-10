<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('pollEnd-Notification.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
