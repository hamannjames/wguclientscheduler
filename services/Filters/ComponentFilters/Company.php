<?php

namespace Services\Filters\ComponentFilters;

use Illuminate\Database\Eloquent\Builder;

class Company extends ComponentFilter {

    public function applyFilter(Builder $builder)
    {   
        return $builder->where('company_id', $this->component->company);
    }

    public function toString():string {
        return 'company';
    }
}