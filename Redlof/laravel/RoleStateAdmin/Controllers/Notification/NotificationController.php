<?php
namespace Redlof\RoleStateAdmin\Controllers\Notification;
use Helpers\PingtoHelper;
use Illuminate\Http\Request;
use Redlof\Engine\SystemCommunication\PingTo;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;
use Redlof\RoleStateAdmin\Controllers\Notification\Requests\AddPingToImageRequest;
use Redlof\RoleStateAdmin\Controllers\Notification\Requests\AddNotificationRequest;
use Redlof\RoleStateAdmin\Controllers\Notification\Requests\AddStudentNotificationRequest;

class NotificationController extends RoleStateAdminBaseController {

	function getSearchUsers(Request $request) {

		$users = \Models\User::select('id', 'first_name', 'last_name', 'email')
			->whereHas('userrole', function ($query) {

				$query->where('role_id', \RoleHelper::getRoleId('role-member'));

			})
			->search($request, ['email', 'username'])
			->get();

		return api('', $users);
	}

	function getFilterUsers(Request $request) {

		$users = [];

		switch ($request->filter) {
		case 1:
			$users = $this->getLatestTenUsers();
			break;

		case 2:
			$users = $this->getOldestTenUsers();
			break;

		case 3:
			$users = $this->getAllUsers();
			break;
		}

		return api('', $users);
	}

	function getLatestTenUsers() {

		$users = \Models\User::select('id', 'first_name', 'last_name', 'email')
			->whereHas('userrole', function ($query) {
				$query->where('role_id', \RoleHelper::getRoleId('role-member'));
			})
			->orderBy('created_at', 'desc')
			->limit(10)
			->get();

		return $users;
	}

	function getOldestTenUsers() {

		$users = \Models\User::select('id', 'first_name', 'last_name', 'email')
			->whereHas('userrole', function ($query) {
				$query->where('role_id', \RoleHelper::getRoleId('role-member'));
			})
			->orderBy('created_at', 'asc')
			->limit(10)
			->get();

		return $users;
	}

	function getAllUsers() {

		$users = \Models\User::select('id', 'first_name', 'last_name', 'email')
			->whereHas('userrole', function ($query) {
				$query->where('role_id', \RoleHelper::getRoleId('role-member'));
			})
			->orderBy('created_at', 'asc')
			->get();

		return $users;
	}

	function postPopupUsers(AddNotificationRequest $request) {

		$users = \Models\User::whereIn('id', $request->member_ids)
			->select('id', 'first_name', 'last_name', 'photo', 'email')
			->get();

		foreach ($users as $key => $item) {

			$user = $users->where('id', $item['id'])->first();

			PingTo::init($user)
				->popup($request['content'])
				->trigger($request['trigger_time'], $request['expiry_time']);

		}

		$data['reload'] = true;

		return api('Popup notifications have been set to trigger', $data);
	}

	function postEmailNotifications(AddNotificationRequest $request) {

		$users = \Models\User::whereIn('id', $request->member_ids)
			->select('id', 'first_name', 'last_name', 'photo', 'email')
			->get();

		foreach ($users as $key => $user) {

			// $user = $users->where('id', $item['id'])->first();

			PingtoHelper::triggerNotification($user, $request, 'mail');

		}

		$data['reload'] = true;

		return api('Email notifications have been set to trigger', $data);
	}

	function postBrowserNotifications(AddNotificationRequest $request) {

		$users = \Models\User::whereIn('id', $request->member_ids)
			->select('id', 'first_name', 'last_name', 'photo', 'email')
			->get();

		foreach ($users as $key => $item) {

			$user = $users->where('id', $item['id'])->first();

			PingTo::init($user)
				->browser($request['content'], null)
				->trigger($request['trigger_time'], $request['expiry_time']);

		}

		$data['reload'] = true;

		return api('Browser notifications have been set to trigger', $data);
	}

	function postSMSNotifications(AddNotificationRequest $request) {

		$users = \Models\User::whereIn('id', $request->member_ids)
			->select('id', 'first_name', 'last_name', 'photo', 'email', 'phone')
			->get();

		foreach ($users as $key => $user) {

			// $user = $users->where('id', $item['id'])->first();

			PingtoHelper::triggerNotification($user, $request, 'sms');

		}

		$data['reload'] = true;

		return api('SMS notifications have been set to trigger', $data);
	}

