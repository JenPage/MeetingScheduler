<?php
namespace App\Helpers;

/**
 * Created by PhpStorm.
 * User: jpage
 * Date: 6/3/17
 * Time: 3:08 PM
 */
class EventClass {
    public function getFacadeTest($test='test')
    {
        return $test;
    }

    public function createEvent(){

        return 'New Event';
    }

    public function editEvent()
    {
        return 'Edit Event';
    }

    public function saveEvent()
    {
        return 'Save Event';
    }
}