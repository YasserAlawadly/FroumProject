<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelId ,Thread $thread)
    {
        \request()->validate([
            'body' => 'required'
        ]);

        $thread->replies()->create([
            'body' => \request('body'),
            'user_id' => auth()->id(),
        ]);

        return redirect($thread->path());
    }
}
