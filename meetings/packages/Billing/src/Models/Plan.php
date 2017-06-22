<?php
namespace Billing\Models;

use Illuminate\Database\Eloquent\Model;


class Plan extends Model{


    protected $table='plans';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id', 'type', 'name', 'description', 'cost',
    ];

    public $timestamps = true;



    public function getPlanInfo($opts)
    {

        $plan = $this->where('name', '=', $opts)->first();

        $messageplan = $plan['attributes'];

        $plans = [
            'id' => $plan['id'],

            'type' => $plan['type'],

            'description' => $plan['description'],

            'name' => $plan['name'],

            'cost' => $plan['cost']

        ];

        return $plans;
    }


}
