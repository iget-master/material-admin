<?php namespace IgetMaster\MaterialAdmin\Models;

use \Eloquent;

class PermissionGroup extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'permission_groups';

	public function users() {
		return $this->hasMany('User');
	}

	static public function getSelectOptions() 
	{
		$options = [];
		foreach( PermissionGroup::all() as $permission_group) {
			$options[$permission_group->id] = $permission_group->name;
		}

		return $options;
	}
}
