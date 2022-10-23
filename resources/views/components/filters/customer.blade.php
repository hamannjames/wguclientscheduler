<div {{$attributes->merge(['class'])}}>
    @php
        $customers = \App\Models\Customer::all();
    @endphp
    <select wire:model="customer" wire:change="onCustomerChange">
        <option value="">Choose a Customer</option>
        @foreach($customers as $customer)
            <option value="{{$customer->id}}">{{$customer->fullName()}}</option>
        @endforeach
    </select>
</div>