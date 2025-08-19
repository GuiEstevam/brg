<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return $next($request);
        }

        // Superadmin não precisa de contexto
        if (Auth::user() && Auth::user()->hasRole('superadmin')) {
            return $next($request);
        }

        // Permite acesso à tela de seleção de contexto e logout mesmo sem contexto
        $hasEmpresa = $request->session()->has('empresa_id');
        $hasFilial = $request->session()->has('filial_id');

        // Admin: exige apenas empresa
        if (Auth::user()->hasRole('admin')) {
            if (!$hasEmpresa && !$request->routeIs('context.*') && !$request->routeIs('logout')) {
                return redirect()->route('context.select');
            }
            return $next($request);
        }

        // Operador/Motorista/Veículo: exige empresa e filial
        if (
            (!$hasEmpresa || !$hasFilial)
            && !$request->routeIs('context.*')
            && !$request->routeIs('logout')
        ) {
            return redirect()->route('context.select');
        }
        return $next($request);
    }
}
