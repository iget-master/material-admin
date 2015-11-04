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

    /**
     * Verify if current user can delete user.
     *
     * @return boolean
     */
    public function deleted(User $model)
    {
        // If the User is deleted, delete your image
        \File::delete(base_path($model->img_url));
        return true;
    }

    /**
     * Verify if current user can delete user.
     *
     * @return boolean
     */
    public function creating(User $model)
    {   
        $availableColors = array("blue", "red", "teal", "grey", "purple", "yellow", "orange", "deep-orange", "deep-purple", "cyan", "pink", "indigo", "green", "light-green", "lime", "blue-grey", "brown", "amber", "light-blue", "orange");
        $model->color = $availableColors[array_rand($availableColors)];
        return true;
    }


}