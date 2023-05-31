<?php
namespace Redlof\Engine\ServiceProviders;

use App;
use Illuminate\Support\ServiceProvider;
use View;

class RoleNodalAdminServiceProvider extends ServiceProvider {
	/**
	 * Register the Admin module service provider.
	 *
	 * @return void
	 */
	public function register() {

		App::register('Redlof\Engine\ServiceProviders\RoleNodalAdminRouteServiceProvider');

		$this->registerBindings();
		$this->registerNamespaces();
	}

	/**
	 * Register service provider bindings
	 */
	public function registerBindings() {

	}

	/**
	 * Register the Admin module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces() {
		View::addNamespace('nodaladmin', realpath(base_path('Redlof/') . 'laravel/RoleNodalAdmin/Views'));
	}
}
