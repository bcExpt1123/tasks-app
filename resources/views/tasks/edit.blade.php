<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
                    <form method="POST" action="{{ $task ? route('tasks.update', $task) : route('tasks.store') }}">
                        @csrf
                        @if($task)
                            @method('patch')
                        @endif
                        <div class="mt-4">
                            <x-label for="title">Title:</x-label>
                            <x-input name="title" id="title" class="w-full mt-2"
                                     :value="old('title', $task?->title)"/>
                            <x-input-error for="title" class="mt-2"/>
                        </div>
                        <div class="mt-4">
                            <x-label for="description">Description:</x-label>
                            <x-textarea name="description" id="description" class="w-full mt-2"
                                        :value="old('description', $task?->description)"/>
                            <x-input-error for="description" class="mt-2"/>
                        </div>
                        <div class="mt-4 flex items-center justify-start gap-x-2">
                            <x-button>{{ __('Save') }}</x-button>
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                               href="{{ route('tasks.index') }}">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
