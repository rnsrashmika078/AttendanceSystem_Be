<?php

namespace App\Http\Controllers;

use App\Events\PresenceChannelEvent;
use App\Events\PrivateChannelEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WebsocketController extends Controller
{
    public function sendMessage(Request $request)
    {
        $validate = $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
        ]);
        $sender = Auth::user();

        event(new PrivateChannelEvent(
            $request->message,
            $validate['receiver_id'],
            $sender
        ));

        return response()->json([
            "success" => true,
            "message" => "Message sent Successful!",
        ]);
    }
    public function session(Request $request)
    {
        $validate = $request->validate([
            'message' => 'required|string',
            'session_id' => 'required|string',
        ]);
        $sender = Auth::user();

        event(new PresenceChannelEvent(
            $request->message,
            $validate['session_id'],
            $sender
        ));
        Log::info('Session event triggered', [
            'session_id' => $validate['session_id'],
            'user_id' => $sender->id
        ]);
        return response()->json([
            "success" => true,
            "message" => "Message sent Successful!",
        ]);
    }
}
