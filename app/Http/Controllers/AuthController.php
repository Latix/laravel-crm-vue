<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponseTrait;

    /**
    * Create a new AuthController instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login', 'register']]);
    }

    /**
    * Get a JWT via given credentials.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function login()
    {
        $validator = Validator::make(request()->all(), [
            'email'         => ['required', 'string', 'email'],
            'password'      => ['required', 'string'],
        ]);

        if ($validator->fails()):
            return static::sendResponse(400, 'error', 'Field validation error!', [
                $validator->errors()
            ]);
        endif;

        try {
            if (! $token = JWTAuth::attempt(['email' => request('email'), 'password' => request('password')])):
                return static::sendResponse(400, 'error', 'User does not exist!', [
                    'error' => 'invalid_credentials',
                ]);
            endif;
        } catch (JWTException $e) {
            return static::sendResponse(500, 'error', 'User does not exist!', [
                    'error' => 'could_not_create_token',
            ]);
        }

        return static::sendResponse(200, 'success', 'User exists!', [
            'user'  => User::where('email', request('email'))->first(),
            'token' => $token
        ]);
    }

    /**
    * Get the authenticated User.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function user()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()):
                return static::sendResponse(404, 'error', 'User not resolved!', [
                    'error'  => 'user_not_found'
                ]);
            endif;
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return static::sendResponse($e->getStatusCode(), 'error', 'Token is expired');
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return static::sendResponse($e->getStatusCode(), 'error', 'Token is invalid');
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return static::sendResponse($e->getStatusCode(), 'error', 'Token is absent');
        }

        return static::sendResponse(200, 'success', 'User resolved!', [
            'user'  => $user
        ]);
    }
}
