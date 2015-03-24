<?php namespace IgetMaster\MaterialAdmin\Models;

use \Eloquent;

class Message extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'messages';

	protected $fillable = array('to_user_id', 'from_user_id', 'subject', 'message', 'read', 'created_at', 'updated_at');

	public function toUser() {
		return $this->belongsTo('IgetMaster\MaterialAdmin\Models\User', 'to_user_id');
	}

	public function fromUser() {
		return $this->belongsTo('IgetMaster\MaterialAdmin\Models\User', 'from_user_id');
	}

	public function user()
	{
		return $this->belongsTo('IgetMaster\MaterialAdmin\Models\User', 'from_user_id');
	}

}
