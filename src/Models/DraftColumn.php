<?php namespace IgetMaster\MaterialAdmin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class DraftColumn extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'draft_columns';
    public $timestamps = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $fillable = array('draft_id', 'column', 'value');

    public $rules = [''];

    public function draft() {
        return $this->belongsTo('IgetMaster\MaterialAdmin\Models\Draft');
    }
}
