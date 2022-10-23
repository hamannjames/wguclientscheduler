<?php

namespace Services\Filters\ComponentFilters;

use Carbon\Carbon;
use Services\Helpers\TimeHelper;
use Illuminate\Database\Eloquent\Builder;

class ExcludePast extends ComponentFilter
{
    public function applyFilter(Builder $builder)
    {
        $th = TimeHelper::get();
        return $builder->where('start', '>=', Carbon::now($th->getUserTimeZone())->startOfDay());
    }

    public function toString():string {
        return 'date';
    }
}