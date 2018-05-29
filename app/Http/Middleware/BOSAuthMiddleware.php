<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use App\Models\User;

class BOSAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('token')) {
            $token = Session::get('token');
            $count = User::select('USER_ID')->where('USER_SECURITY_TOKEN',$token)->count();

            if ($count > 0) {
              return $next($request);
            }

            return redirect()->route('auth.index')->with('error',Lang::get('validation.token_is_not_validated'));

        }

        return redirect()->route('auth.index');

    }

}
