<?php namespace IgetMaster\MaterialAdmin\Models;

use \Eloquent;
use IgetMaster\MaterialAdmin\Traits\SelectableTrait;

class PermissionGroup extends Eloquent {
	use SelectableTrait;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'permission_groups';

	protected $fillable = ['name'];

	public $rules = [
		'name'=>'required'
	];

	public function users() {
		return $this->hasMany('IgetMaster\MaterialAdmin\Models\User');
	}

	public function roles() {
		return $this->belongsToMany('IgetMaster\MaterialAdmin\Models\Role');
	}

	// static public function getSelectOptions() 
	// {
	// 	$options = [];
	// 	foreach( PermissionGroup::all() as $permission_group) {
	// 		$options[$permission_group->id] = $permission_group->name;
	// 	}

	// 	return $options;
	// }
}
