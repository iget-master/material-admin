<?php namespace IgetMaster\MaterialAdmin\Models;

use \Eloquent;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';


	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $fillable = array('name', 'surname', 'dob', 'email', 'password', 'permission_group_id', 'language');

	public function getDateFormat()
    {
        return 'd/m/Y';
    }

	/**
	 * Model relationships definitions
	 */

	public function permission_group() {
		return $this->belongsTo('IgetMaster\MaterialAdmin\Models\PermissionGroup');
	}

	/**
	 * Model mutators definitions
	 */
	protected $dates = ['dob'];

    public function setDobAttribute($value)
    {
    	$this->attributes['dob'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function hasRole($role)
    {
    	$count = $this->permission_group->roles->filter(function($item) use ($role) {
    		return $item->name == $role;
    	})->count();

    	if ($count) {
    		return true;
    	} else {
    		return false;
    	}
    }

    public function messages()
    {
    	return $this->hasMany('IgetMaster\MaterialAdmin\Models\Message','to_user_id');
    }

    public function sentMessages()
    {
    	return $this->hasMany('IgetMaster\MaterialAdmin\Models\Message','from_user_id');
    }
}