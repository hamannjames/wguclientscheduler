<div class="space-y-2">
    <div>
        <label class="px-2">
            Exclude past appointments
            <input type="checkbox" wire:model="filtered" wire:change="onFilteredChange" />
        </label>
    </div>
    <div class="flex flex-wrap space-y-4 md:space-y-0">
        <div class="w-full md:w-1/3 px-2">
            <div class="w-full bg-white p-4 rounded-xl shadow-sm h-full">
                <p class="font-bold">Appointments by Division</p>
                @php
                    $divisionItems = $filtered ? $divisionFiltered : $divisionAll;
                @endphp
                @foreach($divisionItems as $item)
                    @if($wasFiltered)
                        <p>{{$item['first_level_division']}}: {{$item['numAppointments']}}</p>
                    @else
                        <p>{{$item->first_level_division}}: {{$item->numAppointments}}</p>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="w-full md:w-1/3 px-2">
            <div class="w-full bg-white p-4 rounded-xl shadow-sm h-full">
                <p class="font-bold">Customer with most Appointments</p>
                @php
                    $customerItem = $filtered ? $customerFiltered[0] : $customerAll[0];
                @endphp
                @if($wasFiltered)
                    <p>{{$customerItem['first_name'] . ' ' . $customerItem['last_name']}}: {{$customerItem['numAppointments']}}</p>
                @else
                    <p>{{$customerItem->first_name . ' ' . $customerItem->last_name}}: {{$customerItem->numAppointments}}</p>
                @endif
            </div>
        </div>
        <div class="w-full md:w-1/3 px-2">
            <div class="w-full bg-white p-4 rounded-xl shadow-sm h-full">
                <p class="font-bold">Representative with most Appointments</p>
                @php
                    $repItem = $filtered ? $repFiltered[0] : $repAll[0];
                @endphp
                @if($wasFiltered)
                    <p>{{$repItem['name']}}: {{$repItem['numAppointments']}}</p>
                @else
                    <p>{{$repItem->name}}: {{$repItem->numAppointments}}</p>
                @endif
            </div>
        </div>
    </div>
</div>
