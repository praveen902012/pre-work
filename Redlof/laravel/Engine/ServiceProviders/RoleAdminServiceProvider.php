<?php
namespace Redlof\Engine\ServiceProviders;

use App;
use Illuminate\Support\ServiceProvider;
use View;

class RoleAdminServiceProvider extends ServiceProvider {
	/**
	 * Register the Admin module service provider.
	 *
	 * @return void
	 */
	public function register() {

		App::register('Redlof\Engine\ServiceProviders\RoleAdminRouteServiceProvider');

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
		View::addNamespace('admin', realpath(base_path('Redlof/') . 'laravel/RoleAdmin/Views'));
	}
}
