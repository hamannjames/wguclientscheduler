<div class="flex gap-4">
    <div class="flex flex-col gap-4">
        <label class="relative">
            Name
            <input class="block" wire:model="rep.name" type="text" />
            <div class="absolute top-full text-sm text-red-500 left-0">@error('rep.name'){{$message}}@enderror</div>
        </label>
        <label class="relative">
            Email
            <input class="block" wire:model="rep.email" type="text" />
            <div class="absolute top-full text-sm text-red-500 left-0">@error('rep.email'){{$message}}@enderror</div>
        </label>
    </div>
    <livewire:delete-modal />
</div>
