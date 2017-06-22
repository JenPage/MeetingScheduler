<?php
namespace Meetings\Controllers;

use App\Http\Controllers\Controller;
//Iterator, Mediator, Observer, State, Chain of Responsibility, Command

class MeetingsController extends Controller {

    public function index($id)
    {
        echo $id;
    }

    public function create_meeting()
    {
        var_dump('blah');
    }
}