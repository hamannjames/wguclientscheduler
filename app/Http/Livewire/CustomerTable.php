<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Database\Enums\FirstLevelDivisions;
use Services\Filters\ComponentFilters\Search;
use Services\Filters\ComponentFilters\Company;
use Services\Filters\ComponentFilters\Division;

class CustomerTable extends ModelTable {

    public $search = '';
    public $searchFields = ['first_name', 'last_name'];
    public $baseModel = Customer::class;
    public $division;
    public $company;

    public function mount($models) {

        $filters = [
            Search::class,
            Division::class,
            Company::class
        ];

        $columns = [
            [
                'type' => 'method',
                'name' => 'fullName',
                'display' => 'Full Name'
            ],
            [
                'type' => 'property',
                'name' => 'first_level_division',
                'display' => 'Division',
            ],
            [
                'type' => 'property',
                'name' => 'state',
                'display' => 'State'
            ],
            [
                'type' => 'property',
                'name' => 'email',
                'display' => 'Email'
            ],
            [
                'type' => 'property',
                'name' => 'phone',
                'display' => 'Phone'
            ],
            [
                'type' => 'route',
                'name' => 'company',
                'route' => 'admin.company.show',
                'display' => 'Company'
            ]
        ];

        parent::onMount($columns, $filters);
    }

    public function search() {
        $this->validate();
        $this->getModels();
    }

    public function onChangeDivision() {
        $this->getModels();
    }

    public function onCompanyChange() {
        $this->getModels();
    }
}