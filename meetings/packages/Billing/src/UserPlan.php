<?php
namespace Billing;

use Billing\Models\Plan;

use Billing\PlanInterface;

class UserPlan implements PlanInterface{

    protected $planInterface;

    public $message;

    public $opts;

    public function __construct($opts, PlanInterface $planInterface)
    {
        $this->opts = $opts;
        $this->planInterface = $planInterface;
    }

    /**
     * @param $opts
     * @param Plan $model
     * @return string
     */
    public function getPlan($opts, Plan $model)
    {
        $plan = $model->getPlanInfo($this->opts);

        $users = ['users'=> $plan];

        $userplan = $this->planInterface->getPlan($opts=null, $model);

        return ($userplan + $users);
        //. $this->planInterface->getPlan($opts=null, $model);

    }



}
