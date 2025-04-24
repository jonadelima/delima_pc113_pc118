<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() {
        return Task::all();
    }

    public function store(Request $request) {
        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->assigned_by = 'Admin';  // or get from logged in user
        $task->due_date = $request->due_date;
        $task->save();

        return response()->json(['message' => 'Task added successfully'], 201);
    }

    public function update(Request $request, $id) {
        $task = Task::findOrFail($id);
        $task->update($request->all());
        return response()->json(['message' => 'Task updated successfully']);
    }
    

    public function destroy($id) {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
