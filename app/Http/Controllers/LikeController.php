<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Message $message)
    {
        $user = auth()->user();
        
        $like = $message->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
        } else {
            $message->likes()->create([
                'user_id' => $user->id
            ]);
        }

        return back();
    }
}
