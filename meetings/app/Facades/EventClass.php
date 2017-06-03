<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;

/**
 * Created by PhpStorm.
 * User: jpage
 * Date: 6/3/17
 * Time: 3:12 PM
 */
class EventClass extends Facade
{
    protected static function getFacadeAccessor() { return 'eventclass'; }
}
