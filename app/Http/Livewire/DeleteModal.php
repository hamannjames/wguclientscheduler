<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DeleteModal extends Component
{
    public $show;
    public $class;
    public $modelId;
    public $message;

    protected $listeners = ['modelWillBeDeleted'];
    
    public function render()
    {
        return view('livewire.delete-modal');
    }

    public function modelWillBeDeleted($data) {
        $this->class = $data['class'];
        $this->modelId = $data['id'];
        if (isset($data['message'])) {
            $this->message = $data['message'];
        }
        $this->show = true;
    }

    public function cancel() {
        $this->show = false;
    }

    public function delete() {
        $this->emit('model' . $this->class . 'MustBeDeleted', $this->modelId);
        $this->show = false;
    }
}
