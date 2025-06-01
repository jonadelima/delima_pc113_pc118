<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Task;

class TaskController extends Controller
{
    // GET: /api/tasks
    public function index()
{
    try {
        return Task::all();
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to fetch tasks: ' . $e->getMessage()], 500);
    }
}

// POST: /api/tasks
public function store(Request $request)
{
    try {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'subject'      => 'required|string|max:100',
            'type'         => 'required|string|max:50',
            'assigned_to'  => 'required|string|max:255',
            'due_date'     => 'required|date',
            'file'         => 'nullable|file|max:2048',
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('tasks', 'public');
        }

        $task = Task::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'subject'      => $request->subject,
            'type'         => $request->type,
            'assigned_to'  => $request->assigned_to,
            'due_date'     => $request->due_date,
            'file'         => $filePath,
        ]);

        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to create task: ' . $e->getMessage()], 500);
    }
}

// PUT or POST: /api/tasks/{id}
public function update(Request $request, $id)
{
    try {
        $task = Task::findOrFail($id);

        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'subject'      => 'required|string|max:100',
            'type'         => 'required|string|max:50',
            'assigned_to'  => 'required|string|max:255',
            'due_date'     => 'required|date',
            'file'         => 'nullable|file|max:2048',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($task->file && Storage::disk('public')->exists($task->file)) {
                Storage::disk('public')->delete($task->file);
            }
            $filePath = $request->file('file')->store('tasks', 'public');
            $task->file = $filePath;
        }

        $task->update([
            'title'        => $request->title,
            'description'  => $request->description,
            'subject'      => $request->subject,
            'type'         => $request->type,
            'assigned_to'  => $request->assigned_to,
            'due_date'     => $request->due_date,
        ]);

        return response()->json(['message' => 'Task updated successfully', 'task' => $task]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to update task: ' . $e->getMessage()], 500);
    }
}

// DELETE: /api/tasks/{id}
public function destroy($id)
{
    try {
        $task = Task::findOrFail($id);

        if ($task->file && Storage::disk('public')->exists($task->file)) {
            Storage::disk('public')->delete($task->file);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to delete task: ' . $e->getMessage()], 500);
    }
}
}