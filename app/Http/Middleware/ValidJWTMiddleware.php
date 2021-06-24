<?php

namespace App\Http\Middleware;

use App\Contracts\JWTValidatorContract;
use Closure;
use Illuminate\Http\Request;

class ValidJWTMiddleware
{
    private $JWTValidator;

    public function __construct(JWTValidatorContract $JWTValidator)
    {
        $this->JWTValidator = $JWTValidator;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->JWTValidator->validate($request->bearerToken())) {
            abort(419, trans('auth.failed'));
        }
        return $next($request);
    }
}
