<?php namespace IgetMaster\MaterialAdmin\Models;

use \Eloquent;
use Nicolaslopezj\Searchable\SearchableTrait;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Eloquent implements AuthenticatableContract, CanResetPasswordContract {
	use Authenticatable, CanResetPassword;
    use SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'name' => 10,
            'surname' => 10,
        ]
    ];

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

    public function unreadMessages()
    {
        return $this->hasMany('IgetMaster\MaterialAdmin\Models\Message','to_user_id')->where('read', 0);
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