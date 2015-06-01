<?php namespace IgetMaster\MaterialAdmin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Setting extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'settings';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

	public $rules = [
		'key' => 'required|max:255',
        'value' => '',
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $fillable = ['key','value'];

    /**
     * @param $key
     * @return string
     */
    static public function get($key) {
        return static::find($key)->value;
    }

    /**
     * @param $key
     * @param $value
     */
    static public function set($key, $value) {
        static::updateOrCreate(
            compact(key),
            compact($value)
        );
    }
}