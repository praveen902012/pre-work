<?php namespace Redlof\Core\Middleware;

use Closure;

class CheckLanguageCookie {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	protected $except = [];

	public function handle($request, Closure $next) {

		if($request->hasCookie('lang')) {
			return $next($request);    
		}

		if (!isset($_COOKIE['lang'])) {
			setcookie('lang', 'default', time() + (129600 * 30), "/");
			header("Refresh:0");
			die();
		}

	}
}