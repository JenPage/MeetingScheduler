<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use MailMessageMediator;
use Zizaco\Entrust\EntrustRole;


class Role extends EntrustRole
{

    protected $table='roles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    /**
     * Get the comments for the blog post.
     */
    public function users()
    {
        return $this->belongstoMany('App\Users', 'role_user');
    }


}
