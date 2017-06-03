<?php
namespace Billing;
use Billing\Models\Plan;

interface PlanInterface{

    public  function getPlan($opts, Plan $model);

}