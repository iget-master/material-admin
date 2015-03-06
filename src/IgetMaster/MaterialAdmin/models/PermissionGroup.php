<?php namespace IgetMaster\MaterialAdmin;

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
}
