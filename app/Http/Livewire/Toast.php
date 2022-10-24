<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Toast extends Component
{
    public $message;
    public $show;
    public $status;

    protected $listeners = ['successNotification'];

    public function mount() {
        if (session()->has('successNotification')) {
            $this->successNotification(session()->get('successNotification'));
        }
    }

    public function render()
    {
        return view('livewire.toast');
    }

    public function successNotification($message = null) {
        $this->message = $message;
        $this->show = true;
        $this->status = 'error';
    }
}
