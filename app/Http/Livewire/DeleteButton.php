<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DeleteButton extends Component
{
    public $modelId;
    public $modelClass;
    public $message;

    protected $listeners = ['modelSet'];

    public function mount($model = null, $message = null) {
        if (isset($model)) {
            $this->modelId = $model->id;
            $this->modelClass = class_basename($model::class);
        }

        $this->message = $message;
    }

    public function render()
    {
        return view('livewire.delete-button');
    }

    public function modelSet($model) {
        $this->modelId = $model['id'];
        $this->modelClass = $model['class'];
    }
}
