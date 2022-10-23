<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ToastError extends Component
{
    public $message;
    public $show;
    public $status;

    protected $listeners = ['errorNotification'];

    public function mount() {
        if (session()->has('errorNotification')) {
            $this->errorNotification(session()->get('errorNotification'));
        }
    }

    public function render()
    {
        return view('livewire.toast-error');
    }

    public function errorNotification($message = null) {
        $this->message = $message;
        $this->show = true;
        $this->status = 'error';
    }
}
