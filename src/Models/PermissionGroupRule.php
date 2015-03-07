<?php namespace IgetMaster\MaterialAdmin\Models;

use \Eloquent;

class PermissionGroupRule extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'permission_group_rules';

	public function groups() {
		return $this->hasMany('IgetMaster\MaterialAdmin\Models\PermissionGroup');
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
