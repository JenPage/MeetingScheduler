<?php
namespace Billing;

use Billing\Models\Plan;

use Billing\PlanInterface;

class MessagePlan implements PlanInterface{

    protected $planInterface;

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

        $messages = ['messages'=> $plan];
        $userplan = $this->planInterface->getPlan($opts=null, $model);
        return ($userplan + $messages);
    }
}
