<div>
    <div>
        <label>
            Exclude past appointments
            <input type="checkbox" wire:model="filtered" />
        </label>
    </div>
    <div class="flex flex-wrap spacing-y-4 md:spacing-y-0">
        <div class="w-full md:w-1/3 px-2">
            <p class="font-bold">Appointments by Division</p>
            @php
                $divisionItems = $filtered ? $divisionFiltered : $divisionAll;
            @endphp
            @foreach($divisionItems as $item)
                <p>{{$item->first_level_division}}: {{$item->numAppointments}}</p>
            @endforeach
        </div>
        <div class="w-full md:w-1/3 px-2">
            <p class="font-bold">Customer with most Appointments</p>
            @php
                $customerItem = $filtered ? $customerFiltered[0] : $customerAll[0];
            @endphp
            <p>{{$customerItem->first_name . ' ' . $customerItem->last_name}}: {{$customerItem->numAppointments}}</p>
        </div>
        <div class="w-full md:w-1/3 px-2">
            <p class="font-bold">Representative with most Appointments</p>
            @php
                $repItem = $filtered ? $repFiltered[0] : $repAll[0];
            @endphp
            <p>{{$repItem->name}}: {{$repItem->numAppointments}}</p>
        </div>
    </div>
</div>