	function postPushNotifications(AddNotificationRequest $request) {

		$users = \Models\User::whereIn('id', $request->member_ids)
			->select('id', 'first_name', 'last_name', 'photo', 'email', 'phone')
			->get();

		foreach ($users as $key => $item) {

			$user = $users->where('id', $item['id'])->first();

			PingTo::init($user)
				->mobile($request['content'])
				->trigger($request['trigger_time'], $request['expiry_time']);
		}

		$data['reload'] = true;

		return api('Push notifications have been set to trigger', $data);
	}

	function postPingToImageUpload(AddPingToImageRequest $request) {

		$filename = upload('ping-to', $request->photo, $request->access);

		\Models\SystemImage::create(['orig_name' => $request->photo->getClientOriginalName(), 'stored_name' => $filename, 'access' => $request->access]);

		$data['reload'] = true;

		return api('Uploaded image', $data);

	}

	function getPingToImages(Request $request) {
		$images = new \Models\SystemImage();

		if (isset($request['access']) && $request['access'] != 'all') {
			$images = $images->where('access', $request['access']);
		}

		$images = $images->page($request);

		if (isset($request['order_by'])) {
			$images = $images->orderBy('created_at', $request['order_by']);
		}

		$images = $images->orderBy('created_at', 'desc')
			->get()
			->humanDate('created_at', 'created_at')
			->transform(function ($item, $key) {
				$item = collect($item);

				if ($item['access'] == 'private') {
					$item['url'] = \AWSHelper::getFileUrl($item['stored_name'], '+1 week');
				} else {
					$item['url'] = \AWSHelper::getFromS3($item['stored_name'], '');
				}

				return $item;
			})
			->preparePage($request);

		return api('All PingTo Images', $images);

	}

	function getSchoolCount(Request $request) {

		if ($request->school_status != 'ban') {

			$count = \Models\School::where('application_status', $request->school_status)
				->where('state_id', $this->state_id)
				->count();

		} else {

			$count = \Models\School::where('status', $request->school_status)
				->where('state_id', $this->state_id)
				->count();

		}

		return api('', $count);

	}

	function getStudentCount(Request $request) {

		$latest_application_cycle = \Helpers\ApplicationCycleHelper::getLatestCycle();

		$query = \Models\RegistrationBasicDetail::where('status', 'completed')
							->whereHas('registration_cycle.application_details', function ($sub_query) use ($latest_application_cycle) {

								$sub_query->where('session_year', $latest_application_cycle['session_year']);
							});

		if($request->student_status == 'verified'){

			$query->whereHas('registration_cycle', function ($sub_query) {

				$sub_query->where('document_verification_status', 'verified');
			});

		}else{

			$query->whereHas('registration_cycle', function ($sub_query) use ($request){

				$sub_query->where('status', $request->student_status);
			});
		}

		$count = $query->count();

		return api('', $count);
	}

	function getSchoolAdmin(Request $request) {

		$users = \Models\SchoolAdmin::select('id', 'user_id')
			->whereIn('school_id', function ($query) use ($request) {
				$query->select('id')
					->where('application_status', $request->school_status)
					->where('state_id', $this->state_id)
					->from(with(new \Models\School)->getTable());
			});

		if ($request->notification_type == 'mail') {

			$users = $users->whereIn('user_id', function ($query) use ($request) {
				$query->select('id')
					->where('email', 'LIKE', '%@%.%')
					->from(with(new \Models\User)->getTable());
			});
		}

		$users = $users->pluck('user_id');

		return api('', $users);

	}

	function postSMSNotificationsForStudent(AddStudentNotificationRequest $request) {

		$latest_application_cycle = \Helpers\ApplicationCycleHelper::getLatestCycle();

		$query = \Models\RegistrationBasicDetail::select('id', 'first_name', 'last_name', 'photo', 'email', 'mobile', 'status')
							->where('status', 'completed')
							->whereHas('registration_cycle.application_details', function ($sub_query) use ($latest_application_cycle) {

								$sub_query->where('session_year', $latest_application_cycle['session_year']);
							});

		if($request->student_status == 'verified'){

			$query->whereHas('registration_cycle', function ($sub_query) {

				$sub_query->where('document_verification_status', 'verified');
			});

		}else{

			$query->whereHas('registration_cycle', function ($sub_query) use ($request){

				$sub_query->where('status', $request->student_status);
			});
		}

		$users = $query->get();

		foreach ($users->chunk(50) as $key => $chunk) {

			foreach ($chunk as $key => $user) {

				PingtoHelper::triggerNotification($user, $request, 'sms');
			}
		}

		$data['reload'] = true;

		return api('SMS notifications have been set to trigger', $data);
	}

}