<?php namespace IgetMaster\MaterialAdmin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Draft extends Eloquent
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'drafts';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $fillable = [
        'draftable_type'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'reconstructed'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'columns'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getReconstructedAttribute()
    {
        return $this->reconstructModel();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
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
        $draftColumn = $this->columns->where('column', $key)->first();

        return ($draftColumn) ? $draftColumn->value : null;
    }

    /**
     * Reconstruct original model from Draft
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function reconstructModel()
    {
        $model = new $this->draftable_type;

        if (method_exists($model, 'reconstructModel')) {
            return $model->reconstructModel($this);
        }
        foreach ($this->columns as $column) {
            $attribute = $column->column;
            $model->$attribute = $column->value;
        }

        $model->deleted_at = $this->deleted_at;
        $model->updated_at = $this->updated_at;
        $model->created_at = $this->created_at;

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
