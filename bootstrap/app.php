<?php

use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureUserContext;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'context' => EnsureUserContext::class,
        ]);

        // Garante que o contexto seja exigido em todas as rotas web autenticadas
        $middleware->appendToGroup('web', [
            EnsureUserContext::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Handler específico para UnauthorizedException do Spatie Permission
        $exceptions->render(function (UnauthorizedException $e, Request $request) {
            if (!$request->expectsJson()) {
                session()->flash('acessonegado', true);
                session()->flash('forbiddenurl', url()->current());
                session()->flash('forbiddenmessage', 'Você não possui as permissões necessárias para acessar este recurso.');

                return redirect()->back()->withInput();
            }

            return response()->json([
                'error' => 'Acesso não autorizado',
                'message' => 'Você não possui as permissões necessárias para acessar este recurso.'
            ], 403);
        });

        // Handler para AuthorizationException padrão do Laravel
        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if (!$request->expectsJson()) {
                session()->flash('acessonegado', true);
                session()->flash('forbiddenurl', url()->current());
                session()->flash('forbiddenmessage', $e->getMessage() ?: 'Você não tem permissão para acessar este recurso.');

                return redirect()->back()->withInput();
            }

            return response()->json([
                'error' => 'Acesso não autorizado',
                'message' => $e->getMessage() ?: 'Você não tem permissão para acessar este recurso.'
            ], 403);
        });

        // Handler para AccessDeniedHttpException (caso convertido automaticamente)
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if (!$request->expectsJson()) {
                session()->flash('acessonegado', true);
                session()->flash('forbiddenurl', url()->current());
                session()->flash('forbiddenmessage', $e->getMessage() ?: 'Acesso negado a este recurso.');

                return redirect()->back()->withInput();
            }

            return response()->json([
                'error' => 'Acesso não autorizado',
                'message' => $e->getMessage() ?: 'Acesso negado a este recurso.'
            ], 403);
        });

        // Handler para HttpException com status 403 especificamente
        $exceptions->render(function (HttpException $e, Request $request) {
            // APENAS se for status 403
            if ($e->getStatusCode() === 403) {
                $message = $e->getMessage();

                // Verificar se a mensagem contém indicadores de erro de permissão
                if (
                    stripos($message, 'USER DOES NOT HAVE THE RIGHT ROLES') !== false ||
                    stripos($message, 'does not have any of the necessary access rights') !== false ||
                    stripos($message, 'permission denied') !== false ||
                    stripos($message, 'access denied') !== false ||
                    stripos($message, 'unauthorized') !== false ||
                    stripos($message, 'forbidden') !== false
                ) {

                    if (!$request->expectsJson()) {
                        session()->flash('acessonegado', true);
                        session()->flash('forbiddenurl', url()->current());
                        session()->flash('forbiddenmessage', $message ?: 'Você não tem permissão para acessar este recurso.');

                        return redirect()->back()->withInput();
                    }

                    return response()->json([
                        'error' => 'Acesso não autorizado',
                        'message' => $message ?: 'Você não tem permissão para acessar este recurso.'
                    ], 403);
                }
            }
        });
    })->create();
