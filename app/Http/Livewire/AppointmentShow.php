<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Appointment;
use Database\Enums\MeetingTypes;
use Services\Helpers\RoleHelper;
use Services\Helpers\TimeHelper;
use Illuminate\Validation\Rules\Enum;

class AppointmentShow extends Component
{
    public $appointment;
    public $users;
    public $firstDateChange;
    public $otherAppointments;
    public $otherStart;
    public $otherRep;
    public $startHour;
    public $endHour;
    public $endTime;
    public $otherCustomer;
    public $customers;

    protected $listeners = ['modelAppointmentMustBeDeleted' => 'delete', 'modelWillSave' => 'save'];

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
            'appointment.customer_id' => 'required'
        ];
    }

    public function mount($appointment = null) {
        $th = TimeHelper::get();
        $tdf = $th->getTimeDisplayFormat();
        $this->users = RoleHelper::getRepresentatives();
        $this->firstDateChange = true;
        
        if (!isset($appointment)) {
            $this->customers = Customer::orderBy('first_name')->get();
            $start = $th->getBusinessStart();
            $appointment = new Appointment;
            $appointment->type = MeetingTypes::cases()[0]->value;
            $appointment->start = $start->copy();
            $appointment->end = $start->copy()->addHour();
            $appointment->user_id = $this->users->first()->id;
            $appointment->customer_id = $this->customers->first()->id;
            $this->startHour = $start->copy()->format($tdf);
            $this->endHour = $start->copy()->addHour()->format($tdf);
        }

        $this->appointment = $appointment;
        $this->startHour = $th->fromStringToUserObject($this->appointment->start)->format($tdf);
        $this->endHour = $th->fromStringToUserObject($this->appointment->end)->format($tdf);
        $this->otherStart = $th->fromStringToUser($this->appointment->start);
        $this->otherEnd = $th->fromStringToUser($this->appointment->end);
        $this->otherRep = $this->appointment->user->id;
        $this->otherCustomer = $this->appointment->customer_id;
        $this->getOtherAppointments(Carbon::parse($this->appointment->start));
    }

    public function render()
    {
        return view('livewire.appointment-show');
    }

    public function onDateChange() {
        $this->getOtherAppointments();
    }

    private function getOtherAppointments() {
        $appointment = $this->appointment;
        $start = Carbon::parse($this->otherStart)->startOfDay();
        $rep = $this->otherRep;
        $customer = $this->otherCustomer;
        
        $this->otherAppointments = Appointment::where(function ($query) use ($appointment, $start, $rep, $customer) {
                $query->where('user_id', $rep)
                ->orWhere('customer_id', $customer);
             })
             ->where('id', '!=', $appointment->id)
            ->whereBetween('start', [
                $start->copy()->startOfDay(), 
                $start->copy()->endOfDay()
            ])
            ->get();
    }

    public function save() {
        $this->validate();
        $this->appointment->user_id = $this->otherRep;
        $this->appointment->customer_id = $this->otherCustomer;
        $this->appointment->start = $this->getCompiledStart();
        $this->appointment->end = $this->getCompiledEnd();
        $this->appointment->save();
        $this->emit('successNotification', 'Appointment Saved!');
        $this->emit('modelSet', ['id' => $this->appointment->id, 'class' => 'Appointment']);
    }

    public function onRepChanged() {
        $this->getOtherAppointments();
    }

    public function delete() {
        $this->appointment->delete();
        session()->flash('successNotification', $this->appointment->title . ' was deleted');
        return redirect()->to(route('admin.appointment.index'));
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
}
