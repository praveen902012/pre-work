<?php

namespace Redlof\Core\Middleware;

use Closure;
use Cookie;

class ProtectPublicAccess {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		//die('test');

		// Check if the cookie exists
		// if the cookie exists allow... or else deny
		//

		if ($request->is('join/*') || $request->is('invite/*') || $request->is('sms-join/*')) {
			return $next($request);
		}

		if ($request->is('api/*')) {
			return $next($request);
		}

		if (!$request->is('*/allow-access')) {

			$value = $request->cookie('redlof_access');

			if ($value == NULL) {
				//return redirect()->route('allowaccess');
			}
		}

		return $next($request);
	}
}
