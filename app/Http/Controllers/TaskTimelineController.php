<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskTimelineController extends Controller
{
    public function store (Request $request, Task $task)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $task->timelines()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return redirect()->route('tasks.show', $task)->with('message', 'Timeline updated!');
    }
}
