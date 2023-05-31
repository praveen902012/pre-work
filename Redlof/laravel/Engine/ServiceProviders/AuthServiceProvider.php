<?php
namespace Redlof\Engine\ServiceProviders;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Models\RegistrationBasicDetail;
use Redlof\Engine\Policies\RegistrationPolicy;

class AuthServiceProvider extends ServiceProvider {
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		RegistrationBasicDetail::class => RegistrationPolicy::class,

	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->registerPolicies();
	}
}
