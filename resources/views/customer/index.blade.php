<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customers') }}
        </h2>

        <div class="ml-auto">
            <a class="btn btn-green" href="{{route('admin.customer.create')}}">New Customer</a>
        </div>
    </x-slot>
    
    <livewire:customer-table :models="$customers" />
    <livewire:delete-modal />
</x-app-layout>