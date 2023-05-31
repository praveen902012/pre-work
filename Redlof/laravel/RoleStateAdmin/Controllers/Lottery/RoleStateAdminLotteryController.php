<?php
namespace Redlof\RoleStateAdmin\Controllers\Lottery;

use Illuminate\Http\Request;
use Redlof\Core\Jobs\SendNotifications;
use Redlof\RoleStateAdmin\Controllers\Lottery\Requests\AddLotteryRequest;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class RoleStateAdminLotteryController extends RoleStateAdminBaseController
{

    public function postLotteryDetails(AddLotteryRequest $request)
    {

        $input['reg_start_date'] = $request->reg_start_date ? \Carbon::parse($request->reg_start_date)->addHours(12) : null;
        $input['reg_end_date'] = $request->reg_end_date ? \Carbon::parse($request->reg_end_date)->addHours(12) : null;
        $input['enrollment_end_date'] = \Carbon::parse($request->enrollment_end_date)->addHours(12);
        $input['lottery_announcement'] = $request->lottery_announcement;
        $input['session_year'] = $request->session_year;
        $input['stu_reg_start_date'] = \Carbon::parse($request->stu_reg_start_date)->addHours(12);
        $input['stu_reg_end_date'] = \Carbon::parse($request->stu_reg_end_date)->addHours(12);
        $input['state_id'] = $this->data['state_id'];
        $input['is_latest'] = true;

        $previous_sessions = \Models\ApplicationCycle::get()->pluck('session_year')->toArray();

        $prev_session = \Models\ApplicationCycle::where('is_latest', true)->first();

        if (in_array($request->session_year, $previous_sessions)) {

            if ($request->is_school_reg == 'No') {

                $input['reg_start_date'] = \Carbon::parse($prev_session->reg_start_date);
                $input['reg_end_date'] = \Carbon::parse($prev_session->reg_end_date);
            }

            $input['cycle'] = $request->cycle;
        };

        \Models\ApplicationCycle::where('is_latest', true)->update(['is_latest' => false]);

        \Models\ApplicationCycle::create($input);

        $showObject = [
            'reload' => true,
        ];

        return api('Lottery Settings have been updated', $showObject);
    }

    public function getLotteries(Request $request)
    {

        $lottery = \Models\ApplicationCycle::where('state_id', $this->data['state_id'])
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->formatDate('lottery_announcement', 'announcement_date')
            ->formatDate('enrollment_end_date', 'enrollment_deadline')
            ->preparePage($request);

        return api('Showing All lotteries', $lottery);
    }

    public function getAllottedStudent(Request $request)
    {

        $allotted_student = \Models\RegistrationCycle::select()
            ->where('status', 'allotted')
            ->page($request)
            ->get()
            ->preparePage($request);
        return api('Showing All Allotted Student', $allotted_student);

    }

    public function postEditLotteryDetails($lottery_id, AddLotteryRequest $request)
    {

        $updateLottery = \Models\ApplicationCycle::find($lottery_id);

        if ($request['reg_end_date'] != $updateLottery->orig_reg_end_date) {
            $request['reg_end_date'] = \Carbon::parse($request['reg_end_date'])->addHours(12);

        }

        if ($request['enrollment_end_date'] != $updateLottery->enrollment_end_date) {
            $request['enrollment_end_date'] = \Carbon::parse($request['enrollment_end_date'])->addHours(12);

        }

        if ($request['stu_reg_start_date'] != $updateLottery->orig_stu_reg_start_date) {

            $request['stu_reg_start_date'] = \Carbon::parse($request['stu_reg_start_date'])->addHours(12);

        }

        if ($request['stu_reg_end_date'] != $updateLottery->orig_stu_reg_end_date) {

            $request['stu_reg_end_date'] = \Carbon::parse($request['stu_reg_end_date'])->addHours(12);

        }

        $updateLottery->reg_end_date = $request['reg_end_date'];

        $updateLottery->enrollment_end_date = $request['enrollment_end_date'];

        $updateLottery->lottery_announcement = $request['lottery_announcement'];

        $updateLottery->stu_reg_end_date = $request['stu_reg_end_date'];

        $updateLottery->stu_reg_start_date = $request['stu_reg_start_date'];

        $updateLottery->save();

        $showObject = [
            'reload' => true,
        ];

        return api('Lottery Edited Sucessfully', $showObject);

    }

    public function postTriggerLottery(Request $request)
    {

        ini_set('max_execution_time', 0);

        \Helpers\LotteryIntermediateHelper::lotterySelector($this->data['state_id'], 'manual');

        $allotments = \Models\ApplicationCycle::select('id')->where('state_id', $this->state_id)->orderBy('id', 'desc')->first();

        $request->merge(['application_id' => $allotments['id']]);

        \Models\LotteryNotification::create($request->all());

        $showObject = ['reload' => true];

        return api('Lottery process is completed', $showObject);

    }

    public function postSendNotification(Request $request, $application_id)
    {

        ini_set('max_execution_time', 0);

        SendNotifications::dispatch($application_id, $this->state_id);

        $showObject = [
            'reload' => true,
        ];

        \Models\LotteryNotification::where('application_id', $application_id)->update(['status' => 'sent']);

        return api('Notification has been sent successfully', $showObject);

    }

    public function getLottery($lottery_id)
    {

        $lottery = \Models\ApplicationCycle::where('id', $lottery_id)
            ->first();

        return api('Showing lottery', $lottery);
    }

    public function searchLotteries(Request $request)
    {
        if (is_numeric($request['s']) == false) {
            return api('Showing All lotteries', ['items' => []]);

        }
        $lottery = \Models\ApplicationCycle::where('session_year', $request['s'])
            ->where('state_id', $this->data['state_id'])
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->formatDate('lottery_announcement', 'announcement_date')
            ->formatDate('enrollment_end_date', 'enrollment_deadline')
            ->preparePage($request);

        return api('Showing All lotteries', $lottery);
    }

    public function postDownloadLotteryStats(Request $request, $lottery_id)
    {

        // Get all the registrations  for the cycle
        // $registrations = \Models\RegistrationBasicDetail::where('status', 'completed')
        //     ->whereHas('registration_cycle', function ($query) use ($lottery_id) {

        //         $query->where('application_cycle_id', $lottery_id);
        //     })
        //     ->with(['registration_cycle', 'personal_details'])
        //     ->get();

        // Get all the districts
        $districts = \Models\District::where('state_id', $this->state_id)->get();

        // Get all the schools for the cycle

        $schools = \Models\School::where('application_status', 'verified')
            ->whereHas('schoolcycle', function ($query) use ($lottery_id) {

                $query->where('application_cycle_id', $lottery_id);
            })->get();

        $data = [];

        foreach ($districts as $key => $district) {

            $schoolsId = $schools->where('district_id', $district->id)->pluck('id')->toArray();

            $allotted = \Models\AllottmentStatistic::where('application_cycle_id', $lottery_id)
                ->whereIn('school_id', $schoolsId)
                ->sum('allotted_seats');

            array_push($data, ['district' => $district->name, 'allotted_seats' => $allotted]);
        }

        $reports = \Excel::create('lottery-stats', function ($excel) use ($data) {

            $excel->sheet('Schools List', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'lottery-stats.xlsx', 'data' => asset('temp/lottery-stats.xlsx')], 200);
    }
}
