<?php

namespace App\Http\Middleware;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new HttpResponseException(
            response()->json([
                'error' => 'Unauthorized',
            ], 401)
        );
    }
}
