<?php

namespace App\Http\Controllers;

use App\Models\Message;
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

        if ($request->filled('parent_id')) {
            return back()->with('status', 'reply-posted');
        }

        return redirect(route('dashboard'));
    }
}
