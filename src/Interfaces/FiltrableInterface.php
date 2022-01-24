<?php
namespace IgetMaster\MaterialAdmin\Interfaces;

interface FiltrableInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $filters);
}
