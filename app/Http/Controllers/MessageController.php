<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Notifications\UserMentioned;
use App\Notifications\NewReply;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Display a specific message.
     */
    public function show(Message $message): View
    {
        return view('messages.show', [
            'message' => $message->load(['user', 'replies.user'])
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:140',
            'parent_id' => 'nullable|exists:messages,id',
        ]);

        $message = $request->user()->messages()->create($validated);

        // Parsing mentions
        preg_match_all('/@([a-zA-Z0-9_]+)/', $message->content, $matches);
        $usernames = array_unique($matches[1]);

        foreach ($usernames as $username) {
            $user = User::where('name', $username)->first();
            if ($user && $user->id !== auth()->id()) {
                $user->notify(new UserMentioned($message));
            }
        }

        if ($request->filled('parent_id')) {
            $parentMessage = \App\Models\Message::find($request->parent_id);
            if ($parentMessage && $parentMessage->user_id !== auth()->id()) {
                $parentMessage->user->notify(new NewReply($message));
            }
            return back()->with('status', 'reply-posted');
        }

        return redirect(route('dashboard'));
    }
}
