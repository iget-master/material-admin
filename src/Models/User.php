<?php namespace IgetMaster\MaterialAdmin\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;
use IgetMaster\MaterialAdmin\Filters\DateFilter;
use IgetMaster\MaterialAdmin\Filters\StringFilter;
use IgetMaster\MaterialAdmin\Interfaces\FiltrableInterface;
use IgetMaster\MaterialAdmin\Traits\FiltrableTrait;
use IgetMaster\MaterialAdmin\Traits\SelectableTrait;

class User extends Eloquent implements FiltrableInterface {

	use SelectableTrait, FiltrableTrait;

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
     * @return string
     */
    public function getLabelColumn() {
        return $this->name . " " . $this->surname;
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

    public function filterName($query, $value) {
        return StringFilter::contains(\DB::raw("CONCAT(name, ' ', surname)"), $value)->filter($query);
    }

    public function filterEmail($query, $value) {
        return StringFilter::contains('email', $value)->filter($query);
    }

    public function filterDob($query, $start = null, $end = null) {
        return DateFilter::between('dob', $start, $end)->filter($query);
    }

    public function filterId($query, $operator, $value) {
        return $query->where('id', $operator, $value);
    }
}