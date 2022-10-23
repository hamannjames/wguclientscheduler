<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Database\Enums\Roles;

class RepShow extends Component
{
    public $rep;

    public $listeners = ['modelWillSave' => 'save', 'modelUserMustBeDeleted' => 'delete'];

    protected $rules = [
        'rep.name' => 'required',
        'rep.email' => 'required|email',
    ];

    public function mount($rep = null) {
        $role = Role::where('name', Roles::REPRESENTATIVE->value);
        if (!isset($rep)) {
            $this->rep = new User;
            $this->rep->role_id = $role;
        }
    }

    public function render()
    {
        return view('livewire.rep-show');
    }

    public function save() {
        $this->validate();
        $this->rep->save();
        $this->emit('successNotification', 'Representative Saved!');
        $this->emit('modelSet', $this->rep);
    }

    public function delete() {
        $this->rep->delete();
        session()->flash('successNotification', $this->rep->name . ' was deleted');
        return redirect()->to(route('admin.user.index'));
    }
}
