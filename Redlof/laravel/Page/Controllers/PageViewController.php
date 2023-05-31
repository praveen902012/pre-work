<?php
namespace Redlof\Page\Controllers;
use Models\RegistrationBasicDetail;
use Models\School;
use Models\State;
use Redlof\Core\Controllers\Controller;

class PageViewController extends Controller {

	function __construct() {
	}

	function getHome() {

		$state_name = 'uttarakhand';

		return redirect()->route('state', [$state_name]);
	}

	function getAbout() {

		$Data['title'] = 'About';

		return view('page::static.about', $Data);
	}

	function getHelp() {

		$Data['title'] = 'Help';

		return view('page::static.help', $Data);
	}

	function getContact() {

		$Data['title'] = 'Contact';

		return view('page::static.contact', $Data);
	}

	function getFaqs() {

		$Data['title'] = 'Faqs';

		return view('page::static.faqs', $Data);
	}

	function getPrivacy() {

		$Data['title'] = 'Privacy';

		return view('page::static.privacy', $Data);
	}

	function getTerms() {

		$Data['title'] = 'Terms';

		return view('page::static.terms', $Data);
	}

	function getTeam() {

		$Data['title'] = 'Team';

		return view('page::static.team', $Data);
	}

	function getFeedback() {

		$Data['title'] = 'Feedback';

		return view('page::static.feedback', $Data);
	}

	function getGallery() {

		$Data['title'] = 'Gallery';

		return view('page::static.gallery', $Data);
	}

	function getReport() {

		$Data['title'] = 'Report';

		return view('page::static.report', $Data);
	}

	function getSignIn() {

		$Data['title'] = 'SignIn';

		return view('page::signin.member-signin', $Data);
	}

	function getResendConfirmation() {

		$Data['title'] = 'Resend Confirmation';

		return view('page::signin.resend-confirmation', $Data);
	}

	function getForgotPassword() {

		$Data['title'] = 'Forgot Password';

		return view('page::signin.forgot-password', $Data);
	}

	function getChangePassword() {

		$Data['title'] = 'Change Password';

		return view('page::signin.change-password', $Data);
	}

	function getResetpassword($token) {

		$Data['title'] = 'Reset Password';
		$Data['token'] = $token;

		return view('page::signin.reset-password', $Data);
	}

	function getSignUp() {

		$Data['title'] = 'SignUp';

		return view('page::signin.member-signup', $Data);
	}

	function getAdminSignIn() {

		$Data['title'] = 'Admin Signin';

		return view('page::signin.admin-signin', $Data);
	}

}