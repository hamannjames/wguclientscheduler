<?php

namespace Services\Filters\ComponentFilters;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

abstract class ComponentFilter implements \Services\Filters\Filter
{
    protected $component;

    public function handle($component, Closure $next)
    {
        $filterName = $this->filterName();
        $this->component = $component;

        if ( !isset($component->$filterName) || empty($component->$filterName) ) {
            return $next($component);
        }

        $builder = $component->getQuery();
        $this->applyFilter($builder);
        return $next($component);
    }

    public abstract function applyFilter(Builder $builder);
    public abstract function toString():string;

    protected function filterName()
    {
        return Str::camel(class_basename($this));
    }
}