<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $rep ? $rep->name : 'New Representative' }}
        </h2>

        <div class="ml-auto flex gap-2">
            <livewire:save-button :model="$rep" />
            <livewire:delete-button :model="$rep" message="All their appointments will also be deleted" />
        </div>
    </x-slot>

    <livewire:rep-show :rep="$rep" />
</x-app-layout>