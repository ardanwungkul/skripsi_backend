<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatMessages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(User $user)
    {

        $messages = ChatMessages::with(['sender', 'receiver'])
            ->where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->get();
        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $message = ChatMessages::create([
            'sender_id' => $request->sender_id,
            'text' => $request->message,
            'receiver_id' => $request->receiver_id ? $request->receiver_id : null
        ]);
        broadcast(new MessageSent($message))->toOthers();
        return response()->json($message);
    }
}
