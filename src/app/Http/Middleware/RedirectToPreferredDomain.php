<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

/**
 * Class PreferredDomain
 * @package App\Http\Middleware
 */
class RedirectToPreferredDomain
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
        $url = config('app.url');

        if ($request->header('host') !== data_get(parse_url($url), 'host')) {
            $target = $url;

            if ($path = ltrim($request->path(), '/')) {
                $target .= "/".$path;
            }

            return Redirect::to($target, 301);
        }

        return $next($request);
    }
}
