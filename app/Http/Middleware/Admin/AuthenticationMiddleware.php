<?php

namespace App\Http\Middleware\Admin;

use App\Traits\Admin\Authentication;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        if (empty(self::auth()->id)) {
            return redirect()->action('Admin\Auth\LoginController@getIndex')
                ->with([
                    'message' => "You must login first !"
                ]);
        }

        if (!empty(self::auth()->id)) {
            if ($request->is('/admin/lockscreen') || Session::get('lockscreen') == 1) {
                return redirect('/admin/lockscreen');
            }
        }

        return $next($request);
    }
}
