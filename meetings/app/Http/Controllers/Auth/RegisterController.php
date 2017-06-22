<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Company;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

use Messages;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $request;

    protected $company;


    /**
     * RegisterController constructor.
     * @param Request $request
     * @param Company $company
     */
    public function __construct(Request $request, Company $company)
    {

        $this->request = $request;
        //$this->middleware('guest');
        if($request->route()->getPrefix() == 'api') {
            $this->middleware(['ability:admin,create-users']);
        }else{
            $this->middleware('guest');
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'company' => 'string'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
       $user =  User::create([
           'first_name' => $data['first_name'],
           'last_name' => $data['last_name'],
           'email' => $data['email'],
           'password' => bcrypt($data['password']),
        ]);

        if(Company::where('name', '=', $data['company'])->first())
        {
            $user_company = Company::where('name', '=',$data['company'])->first();
            $user->update(['company_id'=> $user_company->id]);
            $role = Role::where('name', '=', 'member')->first();
            $user->attachRole($role);

        }else{
            $company = Company::create(['name' => $data['company'], 'owner' => $user->id]);

            $user->update(['company_id' => $company->id]);

            $role = Role::where('name', '=', 'member')->first();

            $user->attachRole($role);
        }
        return $user;

    }
}



