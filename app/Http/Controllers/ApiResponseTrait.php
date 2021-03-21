<?php

namespace App\Http\Controllers;

use JWTAuth;

trait ApiResponseTrait
{
	/**
     * Send response.
     *
     * @param int $statusCode
     * @param string $message
     * @param string $responseType
     * @param mixed $response
     * @return void
     */
    public static function sendResponse(int $statusCode, string $message, string $responseType, $response=null)
    {
        return response()->json([
        	'statusCode' 	=> $statusCode,
            'message'       => $message,
            'responseType'  => $responseType,
            'response'      => $response,
        ]);
    }

    /**
     * Get logged in user
     *
     * @return App\Models\User
     */
    public static function getLoggedUser()
    {
        $user   = JWTAuth::parseToken()->authenticate();

        return $user;
    }
}
