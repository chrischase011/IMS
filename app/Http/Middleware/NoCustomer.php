<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NoCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && in_array(Auth::user()->role->slug, ['admin', 'employee', 'sales-employee', 'purchase-employee', 'warehouse-employee', 'inventory-employee']))
            return $next($request);
        return redirect('/');
    }
}
