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
        if(!empty($this->auth()->id)) {
            $url_prev = url()->previous();
            $url_prev = str_replace(url('/admin'), '', $url_prev);
            if ($request->segment(2) !== 'logout') {
                $exception = ['/login', '/forgot'];

                if (in_array($url_prev, $exception)) {
                    return redirect('/admin');
                } else {
                    return redirect('/admin');
                }
            }
        }

        return $next($request);
    }
}
