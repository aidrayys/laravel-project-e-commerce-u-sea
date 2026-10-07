<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! session('seller_logged_in')) {
            return redirect()->route('seller.login');
        }

        return $next($request);
    }
}
