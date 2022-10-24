<div class="flex flex-wrap space-y-4 lg:space-y-0">
    <div class="w-full md:w-1/3 px-0 md:px-2">
        <div class="flex w-full flex-col gap-4 p-4 rounded-xl bg-white h-full">
            <label class="relative font-bold">
                Name
                <input class="block font-normal w-full" wire:model="rep.name" type="text" />
                <div class="absolute top-full text-sm text-red-500 left-0">@error('rep.name'){{$message}}@enderror</div>
            </label>
            <label class="relative font-bold">
                Email
                <input class="block font-normal w-full" wire:model="rep.email" type="text" />
                <div class="absolute top-full text-sm text-red-500 left-0">@error('rep.email'){{$message}}@enderror</div>
            </label>
            @if(!$rep->id)
            <label class="relative font-bold">
                Password
                <input class="block font-normal w-full" wire:model="password" type="text" />
                <div class="absolute top-full text-sm text-red-500 left-0">@error('password'){{$message}}@enderror</div>
            </label>
            @endif
        </div>
    </div>
    <div class="w-full md:w-1/3 px-0 md:px-2">
        <div class="flex w-full flex-col gap-4 p-4 rounded-xl bg-white h-full">
            <p class="font-bold">Appointments</p>
            @if($appointments && $appointments->count() > 0)
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
    <div class="w-full md:w-1/3 px-0 md:px-2">
        <div class="flex w-full flex-col gap-4 p-4 rounded-xl bg-white h-full">
            <p class="font-bold">Special Link:</p>
            @if($rep->id)
                <p class="break-all">/calendar/?key={{base64_encode(Hash::make($rep->email))}}</p>
            @else
            Save to generate
            @endif
        </div>
    </div>
    <livewire:delete-modal />
</div>
