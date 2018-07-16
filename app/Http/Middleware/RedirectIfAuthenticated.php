<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class RedirectIfAuthenticated
{
    
    protected $auth;

    
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
            return redirect('/');
        }

        return $next($request);
    }
}
