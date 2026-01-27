<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $users = collect();
        $messages = collect();

        if ($query) {
            $users = User::where('name', 'LIKE', "%{$query}%")
                ->limit(5)
                ->get();

            $messages = Message::whereNull('parent_id')
                ->where('content', 'LIKE', "%{$query}%")
                ->with(['user', 'likes', 'replies'])
                ->latest()
                ->get();
        }

        return view('search.index', [
            'users' => $users,
            'messages' => $messages,
            'query' => $query
        ]);
    }
}
