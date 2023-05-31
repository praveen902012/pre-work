<?php
namespace Redlof\Engine\ServiceProviders;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot(UrlGenerator $url) {
		if ($this->app->environment() == 'production') {

			$url->forceScheme('https');

		}

		// \DB::listen(function ($query) {

		// 	\Log::info($query->sql);

		// });
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {

		$this->app->register("Redlof\Engine\ServiceProviders\RoleAdminServiceProvider");
		$this->app->register("Redlof\Engine\ServiceProviders\RoleStateAdminServiceProvider");
		$this->app->register("Redlof\Engine\ServiceProviders\RoleDistrictAdminServiceProvider");
		$this->app->register("Redlof\Engine\ServiceProviders\RoleNodalAdminServiceProvider");
		$this->app->register("Redlof\Engine\ServiceProviders\RoleSchoolAdminServiceProvider");
		$this->app->register("Redlof\Engine\ServiceProviders\PageServiceProvider");
		$this->app->register("Redlof\Engine\ServiceProviders\StateServiceProvider");

	}
}
