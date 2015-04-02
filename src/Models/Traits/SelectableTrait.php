<?php
namespace IgetMaster\MaterialAdmin\Models\Traits;

trait SelectableTrait {
    public function getLabelColumn() {
        return $this->name;
    }

    static public function getSelectOptions() {
        $items = self::all();
        $options = [];
        foreach ($items as $item) {
            $options[$item->id] = $item->getLabelColumn();
        }
        return $options;
    }
}