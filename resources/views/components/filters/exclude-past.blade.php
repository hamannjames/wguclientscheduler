<div {{$attributes->merge(['class'])}}>
    <div class="flex items-center gap-2 relative">
        <p>Exclude Past</p>
        <input wire:model="excludePast" wire:change="onExcludePastChange" type="checkbox" />
    </div>
</div>