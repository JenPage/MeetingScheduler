<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Messages\Messages;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return view('home');
    }

    public function testMessage(Messages $messages)
    {
        return $messages->test_facade();
    }

    public function testOtherMessage(Messages $messages)
    {
        return $messages->test_other_facade();
    }


}
