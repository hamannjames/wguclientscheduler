<?php

namespace App\Http\Livewire;

use App\Models\Company;
use Livewire\Component;
use App\Models\Customer;
use Database\Enums\States;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Database\Enums\FirstLevelDivisions;

class CustomerShow extends Component
{
    public $customer;
    public $companies;

    public $listeners = ['modelWillSave' => 'save', 'modelCustomerMustBeDeleted' => 'delete'];

    protected function rules() {
        return [
            'customer.first_name' => 'required',
            'customer.last_name' => 'required',
            'customer.email' => 'required|email',
            'customer.street_1' => 'nullable',
            'customer.street_2' => 'nullable',
            'customer.city' => 'nullable',
            'customer.postal_code' => 'nullable',
            'customer.state' => new Enum(States::class),
            'customer.first_level_division' => new Enum(FirstLevelDivisions::class),
            'customer.company_id' => 'nullable'
        ];
    }

    public function mount($customer = null) {
        if (!isset($customer)) {
            $customer = new Customer;
            $customer->state = States::TX->value;
            $customer->first_level_division = States::TX->firstLevelDivision();
        }

        $this->companies = Company::all();
        $this->customer = $customer;
    }

    public function render()
    {
        return view('livewire.customer-show');
    }

    public function save() {
        $this->validate();
        $this->customer->save();
        $this->emit('successNotification', 'Customer Saved!');
        $this->emit('modelSet', ['id' => $this->customer->id, 'class' => 'Customer']);
    }

    public function delete() {
        $this->customer->delete();
        session()->flash('successNotification', $this->customer->fullName() . ' was deleted');
        return redirect()->to(route('admin.customer.index'));
    }
}
