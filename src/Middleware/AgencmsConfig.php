<?php

namespace Silvanite\AgencmsAuth\Middleware;

use Closure;
use Silvanite\AgencmsAuth\Handlers\AgencmsHandler;

class AgencmsConfig
{
    /**
     * Register Agencms endpoints
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        AgencmsHandler::registerAdmin();
        return $next($request);
    }
}
