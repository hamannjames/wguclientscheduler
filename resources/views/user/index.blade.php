<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Representatives') }}
        </h2>
    </x-slot>

    <livewire:rep-table :models="$reps" />
    <livewire:delete-modal />
</x-app-layout>