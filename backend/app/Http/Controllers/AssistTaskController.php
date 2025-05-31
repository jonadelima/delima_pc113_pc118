<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssistTask;
use Illuminate\Support\Facades\Storage;

class AssistTaskController extends Controller
{
    // GET: /api/tasks
    public function index()
    {
        return AssistTask::all();
    }

    // POST: /api/tasks
    public function store(Request $request)
    {
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

        $task = AssistTask::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'subject'      => $request->subject,
            'type'         => $request->type,
            'assigned_to'  => $request->assigned_to,
            'due_date'     => $request->due_date,
            'file'         => $filePath,
        ]);

        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    }

    // PUT or POST: /api/tasks/{id}
    public function update(Request $request, $id)
    {
        $task = AssistTask::findOrFail($id);

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
    }

    // DELETE: /api/tasks/{id}
    public function destroy($id)
    {
        $task = AssistTask::findOrFail($id);

        // Delete file if exists
        if ($task->file && Storage::disk('public')->exists($task->file)) {
            Storage::disk('public')->delete($task->file);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }

}
      