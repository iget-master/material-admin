<?php namespace IgetMaster\MaterialAdmin\Models;

use Iget\Base\Models\PermissionGroup;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Role extends Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    public $timestamps = false;

    public function groups()
    {
        return $this->belongsToMany(PermissionGroup::class);
    }

    protected $fillable = array('name');
}
