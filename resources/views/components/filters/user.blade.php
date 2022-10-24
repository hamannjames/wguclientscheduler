<div {{$attributes->merge(['class'])}}>
    @php
        $users = \App\Models\Role::with('users')
            ->firstWhere('name', 'Representative')
            ->users()
            ->orderBy('name')
            ->get();
    @endphp
    <select wire:model="user" wire:change="onUserChange">
        <option value="">Choose a Rep</option>
        @foreach($users as $user)
            <option value="{{$user->id}}">{{$user->name}}</option>
        @endforeach
    </select>
</div>