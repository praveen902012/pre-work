<?php

namespace Redlof\Core;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {
	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 *
	 * @var array
	 */
	protected $middleware = [
		\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
		\Redlof\Core\Middleware\ProtectPublicAccess::class,
		\Redlof\Core\Middleware\OptimizeResponse::class,
		\Redlof\Core\Middleware\CheckLanguageCookie::class,

	];

	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middlewareGroups = [
		'web' => [
			\Redlof\Core\Middleware\EncryptCookies::class,
			\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
			\Illuminate\Session\Middleware\StartSession::class,
			\Illuminate\View\Middleware\ShareErrorsFromSession::class,
			\Redlof\Core\Middleware\VerifyCsrfToken::class,
			\Illuminate\Routing\Middleware\SubstituteBindings::class,
		]];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => \Redlof\Core\Middleware\Authenticate::class,
		'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
		'jwt.auth' => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
		'jwt.refresh' => \Tymon\JWTAuth\Middleware\RefreshToken::class,
		'role' => '\Redlof\Core\Middleware\TokenEntrustRole',
		'permission' => '\Redlof\Core\Middleware\TokenEntrustPermission',
		'ability' => '\Redlof\Core\Middleware\TokenEntrustAbility',
		'throttle' => \Redlof\Core\Middleware\ThrottleRequests::class,
		'revalidate' => \Redlof\Core\Middleware\PreventBackHistory::class,
		'force_password_change' => \Redlof\Core\Middleware\MemberChangePasswordRule::class,
	];
}
