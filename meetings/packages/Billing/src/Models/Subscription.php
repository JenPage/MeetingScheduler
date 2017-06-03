<?php
namespace Billing\Models;

use Illuminate\Database\Eloquent\Model;


class Subscription extends Model{


    protected $table='subscriptions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_type','event_type', 'user_type', 'owner', 'status',  'payment_due', 'payment_amount'
    ];

    public $timestamps = true;



}
