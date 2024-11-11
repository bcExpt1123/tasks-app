<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tasks') }}
            </h2>
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               href="{{ route('tasks.create') }}">
                {{ __('Create') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg py-4">
                @if ($tasks->isEmpty())
                    <div class="px-4">
                        <p class="text-gray-600">
                            {{ __('No tasks available. Start by creating a new task!') }}
                        </p>
                    </div>
                @else
                    <ul role="list" class="divide-y divide-gray-100">
                        @foreach ($tasks as $task)
                            <li class="flex min-w-0 gap-x-4 p-4">
                                <form method="POST" action="{{ route('tasks.toggle-completion', $task) }}">
                                    @csrf
                                    @method('patch')
                                    <x-checkbox :id="'task'.$task->id" :checked="$task->is_completed"
                                                onchange="this.form.submit()"/>
                                </form>
                                <div class="min-w-0 flex-auto">
                                    <div class="flex items-center justify-between">
                                        <label for="{{ 'task'.$task->id }}"
                                               class="text-sm/6 font-semibold text-gray-900">
                                            {{ $task->title }}
                                        </label>
                                        <p class="text-xs/5 text-gray-500">{{ $task->created_at->format('j M Y, g:i a') }}</p>
                                    </div>
                                    <p class="truncate text-xs/5 text-gray-500">{{ $task->description }}</p>
                                </div>
                                <div class="flex items-center">
                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <button class="p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                     fill="currentColor" aria-hidden="true" data-slot="icon"
                                                     class="h-5 w-5 text-gray-400">
                                                    <path
                                                        d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM11.5 15.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z"></path>
                                                </svg>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('tasks.edit', $task)">
                                                {{ __('Edit') }}
                                            </x-dropdown-link>
                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                                @csrf
                                                @method('delete')
                                                <x-dropdown-link :href="route('tasks.destroy', $task)"
                                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                                    {{ __('Delete') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
