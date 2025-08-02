<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\TaskTimeline;

class TaskController extends Controller
{
    use AuthorizesRequests;


    public function index()
    {
        $tasks = Task::where('created_by', auth()->id())->latest()->get();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks
        ]);
    }

    public function show(Task $task)
    {
        $task->load(['timelines.user', 'assignee', 'creator']);

        return Inertia::render('Tasks/Show', [
            'task' => $task,
        ]);
    }

    public function create()
    {
        $users = User::all();
        return Inertia::render('Tasks/Create', [
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task = Task::create([
            ...$validated,
            'created_by' => auth()->id(),
        ]);

        // ✅ Create timeline entry
        TaskTimeline::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'message' => 'Task created by ' . auth()->user()->name. 'at '.now()->format('Y-m-d H:i'),
        ]);

        return redirect()->route('tasks.index')->with('message', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        return Inertia::render('Tasks/Edit', [
            'task' => $task
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $this->authorize('task', $task);

        $task->delete();

        return redirect()->route('tasks.index');
    }
}
