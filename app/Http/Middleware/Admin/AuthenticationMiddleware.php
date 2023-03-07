<?php

namespace App\Http\Middleware\Admin;

use App\Traits\Admin\Authentication;
use Closure;
use Illuminate\Http\Request;

class AuthenticationMiddleware
{
    use Authentication;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty($this->auth()->id)) {
            return redirect()->action('Admin\Auth\LoginController@getIndex')
                ->with([
                    'message' => "You must login first !"
                ]);
        }

        return $next($request);
    }
}
