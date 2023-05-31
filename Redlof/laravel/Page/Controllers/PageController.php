<?php
namespace Redlof\Page\Controllers;
use Exceptions\ActionFailedException;
use Illuminate\Http\Request;
use Models\State;
use Redlof\Core\Controllers\Controller;

class PageController extends Controller {

	function __construct() {
	}

	function getAllowAccess() {
		$this->data['title'] = 'Allow Access';
		return view('page::static.allowaccess', $this->data);
	}

	function getStates() {
		$states = State::select('name', 'slug')->get();
		return api('Showing all states', $states);
	}

	function postGrantAllowAccess(Request $request) {

		$allowAccess = $request->input('allowaccess');

		if ($allowAccess === 'web@rte') {

			$msg = 'Successfully verified, now you can login using signin page.';

			setcookie('redlof_access', 'allowaccess', time() + (60 * 60 * 24), "/");

		} else {

			throw new ActionFailedException("Your password is incorrect.", 422);

		}

		$showData = [
			'redirect' => url('/'),
		];

		return response()->json(['msg' => $msg, 'show' => $showData], 200);

	}

	function getCompanyConfirmationView(Request $request) {
		$Data = [];

		$Data['user'] = \UserHelper::getUser(\AuthHelper::getCurrentUser()->id);
		$Data['token'] = $request->t;

		$request_link = urldecode($request->l);
		$Data['request_link'] = $request_link;

		$Data['title'] = 'Account Confirmation';

		return view('page::signin.company-confirmation', $Data);
	}

	//This function is used to upload bulk locality to database.

	function addLocality() {

		$data = [
			[35, 'KHARACH'],
			[35, 'Ambedkar Nagar'],
			[35, 'Tibdi'],
			[35, 'Balmiki Basti'],
			[35, 'Nirmal Chavni'],
			[35, 'Bharpuri'],
			[35, 'Kotrawan'],
			[35, 'Ravi Das Basti Kankhal'],
			[35, 'Mayapuri'],
			[35, 'Maidaniyaan'],
			[35, 'Aarchayaan'],
			[35, 'Har Ki Pauri'],
			[35, 'Bheemgoda'],
			[35, 'Sharda Nagar'],
			[35, 'Gau Ghaat'],
			[35, 'Khadkhadi'],
			[35, 'Shastri Nagar Jawalapur'],
			[35, 'Arya Nagar Jawalapur'],
			[35, 'Bhoptawala'],
			[35, 'Rishikul'],
			[35, 'Awaas Vikas'],
			[35, 'Govindpuri'],
			[35, 'ChaakLaan'],
			[35, 'Mehtaan'],
			[35, 'Krishna Nagar'],
			[35, 'LodhaMandi'],
			[35, 'Kassawaan'],
			[35, 'Pawndhoi'],
			[35, 'Rajghat'],
			[35, 'LakaadHaran'],

		];

		foreach ($data as $key => $locality) {
			$Obj = new \Models\Locality();
			$Obj->timestamps = false;
			$Obj->block_id = $locality[0];
			$Obj->name = $locality[1];
			$Obj->save();
		}

		return api('Locality as been added', $locality);
	}

}
