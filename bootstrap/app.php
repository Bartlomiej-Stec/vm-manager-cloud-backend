<?php

use Illuminate\Http\Request;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Foundation\Application;
use App\Exceptions\ApplicationException;
use App\Exceptions\UserRoleNotExistsException;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AccessDeniedHttpException|UnauthorizedException $exception, Request $request) {
            throw new ApplicationException('Access denied', 403);
        });

        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            throw new ApplicationException('Not found', 404);
        });

        $exceptions->render(function (RoleDoesNotExist $exception, Request $request) {
            throw new UserRoleNotExistsException('Role does not exist', 404);
        });
    })->create();
