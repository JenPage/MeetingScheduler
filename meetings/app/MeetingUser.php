<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


class MeetingUser extends Model{


    protected $table='meeting_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meeting_id', 'user_id', 'message_id', 'response'
    ];

    public $timestamps = true;

    /**
     * Get the meeting data
     */
    public function meetings()
    {
        return $this->hasOne('App\Meeting', 'id', 'meeting_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id');
    }

}
