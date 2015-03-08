<?php namespace IgetMaster\MaterialAdmin\Models;

use \Eloquent;

class Role extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

	public $timestamps = false;

	public function groups() {
		return $this->belongsToMany('IgetMaster\MaterialAdmin\Models\PermissionGroup');
	}

	protected $fillable = array('name');
}
