<?php
namespace Billing;

use Billing\Models\Plan;

use Billing\PlanInterface;

class EventPlan implements PlanInterface{

    protected $planInterface;

    public $opts;

    public function __construct($opts, PlanInterface $planInterface)
    {
        $this->opts = $opts;
        $this->planInterface = $planInterface;
    }

    /**d
     * @param $opts
     * @param Plan $model
     * @return string
     */
    public function getPlan($opts, Plan $model)
    {
        $plan = $model->getPlanInfo($this->opts);
        $events = ['events'=> $plan];
        $userplan = $this->planInterface->getPlan($opts=null, $model);


        return ($userplan + $events);
        //. $this->planInterface->getPlan($this->opts, $model);
    }


}
