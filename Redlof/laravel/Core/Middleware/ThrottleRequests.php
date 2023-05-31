<?php

namespace Redlof\Core\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ThrottleRequests {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */

	protected $limiter;

	public function __construct(RateLimiter $limiter) {
		$this->limiter = $limiter;
	}

	public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1) {
		$key = $this->resolveRequestSignature($request);

		if ($this->limiter->tooManyAttempts($key, $maxAttempts, $decayMinutes)) {
			return $this->buildResponse($key, $maxAttempts);
		}

		$this->limiter->hit($key, $decayMinutes);

		$response = $next($request);

		return $this->addHeaders(
			$response, $maxAttempts,
			$this->calculateRemainingAttempts($key, $maxAttempts)
		);
	}

	protected function resolveRequestSignature($request) {
		return $request->fingerprint();
	}

	protected function buildResponse($key, $maxAttempts) {
		$message = json_encode([
			'msg' => 'Too many attempts, please slow down the request.',
			'status' => 422,
		]);

		$response = new Response($message, 429);

		$retryAfter = $this->limiter->availableIn($key);

		return $this->addHeaders(
			$response, $maxAttempts,
			$this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
			$retryAfter
		);
	}

	protected function addHeaders(Response $response, $maxAttempts, $remainingAttempts, $retryAfter = null) {
		$headers = [
			'X-RateLimit-Limit' => $maxAttempts,
			'X-RateLimit-Remaining' => $remainingAttempts,
		];

		if (!is_null($retryAfter)) {
			$headers['Retry-After'] = $retryAfter;
			$headers['Content-Type'] = 'application/json';
		}

		$response->headers->add($headers);

		return $response;
	}

	/**
	 * Calculate the number of remaining attempts.
	 *
	 * @param  string $key
	 * @param  int $maxAttempts
	 * @param  int|null $retryAfter
	 * @return int
	 */
	protected function calculateRemainingAttempts($key, $maxAttempts, $retryAfter = null) {
		if (!is_null($retryAfter)) {
			return 0;
		}

		return $this->limiter->retriesLeft($key, $maxAttempts);
	}
}
