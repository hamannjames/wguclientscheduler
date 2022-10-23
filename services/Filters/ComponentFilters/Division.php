<?php

namespace Services\Filters\ComponentFilters;

use Illuminate\Database\Eloquent\Builder;

class Division extends ComponentFilter
{
    public function applyFilter(Builder $builder)
    {
        $division = $this->component->division;
        
        return $builder->where('first_level_division', $division);
    }

    public function toString():string {
        return 'division';
    }
}