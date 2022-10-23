<div {{$attributes->merge(['class'])}}>
    @php
        $divisions = \Database\Enums\FirstLevelDivisions::cases();
    @endphp
    <select wire:model="division" wire:change="onChangeDivision">
        <option value="">Choose a Division</option>
        @foreach($divisions as $division)
            <option value="{{$division->value}}">{{$division->value}}</option>
        @endforeach
    </select>
</div>