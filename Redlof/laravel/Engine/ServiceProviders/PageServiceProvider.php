<?php
namespace Redlof\Engine\ServiceProviders;

use App;
use Illuminate\Support\ServiceProvider;
use View;

class PageServiceProvider extends ServiceProvider {
	/**
	 * Register the Page module service provider.
	 *
	 * @return void
	 */
	public function register() {

		App::register('Redlof\Engine\ServiceProviders\PageRouteServiceProvider');

		$this->registerBindings();
		$this->registerNamespaces();
	}

	/**
	 * Register service provider bindings
	 */
	public function registerBindings() {

	}

	/**
	 * Register the Page module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces() {
		//Lang::addNamespace('page', realpath(__DIR__.'/../Resources/Lang'));

		View::addNamespace('page', realpath(base_path('Redlof/') . 'laravel/Page/Views'));
	}
}
