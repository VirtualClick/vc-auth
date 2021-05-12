<?php

namespace VirtualClickAuth;

use Closure;


final class HandleVCAuth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $vcAuth = new VCAuth($request);

        if (!$vcAuth->validaToken()) {

            abort(401, 'Unauthorized');
        }

        return $next($request);
    }
}