<div class="flex gap-4">
    <div class="flex flex-col gap-4">
        <div class="flex gap-4">
            <label class="relative">
                First Name 
                <input class="block" wire:model="customer.first_name" type="text" />
                <div class="absolute top-full text-sm text-red-500 left-0">@error('customer.first_name'){{$message}}@enderror</div>
            </label>
            <label class="relative">
                Last Name 
                <input class="block" wire:model="customer.last_name" type="text" />
                <div class="absolute top-full text-sm text-red-500 left-0">@error('customer.last_name'){{$message}}@enderror</div>
            </label>
        </div>
        <label class="relative">
            Email
            <input class="block" wire:model="customer.email" type="text" />
            <div class="absolute top-full text-sm text-red-500 left-0">@error('customer.email'){{$message}}@enderror</div>
        </label>
        <label class="relative">
            Street
            <input class="block" wire:model="customer.street_1" type="text" />
        </label>
        <label class="relative">
            Street (cont.)
            <input class="block" wire:model="customer.street_2" type="text" />
        </label>
        <div class="flex gap-4">
            <label class="relative">
                City
                <input class="block" wire:model="customer.city" type="text" />
            </label>
            <label class="relative">
                State
                <select wire:model="customer.state" class="block">
                    @foreach(array_column(\Database\Enums\States::cases(), 'value') as $state)
                        <option value="{{$state}}">{{$state}}</option>
                    @endforeach
                </select>
                <div class="absolute top-full text-sm text-red-500 left-0">@error('customer.state'){{$message}}@enderror</div>
            </label>
        </div>
        <div class="flex gap-4">
            <label class="relative">
                Postal Code
                <input class="block" wire:model="customer.postal_code" type="text" />
            </label>
            <label class="relative">
                Division
                <input class="block text-gray-500 italic" type="text" disabled value="{{\Database\Enums\States::from($customer->state)->firstLevelDivision()}}"/>
                <div class="absolute top-full text-sm text-red-500 left-0">@error('customer.first_level_division'){{$message}}@enderror</div>
            </label>
        </div>
        <label class="relative">
            Company
            <select wire:model="customer.company_id" class="block">
                <option value="">No Company</option>
                @foreach($companies as $company)
                    <option value="{{$company->id}}">{{$company->name}}</option>
                @endforeach
            </select>
            <div class="absolute top-full text-sm text-red-500 left-0">@error('customer.company_id'){{$message}}@enderror</div>
        </label>
    </div>
    <livewire:delete-modal />
</div>
