<?php
namespace Redlof\Core\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotifications implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels, Dispatchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $state_id;
    protected $application_cycle_id;

    public function __construct($application_cycle_id, $state_id)
    {
        $this->state_id = $state_id;
        $this->application_cycle_id = $application_cycle_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $lottery_id = $this->application_cycle_id;

        $applicants = \Models\RegistrationBasicDetail::select('id', 'first_name', 'middle_name', 'last_name', 'email', 'registration_no', 'mobile')
            ->where('state_id', $this->state_id)
            ->with(['registration_cycle', 'registration_cycle.school'])
            ->whereHas('registration_cycle', function ($query) use ($lottery_id) {
                $query->where('application_cycle_id', $lottery_id);
            })
            ->get()
            ->toArray();

        foreach ($applicants as $key => $applicant) {

            if (isset($applicant['email']) && !empty($applicant['email'])) {

                if ($applicant['registration_cycle']['status'] == 'allotted') {

                    $EmailData = array(
                        'registration_no' => $applicant['registration_no'],
                        'first_name' => $applicant['first_name'],
                        'middle_name' => $applicant['middle_name'],
                        'last_name' => $applicant['last_name'],
                        'result_message' => 'You have been allotted to ' . $applicant['registration_cycle']['school']['name'] . ', Click on Student Results to view your application status.',

                    );

                } else {

                    $EmailData = array(
                        'registration_no' => $applicant['registration_no'],
                        'first_name' => $applicant['first_name'],
                        'middle_name' => $applicant['middle_name'],
                        'last_name' => $applicant['last_name'],
                        'result_message' => 'Click on Results to view your application status.',

                    );

                }

                $subject = 'RTE Lottery Result Annoucement';

                \MailHelper::sendSyncMail('state::emails.student-lottery-result', $subject, $applicant['email'], $EmailData);

            }

            if ($applicant['registration_cycle']['status'] == 'allotted') {

                $input['message'] = "Lottery results are out for your RTE application " . $applicant['registration_no'] . ". You have been allotted to " . $applicant['registration_cycle']['school']['name'];

            } else {

                $input['message'] = "RTE lottery results are out. check out application status by clicking on Student Results. - PE Indus Action";

            }

            // $input['phone'] = $applicant['mobile'];

            $msgData = [
                "flow_id" => env('MSG_LOTTERY_FLOW_ID', '60d5cf3e86405d54f97c0eb6'),
                "phone" => $applicant['mobile'],
            ];

            \MsgHelper::sendTemplateSMS($msgData);

            $noti_msg = 'Notification Send to ' . $applicant['registration_no'];

            \Log::info($noti_msg);
        }

        return true;
    }
}
