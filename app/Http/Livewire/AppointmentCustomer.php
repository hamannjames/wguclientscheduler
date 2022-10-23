<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Customer;
use Database\Enums\States;
use App\Models\Appointment;
use Database\Enums\MeetingTypes;
use Services\Helpers\RoleHelper;
use Services\Helpers\TimeHelper;
use Illuminate\Validation\Rules\Enum;
use Database\Enums\FirstLevelDivisions;

class AppointmentCustomer extends Component
{
    public $appointment;
    public $firstDateChange;
    public $otherAppointments;
    public $otherStart;
    public $startHour;
    public $endHour;
    public $endTime;
    public $first_name;
    public $last_name;
    public $email;
    public $street_1;
    public $street_2;
    public $city;
    public $postal_code;
    public $state;
    public $rep;

    protected $listeners = ['modelWillSave' => 'save'];

    protected function rules() {
        $th = TimeHelper::get();
        $theStart = $this->getCompiledStart();
        $otherAppointments = $this->otherAppointments;
        $theStartHour = $this->startHour;
        $this->endTime = $this->getCompiledEnd();
        return [
            'otherStart' => 'required|date|after:yesterday',
            'startHour' => 'required',
            'endHour' => [
                'required',
                function($attribute, $value, $fail) use ($theStartHour) {
                    $startTime = Carbon::parse($theStartHour);
                    $endTime = Carbon::parse($value);

                    if ($startTime->greaterThanOrEqualTo($endTime)) {
                        $fail('Start time must come before end time');
                    }
                }
            ],
            'endTime' => [
                'required',
                'date',
                function($attribute, $value, $fail) use ($theStart, $otherAppointments) {
                    $th = TimeHelper::get();

                    if (!$th->isBetweenBusinessHours($theStart, $value)) {
                        $fail('Outside of business hours');
                    }

                    if(abs($theStart->diffInHours($value)) > 3) {
                        $fail('Appointment is too long');
                    }

                    foreach($otherAppointments as $a) {
                        $aStart = Carbon::parse($a->start);
                        $aEnd = Carbon::parse($a->end);
                        if (TimeHelper::get()->isOverlap($theStart, $value, $aStart, $aEnd)) {
                            $fail('Overlapping Times');
                        }
                    }
                }
            ],
            'appointment.title' => 'required|min:3',
            'appointment.description' => 'required|min:3|max:500',
            'appointment.type' => new Enum(MeetingTypes::class),
            'appointment.user_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'street_1' => 'nullable',
            'street_2' => 'nullable',
            'city' => 'nullable',
            'postal_code' => 'nullable',
            'state' => new Enum(States::class)
        ];
    }

    public function mount($rep) {
        $th = TimeHelper::get();
        $tdf = $th->getTimeDisplayFormat();
        $this->firstDateChange = true;
        $this->rep = $rep;
        
        $start = $th->getBusinessStart();
        $appointment = new Appointment;
        $appointment->type = MeetingTypes::cases()[0]->value;
        $appointment->start = $start->copy();
        $appointment->end = $start->copy()->addHour();
        $appointment->user_id = $this->rep->id;
        $this->startHour = $start->copy()->format($tdf);
        $this->endHour = $start->copy()->addHour()->format($tdf);

        $this->appointment = $appointment;
        $this->startHour = $th->fromStringToUserObject($this->appointment->start)->format($tdf);
        $this->endHour = $th->fromStringToUserObject($this->appointment->end)->format($tdf);
        $this->otherStart = $th->fromStringToUser($this->appointment->start);
        $this->otherEnd = $th->fromStringToUser($this->appointment->end);
        $this->getOtherAppointments(Carbon::parse($this->appointment->start));
    }

    public function render()
    {
        return view('livewire.appointment-customer');
    }

    public function onDateChange() {
        $this->getOtherAppointments();
    }

    private function getOtherAppointments() {
        $start = Carbon::parse($this->otherStart)->startOfDay();
        
        $this->otherAppointments = Appointment::where('user_id', $this->rep->id)
            ->whereBetween('start', [
                $start->copy()->startOfDay(), 
                $start->copy()->endOfDay()
            ])
            ->get();
    }

    public function save() {
        $this->validate();
        $customer = Customer::firstWhere('email', $this->email);
        if (!$customer) {
            $customer = $this->compileCustomer();
        }
        $this->appointment->customer_id = $customer->id;
        $this->appointment->start = $this->getCompiledStart();
        $this->appointment->end = $this->getCompiledEnd();
        $this->appointment->save();

        $th = TimeHelper::get();
        
        return redirect('/')->with('appointmentInfo', [
            'title' => $this->appointment->title,
            'start' => $th->fromStringToUserObject($this->appointment->start)->format('D M d g A e'),
            'end' => $th->fromStringToUserObject($this->appointment->end)->format('D M d g A e'),
            'rep' => $this->rep->name,
            'email' => $this->rep->email
        ]);
    }

    public function onRepChanged() {
        $this->getOtherAppointments();
    }

    private function getCompiledStart() {
        $th = TimeHelper::get();
        $theStart = Carbon::parse($this->otherStart);
        $theStartHour = Carbon::parse($this->startHour)->format('H');
        $theStart->setHour($theStartHour);
        $theStart->setTimezone($th->getBusinessTimeZone());
        
        return $theStart;
    }

    private function getCompiledEnd() {
        $th = TimeHelper::get();
        $theEnd = Carbon::parse($this->otherStart);
        $theEndHour = Carbon::parse($this->endHour)->format('H');
        $theEnd->setHour($theEndHour);
        $theEnd->setTimezone($th->getBusinessTimeZone());
        
        return $theEnd;
    }

    private function compileCustomer() {
        $customer = new Customer;
        $customer->email = $this->email;
        $customer->first_name = $this->first_name;
        $customer->last_name = $this->last_name;
        $customer->street_1 = $this->street_1;
        $customer->street_2 = $this->street_2;
        $customer->city = $this->city;
        $customer->postal_code = $this->postal_code;
        $customer->state = $this->state;
        $customer->first_level_division = States::from($this->state)->firstLevelDivision();
        $customer->save();

        return $customer;
    }
}
