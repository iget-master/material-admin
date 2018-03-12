<?php

namespace IgetMaster\MaterialAdmin\Traits;

use IgetMaster\MaterialAdmin\Models\Draft;
use IgetMaster\MaterialAdmin\Models\DraftColumn;

trait DraftableTrait
{
    /**
     * @return \IgetMaster\MaterialAdmin\Models\Draft;
     */
    public function draft()
    {
        $draft = Draft::create(['draftable_type'=>get_class($this)]);

        foreach ($this->getAttributes() as $column => $value) {
            if ($value) {
                DraftColumn::create(['draft_id'=>$draft->id, 'column'=>$column, 'value'=>$value]);
            }
        }

        return $draft;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    static public function drafts()
    {
        return Draft::where(['draftable_type'=>get_called_class()])->get();
    }
}
