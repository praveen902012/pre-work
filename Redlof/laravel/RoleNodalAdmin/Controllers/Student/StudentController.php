<?php

namespace Redlof\RoleNodalAdmin\Controllers\Student;

use Exceptions\EntityNotFoundException;
use Illuminate\Http\Request;
use Redlof\RoleNodalAdmin\Controllers\Role\RoleNodalAdminBaseController;

class StudentController extends RoleNodalAdminBaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllottedStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->where('status', 'allotted')
            ->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getStudentsAll(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->whereHas('basic_details', function ($query) {
                $query->where('status', 'completed');
            })
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getAllAllottedStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->where('status', 'allotted')
            ->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getSearchAllottedStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->whereHas('basic_details', function ($query) use ($request) {
                $query->where('first_name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('registration_no', $request['s']);
            })
            ->where('status', 'allotted')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getSearchByNameAllStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['school', 'basic_details', 'basic_details.level'])
            ->whereIn('registration_id', $reg_ids)
            ->whereHas('basic_details', function ($query) use ($request) {
                $query->where('first_name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('registration_no', $request['s']);
            })
            ->whereHas('basic_details', function ($query) {
                $query->where('status', 'completed');
            })
            ->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getSearchByNameVerifyStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->whereHas('basic_details', function ($query) use ($request) {
                $query->where('first_name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('registration_no', $request['s']);
            })
            ->whereHas('basic_details', function ($query) {
                $query->where('status', 'completed');
            })
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getSearchByNameEnrolledStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details', 'basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->whereHas('basic_details', function ($query) use ($request) {
                $query->where('first_name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('registration_no', $request['s']);
            })
            ->where('status', 'enrolled')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getSearchByNameAllRejectedStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details', 'basic_details.level', 'school'])
            ->whereHas('basic_details', function ($query) use ($request) {
                $query->where('first_name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('registration_no', $request['s']);
            })
            ->whereIn('registration_id', $reg_ids)
            ->where('document_verification_status', 'rejected')
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getSearchVerifiedStudents(Request $request)
    {
        $state_id = $this->state->id;
        $nodal_id = $this->state_nodal->id;
        $subParameters = [];
        $subParameters['nodal_id'] = $nodal_id;
        $subParameters['s'] = $request['s'];

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'school'])
            ->where('application_cycle_id', function ($query) use ($state_id) {
                $query->select('id')->where('state_id', $state_id)
                // ->where('status', 'completed')
                    ->orderBy('created_at', 'desc')
                    ->from(with(new \Models\ApplicationCycle)->getTable());
            })
            ->where('status', 'allotted')
            ->where('document_verification_status', 'verified')
            ->whereIn('allotted_school_id', function ($query) use ($subParameters) {
                $query->select('school_id')->where('nodal_id', $subParameters['nodal_id'])->where('school_id', $subParameters['s'])
                    ->from(with(new \Models\SchoolNodal)->getTable());
            })
            ->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getSearchByNameVerifiedStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->whereHas('basic_details', function ($query) use ($request) {
                $query->where('first_name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('registration_no', $request['s']);
            })
            ->where('document_verification_status', 'verified')
            ->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getSearchRejectedStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details', 'basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->whereHas('basic_details', function ($query) use ($request) {
                $query->where('first_name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('registration_no', $request['s']);
            })
            ->where('status', 'dismissed')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getSearchByNameRejectedStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->whereHas('basic_details', function ($query) use ($request) {
                $query->where('first_name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('registration_no', $request['s']);
            })
            ->where('document_verification_status', 'rejected')
            ->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getAllStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'school'])
            ->whereHas('basic_details', function ($query) {

                $query->where('status', 'completed');
            })
            ->whereIn('registration_id', $reg_ids)
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getDownloadAllStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
            ->whereHas('basic_details', function ($query) {

                $query->where('status', 'completed');
            })
            ->whereIn('registration_id', $reg_ids)
            ->orderBy('created_at', 'desc')
            ->get();

        $type = 'all-students-list';

        return $this->downloadStudents($students, $type);
    }

    public function getDownloadAllottedStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
            ->whereIn('registration_id', $reg_ids)
            ->where('status', 'allotted')
            ->distinct()
            ->get();

        $type = 'all-allotted-list';

        return $this->downloadStudents($students, $type);
    }

    public function getDownloadAllAllottedStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->whereHas('basic_details', function ($query) {
                $query->where('status', 'completed');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $items = [];

        if (count($students) != 0) {
            foreach ($students as $student) {

                $student = $student->toArray();
                $InnData['Registration No.'] = $student['basic_details']['registration_no'];
                $InnData['Student Name'] = $student['basic_details']['first_name'];
                $InnData['Status'] = $student['basic_details']['status'];
                $InnData['DOB'] = $student['basic_details']['dob'];
                $InnData['Class'] = $student['basic_details']['level']['level'];
                $InnData['School'] = $student['school']['name'];
                $InnData['Document verification status'] = $student['doc_verification_status'];
                $items[] = $InnData;
            }
        }

        $reports = \Excel::create('allotted-students-list', function ($excel) use ($items) {

            $excel->sheet('Allotted Students List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });
        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'all-students-list.xlsx', 'data' => asset('temp/allotted-students-list.xlsx')], 200);
    }

    public function getEnrolledStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);
        $students = \Models\RegistrationCycle::with(['basic_details', 'basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->where('status', 'enrolled')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getDownloadEnrolledStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
            ->whereIn('registration_id', $reg_ids)
            ->where('status', 'enrolled')
            ->get();

        $type = 'all-enrolled-list';

        return $this->downloadStudents($students, $type);
    }

    public function getDownloadVerifiedDocStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details', 'basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->whereHas('basic_details', function ($query) {
                $query->where('status', 'completed');
            })
            ->where('document_verification_status', 'verified')
            ->orderBy('created_at', 'desc')
            ->get();

        $items = [];

        if (count($students) != 0) {
            foreach ($students as $student) {

                $student = $student->toArray();
                $InnData['Registration No.'] = $student['basic_details']['registration_no'];
                $InnData['Student Name'] = $student['basic_details']['first_name'];
                $InnData['Status'] = $student['basic_details']['status'];
                $InnData['DOB'] = $student['basic_details']['dob'];
                $InnData['Class'] = $student['basic_details']['level']['level'];
                $InnData['School'] = $student['school']['name'];
                $InnData['Document verification status'] = $student['doc_verification_status'];
                $items[] = $InnData;
            }
        }

        $reports = \Excel::create('verified-doc-students-list', function ($excel) use ($items) {

            $excel->sheet('Verified Doc Students List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });
        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'verified-doc-students-list.xlsx', 'data' => asset('temp/verified-doc-students-list.xlsx')], 200);
    }

    public function getDownloadRejectedDocStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details', 'basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->whereHas('basic_details', function ($query) {
                $query->where('status', 'completed');
            })
            ->where('document_verification_status', 'rejected')
            ->orderBy('created_at', 'desc')
            ->get();

        $items = [];

        if (count($students) != 0) {
            foreach ($students as $student) {

                $student = $student->toArray();
                $InnData['Registration No.'] = $student['basic_details']['registration_no'];
                $InnData['Student Name'] = $student['basic_details']['first_name'];
                $InnData['Status'] = $student['basic_details']['status'];
                $InnData['DOB'] = $student['basic_details']['dob'];
                $InnData['Class'] = $student['basic_details']['level']['level'];
                $InnData['School'] = $student['school']['name'];
                $InnData['Document verification status'] = $student['doc_verification_status'];
                $items[] = $InnData;
            }
        }

        $reports = \Excel::create('rejected-doc-students-list', function ($excel) use ($items) {

            $excel->sheet('Rejected Doc Students List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });
        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'rejected-doc-students-list.xlsx', 'data' => asset('temp/rejected-doc-students-list.xlsx')], 200);
    }

    public function getRejectedStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details', 'basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->where('status', 'dismissed')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getDownloadRejectedStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
            ->whereIn('registration_id', $reg_ids)
            ->where('status', 'dismissed')
            ->get();

        $type = 'all-rejected-list';

        return $this->downloadStudents($students, $type);
    }

    public function getDropoutPending(Request $request)
    {
        $nodal_id = $this->state_nodal->id;

        $students = \Models\RegistrationCycle::with(['basic_details', 'basic_details.level', 'school'])
            ->where('status', 'withdraw')
            ->whereIn('allotted_school_id', function ($query) use ($nodal_id) {

                $query->select('school_id')
                    ->where('nodal_id', $nodal_id)
                    ->from(with(new \Models\SchoolNodal)->getTable());
            })
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getDropoutVerified(Request $request)
    {
        $nodal_id = $this->state_nodal->id;

        $students = \Models\RegistrationCycle::with(['basic_details', 'basic_details.level', 'school'])
            ->where('status', 'dropout')
            ->whereIn('allotted_school_id', function ($query) use ($nodal_id) {

                $query->select('school_id')
                    ->where('nodal_id', $nodal_id)
                    ->from(with(new \Models\SchoolNodal)->getTable());
            })
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function postMarkStudentDropout($registration_id)
    {
        $drop = \Models\RegistrationCycle::where('registration_id', $registration_id)
            ->with('basic_details')
            ->first();

        $school_id = $drop->allotted_school_id;
        $drop->status = 'dropout';
        $drop->save();

        $dropReport = \Models\ReportCard::where('registration_id', $registration_id)
            ->update(['student_status' => 'dropped']);

        $report = \Models\ReportCard::where('registration_id', $registration_id)->first();

        $fee = \Models\SchoolLevelInfo::select('tution_fee', 'other_fee')
            ->where('school_id', $report->school_id)
            ->where('level_id', $report->level_id)
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->first();

        $attendance = \Models\AttendanceReport::where('report_id', $report->id)
            ->where('total_days', '>', 0)
            ->groupBy('report_id')
            ->count();

        // $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $report['dropped_at']);

        $total = $fee->tution_fee * $attendance;

        $alltotal = $fee->tution_fee * 12;

        $othertotal = $fee->other_fee * $attendance;

        $reportUpdate = \Models\ReportCard::where('registration_id', $registration_id)
            ->update(['tution_payable' => $total, 'amount_payable' => $alltotal, 'other_payable' => $othertotal]);

        $updateStatus = \Models\SchoolReimbursement::where('school_id', $this->school->id)
            ->update(['allow_status' => 'yes']);

        $school = \Models\School::where('id', $school_id)
            ->with('schooladmin')
            ->first();

        $input['phone'] = $school->schooladmin->user->phone;
        $input['message'] = 'Nodal admin has verified the student ' . $drop->basic_details->first_name . ' with registration number ' . $drop->basic_details->registration_no . ' as dropout. Please signin to know more.';
        \MsgHelper::sendSyncSMS($input);

        $redirect_state = route('nodaladmin.dropout.pending');

        $reloadObj['redirect'] = $redirect_state;

        return api('Student has been marked dropout', $reloadObj);
    }

    public function postRejectStudentDropout($registration_id)
    {

        $drop = \Models\RegistrationCycle::where('registration_id', $registration_id)
            ->update(['status' => 'enrolled']);

        $redirect_state = route('nodaladmin.dropout.pending');

        $reloadObj['redirect'] = $redirect_state;

        return api('Student dropout has been cancelled', $reloadObj);
    }

    public function postMarkStudentReject($registration_id)
    {

        $application_cycle = \Models\ApplicationCycle::select('id')
            ->where('state_id', $this->state->id)
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->first();

        $student = \Models\RegistrationCycle::where('registration_id', $registration_id)
            ->with('basic_details', 'school')
            ->first();

        $school_id = $student->allotted_school_id;
        $student->status = 'rejected';
        $student->save();
        $schoolSeat = \Models\AllottmentStatistic::where('school_id', $student->allotted_school_id)
            ->where('level_id', $student->basic_details->level_id)
            ->where('application_cycle_id', $application_cycle->id)
            ->orderBy('year', 'desc')
            ->first();

        if ($schoolSeat->allotted_seats > 0) {
            $schoolSeat->allotted_seats = $schoolSeat->allotted_seats - 1;
        }

        if ($schoolSeat->full_house == true) {
            $schoolSeat->full_house = false;
        }

        $schoolSeat->save();

        $applicant = \Models\RegistrationBasicDetail::select('first_name', 'middle_name', 'last_name', 'id', 'email', 'mobile', 'registration_no')
            ->where('id', $registration_id)
            ->first();

        if (isset($applicant->email) && !empty($applicant->email)) {

            $EmailData = array(
                'registration_no' => $applicant->registration_no,
                'first_name' => $applicant->first_name,
                'middle_name' => $applicant->middle_name,
                'last_name' => $applicant->last_name,
                'school' => $student->school->name,
                'reason' => $student->meta_data['reason'],
            );

            $subject = 'RTE Enrollment Rejected';

            \MailHelper::sendSyncMail('state::emails.student-enrollment-rejected', $subject, $applicant->email, $EmailData);
        }

        $input['phone'] = $applicant->mobile;
        $input['message'] = "RTE your enrollment has been rejected at your prefered school";

        \MsgHelper::sendSyncSMS($input);

        $redirect_state = route('nodaladmin.rejectedstudents');

        $reloadObj['redirect'] = $redirect_state;

        return api('Student has been marked rejected', $reloadObj);
    }

    public function postCancelStudentReject($registration_id)
    {

        $studentUpdate = \Models\RegistrationCycle::where('registration_id', $registration_id)
            ->update(['status' => 'enrolled']);

        $reportCard = \Models\RegistrationCycle::where('registration_id', $registration_id)
            ->with(['basic_details', 'application_details', 'school', 'school.schooladmin.user'])
            ->first();

        $newReportCard = new \Models\ReportCard();

        $newReportCard['school_id'] = $reportCard->school->id;

        $newReportCard['registration_id'] = $registration_id;

        $newReportCard['application_year'] = $reportCard->application_details->session_year;

        $newReportCard['level_id'] = $reportCard->basic_details->level_id;

        $newReportCard->save();

        $months = array();

        for ($i = 0; $i < 12; $i++) {

            $timestamp = mktime(0, 0, 0, 4 + $i, 1);

            $months[date('n', $timestamp)] = date('F', $timestamp);
        }

        foreach ($months as $key => $month) {

            $newAttendance = new \Models\AttendanceReport();

            $newAttendance['report_id'] = $newReportCard->id;

            $newAttendance['month'] = $month;

            $newAttendance['total_days'] = 0;

            $newAttendance['attended_days'] = 0;

            $newAttendance->save();
        }

        $applicant = \Models\RegistrationBasicDetail::select('first_name', 'middle_name', 'last_name', 'id', 'email', 'mobile', 'registration_no')
            ->where('id', $registration_id)
            ->first();

        if (isset($applicant->email) && !empty($applicant->email)) {

            $EmailData = array(
                'registration_no' => $applicant->registration_no,
                'first_name' => $applicant->first_name,
                'middle_name' => $applicant->middle_name,
                'last_name' => $applicant->last_name,
            );

            $subject = 'RTE Enrollment Confirmation';

            \MailHelper::sendSyncMail('state::emails.student-enrollment-accepted', $subject, $applicant->email, $EmailData);
        }

        $input['phone'] = $applicant->mobile;
        $input['message'] = "RTE your enrollment has been confirmed at your prefered school ";

        \MsgHelper::sendSyncSMS($input);

        $schoolInput['phone'] = $reportCard->school->schooladmin->user->phone;
        $schoolInput['message'] = "RTE your rejected student with registration id" . $applicant->registration_no . "  has been enrolled in your school";

        \MsgHelper::sendSyncSMS($schoolInput);

        $redirect_state = route('nodaladmin.rejectedstudents');

        $reloadObj['redirect'] = $redirect_state;

        return api('Student rejection has been cancelled', $reloadObj);
    }

    public function getAllRejectedStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details', 'basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->where('document_verification_status', 'rejected')
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getDownloadAllRejectedStudents(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
            ->whereIn('registration_id', $reg_ids)
            ->where('document_verification_status', 'rejected')
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->get();

        $type = 'all-rejected-list';

        return $this->downloadStudents($students, $type);
    }

    public function verifyStudent($registration_id)
    {
        $data = \Models\RegistrationCycle::where('registration_id', $registration_id)
            ->where('application_cycle_id', $this->data['latest_application_cycle']['id'])
            ->first();

        if (empty($data)) {

            throw new EntityNotFoundException('Only current cycle students can be verified');
        }

        $data->document_verification_status = 'verified';

        $data->save();

        $data = [];

        return api('Student Verified', $data);
    }

    public function postverifyStudent($registration_id)
    {
        $data = \Models\RegistrationCycle::where('registration_id', $registration_id)
            ->where('application_cycle_id', $this->data['latest_application_cycle']['id'])
            ->update(['document_verification_status' => 'verified']);

        if (empty($data)) {

            throw new EntityNotFoundException('Only current cycle students can be verified');
        }

        $dataSend['reload'] = true;

        return api('Student Verified', $dataSend);
    }

    public function undoStudent($registration_id)
    {

        if ($registration_id) {

            $data = \Models\RegistrationCycle::where('registration_id', $registration_id)->first();

            $data->document_verification_status = null;

            $data->save();

            if ($data) {
                $data['reload'] = true;
                return api('Student Verification status Unchecked', $data);
            }
        }
    }

    public function rejectStudent(Request $request)
    {
        if ($request['registration_id']) {

            $data = \Models\RegistrationCycle::where('registration_id', $request['registration_id'])
                ->where('application_cycle_id', $this->data['latest_application_cycle']['id'])
                ->first();

            if (empty($data)) {

                throw new EntityNotFoundException('Only current cycle students can be rejected');
            }

            $data->document_verification_status = 'rejected';

            $data->doc_reject_reason = $request['rejected_reason'];

            $data->save();

            if ($data) {
                $dataSend['reload'] = true;
                return api('Student Rejected', $dataSend);
            }
        }
    }

    public function getVerifiedStudentsDocs(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->whereHas('basic_details', function ($query) {
                $query->where('status', 'completed');
            })
            ->where('document_verification_status', 'verified')
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getRejectedStudentsDocs(Request $request)
    {
        $reg_ids = $this->getStudentIds($request, $this->state_nodal->id);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'school'])
            ->whereIn('registration_id', $reg_ids)
            ->whereHas('basic_details', function ($query) {
                $query->where('status', 'completed');
            })
            ->where('document_verification_status', 'rejected')
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    private function downloadStudents($students, $type)
    {
        $items = [];

        if (count($students) != 0) {

            foreach ($students as $key => $result) {

                $result = $result->toArray();

                // $InnData['App Cycle Id'] = $result['id'];
                $InnData['Cycle'] = $result['cycle'];
                $InnData['Student Name'] = $result['basic_details']['first_name'] . ' ' . $result['basic_details']['last_name'];
                $InnData['Registration No.'] = $result['basic_details']['registration_no'];
                $InnData['Status of admission'] = ucfirst($result['status']);

                $doc_status = 'Not verified';

                if (!is_null($result['document_verification_status'])) {

                    $doc_status = $result['document_verification_status'];
                }

                $InnData['Status of verification'] = $doc_status;
                $InnData['Alloted School'] = $result['school']['name'];
                $InnData['Alloted School Udise'] = $result['school']['udise'];
                $InnData['District'] = $result['basic_details']['personal_details']['district']['name'];
                $InnData['Block'] = $result['basic_details']['personal_details']['block']['name'];
                $InnData['Ward'] = $result['basic_details']['personal_details']['locality']['name'];
                $InnData['Gender'] = $result['basic_details']['gender'];
                $InnData['Date of Birth'] = $result['basic_details']['fmt_dob'];
                $InnData['Phone Number'] = $result['basic_details']['mobile'];
                $InnData['Email'] = str_replace('=', '', $result['basic_details']['email']);
                $InnData['Class/Grade'] = $result['basic_details']['level']['level'];
                $InnData['Aadhar No'] = $result['basic_details']['aadhar_no'];
                $InnData['Aadhar Enrollment No'] = $result['basic_details']['aadhar_enrollment_no'];
                $InnData['Father Name'] = '';
                $InnData['Father Mobile No.'] = '';
                $InnData['Father Profession'] = '';
                $InnData['Mother Name'] = '';
                $InnData['Mother Mobile No.'] = '';
                $InnData['Mother Profession'] = '';
                $InnData['Guardian Name'] = '';
                $InnData['Guardian Mobile No.'] = '';
                $InnData['Guardian Profession'] = '';

                foreach ($result['basic_details']['all_parent_details'] as $key => $parent_details) {

                    $parentType = ucfirst($parent_details['parent_type']);

                    $InnData[$parentType . ' Name'] = $parent_details['parent_name'];

                    $InnData[$parentType . ' Mobile No.'] = $parent_details['parent_mobile_no'];

                    if ($parent_details['parent_profession'] == 'government') {

                        $InnData[$parentType . ' Profession'] = 'Government Services';
                    } elseif ($parent_details['parent_profession'] == 'business') {

                        $InnData[$parentType . ' Profession'] = 'Self employed / Business';
                    } elseif ($parent_details['parent_profession'] == 'private') {

                        $InnData[$parentType . ' Profession'] = 'Private Job';
                    } elseif ($parent_details['parent_profession'] == 'other') {

                        $InnData[$parentType . ' Profession'] = 'Other';
                    } elseif ($parent_details['parent_profession'] == 'home-maker') {

                        $InnData[$parentType . ' Profession'] = 'Home maker';
                    }
                }

                $InnData['Applied Category'] = '';
                $InnData['Type of DG'] = '';
                $InnData['Total Annual Income of both the Parents from all sources'] = '';
                $InnData['Caste Tehsil'] = '';
                $InnData['Caste Certificate No.'] = '';
                $InnData['Income Tehsil'] = '';
                $InnData['Income Certificate No.'] = '';
                $InnData['Income Issue Date'] = '';
                $InnData['BPL Tehsil'] = '';
                $InnData['BLP Card No.'] = '';

                if ($result['basic_details']['personal_details']['category'] == 'dg') {

                    $InnData['Applied Category'] = 'DG (Disadvantaged Group)';

                    if ($result['basic_details']['personal_details']['certificate_details']['dg_type'] == 'sc') {

                        $InnData['Type of DG'] = 'SC';
                    } elseif ($result['basic_details']['personal_details']['certificate_details']['dg_type'] == 'st') {

                        $InnData['Type of DG'] = 'ST';
                    } elseif ($result['basic_details']['personal_details']['certificate_details']['dg_type'] == 'obc') {

                        $InnData['Type of DG'] = 'OBC NCL (Income less than 4.5L)';
                    } elseif ($result['basic_details']['personal_details']['certificate_details']['dg_type'] == 'orphan') {

                        $InnData['Type of DG'] = 'Orphan';
                    } elseif ($result['basic_details']['personal_details']['certificate_details']['dg_type'] == 'with_hiv') {

                        $InnData['Type of DG'] = 'Child or Parent is HIV +ve';
                    } elseif ($result['basic_details']['personal_details']['certificate_details']['dg_type'] == 'disable') {

                        $InnData['Type of DG'] = 'Child or Parent is Differently Abled';
                    } elseif ($result['basic_details']['personal_details']['certificate_details']['dg_type'] == 'widow_women') {

                        $InnData['Type of DG'] = 'Widow women with income less than INR 80,000';
                    } elseif ($result['basic_details']['personal_details']['certificate_details']['dg_type'] == 'divorced_women') {

                        $InnData['Type of DG'] = 'Divorced women with income less than INR 80,000';
                    } elseif ($result['basic_details']['personal_details']['certificate_details']['dg_type'] == 'disable_parents') {

                        $InnData['Type of DG'] = 'Parent is Differently Abled';
                    }

                    if ($result['basic_details']['personal_details']['certificate_details']['dg_type'] == 'sc' || $result['basic_details']['personal_details']['certificate_details']['dg_type'] == 'st' || $result['basic_details']['personal_details']['certificate_details']['dg_type'] == 'obc') {

                        if (isset($result['basic_details']['personal_details']['certificate_details']['dg_tahsil_name'])) {

                            $InnData['Caste Tehsil'] = $result['basic_details']['personal_details']['certificate_details']['dg_tahsil_name'];
                        }

                        if (isset($result['basic_details']['personal_details']['certificate_details']['dg_cerificate'])) {

                            $InnData['Caste Certificate No.'] = $result['basic_details']['personal_details']['certificate_details']['dg_cerificate'];
                        }
                    }

                    if ($result['basic_details']['personal_details']['certificate_details']['dg_type'] == 'obc') {

                        if (isset($result['basic_details']['personal_details']['certificate_details']['dg_income_tahsil_name'])) {

                            $InnData['Income Tehsil'] = $result['basic_details']['personal_details']['certificate_details']['dg_income_tahsil_name'];
                        }

                        if (isset($result['basic_details']['personal_details']['certificate_details']['dg_income_cerificate'])) {

                            $InnData['Income Certificate No.'] = $result['basic_details']['personal_details']['certificate_details']['dg_income_cerificate'];
                        }

                        if (isset($result['basic_details']['personal_details']['certificate_details']['dg_cerificate_date']) && isset($result['basic_details']['personal_details']['certificate_details']['dg_cerificate_month']) && isset($result['basic_details']['personal_details']['certificate_details']['dg_cerificate_year'])) {

                            $InnData['Income Issue Date'] = $result['basic_details']['personal_details']['certificate_details']['dg_cerificate_date'] . '/' .
                                $result['basic_details']['personal_details']['certificate_details']['dg_cerificate_month'] . '/' .
                                $result['basic_details']['personal_details']['certificate_details']['dg_cerificate_year'];
                        }
                    }
                } elseif ($result['basic_details']['personal_details']['category'] == 'ews') {

                    $InnData['Applied Category'] = 'EWS';

                    if ($result['basic_details']['personal_details']['certificate_details']['ews_type'] == 'income_certificate') {

                        if (isset($result['basic_details']['personal_details']['certificate_details']['ews_tahsil_name'])) {

                            $InnData['Income Tehsil'] = $result['basic_details']['personal_details']['certificate_details']['ews_tahsil_name'];
                        }

                        if (isset($result['basic_details']['personal_details']['certificate_details']['ews_cerificate_no'])) {

                            $InnData['Income Certificate No.'] = $result['basic_details']['personal_details']['certificate_details']['ews_cerificate_no'];
                        }

                        if (isset($result['basic_details']['personal_details']['certificate_details']['ews_income'])) {

                            $InnData['Total Annual Income of both the Parents from all sources'] = $result['basic_details']['personal_details']['certificate_details']['ews_income'];
                        }

                        if (isset($result['basic_details']['personal_details']['certificate_details']['bpl_cerificate_date']) && isset($result['basic_details']['personal_details']['certificate_details']['bpl_cerificate_month']) && isset($result['basic_details']['personal_details']['certificate_details']['bpl_cerificate_year'])) {

                            $InnData['Income Issue Date'] = $result['basic_details']['personal_details']['certificate_details']['bpl_cerificate_date'] . '/' .
                                $result['basic_details']['personal_details']['certificate_details']['bpl_cerificate_month'] . '/' .
                                $result['basic_details']['personal_details']['certificate_details']['bpl_cerificate_year'];
                        }
                    } elseif ($result['basic_details']['personal_details']['certificate_details']['ews_type'] == 'bpl_card') {

                        if (isset($result['basic_details']['personal_details']['certificate_details']['ews_tahsil_name'])) {

                            $InnData['BPL Tehsil'] = $result['basic_details']['personal_details']['certificate_details']['ews_tahsil_name'];
                        }

                        if (isset($result['basic_details']['personal_details']['certificate_details']['ews_cerificate_no'])) {

                            $InnData['BLP Card No.'] = $result['basic_details']['personal_details']['certificate_details']['ews_cerificate_no'];
                        }
                    }
                }

                $InnData['State'] = $result['basic_details']['country_state']['name'];
                $InnData['District'] = $result['basic_details']['personal_details']['district']['name'];
                $InnData['Block/Nagar/Panchayat'] = $result['basic_details']['personal_details']['block']['name'];
                $InnData['Ward Name/Ward Number'] = $result['basic_details']['personal_details']['locality']['name'];
                $InnData['Pincode'] = $result['basic_details']['personal_details']['pincode'];
                $InnData['Residential address'] = $result['basic_details']['personal_details']['residential_address'];

                $items[] = $InnData;
            }
        }

        $reports = \Excel::create($type, function ($excel) use ($items, $type) {

            $excel->sheet($type, function ($sheet) use ($items) {

                // $sheet->setAutoSize(false);
                $sheet->fromArray($items);
            });
        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => $type . '.xlsx', 'data' => asset('temp/' . $type . '.xlsx')], 200);
    }

    private function getStudentIds($request, $nodal_id)
    {
        $current_year = $this->data['latest_application_cycle']['session_year'];

        if (!empty($request->selectedCycle) && $request->selectedCycle != 'null') {

            $current_year = $request->selectedCycle;
        }

        $students = \Models\RegistrationCycle::whereHas('application_details', function ($query) use ($current_year) {

            $query->where('session_year', $current_year);
        })
            ->get();

        if ($this->data['latest_application_cycle']['cycle'] > 1) {

            // get users which registered for second cycle
            // remove there first cycle entry

            $usersUnique = $students->unique('registration_id');

            $usersDupesRegistrationId = $students->diff($usersUnique)->pluck('id')->toArray();

            $delStudentIds = $students->whereIn('id', $usersDupesRegistrationId)
                ->where('cycle', '<', $this->data['latest_application_cycle']['cycle'])
                ->pluck('id')
                ->toArray();

            $students = $students->whereNotIn('id', $delStudentIds);
        }

        $schoolIds = \Models\SchoolNodal::where('nodal_id', $nodal_id)
            ->pluck('school_id')
            ->toArray();

        $reg_ids = [];

        foreach ($students as $student) {

            if (isset($student->preferences[0]) && in_array((int) $student->preferences[0], $schoolIds)) {

                array_push($reg_ids, $student->registration_id);

                continue;
            }

            if (!isset($student->preferences[0])) {

                if (isset($student->nearby_preferences[0]) && in_array($student->nearby_preferences[0], $schoolIds)) {

                    array_push($reg_ids, $student->registration_id);
                }
            }
        }

        return $reg_ids;
    }

}
