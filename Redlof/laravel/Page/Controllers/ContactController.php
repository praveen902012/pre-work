<?php
namespace Redlof\Page\Controllers;

use Redlof\Core\Controllers\Controller;
use Redlof\Core\Helpers\MailHelper;
use Redlof\Page\Controllers\Requests\AddContactRequest;

class ContactController extends Controller {

	public function __construct() {

	}

	public function submitContact(AddContactRequest $request) {
		// Get Input variables
		$Data = $request->all();

		$EmailData = array(
			'name' => $Data['name'],
			'email' => $Data['email'],
			'usermessage' => $Data['message'],
		);

		// Send a mail to Admin about the contact
		\MailHelper::sendMail('page::emails.contact', 'There is an inquiry', env('MAIL_FROM'), $EmailData);

		\MailHelper::sendMail('page::emails.usercontact', 'Thanks for Contacting Us.', $Data['email'], $EmailData);

		$data['redirect'] = url('/contact');

		return api('Thanks for contacting us, will get back to you soon!', $data);
	}

}
