<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

use Zizaco\Entrust\EntrustRole;


class PermissionRole extends Model
{

    protected $table='permission_role';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'permission_id'
    ];

   public  $timestamps = false;



}
