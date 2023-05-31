<?php

namespace Redlof\Core\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

class TokenEntrustRole extends BaseMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $role) {

		$user = null;

		if (!$token = $this->auth->setRequest($request)->getToken()) {
			if (!$token = $request->cookie('redlof_token')) {
				$this->removeAuthCookie();

				if (!$request->ajax()) {
					$notification = array(
						'message' => 'You are not authorized to access this page',
						'alert-type' => 'error',
					);

					session()->set('notification', $notification);

					return redirect('/');
				}

				return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
			}
		}

		try {
			$user = $this->auth->authenticate($token);
		} catch (TokenExpiredException $e) {
			$this->removeAuthCookie();

			if (!$request->ajax()) {

				$notification = array(
					'message' => 'Token expired',
					'alert-type' => 'error',
				);

				session()->set('notification', $notification);
				return redirect('/');
			}

			return $this->respond('tymon.jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
		} catch (JWTException $e) {
			$this->removeAuthCookie();

			if (!$request->ajax()) {
				$notification = array(
					'message' => 'Token invalid',
					'alert-type' => 'error',
				);

				session()->set('notification', $notification);
				return redirect('/');
			}

			return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
		}

		if (!$user) {
			$this->removeAuthCookie();

			if (!$request->ajax()) {
				$notification = array(
					'message' => 'Invalid user',
					'alert-type' => 'error',
				);

				session()->set('notification', $notification);
				return redirect('/');
			}

			return $this->respond('tymon.jwt.user_not_found', 'user_not_found', 404);
		}

		if (!$user->hasRole(explode('|', $role))) {
			$this->removeAuthCookie();

			if (!$request->ajax()) {
				$notification = array(
					'message' => 'Invalid user',
					'alert-type' => 'error',
				);

				session()->set('notification', $notification);
				return redirect('/');
			}

			return $this->respond('tymon.jwt.invalid', 'token_invalid', 401, 'Unauthorized');
		}

		$this->events->fire('tymon.jwt.valid', $user);

		return $next($request);
	}

	private function removeAuthCookie() {
		setcookie("redlof_token", "", time() - 300);
		\Cookie::forget('redlof_token');
		\Cookie::queue(\Cookie::forget('redlof_token'));
		setcookie("redlof_token", "", time() - 300);

	}
}