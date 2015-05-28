<?php
namespace IgetMaster\MaterialAdmin\Interfaces;

interface DraftableInterface {
    /**
     * @return \App\Models\Draft
     */
    public function draft();

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    static public function drafts();
}
