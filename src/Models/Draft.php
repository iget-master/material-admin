<?php namespace IgetMaster\MaterialAdmin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Draft extends Eloquent
{
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

    public function columns()
    {
        return $this->hasMany('IgetMaster\MaterialAdmin\Models\DraftColumn');
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getColumn($key)
    {
        $draftColumn = $this->columns()->where('column', $key)->first();

        return ($draftColumn) ? $draftColumn->value : null;
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

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        $value = $this->getAttribute($key);

        return (is_null($value)) ? $this->getColumn($key) : $value;
    }
}
