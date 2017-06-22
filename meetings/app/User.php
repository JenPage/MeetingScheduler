<?php

namespace App;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Zizaco\Entrust\Traits\EntrustUserTrait;
use Messages;



class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    use CanResetPassword;

    protected $table='users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'company_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = true;

    /**
     * Get the user's company
     */
    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }


    /**
     * Get the user that owns the phone.
     */
    public function role()
    {
        return $this->belongsToMany('App\Role', 'role_user');
    }


    public function messages()
    {
        return $this->hasMany('Messages\Models\Messages', 'sender', 'id');
    }

    public function meetings()
    {
        return $this->hasMany('App\MeetingUser', 'user_id');
    }


}
