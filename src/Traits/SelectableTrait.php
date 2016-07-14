<?php
namespace IgetMaster\MaterialAdmin\Traits;

trait SelectableTrait
{
    /**
     * Defines the column used by the select option as label
     * @return string
     */
    public function getLabelColumn()
    {
        return $this->name;
    }

    /**
     * Defines the column used by the select option as value
     * @return string
     */
    public function getValueColumn()
    {
        return $this->id;
    }

    /**
     * Return an array with all model items as options.
     * @return array
     */
    static public function getSelectOptions()
    {
        $items = self::all();
        $options = [""=>trans('materialadmin::admin.select_default')];
        foreach ($items as $item) {
            if (strlen($value = $item->getValueColumn()) && strlen($label = $item->getLabelColumn())) {
                $options[$value] = $label;
            }
        }
        return $options;
    }
}
