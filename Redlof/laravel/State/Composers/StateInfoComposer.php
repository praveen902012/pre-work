<?php
namespace Redlof\State\Composers;
use Models\State;

/**
 * Company admin view composer
 */
class StateInfoComposer {

	public function compose($view) {

		$parameters = \Route::current()->parameters();

		$state_details = State::select('id', 'name', 'logo')->where('slug', $parameters['state'])->first();

		$view->with('state_details', $state_details);

	}

}