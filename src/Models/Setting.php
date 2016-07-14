<?php

namespace IgetMaster\MaterialAdmin\Models;

use \Cache;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Setting extends Eloquent
{

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
    protected $fillable = [
        'key',
        'value'
    ];

    /**
     * @param $key
     * @return string|null
     */
    public static function get($key)
    {
        return Cache::rememberForever("setting_{$key}", function () use ($key) {
            $setting = static::find($key);
            return $setting ? $setting->value : null;
        });
    }

    /**
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        static::updateOrCreate(
            compact('key'),
            compact('value')
        );

        Cache::forever("setting_{$key}", $value, 0);
    }

    /**
     * @param $key
     */
    public static function forget($key)
    {
        static::destroy($key);
        Cache::forget("setting_{$key}");
    }
}
