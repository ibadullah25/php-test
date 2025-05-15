<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;

// This block defines endpoints for listing, creating, updating, and deleting tasks.
// Each route is automatically associated with the corresponding method in the TasksController.
Route::controller(TasksController::class)->group(function(){
    Route::get('/tasks', 'showTasks');         // GET request to fetch all tasks
    Route::post('/tasks', 'createTask');      // POST request to create a new task
    Route::put('/tasks/{id}', 'updateTask');    // PUT request to update an existing task by ID
    Route::delete('/tasks/{id}', 'deleteTask'); // DELETE request to remove a task by ID
});