<?php namespace IgetMaster\MaterialAdmin\Models\Observers;

use IgetMaster\MaterialAdmin\Models\User;

class UserObserver {

	/**
     * Verify if current user can delete user.
     *
     * @return boolean
     */
	public function deleting(User $model)
    {
        return ($model->id !== \Auth::user()->id);
    }
}