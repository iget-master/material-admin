<?php namespace IgetMaster\MaterialAdmin\Models;

use \Eloquent;

class Draft extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'drafts';
    public $timestamps = true;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $fillable = array('draftable_type');

    public $rules = [''];

    public function columns() {
        return $this->hasMany('IgetMaster\MaterialAdmin\Models\DraftColumn');
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getColumn($key)
    {
        if ($column = $this->columns->where('column', $key)) {
            return $column->first()->value;
        }
    }

    /**
     * Reconstruct original model from Draft
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function reconstructModel()
    {
        $model = new $this->draftable_type;
        foreach ($this->columns as $column) {
            $attribute = $column->column;
            $model->$attribute = $column->value;
        }

        return $model;
    }
}
