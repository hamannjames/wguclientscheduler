<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedule an Appointment') }}
        </h2>

        <div class="ml-auto flex gap-2">
            <livewire:save-button  />
        </div>
    </x-slot>

    <livewire:appointment-customer :rep="$rep" />
</x-app-layout>