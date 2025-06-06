<?php

declare(strict_types=1);

namespace Wave\Http\Middleware;

use Closure;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Factory as Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Wave\ApiToken;

class TokenMiddleware
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->token && strlen($request->token) <= 60) {
            $api_token = ApiToken::where('token', '=', $request->token)->first();

            if (isset($api_token->id)) {
                $token = JWTAuth::fromUser($api_token->user);
            }

        } else {
            $this->auth->authenticate();
        }

        // Then process the next request if every tests passed.
        return $next($request);
    }
}
