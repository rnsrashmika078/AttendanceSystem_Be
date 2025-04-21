<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('private-user.{chatId}', function ($user, $id) {
    Log::info('test', (['message' => $user->id]));
    return $user->id == $id;
});