<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Http\Livewire\ModelTable;

class RepTable extends ModelTable {
    public $baseModel = User::class;

    public function mount($models) {
        $columns = [
            [
                'type' => 'property',
                'name' => 'name',
                'display' => 'Name'
            ],
            [
                'type' => 'property',
                'name' => 'email',
                'display' => 'Email'
            ]
        ];

        parent::onMount($columns);
    }
}