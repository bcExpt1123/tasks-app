<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * Test that a user can view the tasks index page.
     */
    public function test_user_can_view_task_index(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('tasks.index'))
            ->assertStatus(200)
            ->assertViewIs('tasks.index');
    }

    /**
     * Test that a user can create a task.
     */
    public function test_user_can_create_task(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('tasks.store'), [
                'title' => 'Test Task',
                'description' => 'Test Task Description',
            ])
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'description' => 'Test Task Description',
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test that a user view a task edit page
     */
    public function test_user_can_view_edit_task_page(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create();

        $this->actingAs($user)
            ->get(route('tasks.edit', $task))
            ->assertStatus(200)
            ->assertViewIs('tasks.edit')
            ->assertSee($task->title);
    }

    /**
     * Test that a user can update a task
     */
    public function test_user_can_edit_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create([
            'title' => 'Test Task',
            'description' => 'Test Task Description',
        ]);

        $this->actingAs($user)
            ->put(route('tasks.update', $task), [
                'title' => 'Test Task Updated',
                'description' => 'Test Task Updated Description',
            ])
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Test Task Updated',
            'description' => 'Test Task Updated Description',
        ]);
    }

    /**
     * Test that a user can delete a task
     */
    public function test_user_can_delete_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create();

        $this->actingAs($user)
            ->delete(route('tasks.destroy', $task))
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    /**
     * Test that a user cannot access another user's task
     */
    public function test_user_cannot_access_another_users_task(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $task = Task::factory()->for($otherUser)->create();

        $this->actingAs($user)
            ->get(route('tasks.edit', $task))
            ->assertForbidden();

        $this->actingAs($user)
            ->patch(route('tasks.update', $task), [
                'title' => 'Test Task Updated',
            ])
            ->assertForbidden();

        $this->actingAs($user)
            ->delete(route('tasks.destroy', $task))
            ->assertForbidden();
    }

    /**
     * Test that a user can toggle the completion status of a task
     */
    public function test_user_can_toggle_task_completion_status(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create([
            'is_completed' => false,
        ]);

        // Toggle completion status to "completed"
        $this->actingAs($user)
            ->patch(route('tasks.toggle-completion', $task))
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => true,
        ]);

        // Toggle completion status back to "not completed"
        $this->actingAs($user)
            ->patch(route('tasks.toggle-completion', $task))
            ->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => false,
        ]);
    }

    /**
     * Test that a user cannot toggle another user's task completion status
     */
    public function test_user_cannot_toggle_another_users_task_completion_status(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $task = Task::factory()->for($otherUser)->create([
            'is_completed' => false,
        ]);

        // Attempt to toggle completion status on another user's task
        $this->actingAs($user)
            ->patch(route('tasks.toggle-completion', $task))
            ->assertForbidden();

        // Ensure the task completion status has not changed
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => false,
        ]);
    }
}
