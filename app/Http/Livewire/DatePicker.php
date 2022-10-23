<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DatePicker extends Component
{
    public $date;

    public function render()
    {
        return view('livewire.date-picker');
    }

    public function dateChange() {
        $this->emit('dateChanged', $this->date);
    }
}
