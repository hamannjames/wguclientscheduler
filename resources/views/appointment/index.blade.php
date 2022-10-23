<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Appointments') }}
        </h2>

        <div class="ml-auto">
            <a class="btn btn-green" href="{{route('admin.appointment.create')}}">New Appointment</a>
        </div>
    </x-slot>

    <p>Times are shown in {{\Services\Helpers\TimeHelper::get()->getUserTimeZone()}}. If this is not your time zone, try refreshing the page.</p>
    <livewire:appointment-table :models="$appointments" />
    <livewire:delete-modal />
</x-app-layout>