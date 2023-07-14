<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermissao
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permissao): Response
    {
        if (!Auth::check()) {
            return response(null, HttpResponse::HTTP_UNAUTHORIZED);
        }

        $usuario = Auth::user();

        if ($usuario->permissoes()->where("nome", $permissao)->exists()) {
            return $next($request);
        }


        return response(null, HttpResponse::HTTP_FORBIDDEN);
    }
}
