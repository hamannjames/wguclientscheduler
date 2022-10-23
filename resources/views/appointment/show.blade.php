<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $appointment ? $appointment->title : 'New Appointment' }}
        </h2>
        
        <div class="ml-auto flex gap-2">
            <livewire:save-button :model="$appointment" />
            <livewire:delete-button :model="$appointment" />
        </div>
    </x-slot>

    <livewire:appointment-show :appointment="$appointment" />
</x-app-layout>