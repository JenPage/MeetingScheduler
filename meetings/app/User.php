<?php

namespace App;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Contracts\Auth\Authenticatable;

use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

use Illuminate\Database\Eloquent\Model;
use MessageMediatorInterface;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    use CanResetPassword;
//    use AuthenticableTrait;



protected $table='users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'company',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    private $mediator;

    public function __construct(array $attributes, $mediator)
    {
        parent::__construct($attributes);

        $this->mediator = $mediator;
    }

    /**
     * Get the user that owns the phone.
     */
    public function company()
    {
        return $this->belongsToMany('App\Company', 'company_user');
    }

    public function makeCompany($company)
    {

    }


}
