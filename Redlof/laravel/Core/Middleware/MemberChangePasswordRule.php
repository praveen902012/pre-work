<?php namespace Redlof\Core\Middleware;
use Closure;

class MemberChangePasswordRule {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {

		if (\AuthHelper::isSignedInWithCookie()) {

			$isChangesPassword = \AuthHelper::getCurrentUser()->change_pass;

			if ($isChangesPassword == TRUE) {
				$role_dashboard = route('member.enforce.change-pass', \Request::route('subdomain'));

				return redirect($role_dashboard);
			}

		}

		return $next($request);
	}
}
