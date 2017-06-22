<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Support\Facades\Auth;

class TokenEntrustAbility extends BaseMiddleware
{
    public function handle($request, Closure $next, $roles, $permissions, $validateAll = false, $guard = null)
    {

        if (Auth::check()) {
            return redirect('/home');
        }else{

            if (! $token = $this->auth->setRequest($request)->getToken()) {

                $credentials = $request->only('email', 'password');

                try {
                    // verify the credentials and create a token for the user
                    if (! $token = JWTAuth::attempt($credentials)) {
                        return response()->json(['error' => 'invalid_credentials'], 401);
                    }
                } catch (JWTException $e) {
                    // something went wrong
                    return response()->json(['error' => 'could_not_create_token'], 500);
                }
                // if no errors are encountered we can return a JWT
                return response()->json(compact('token'));

             //   return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
            }

            try {
                $user = $this->auth->authenticate($token);
            } catch (TokenExpiredException $e) {
                return $this->respond('tymon.jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
            } catch (JWTException $e) {
                var_dump('test', $e);
                return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
            }

            if (! $user) {
                return $this->respond('tymon.jwt.user_not_found', 'user_not_found', 404);
            }

            if (!$request->user()->ability(explode('|', $roles), explode('|', $permissions), array('validate_all' => $validateAll))) {

                //var_dump($permissions);
                return $this->respond('tymon.jwt.invalid', 'token_invalid', 401, 'Unauthorized');
            }

            $this->events->fire('tymon.jwt.valid', $user);
        }




        return $next($request);
    }
}