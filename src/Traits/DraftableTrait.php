<?php

namespace IgetMaster\MaterialAdmin\Traits;

use IgetMaster\MaterialAdmin\Models\Draft;
use IgetMaster\MaterialAdmin\Models\DraftColumn;
use Illuminate\Database\Eloquent\Collection;

trait DraftableTrait
{
    /**
     * @return \IgetMaster\MaterialAdmin\Models\Draft;
     */
    public function draft()
    {
        return Draft::create([
            'draftable_type' => get_class($this),
            'columns' => $this->getAttributes(),
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    static public function drafts()
    {
        return Draft::where(['draftable_type'=>get_called_class()])->get();
    }
}
