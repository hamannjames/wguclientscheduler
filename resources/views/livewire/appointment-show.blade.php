<div class="flex gap-4">
    <div class="flex flex-col gap-4 w-112 max-w-full">
        <label class="relative">
            Title
            <input class="block w-full" wire:model="appointment.title" type="text" />
            <div class="absolute top-full text-sm text-red-500 left-0">@error('appointment.title'){{$message}}@enderror</div>
        </label>
        <label class="relative">
            Description
            <textarea rows="5" class="block w-full" wire:model="appointment.description"></textarea>
            <div class="absolute top-full text-sm text-red-500 left-0">@error('appointment.description'){{$message}}@enderror</div>
        </label>
        <label class="relative">
            Type
            <select wire:model="appointment.type" class="block">
                @foreach(array_column(\Database\Enums\MeetingTypes::cases(), 'value') as $type)
                    <option value="{{$type}}">{{$type}}</option>
                @endforeach
            </select>
            <div class="absolute top-full text-sm text-red-500 left-0">@error('appointment.type'){{$message}}@enderror</div>
        </label>
        <div class="flex gap-4">
            <label class="relative w-full">
                Customer
                @if($appointment->id)
                    <input class="block w-full" type="text" value="{{$appointment ? $appointment->customer->fullName() : ''}}" disabled />
                @else
                <select class="w-full" wire:model="otherCustomer" class="block" wire:change="onRepChanged">
                    @foreach($customers as $customer)
                        <option value="{{$customer->id}}">{{$customer->fullName()}}</option>
                    @endforeach
                </select>
                @endif
            </label>
            <label class="relative w-full">
                Representative
                <select class="w-full" wire:model="otherRep" class="block" wire:change="onRepChanged">
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
                <div class="absolute top-full text-sm text-red-500 left-0">@error('appointment.user_id'){{$message}}@enderror</div>
            </label>
        </div>
    </div>
    <div class="space-y-4 w-112 max-w-full">
        <script>
            let max = new Date();
            max.setMonth(max.getMonth() + 3);
        </script>
        <label>
            Date
            <input
                id="date-picker"
                x-data
                x-ref="input"
                x-init="
                    new Pikaday({ 
                        field: $refs.input, 
                        disableWeekends:true,
                        maxDate: max,
                        showDaysInNextAndPreviousMonths: true,
                        enableSelectionDaysInNextAndPreviousMonths: true,
                        toString: (date, format) => date.toDateString() + ' ' + Intl.DateTimeFormat().resolvedOptions().timeZone
                    });
                "
                type="text"
                wire:model.lazy="otherStart"
                wire:change="onDateChange"
                class="block w-full"
            >
        </label>
        @php
            $timeHelp = \Services\Helpers\TimeHelper::get();
            $format = $timeHelp->getTimeDisplayFormat();
            $hoursStart = $timeHelp->getBusinessStart();
            $businessStart = $hoursStart->copy()->format($format);
            $businessEnd = $timeHelp->getBusinessEnd()->format($format);
            $tdf = \Services\Helpers\TimeHelper::get()->getTimeDisplayFormat();
        @endphp
        <div class="flex gap-4">
            <label>
                Start
                <select wire:model="startHour" class="w-full">
                    @for($i = 0; $i < 9; $i++)
                        <option value="{{$hoursStart->format($tdf)}}">{{$hoursStart->format($tdf)}}</option>
                        {{$hoursStart->addHour()}}
                    @endfor
                </select>
            </label>
            @php
                $hoursStart = \Services\Helpers\TimeHelper::get()->getBusinessStart();
            @endphp
            <label>
                End
                <select wire:model="endHour" class="w-full">
                    @for($i = 0; $i < 9; $i++)
                        <option value="{{$hoursStart->format($tdf)}}">{{$hoursStart->format($tdf)}}</option>
                        {{$hoursStart->addHour()}} 
                    @endfor
                </select>
            </label>
        </div>
        <p>Meetings cannot overlap with other meetings (see potential conflicts).</p>
        <p>Meetings cannot extend past 3 hours</p>
        <p>Meetings must be between {{$businessStart}} and {{$businessEnd}}.</p>
        <p>Times are shows in {{$timeHelp->getUserTimeZone()}}. If this is not your timezone, try refreshing your browser.</p>
        <div class="text-red-500">@error('otherStart'){{$message}}@enderror</div>
        <div class="text-red-500">@error('endHour'){{$message}}@enderror</div>
        <div class="text-red-500">@error('endTime'){{$message}}@enderror</div>
    </div>
    <div class="space-y-2">
        <p>Potential Conflicts:</p>
        @forelse($otherAppointments as $appointment)
            <div>
                {{Str::limit($appointment->title)}}: 
                {{\Services\Helpers\TimeHelper::get()->fromStringToUserObject($appointment->start)->format('g A')}} -
                {{\Services\Helpers\TimeHelper::get()->fromStringToUserObject($appointment->end)->format('g A')}}
            </div>
        @empty
            <div>No other appointments that day</div>
        @endforelse
    </div>
    <livewire:delete-modal />
</div>
