<?php
namespace Redlof\State\Controllers\Gallery;

use Illuminate\Http\Request;

class GalleryController {

	public function getFeaturedGallery(Request $request, $state_id) {

		$gallery = \Models\Gallery::where('state_id', $state_id)
			->where('isfeatured', 1)
			->page($request)
			->get()
			->imagePath('gallery', 'name')
			->preparePage($request);

		return api('', $gallery);

	}

	public function getStateGallery(Request $request, $state_id) {

		$gallery = \Models\Gallery::where('state_id', $state_id)
			->page($request)
			->get()
			->imagePath('gallery', 'name')
			->preparePage($request);

		return api('', $gallery);

	}

	public function postUpdateAllottment() {
		\Models\AllottmentStatistic::whereNull('application_cycle_id')
			->update([
				'application_cycle_id' => 53,
			]);

		return api('success');

	}

}