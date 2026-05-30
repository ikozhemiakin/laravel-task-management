<?php

declare(strict_types=1);

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tasks');

Route::resource('projects', ProjectController::class)->except(['show']);

Route::patch('tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');
Route::resource('tasks', TaskController::class)->except(['show']);
