<?php
namespace IgetMaster\MaterialAdmin\Traits;

use IgetMaster\MaterialAdmin\Interfaces\FilterInterface;

trait FiltrableTrait
{

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $filters)
    {
        foreach ($filters as $index => $filter) {
            if ($filter instanceof FilterInterface) {
                $query = $filter->filter($query);
            } else {
                array_unshift($filter, $query);
                $query = call_user_func_array(array($this, "filter" . str_replace('_', '', $index)), $filter);
            }
        }

        return $query;
    }
}
