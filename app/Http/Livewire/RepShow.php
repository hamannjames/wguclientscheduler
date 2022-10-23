<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Database\Enums\Roles;
use Illuminate\Support\Facades\Hash;

class RepShow extends Component
{
    public $rep;
    public $appointments;
    public $password;

    public $listeners = ['modelWillSave' => 'save', 'modelUserMustBeDeleted' => 'delete'];

    protected $rules = [
        'rep.name' => 'required',
        'rep.email' => 'required|email',
        'password' => 'required|min:8'
    ];

    public function mount($rep = null) {
        $role = Role::firstWhere('name', Roles::REPRESENTATIVE->value);
        $this->appointments = isset($rep) ? $rep->appointments : null;
        if (!isset($rep)) {
            $this->rep = new User;
            $this->rep->setRelation('role', $role);
        }
    }

    public function render()
    {
        return view('livewire.rep-show');
    }

    public function save() {
        $this->validate();
        if (!$this->rep->password) {
            $this->rep->password = Hash::make($this->password);
        }
        $this->rep->save();
        if (!$this->appointments) {
            $this->appointments = $this->rep->appointments;
        }
        $this->emit('successNotification', 'Representative Saved!');
        $this->emit('modelSet', ['id' => $this->rep->id, 'class' => 'User']);
    }

    public function delete() {
        $this->rep->delete();
        session()->flash('successNotification', $this->rep->name . ' was deleted');
        return redirect()->to(route('admin.user.index'));
    }
}
