<?php
namespace Redlof\RoleStateAdmin\Controllers\Lottery;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class RoleStateAdminLotteryViewController extends RoleStateAdminBaseController {

	function getLotteryView() {
		
		$this->data['title'] = "Lottery";

		$status = 'new';

		$applicationCycle = \Models\ApplicationCycle::select('id', 'status', 'enrollment_end_date')
			->where('state_id', $this->data['state_id'])
			->orderBy('created_at', 'desc')
			->first();

		if (count($applicationCycle) > 0) {

			if ($applicationCycle->status == 'new') {

				$status = 'lottery';

			} elseif ($applicationCycle->status == 'completed' && \Carbon::parse($applicationCycle->enrollment_end_date)->gt(\Carbon::now())) {

				$status = 'enrollment';

			} elseif ($applicationCycle->status == 'completed' && \Carbon::parse($applicationCycle->enrollment_end_date)->lt(\Carbon::now())) {

				$status = 'new';
			}
		}

		$notification = \Models\LotteryNotification::where('application_id', $applicationCycle['id'])->first();

		if ($notification) {

			if ($notification['status'] == 'not_sent') {

				$show_status = true;

			} else {

				$show_status = false;
			}

		} else {

			$show_status = false;

		}

		$this->data['notification_show'] = $show_status;

		$this->data['status'] = $status;

		$this->data['application_id'] = $applicationCycle['id'];

		return view('stateadmin::lottery.lottery', $this->data);
	}

}