<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Message;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $sentTo = User::findOrFail($id);
        $senderId = auth()->user()->id;

        $messages = Message::where(function($query) use ($senderId, $sentTo) {
            $query->where('sender_id', $senderId)
                  ->where('sent_to_id', $sentTo->id);
        })->orWhere(function ($query) use ($senderId, $sentTo) {
            $query->where('sender_id', $sentTo->id)
                  ->where('sent_to_id', $senderId);
        })->get();

        return Inertia::render('Messages/Index', [
            'sentTo' => $sentTo,
            'messages' => $messages,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        Message::create([
            'sender_id' => auth()->user()->id,
            'sent_to_id' => $user->id,
            'message' => $request->message,
        ]);

        return redirect()->back();
    }
}
