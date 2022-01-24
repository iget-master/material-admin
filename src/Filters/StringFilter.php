<?php
namespace IgetMaster\MaterialAdmin\Filters;

use Exception;
use IgetMaster\MaterialAdmin\Interfaces\FilterInterface;

class StringFilter implements FilterInterface
{
    protected $field;
    protected $condition;
    protected $value;

    /**
     * StringFilter constructor.
     * @param $field
     * @param $condition
     * @param $value
     */
    public function __construct($field, $condition, $value)
    {
        $this->field = $field;
        $this->condition = $condition;
        $this->value = $value;
    }

    public static function contains($field, $value)
    {
        return new static($field, 'contains', $value);
    }

    public static function starts($field, $value)
    {
        return new static($field, 'starts', $value);
    }

    public static function ends($field, $value)
    {
        return new static($field, 'ends', $value);
    }

    public static function exact($field, $value)
    {
        return new static($field, 'exact', $value);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter($query)
    {
        $value = $this->value;
        switch ($this->condition) {
            case 'contains':
                $value = "%${value}%";
                break;
            case 'starts':
                $value .= "%";
                break;
            case 'ends':
                $value = "%" . $value;
                break;
            case 'exact':
                break;
            default:
                throw new Exception('Invalid filter condition "' . $this->condition . '".');
        }
        return $query->where($this->field, 'LIKE', $value);
    }
}
