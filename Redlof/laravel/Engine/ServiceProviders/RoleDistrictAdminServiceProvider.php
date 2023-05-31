<?php
namespace Redlof\Engine\ServiceProviders;

use App;
use Illuminate\Support\ServiceProvider;
use View;

class RoleDistrictAdminServiceProvider extends ServiceProvider {
	/**
	 * Register the DistrictAdmin module service provider.
	 *
	 * @return void
	 */
	public function register() {

		App::register('Redlof\Engine\ServiceProviders\RoleDistrictAdminRouteServiceProvider');

		$this->registerBindings();
		$this->registerNamespaces();
	}

	/**
	 * Register service provider bindings
	 */
	public function registerBindings() {

	}

	/**
	 * Register the DistrictAdmin module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces() {
		View::addNamespace('districtadmin', realpath(base_path('Redlof/') . 'laravel/RoleDistrictAdmin/Views'));
	}
}
