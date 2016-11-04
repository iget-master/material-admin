<?php namespace IgetMaster\MaterialAdmin\Models;

use IgetMaster\MaterialAdmin\Models\Role;
use IgetMaster\MaterialAdmin\Models\User;
use Illuminate\Database\Eloquent\Model as Eloquent;
use IgetMaster\MaterialAdmin\Traits\SelectableTrait;

class PermissionGroup extends Eloquent
{
    use SelectableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permission_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public $rules = [
        'name'=>'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
