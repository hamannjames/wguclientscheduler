<?php

namespace Services\Filters\ComponentFilters;

use Illuminate\Database\Eloquent\Builder;

class Customer extends ComponentFilter
{
    public function applyFilter(Builder $builder)
    {
        return $builder->where('customer_id', $this->component->customer);
    }

    public function toString():string {
        return 'customer';
    }
}