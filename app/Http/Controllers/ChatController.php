<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Friends;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use App\Events\Message;
class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $senderEmail = $request->senderEmail;
        $chatId = $request->chatId;
        $recieverEmail = $request->recieverEmail;
        $message = $request->message;
        $time = $request->time;
        $username = $request->username;
        $status = $request->status;

        $messages = ChatMessage::create([
            'senderEmail' => $senderEmail,
            'recieverEmail' => $recieverEmail,
            'chatId' => $chatId,
            'message' => $message,
            'username' => $username,
            'status' => $status,
            'time' => $time
        ]);
        if (!$messages) {
            // Log::info("📡 Store message in dB", [
            //     'message' => "error while store message in db",
            //     'chatId' => $chatId,
            // ]);
            return response()->json([
                'message' => "error while store message in db",
                'success' => false
            ]);
        }

        broadcast(new Message($senderEmail, $chatId, $message, $recieverEmail, $time, $username, $status));

        return response()->json(['status' => 'Message sent!']);
    }

    public function retriveOldMessage(Request $request, $id)
    {

        $oldMessages = ChatMessage::where('chatId', $id)->get();

        return response()->json($oldMessages);

    }
    public function retriveNotification(Request $request, $email)
    {

        $oldNotifications = ChatMessage::where('recieverEmail', $email)->get();

        return response()->json($oldNotifications);

    }
    public function addFriend(Request $request)
    {
        $userEmail = $request->userEmail;
        $username = $request->username;
        $recieverEmail = $request->recieverEmail;

        $exist = Friends::where('userEmail', $userEmail)
            ->where('username', $username)
            ->where('recieverEmail', $recieverEmail)
            ->exists();

        if ($exist) {
            return response()->json([
                "sucess" => false,
                'message' => "User Is Already Exist",
            ]);
        }
        $friend = Friends::create([
            'userEmail' => $userEmail,
            'username' => $username, //this will be friend's user name .. not user's username
            'recieverEmail' => $recieverEmail //this will be friend's user name .. not user's username
        ]);
        if (!$friend) {
            return response()->json([
                "sucess" => false,
                'message' => "userEmail and Friend Emails are invalid or missing",
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'user added to the friend list',
        ]);
    }
    public function getAllFriends($email)
    {
        $allFriends = Friends::where('userEmail', $email)->get();
        return response()->json($allFriends);
    }
}
