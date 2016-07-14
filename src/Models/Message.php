<?php namespace IgetMaster\MaterialAdmin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Message extends Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'messages';

    public $timestamps = true;

    protected $fillable = array('to_user_id', 'from_user_id', 'subject', 'message', 'read', 'created_at', 'updated_at');

    public function toUser()
    {
        return $this->belongsTo('IgetMaster\MaterialAdmin\Models\User', 'to_user_id');
    }

    public function fromUser()
    {
        return $this->belongsTo('IgetMaster\MaterialAdmin\Models\User', 'from_user_id');
    }

    public function sender()
    {
        return $this->belongsTo('IgetMaster\MaterialAdmin\Models\User', 'from_user_id');
    }

    public static function getUsers()
    {
        $users = User::all();
        $options = [];
        foreach ($users as $key => $user) {
            $options[$user->id] = $user->name;
        }
        return $options;
    }
}
