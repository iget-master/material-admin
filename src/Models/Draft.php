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
    ];

    /**
     * Indicates if all mass assignment is enabled.
     *
     * @var bool
     */
    protected static $unguarded = true;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'reconstructed'
    ];

    /**
     * The attributes that really exists on Draft model
     *
     * @var array
     */
    protected $realAttributes = [
        'id',
        'draftable_type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The pending columns that should be saved
     *
     * @var array
     */
    public $columnsToSave = [];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
//        'columns'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Draft $model) {
            $model->columnsToSave = array_except($model->getAttributes(), $model->realAttributes);
            $model->setRawAttributes(array_only($model->getAttributes(), $model->realAttributes));
        });

        static::saved(function (Draft $model) {
            foreach ($model->columnsToSave as $column=>$value) {
                if ($value) {
                    $model->columns()->updateOrCreate(compact('column'), compact('value'));
                } else {
                    $model->columns()->where('column', $column)->delete();
                }

            }
            
            $model->load('columns');
        });
    }

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
        return $this->hasMany(\IgetMaster\MaterialAdmin\Models\DraftColumn::class);
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
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        return (is_null($value)) ? $this->getColumn($key) : $value;
    }
}
