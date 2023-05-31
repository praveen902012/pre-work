<?php
namespace Redlof\RoleStateAdmin\Controllers\Notification;

use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class NotificationViewController extends RoleStateAdminBaseController {

	function getPopupNotifications() {

		$this->data['title'] = 'Notifications';

		$Roles = \RoleHelper::getRolesForUserSwitch();
		$this->data['roles'] = $Roles;

		return view('stateadmin::notifications.popup-notifications', $this->data);
	}

	function getDesktopNotifications() {

		$this->data['title'] = 'Notifications';

		$Roles = \RoleHelper::getRolesForUserSwitch();
		$this->data['roles'] = $Roles;

		return view('stateadmin::notifications.desktop-notifications', $this->data);
	}

	function getNotifications() {

		$this->data['title'] = 'Notifications';

		$Roles = \RoleHelper::getRolesForUserSwitch();
		
		$this->data['roles'] = $Roles;

		return view('stateadmin::notifications.all', $this->data);
	}

	function getSmsNotifications() {

		$this->data['title'] = 'Notifications';

		$Roles = \RoleHelper::getRolesForUserSwitch();
		
		$this->data['roles'] = $Roles;

		return view('stateadmin::notifications.sms-notifications', $this->data);
	}

	function getMailNotifications() {

		$this->data['title'] = 'Notifications';

		$Roles = \RoleHelper::getRolesForUserSwitch();
		$this->data['roles'] = $Roles;

		return view('stateadmin::notifications.mail-notifications', $this->data);
	}

	function getPushNotifications() {

		$this->data['title'] = 'Notifications';

		$Roles = \RoleHelper::getRolesForUserSwitch();
		$this->data['roles'] = $Roles;

		return view('stateadmin::notifications.push-notifications', $this->data);
	}

	function getPingToGalleryUploadView() {

		$this->data['title'] = 'Notifications';

		$Roles = \RoleHelper::getRolesForUserSwitch();
		$this->data['roles'] = $Roles;

		return view('stateadmin::notifications.push-gallery-upload', $this->data);
	}

	function getPingToGalleryLibraryView() {

		$this->data['title'] = 'Notifications';

		$Roles = \RoleHelper::getRolesForUserSwitch();
		$this->data['roles'] = $Roles;

		return view('stateadmin::notifications.push-gallery-library', $this->data);
	}

}