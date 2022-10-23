<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <livewire:dashboard 
        :divisionAll="$divisionAll" 
        :divisionFiltered="$divisionFiltered"
        :customerAll="$customerAll"
        :customerFiltered="$customerFiltered"
        :repAll="$repAll"
        :repFiltered="$repFiltered"
    />
</x-app-layout>
