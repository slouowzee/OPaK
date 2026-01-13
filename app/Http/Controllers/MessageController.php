<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:140',
        ]);

        $request->user()->messages()->create($validated);

        return redirect(route('dashboard'));
    }
}
