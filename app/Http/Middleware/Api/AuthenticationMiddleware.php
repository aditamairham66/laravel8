<?php

namespace App\Http\Middleware\Api;

use App\Helpers\Api\Response;
use App\Traits\Api\Authentication;
use Closure;
use Illuminate\Http\Request;

class AuthenticationMiddleware
{
    use Authentication;

    private $res;
    public function __construct(
        Response $res
    )
    {
        $this->res = $res;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$this->auth()->id) {
            $this->res->error('Users authorization is invalid, please login first !', 400);
        }
        return $next($request);
    }
}
