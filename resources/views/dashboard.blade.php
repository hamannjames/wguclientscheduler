<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $reps = \Services\Helpers\RoleHelper::getRepresentatives();
    @endphp
    @foreach($reps as $rep)
        <p>{{base64_encode(Illuminate\Support\Facades\Hash::make($rep->email))}}</p>
    @endforeach
</x-app-layout>
