<?php

namespace App\Http\Middleware;

use App\Models\Coach;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AlwaysAcceptJson
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->headers->set("Accept", "application/json");

        Auth::loginUsingId(Coach::query()->first()->user_id);

        return $next($request);
    }
}
