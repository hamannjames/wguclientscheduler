<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use App\Http\Livewire\ModelTable;
use Services\Filters\ComponentFilters\User;
use Services\Filters\ComponentFilters\Search;
use Services\Filters\ComponentFilters\Customer;
use Services\Filters\ComponentFilters\ExcludePast;

class AppointmentTable extends ModelTable {
    public $baseModel = Appointment::class;
    public $search = '';
    public $searchFields = ['title'];
    public $user;
    public $customer;
    public $startDate;
    public $endDate;
    public $excludePast;

    public function mount($models) {
        $filters = [
            Search::class,
            Customer::class,
            User::class,
            ExcludePast::class
        ];
        $columns = [
            [
                'type' => 'property',
                'name' => 'title',
                'display' => 'Title'
            ],
            [
                'type' => 'route',
                'name' => 'customer',
                'route' => 'admin.customer.show',
                'display' => 'Customer'
            ],
            [
                'type' => 'route',
                'name' => 'user',
                'route' => 'admin.user.show',
                'display' => 'Representative'
            ],
            [
                'type' => 'property',
                'name' => 'type',
                'display' => 'Type'
            ],
            [
                'type' => 'date',
                'name' => 'start',
                'display' => 'Start'
            ],
            [
                'type' => 'date',
                'name' => 'end',
                'display' => 'End'
            ]
        ];

        parent::onMount($columns, $filters);
    }

    public function search() {
        $this->validate();
        $this->getModels();
    }

    public function onCustomerChange() {
        $this->getModels();
    }

    public function onUserChange() {
        $this->getModels();
    }

    public function onExcludePastChange() {
        $this->getModels();
    }
}