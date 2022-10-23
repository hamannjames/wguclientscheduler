<?php

namespace Services\Filters\ComponentFilters;

use Illuminate\Database\Eloquent\Builder;

class User extends ComponentFilter
{
    public function applyFilter(Builder $builder)
    {
        return $builder->where('user_id', $this->component->user);
    }

    public function toString():string {
        return 'user';
    }
}