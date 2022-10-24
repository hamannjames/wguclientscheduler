<div class="flex flex-wrap space-y-4 lg:space-y-0">
    <div class="flex flex-col gap-4 w-full lg:w-1/3 p-0 md:px-2">
        <div class="p-4 bg-white rounded-xl shadow-md flex flex-col gap-4 h-full">
            <label class="relative font-bold block">
                Title <span class="text-red-500">*</span>
                <input class="block w-full font-normal" wire:model="appointment.title" type="text" />
                <div class="absolute top-full text-sm text-red-500 left-0">@error('appointment.title'){{$message}}@enderror</div>
            </label>
            <label class="relative font-bold">
                Description <span class="text-red-500">*</span>
                <textarea rows="5" class="block w-full font-normal" wire:model="appointment.description"></textarea>
                <div class="absolute top-full text-sm text-red-500 left-0">@error('appointment.description'){{$message}}@enderror</div>
            </label>
            <label class="relative font-bold">
                Type <span class="text-red-500">*</span>
                <select wire:model="appointment.type" class="block font-normal w-1/2">
                    @foreach(array_column(\Database\Enums\MeetingTypes::cases(), 'value') as $type)
                        <option value="{{$type}}">{{$type}}</option>
                    @endforeach
                </select>
                <div class="absolute top-full text-sm text-red-500 left-0">@error('appointment.type'){{$message}}@enderror</div>
            </label>
            <div class="flex gap-4">
                <label class="relative w-full font-bold">
                    Customer <span class="text-red-500">*</span>
                    @if($appointment->id)
                        <input class="block w-full text-gray-500 font-normal italic" type="text" value="{{$appointment ? $appointment->customer->fullName() : ''}}" disabled />
                    @else
                    <select class="w-full font-normal" wire:model="otherCustomer" class="block font-normal" wire:change="onRepChanged">
                        @foreach($customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->fullName()}}</option>
                        @endforeach
                    </select>
                    @endif
                </label>
                <label class="relative w-full font-bold">
                    Representative <span class="text-red-500">*</span>
                    <select class="w-full font-normal" wire:model="otherRep" class="block font-normal" wire:change="onRepChanged">
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                    <div class="absolute top-full text-sm text-red-500 left-0">@error('appointment.user_id'){{$message}}@enderror</div>
                </label>
            </div>
        </div>
    </div>
    <div class="w-full lg:w-1/3 px-0 md:px-2">
        <div class="p-4 bg-white rounded-xl shadow-md flex flex-col gap-4 h-full">
            <script>
                let max = new Date();
                max.setMonth(max.getMonth() + 3);
            </script>
            <label class="font-bold">
                Date <span class="text-red-500">*</span>
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
                            toString: (date, format) => date.toDateString() + ' ' + Intl.DateTimeFormat().resolvedOptions().timeZone,
                            parse: (date, format) => {
                                if (isNaN(Date.parse(date))) {
                                    date = (new Date()).toDateString() + ' ' + Intl.DateTimeFormat().resolvedOptions().timeZone
                                    console.log(date);
                                }

                                return date;
                            }
                        });
                    "
                    type="text"
                    wire:model.lazy="otherStart"
                    wire:change="onDateChange"
                    class="block w-full font-normal relative"
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
            <div class="flex gap-4 w-full">
                <label class="font-bold w-full">
                    Start <span class="text-red-500">*</span>
                    <select wire:model="startHour" class="w-full font-normal">
                        @for($i = 0; $i < 9; $i++)
                            <option value="{{$hoursStart->format($tdf)}}">{{$hoursStart->format($tdf)}}</option>
                            {{$hoursStart->addHour()}}
                        @endfor
                    </select>
                </label>
                @php
                    $hoursStart = \Services\Helpers\TimeHelper::get()->getBusinessStart();
                @endphp
                <label class="font-bold w-full">
                    End <span class="text-red-500">*</span>
                    <select wire:model="endHour" class="w-full font-normal">
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
    </div>
    <div class="w-full lg:w-1/3 p-0 md:px-2">
        <div class="p-4 bg-white rounded-xl shadow-md flex flex-col gap-4 h-full">
            <p>Potential Conflicts:</p>
            @forelse($otherAppointments as $appointment)
                <div class="{{$loop->index % 2 === 0 ? 'bg-gray-200' : ''}} p-2">
                    {{Str::limit($appointment->title, 20)}}: 
                    {{\Services\Helpers\TimeHelper::get()->fromStringToUserObject($appointment->start)->format('g A')}} -
                    {{\Services\Helpers\TimeHelper::get()->fromStringToUserObject($appointment->end)->format('g A')}}
                </div>
            @empty
                <div>No other appointments that day</div>
            @endforelse
        </div>
    </div>
    <livewire:delete-modal />
</div>
