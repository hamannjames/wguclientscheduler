<div {{$attributes->merge(['class'])}}>
    @php
        $companies = \App\Models\Company::orderBy('name')->get();
    @endphp
    <select wire:model="company" wire:change="onCompanyChange">
        <option value="">Choose a Company</option>
        @foreach($companies as $company)
            <option value="{{$company->id}}">{{$company->name}}</option>
        @endforeach
    </select>
</div>