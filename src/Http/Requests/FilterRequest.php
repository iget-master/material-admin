<?php namespace IgetMaster\MaterialAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class FilterRequest extends FormRequest {

    protected $filters = [];

    /**
     * @return array
     */
    public function filters()
    {
        $filters = [];
        foreach ($this->filters as $filterName => $filterType) {
            if ($filterType == 'date') {
                $filterExpects = [$filterName . '_from', $filterName . '_to'];
            } else if ($filterType == 'logical') {
                $filterExpects = [$filterName . '_operator', $filterName];
            } else {
                $filterExpects = [$filterName];
            }

            $hasExpected = true;
            $hasSomething = false;
            $parameters = [];
            foreach ($filterExpects as $index=>$input) {
                if ($this->has($input)) {
                    $hasSomething = true;
                }

                if ($this->has($input) && strlen($this->get($input))) {
                    $parameters[$index] = $this->get($input);
                } else {
                    $hasExpected = false;
                }

            }

            if ($filterType == 'date' && $hasSomething) {
                if (!array_key_exists(0, $parameters)) {
                    array_unshift($parameters, null);
                }
                $filters[$filterName] = $parameters;
            } else if ($filterType == 'logical' && $hasSomething)
            {
                if (!array_key_exists(0, $parameters)) {
                    array_unshift($parameters, '=');
                }
                if (array_key_exists(1, $parameters)) {
                    $filters[$filterName] = $parameters;
                }
            } else if ($hasExpected)
            {
                $filters[$filterName] = $parameters;
            }


        }
        return $filters;
    }

}
