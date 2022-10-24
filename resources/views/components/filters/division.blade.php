<div {{$attributes->merge(['class'])}}>
    @php
        $divisions = collect(\Database\Enums\FirstLevelDivisions::cases())
            ->sortBy(function($d) {
                return $d->value;
            });
    @endphp
    <select wire:model="division" wire:change="onChangeDivision">
        <option value="">Choose a Division</option>
        @foreach($divisions as $division)
            <option value="{{$division->value}}">{{$division->value}}</option>
        @endforeach
    </select>
</div>