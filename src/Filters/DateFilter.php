<?php
namespace IgetMaster\MaterialAdmin\Filters;

use Exception;
use IgetMaster\MaterialAdmin\Interfaces\FilterInterface;

class DateFilter implements FilterInterface
{
    protected $field;
    protected $operator;
    protected $start;
    protected $end;
    protected $inclusive;

    /**
     * @param $field
     * @param $start
     * @param $end
     */
    function __construct($field, $start = null, $end = null, $inclusive = true)
    {
        $this->field = $field;
        $this->start = $start;
        $this->end = $end;
        $this->inclusive = $inclusive;
    }

    /**
     * @param $field
     * @param null $start
     * @param null $end
     * @param bool $inclusive
     * @return static
     */
    public static function between($field, $start = null, $end = null, $inclusive = true)
    {
        return new static($field, $start, $end, $inclusive);
    }

    /**
     * @param $field
     * @param null $end
     * @param bool $inclusive
     * @return static
     */
    public static function before($field, $end = null, $inclusive = true)
    {
        return new static($field, null, $end, $inclusive);
    }

    /**
     * @param $field
     * @param null $end
     * @param bool $inclusive
     * @return static
     */
    public static function after($field, $start = null, $inclusive = true)
    {
        return new static($field, $start, null, $inclusive);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filter($query)
    {
        $inclusiveOperator = '';
        if ($this->inclusive) {
            $inclusiveOperator = "=";
        }

        if (isset($this->start)) {
            $query = $query->where($this->field, '>' . $inclusiveOperator, $this->start);
        }
        if (isset($this->end)) {
            $query = $query->where($this->field, '<' . $inclusiveOperator, $this->end);
        }

        return $query;
    }
}
