<?php

namespace App\Http\Controllers;

use JWTAuth;

use League\Flysystem\Exception;
use Validator;
use Config;
use App\User;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
//use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Messages\Messages;
use Messages\Models\Messages as MessageModel;

class ApiController extends Controller
{
    /**
     * @return string
     */
    public function company_users()
    {
        $user = User::where('id', '=', Auth::user()->id)->first();
        $company = $user->company[0]->id;
        $compusers = Company::where('id', '=', $company)->first();
        $company_users = [];
        foreach($compusers->users as $compuser)
        {
            $company_users[] = [
                'id' => $compuser->id,
                'firstname' => $compuser->first_name,
                'lastname' => $compuser->last_name
            ];
        }

        return json_encode($company_users);

    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->response->errorUnauthorized();
            }
        } catch (JWTException $e) {
            return $this->response->error('could_not_create_token', 500);
        }

        return response()->json(compact('token'));
    }

    public function signup(Request $request)
    {
        $signupFields =  ['name', 'email', 'password'];

            //Config::get('boilerplate.signup_fields');
        $hasToReleaseToken = env('API_SIGNUP_TOKEN_RELEASE', true);

            //Config::get('boilerplate.signup_token_release');

        $userData = $request->only($signupFields);

        $rules =  [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];

        $validator = Validator::make($userData, $rules);

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        User::unguard();
        $user = User::create($userData);
        User::reguard();

        if(!$user->id) {
            return $this->response->error('could_not_create_user', 500);
        }

        if($hasToReleaseToken) {
            return $this->login($request);
        }

        return $this->response->created();
    }

    public function recovery(Request $request)
    {
        $validator = Validator::make($request->only('email'), [
            'email' => 'required'
        ]);

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject(env('API_RECOVERY_EMAIL_SUBJECT', true));
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return $this->response->noContent();
            case Password::INVALID_USER:
                return $this->response->errorNotFound();
        }
    }

    public function reset(Request $request)
    {
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $validator = Validator::make($credentials, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        if($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        $response = Password::reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                if(env('API_RESET_TOKEN_RELEASE', true)) {
                    return $this->login($request);
                }
                return $this->response->noContent();

            default:
                return $this->response->error('could_not_reset_password', 500);
        }
    }


    /**
     * @param $usermessages
     * @return array
     */
    public function user_messages($usermessages)
    {
        foreach($usermessages->where('sender', '=', Auth::user()->id)->get() as $usermessage)
        {

           $usermessage = [
               'type' => $usermessage['type'],
               'subject' => $usermessage['subject'],
               'body' => $usermessage['body'],
               'status' => $usermessage['created'],
               'recipient_user' => $usermessage['recipient_user'],
               'sender' => $usermessage['sender']
           ];
        }
        return array($usermessage);
    }

    /**
     * @param Request $request
     * @param User $user
     * @param MessageModel $usermessages
     */
    public function create_message(Request $request, User $user, MessageModel $usermessages)
    {
        $message = Messages::factory('DirectMessage');
        $message->create(
                $request->input('type'),
                $request->input('subject'),
                $request->input('body'),
                $request->input('status'),
                $request->input('to'),
                Auth::user()->id
            );
    }
}