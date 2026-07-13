<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
},    ['guards' => ['sanctum']]);


Broadcast::channel('private-channel.user.{id}', function ($user, $id) {
    Log::info('test', ['message' => $user->id]);
    return $user->id == $id;
}, [
    'guards' => ['sanctum']
]);
Broadcast::channel('presence-channel.session.{id}', function ($user, $id) {
    Log::info('test', ['message' => $user->id]);
    return [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        // Add any other user data you want available in the presence channel
    ];
}, [
    'guards' => ['sanctum']
]);
