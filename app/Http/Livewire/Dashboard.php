<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $divisionAll;
    public $divisionFiltered;
    public $customerAll;
    public $customerFilteres;
    public $repAll;
    public $repFiltered;
    public $filtered;
    public $wasFiltered;

    public function mount($divisionAll, $divisionFiltered, $customerAll, $customerFiltered, $repAll, $repFiltered) {
        $this->filtered = false;
        $this->wasFiltered = false;
        $this->divisionAll = $divisionAll->toArray();
        $this->divisionFiltered = $divisionFiltered->toArray();
        $this->customerAll = $customerAll->toArray();
        $this->customerFiltered = $customerFiltered->toArray();
        $this->repAll = $repAll->toArray();
        $this->repFiltered = $repFiltered->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }

    public function onFilteredChange() {
        $this->wasFiltered = true;
    }
}
