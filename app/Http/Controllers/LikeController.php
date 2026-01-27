<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Notifications\NewLike;

class LikeController extends Controller
{
    public function toggle(Message $message)
    {
        $user = auth()->user();
        
        $like = $message->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
        } else {
            $like = $message->likes()->create([
                'user_id' => $user->id
            ]);

            if ($message->user_id !== $user->id) {
                $message->user->notify(new NewLike($like));
            }
        }

        return back();
    }
}
