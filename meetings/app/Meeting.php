<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


class Meeting extends Model{


    protected $table='meetings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'owner', 'date_to','date_from', 'location','placeid', 'description'
    ];

    public $timestamps = true;


    /**
     * Get the comments for the blog post.
     */
    public function users()
    {
        return $this->belongsToMany('App\MeetingUser', 'meeting_id',  'id');
    }

    public function delete()
    {
//        $this->users()->delete();

        return parent::delete();
    }
}
