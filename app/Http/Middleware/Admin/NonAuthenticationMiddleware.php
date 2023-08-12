<?php

namespace App\Http\Middleware\Admin;

use App\Traits\Admin\Authentication;
use Closure;
use Illuminate\Http\Request;

class NonAuthenticationMiddleware
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
        if(!empty(self::auth()->id)) {
            $urlCurrent = url()->current();
            $urlCurrent = str_replace(url('/admin'), '', $urlCurrent);

            if ($request->is('admin/*')) {
                $exception = ['/login', '/forgot'];

                if (in_array($urlCurrent, $exception)) {
                    return redirect('/admin');
                }
            }
        }

        return $next($request);
    }
}
