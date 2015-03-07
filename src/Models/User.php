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

	protected $dates = ['dob'];

	public function getDateFormat()
    {
        return 'd/m/Y';
    }

    public function setDobAttribute($value)
    {
    	$this->attributes['dob'] = Carbon::createFromFormat('d/m/Y', $value);
    }

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function permission_group() {
		return $this->belongsTo('IgetMaster\MaterialAdmin\Models\PermissionGroup');
	}

}
