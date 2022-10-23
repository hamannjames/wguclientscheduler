<x-app-layout>
    
    <div class="flex items-center justify-center h-full">
        <div class="text-center space-y-2">
            @if(Session::has('appointmentInfo'))
                @php
                    $info = Session::get('appointmentInfo');
                @endphp
                <h2 class="text-xl">Success! Your appointment has been made.</h2>
                <h3 class="text-lg">{{$info['title']}}</h3>
                <p>{{$info['start']}} - {{$info['end']}}</p>
                <p>With {{$info['rep']}}</p>
                <p>To reschedule or cancel this appointment, please email {{$info['email']}}.</p>
                <p>Or, contact us at email@example.com</p>
                <p>Check your inbox for an email confirmation</p>
            @else
                <h2 class="text-xl">Welcome! If you are looking for a calendar, please use your special link.</h2>
                <p>Need a special link? Email us here: email@example.com</p>
            @endif
        </div>
    </div>

    <livewire:toast />
    <livewire:toast-error/>
</x-app-layout>
