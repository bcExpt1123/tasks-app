<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a list of the user's tasks in descending order of creation.
     */
    public function index(Request $request): View
    {
        return view('tasks.index', [
            'tasks' => $request->user()->tasks()->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(): View
    {
        return view('tasks.edit', [
            'task' => null,
        ]);
    }

    /**
     * Store a newly created task with validated data, linked to the authenticated user.
     */
    public function store(TaskRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $request->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->banner('Task created');
    }

    /**
     * Display a specific task's details.
     *  (Currently unused but reserved for future functionality)
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing a specific task, authorized for the current user.
     */
    public function edit(Task $task): View
    {
        Gate::authorize('update', $task);

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified task with validated data, if authorized for the current user.
     */
    public function update(TaskRequest $request, Task $task): RedirectResponse
    {
        Gate::authorize('update', $task);

        $validated = $request->validated();

        $task->update($validated);

        return redirect()->route('tasks.index')->banner('Task updated');
    }

    /**
     * Delete the specified task, if authorized for the current user.
     */
    public function destroy(Task $task): RedirectResponse
    {
        Gate::authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')->banner('Task deleted');
    }

    /**
     * Toggle the completion status of a task, if authorized for the current user.
     */
    public function toggleCompletion(Task $task): RedirectResponse
    {
        Gate::authorize('update', $task);

        $task->update(['is_completed' => ! $task->is_completed]);

        return redirect()->route('tasks.index')->banner('Task updated');
    }
}
