<div class="flex gap-4 flex-wrap">
    <div class="w-full md:w-5/12">
        <div class="p-4 bg-white rounded-xl shadow-sm flex flex-col gap-4">
            <div class="flex gap-4">
                <label class="relative font-bold w-full">
                    First Name 
                    <input class="block font-normal w-full" wire:model="customer.first_name" type="text" />
                    <div class="absolute top-full text-sm text-red-500 left-0">@error('customer.first_name'){{$message}}@enderror</div>
                </label>
                <label class="relative font-bold w-full">
                    Last Name 
                    <input class="block font-normal w-full" wire:model="customer.last_name" type="text" />
                    <div class="absolute top-full text-sm text-red-500 left-0">@error('customer.last_name'){{$message}}@enderror</div>
                </label>
            </div>
            <label class="relative font-bold">
                Email
                <input class="block font-normal w-full" wire:model="customer.email" type="text" />
                <div class="absolute top-full text-sm text-red-500 left-0">@error('customer.email'){{$message}}@enderror</div>
            </label>
            <label class="relative font-bold">
                Street
                <input class="block font-normal w-full" wire:model="customer.street_1" type="text" />
            </label>
            <label class="relative font-bold">
                Street (cont.)
                <input class="block font-normal w-full" wire:model="customer.street_2" type="text" />
            </label>
            <div class="flex gap-4">
                <label class="relative w-full font-bold">
                    City
                    <input class="block font-normal w-full" wire:model="customer.city" type="text" />
                </label>
                <label class="relative w-full font-bold">
                    State
                    <select wire:model="customer.state" class="block font-normal w-full" wire:change="onStateChange">
                        @foreach(array_column(\Database\Enums\States::cases(), 'value') as $state)
                            <option value="{{$state}}">{{$state}}</option>
                        @endforeach
                    </select>
                    <div class="absolute top-full text-sm text-red-500 left-0">@error('customer.state'){{$message}}@enderror</div>
                </label>
            </div>
            <div class="flex gap-4">
                <label class="relative w-full font-bold">
                    Postal Code
                    <input class="block font-normal w-full" wire:model="customer.postal_code" type="text" />
                </label>
                <label class="relative w-full font-bold">
                    Division
                    <input wire:model="first_level_division" class="block text-gray-500 italic font-normal w-full" type="text" disabled value="{{\Database\Enums\States::from($customer->state)->firstLevelDivision()}}"/>
                    <div class="absolute top-full text-sm text-red-500 left-0">@error('customer.first_level_division'){{$message}}@enderror</div>
                </label>
            </div>
            <label class="relative font-bold">
                Company
                <select wire:model="customer.company_id" class="block font-normal w-full">
                    <option value="">No Company</option>
                    @foreach($companies as $company)
                        <option value="{{$company->id}}">{{$company->name}}</option>
                    @endforeach
                </select>
                <div class="absolute top-full text-sm text-red-500 left-0">@error('customer.company_id'){{$message}}@enderror</div>
            </label>
        </div>
    </div>
    <div class="w-full md:w-5/12">
        <div class="p-4 bg-white rounded-xl shadow-sm flex flex-col gap-4">
            <p class="font-bold">Appointments</p>
            @if($appointments && $appointments->count())
            <div class="grid" style="grid-template-columns: repeat(2, auto);">
                <div class="font-bold bg-gray-200 p-2">Title</div>
                <div class="font-bold bg-gray-200 p-2">Date</div>
                @foreach($appointments as $a)
                    <div class="bg-{{$loop->index % 2 == 0 ? 'white' : '-gray-200'}} p-2">
                        {{Str::limit($a->title, 30)}}
                    </div>
                    <div class="bg-{{$loop->index % 2 == 0 ? 'white' : '-gray-200'}} p-2">
                        {{\Carbon\Carbon::parse($a->start)->format('D M d g A')}}
                    </div>
                @endforeach
                </div>
            @else
                <p>No appointments yet</p>
            @endif
            </div>
    </div>
    <livewire:delete-modal />
</div>
