<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'subject' => 'required|string',
            'type' => 'required|string',
            'assigned_to' => 'required|string',
            'due_date' => 'required|date',
            'file' => 'nullable|file',
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('tasks', 'public');
        }

        $task = Task::create($validated);

        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'subject' => 'required|string',
            'type' => 'required|string',
            'assigned_to' => 'required|string',
            'due_date' => 'required|date',
            'file' => 'nullable|file',
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('tasks', 'public');
        }

        $task->update($validated);

        return response()->json(['message' => 'Task updated successfully', 'task' => $task]);
    }
}
