<?php

use App\Http\Middleware\EnsureActiveStudentAccess;
use App\Http\Middleware\EnsureAdminAccess;
use App\Http\Middleware\EnsureNewStudentAccess;
use App\Http\Middleware\EnsureParentAccess;
use App\Http\Middleware\EnsureStaffAccess;
use App\Http\Middleware\EnsureUserActive;
use App\Http\Middleware\EnsureHasTahunAjaranSession;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;

return Application::configure(basePath: dirname(__DIR__))
        ->withRouting(
                function (Router $router) {
                $router->middleware('api')
                        ->prefix('api')
                        ->group(base_path('routes/api.php'));
                
                $router->middleware('web')
                        ->group(base_path('routes/web.php'));
                
                $router->middleware(['web', 'auth', EnsureUserActive::class, EnsureAdminAccess::class, EnsureHasTahunAjaranSession::class])
                        ->prefix('admin')
                        ->group(base_path('routes/admin.php'));

                $router->middleware(['web', 'auth', EnsureUserActive::class, EnsureActiveStudentAccess::class])
                        ->prefix('student-active')
                        ->group(base_path('routes/student-active.php'));

                $router->middleware(['web', 'auth', EnsureUserActive::class, EnsureNewStudentAccess::class])
                        ->prefix('student-new')
                        ->group(base_path('routes/student-new.php'));

                $router->middleware(['web', 'auth', EnsureUserActive::class, EnsureStaffAccess::class, EnsureHasTahunAjaranSession::class])
                        ->prefix('staff')
                        ->group(base_path('routes/staff.php'));

                $router->middleware(['web', 'auth', EnsureUserActive::class, EnsureParentAccess::class])
                        ->prefix('parent')
                        ->group(base_path('routes/parent.php'));
                        
                $router->middleware('web')
                        ->prefix('auth')
                        ->group(base_path('routes/auth.php'));
                },
                commands: __DIR__.'/../routes/console.php',
                channels: __DIR__.'/../routes/channels.php',
                health: '/up',
        )
        ->withMiddleware(function (Middleware $middleware) {
                $middleware->alias([
                        'psb.schedule' => \App\Http\Middleware\CheckPsbSchedule::class,
                ]);
        })
        ->withExceptions(function (Exceptions $exceptions) {
                //
        })->create();
