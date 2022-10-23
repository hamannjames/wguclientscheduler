<div {{$attributes->merge(['class'])}}>
    @php
        $users = \App\Models\Role::with('users')
            ->firstWhere('name', 'Representative')
            ->users;
    @endphp
    <select wire:model="user" wire:change="onUserChange">
        <option value="">Choose a user</option>
        @foreach($users as $user)
            <option value="{{$user->id}}">{{$user->name}}</option>
        @endforeach
    </select>
</div>