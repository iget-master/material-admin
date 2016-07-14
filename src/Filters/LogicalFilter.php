<?php
namespace IgetMaster\MaterialAdmin\Filters;

use Exception;
use IgetMaster\MaterialAdmin\Interfaces\FilterInterface;

class LogicalFilter implements FilterInterface
{
    protected $field;
    protected $operator;
    protected $value;

    /**
     * LogicalFilter constructor.
     * @param $field
     * @param $operator
     * @param $value
     */
    public function __construct($field, $operator, $value)
    {
        $this->field = $field;
        $this->operator = $operator;
        $this->value = $value;
    }

    /**
     * @param string $field
     * @param string $operator
     * @param mixed $value
     * @return static
     */
    public static function compare($field, $operator, $value)
    {
        return new static($field, $operator, $value);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter($query)
    {
        return $query->where($this->field, $this->operator, $this->value);
    }
}
