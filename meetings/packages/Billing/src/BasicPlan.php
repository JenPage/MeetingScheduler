<?php
namespace Billing;
use Billing\Models\Plan;
use Billing\PlanInterface;

class BasicPlan implements PlanInterface{

    /**
     * @param null $opts
     * @param Plan|null $model
     * @return string
     */
    public function getPlan($opts=null, Plan $model=null)
    {
        $plan = ['basic'=> 'basic options'];
        return $plan;
    }

}