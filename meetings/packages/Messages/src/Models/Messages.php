<?php
namespace Messages\Models;

use Illuminate\Database\Eloquent\Model;


class Messages extends Model{


    protected $table='messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'subject', 'body', 'status', 'recipient_user','sender',  'recipient_company',
    ];

    public $timestamps = true;


    public function user()
    {
        return $this->hasOne('App\User', 'id', 'sender');
    }

}
