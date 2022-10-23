<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $customer ? $customer->fullName() : 'New Customer' }}
        </h2>
        
        <div class="ml-auto flex gap-2">
            <livewire:save-button :model="$customer" />
            <livewire:delete-button :model="$customer" message="All their appointments will also be deleted" />
        </div>
    </x-slot>

    <livewire:customer-show :customer="$customer" />
</x-app-layout>