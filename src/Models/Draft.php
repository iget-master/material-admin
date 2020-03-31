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
        'columns',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'columns' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Draft $model) {
            $model->columns = array_merge(
                $model->columns ?? [],
                array_except(
                    $model->getAttributes(),
                    $model->realAttributes
                )
            );

            $model->setRawAttributes(array_only($model->getAttributes(), $model->realAttributes));
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
     * @param string $key
     * @return mixed
     */
    public function getColumn($key)
    {
        return $this->columns[$key] ?? null;
    }

    /**
     * Reconstruct original model from Draft
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function reconstructModel()
    {
        if (!$this->draftable_type) {
            return null;
        }

        $model = new $this->draftable_type;

        if (method_exists($model, 'reconstructModel')) {
            return $model->reconstructModel($this);
        }

        foreach ($this->columns as $column => $value) {
            $model->$column = $value;
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