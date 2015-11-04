<?php
namespace IgetMaster\MaterialAdmin\Interfaces;

interface FilterInterface {
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter($query);
}