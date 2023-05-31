<?php
namespace Helpers;

class LotteryIntermediateHelper {

	static function lotterySelector($state_id, $type = "auto") {

		$application_cycle = \Models\ApplicationCycle::select('id', 'cycle')
			->where('state_id', $state_id)
			->where('status', 'new')
			->orderBy('id', 'desc')
			->first();

		if ($application_cycle->cycle == 1) {

			\Helpers\LotteryTriggerHelper2::triggerLottery($state_id, $type);

		} elseif ($application_cycle->cycle > 1) {

			\Helpers\LotteryTriggerWithCycleHelper::triggerLottery($state_id, $type);
		}

	}

}
