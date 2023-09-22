<?php

namespace App\Http\Middleware\Api;

use App\Helpers\Api\Response;
use App\Traits\Api\Authentication;
use App\Traits\Api\Token;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class NonAuthenticationMiddleware
{
    use Token, Authentication;

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
        $auth = request()->header('Authorization');
        $token = $this->getToken($auth);

        try {
            // validate empty token
            if (empty($auth)) throw new \Error('Authorization not valid', 400);
            // try decode JWT token
            $this->decode($token);
        } catch (\Firebase\JWT\ExpiredException $th) {
            // catch error expired token
            // $this->res->error($th->getMessage(), 401);
            $this->res->error("Token Expired", 401);
        } catch (\Throwable $th) {
            // catch error token
            $this->res->error($th->getMessage(), ($th->getCode()?$th->getCode():400));
        }

        return $next($request);
    }
}
