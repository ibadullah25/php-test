<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function showTasks(){
        return response()->json(Task::all());
    }

    public function createTask(Request $request){
        $validated = $request->validate([
            'name' => 'required|min:3|max:100',
            'description' => 'required|min:10|max:5000',
        ]);

        // Generate a secure token for the task
        $validated['secure_token'] = \Str::random(32); // Laravel helper for generating random string

        // Generate a secure token for the task
        $task = Task::create($validated);

        return response()->json($task, 201);
    }

    public function updateTask(Request $request, $id){
        $task = Task::findOrFail($id);

        // Validate the secure_token
        if ($task->secure_token !== $request->secure_token) {
            return response()->json(['error' => 'Unauthorized'], 403); // Unauthorized if tokens don't match
        }

        $validated = $request->validate([
            'name' => 'required|min:3|max:100',
            'description' => 'required|min:10|max:5000',
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    // Delete a task
    public function deleteTask(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // Validate the secure_token
        if ($task->secure_token !== $request->secure_token) {
            return response()->json(['error' => 'Unauthorized'], 403); // Unauthorized if tokens don't match
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
