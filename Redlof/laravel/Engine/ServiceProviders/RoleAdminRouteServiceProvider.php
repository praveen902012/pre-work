<?php
namespace Redlof\Engine\ServiceProviders;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RoleAdminRouteServiceProvider extends ServiceProvider {
	/**
	 * This namespace is applied to the controller routes in your module's routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'Redlof\RoleAdmin\Controllers';

	/**
	 * Define your module's route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router $router
	 * @return void
	 */
	public function boot() {
		parent::boot();
	}

	/**
	 * Define the routes for the module.
	 *
	 * @param  \Illuminate\Routing\Router $router
	 * @return void
	 */
	public function map() {

		Route::group([
			'namespace' => $this->namespace,
		], function ($router) {
			$routes = array_reverse(\File::files(base_path('Redlof/') . 'laravel/RoleAdmin/Routes'));
			foreach ($routes as $route) {
				require $route;
			}
		});
	}
}
