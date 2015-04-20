<?php
namespace IgetMaster\MaterialAdmin\Traits;

trait SelectableTrait {
    public function getLabelColumn() {
        return $this->name;
    }

    static public function getSelectOptions() {
        $items = self::all();
        $options = [""=>trans('materialadmin::admin.select_default')];
        foreach ($items as $item) {
            $options[$item->id] = $item->getLabelColumn();
        }
        return $options;
    }
}