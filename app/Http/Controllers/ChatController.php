<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a list of chat
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chat');
    }

    /**
     * Get list of user messages
     * 
     * @return \Illuminate\Http\Response
     */
    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    /**
     * Send message to user
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendMessage(Request $request)
    {
        $user = auth()->user();
        $message = $user->messages()->create($request->all());

        if ($message) {
            broadcast(new MessageSent ($user, $message))->toOthers();
            
            return response([
                'success' => true,
                'message' => 'Message Sent!' 
            ]);
        }

        return response([
            'success' => false,
            'message' => 'Message Not Sent!' 
        ]);
    }
}
