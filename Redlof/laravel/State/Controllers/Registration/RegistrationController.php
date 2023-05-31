<?php

namespace Redlof\State\Controllers\Registration;

use Exceptions\UnAuthorizedException;
use Exceptions\ValidationFailedException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Redlof\State\Controllers\Registration\Requests\AddStep1Request;
use Redlof\State\Controllers\Registration\Requests\AddStep2Request;
use Redlof\State\Controllers\Registration\Requests\AddStep3Request;
use Redlof\State\Controllers\Registration\Requests\AddStep4Request;
use Redlof\State\Controllers\Registration\Requests\AddStep5Request;
use Redlof\State\Controllers\Registration\Requests\AddStudentResultRequest;
use Redlof\State\Controllers\Registration\Requests\ResumeRegistrationRequest;
use Redlof\State\Controllers\Registration\Requests\VerifyOTPRequest;
use Redlof\State\Controllers\StateBaseController;
use \Exceptions\EntityNotFoundException;

class RegistrationController extends StateBaseController
{

    public function getLevels()
    {

        $levels = \Models\Level::select('id', 'level')
            ->where('entry_point', true)
            ->get();

        return api('You can start your registration process now', $levels);
    }

    public function searchSubLocality($state, $locality_id, $keyword)
    {

        $sublocalities = \Models\SubLocality::where('name', 'ilike', '%' . $keyword . '%')->where('locality_id', $locality_id)->get();

        return api('', $sublocalities);
    }

    public function searchSubSubLocality($state, $sub_locality_id, $keyword)
    {

        $subsublocalities = \Models\SubSubLocality::where('name', 'ilike', '%' . $keyword . '%')->where('sub_locality_id', $sub_locality_id)->get();

        return api('', $subsublocalities);
    }

    public function postRegistratonStep1(AddStep1Request $request)
    {
        //form dob
        // check whether there is any registration
        // with the same name, parent, name and dob
        //create random number and uudid
        //send sms to the number with registration number
        //and email with registration number if email if provided

        $file = null;

        $file_name = null;

        if ($request->hasFile('image')) {

            $file_name = $request->image->getClientOriginalName();
            $file = upload('registration/photos', $request->image);
        }

        $dob = \Carbon::createFromDate($request->dob['year'], $request->dob['month'], $request->dob['date'], 'Asia/Kolkata');

        // $uuid = \Uuid::generate(4);
        //$uuid = rand(1000000000, 9999999999);
        $uuid = rand(1, 9) * 1000000000 + rand(100000000, 999999999);
        $rand = rand(1, 9) * 1000000000 + rand(100000000, 999999999);

        $current_year = \Carbon::now()->year;

        $n_l = \Carbon::createFromDate($current_year - 5, 4, 1, 'Asia/Kolkata');
        $n_u = \Carbon::createFromDate($current_year - 3, 3, 31, 'Asia/Kolkata');

        $c_l = \Carbon::createFromDate($current_year - 6, 4, 1, 'Asia/Kolkata');
        $c_u = \Carbon::createFromDate($current_year - 5, 3, 31, 'Asia/Kolkata');

        $level = \Models\Level::select('id', 'level')->find($request->level_id);

        $final_year = \Carbon::now()->subYears(3)->format('Y');
        $inter_year = \Carbon::now()->subYears(5)->format('Y');
        $ini_year = \Carbon::now()->subYears(6)->format('Y');

        if ($level->level == 'Pre-Primary') {

            if ($dob->lt($n_l) || $dob->gt($n_u)) {
                throw new EntityNotFoundException("For Pre-Primary admission, child should be been born on or after 1st April " . $inter_year . " and on or before 31 March " . $final_year);
            }
        }

        if ($level->level == 'Class 1') {

            if ($dob->lt($c_l) || $dob->gt($c_u)) {
                throw new EntityNotFoundException("For Class 1 admission, the child should have been born on or after 1st April " . $ini_year . " and on or before 31 March " . $inter_year);
            }
        }

        $request->merge(['dob' => $dob, 'state_id' => $this->state->id, 'guid' => $uuid, 'registration_no' => $rand, 'photo_name' => $file_name, 'photo' => $file]);

        \Models\RegistrationBasicDetail::create($request->all());

        if (isset($request->email) && !empty($request->email)) {

            $EmailData = array(
                'registration_no' => $rand,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,

            );

            $subject = 'RTE Registration Initiated';

            // \MailHelper::sendSyncMail('state::emails.student-registration', $subject, $request->email, $EmailData);
        }

        $input['phone'] = $request->mobile;
        $input['message'] = 'Your RTE registration number is ' . $rand;

        \MsgHelper::sendSyncSMS($input);

        $data['redirect'] = url($this->state->slug . '/student-registration/' . $rand . '/parent-details');

        $request->session()->put('registration_no', $rand);

        $data['session_token'] = \Crypt::encrypt($rand);

        return api('Updated Personal Details', $data);
    }

    public function getRegistratonStep1(Request $request)
    {

        $registration_no = $this->validateStudentSession($request, $request->registration_no);

        $basicDetails = \Models\RegistrationBasicDetail::select('first_name', 'middle_name', 'last_name', 'gender', 'dob', 'mobile', 'email', 'level_id', 'aadhar_no', 'aadhar_enrollment_no', 'registration_no', 'photo_name', 'photo')
            ->where('registration_no', $registration_no)
            ->first();

        $dob = $basicDetails->dob;

        $except_cols = ['dob'];

        if (empty($basicDetails->aadhar_no)) {
            array_push($except_cols, 'aadhar_no');
        }

        if (empty($basicDetails->aadhar_enrollment_no)) {
            array_push($except_cols, 'aadhar_enrollment_no');
        }

        $basicDetails = collect($basicDetails)->except($except_cols)->all();

        $dob = \Carbon::parse($dob);

        $basicDetails['dob']['date'] = $dob->day;
        $basicDetails['dob']['month'] = $dob->month;
        $basicDetails['dob']['year'] = $dob->year;

        $basicDetails['level_selected'][0] = \Models\Level::select('id', 'level')->find($basicDetails['level_id']);

        return api('', $basicDetails);
    }

    public function getAPIRegistratonStep1(Request $request, $state, $reg_id, $token)
    {

        if ($token) {

            $decrypted_value = \Crypt::decrypt($token);

            if ($decrypted_value == $reg_id) {

                $registration_no = $reg_id;
            } else {

                throw new UnAuthorizedException("Token validation error");
            }
        } else {

            throw new UnAuthorizedException("Token validation error");
        }

        $basicDetails = \Models\RegistrationBasicDetail::select('first_name', 'middle_name', 'last_name', 'gender', 'dob', 'mobile', 'email', 'level_id', 'aadhar_no', 'aadhar_enrollment_no', 'registration_no')
            ->where('registration_no', $registration_no)
            ->first();

        $dob = $basicDetails->dob;

        $except_cols = ['dob'];

        if (empty($basicDetails->aadhar_no)) {
            array_push($except_cols, 'aadhar_no');
        }

        if (empty($basicDetails->aadhar_enrollment_no)) {
            array_push($except_cols, 'aadhar_enrollment_no');
        }

        $basicDetails = collect($basicDetails)->except($except_cols)->all();

        $dob = \Carbon::parse($dob);

        $basicDetails['dob']['date'] = $dob->day;
        $basicDetails['dob']['month'] = $dob->month;
        $basicDetails['dob']['year'] = $dob->year;

        $basicDetails['level_selected'][0] = \Models\Level::select('id', 'level')->find($basicDetails['level_id']);

        return api('', $basicDetails);
    }

    public function updateRegistratonStep1(AddStep1Request $request)
    {

        $registration_no = $this->validateStudentSession($request, $request->registration_no);

        $registration = \Models\RegistrationBasicDetail::select('id', 'level_id')->where('registration_no', $registration_no)->first();

        $dob = \Carbon::createFromDate($request->dob['year'], $request->dob['month'], $request->dob['date'], 'Asia/Kolkata');

        $current_year = \Carbon::now()->year;

        $n_l = \Carbon::createFromDate($current_year - 5, 4, 1, 'Asia/Kolkata');
        $n_u = \Carbon::createFromDate($current_year - 3, 3, 31, 'Asia/Kolkata');

        $c_l = \Carbon::createFromDate($current_year - 6, 4, 1, 'Asia/Kolkata');
        $c_u = \Carbon::createFromDate($current_year - 5, 3, 31, 'Asia/Kolkata');

        $level = \Models\Level::select('id', 'level')->find($request->level_id);

        $final_year = \Carbon::now()->subYears(3)->format('Y');
        $inter_year = \Carbon::now()->subYears(5)->format('Y');
        $ini_year = \Carbon::now()->subYears(6)->format('Y');

        if ($level->level == 'Pre-Primary') {

            if ($dob->lt($n_l) || $dob->gt($n_u)) {
                throw new EntityNotFoundException("For Pre-Primary admission, child should be been born on or after 1st April " . $inter_year . " and on or before 31 March " . $final_year);
            }
        }

        if ($level->level == 'Class 1') {

            if ($dob->lt($c_l) || $dob->gt($c_u)) {
                throw new EntityNotFoundException("For Class 1 admission, the child should have been born on or after 1st April " . $ini_year . " and on or before 31 March " . $inter_year);
            }
        }

        if ($request->hasFile('image')) {

            $file_name = $request->image->getClientOriginalName();

            $file = upload('registration/photos', $request->image);

            $registration->photo_name = $file_name;
            $registration->photo = $file;
        }

        // If Entry class is changed then reset all the schools selected at step5 and update state to step5

        if ($registration->level_id != $request->level_id) {

            $applicationCycle = $this->data['latest_application_cycle'];

            $schoolPreference = \Models\RegistrationCycle::where('registration_id', $registration->id)
                ->whereHas('application_details', function ($query) use ($applicationCycle) {
                    $query->where('id', $applicationCycle->id);
                })
                ->orderBy('created_at', 'desc')
                ->first();

            if (!empty($schoolPreference)) {

                $schoolPreference->preferences = null;
                $schoolPreference->nearby_preferences = null;

                $schoolPreference->save();
            }
        }

        $registration->first_name = $request->first_name;
        $registration->middle_name = $request->middle_name;
        $registration->last_name = $request->last_name;
        $registration->gender = $request->gender;
        $registration->dob = $dob;
        $registration->level_id = $request->level_id;
        $registration->mobile = $request->mobile;
        $registration->email = isset($request->email) ? $request->email : '';
        $registration->aadhar_no = isset($request->aadhar_no) ? $request->aadhar_no : '';
        $registration->aadhar_enrollment_no = isset($request->aadhar_enrollment_no) ? $request->aadhar_enrollment_no : '';

        $registration->save();

        $data['redirect'] = url($this->state->slug . '/student-registration/' . $request->registration_no . '/parent-details');

        return api('Updated Personal Details', $data);
    }

    public function updateAPIRegistratonStep1(AddStep1Request $request, $state, $reg_id, $token)
    {

        if ($token) {

            $decrypted_value = \Crypt::decrypt($token);

            if ($decrypted_value == $reg_id) {

                $registration_no = $reg_id;
            } else {

                throw new UnAuthorizedException("Token validation error");
            }
        } else {

            throw new UnAuthorizedException("Token validation error");
        }

        $registration = \Models\RegistrationBasicDetail::select('id')->where('registration_no', $registration_no)->first();

        $dob = \Carbon::createFromDate($request->dob['year'], $request->dob['month'], $request->dob['date'], 'Asia/Kolkata');

        $current_year = \Carbon::now()->year;

        $n_l = \Carbon::createFromDate($current_year - 5, 4, 1, 'Asia/Kolkata');
        $n_u = \Carbon::createFromDate($current_year - 3, 3, 31, 'Asia/Kolkata');

        $c_l = \Carbon::createFromDate($current_year - 6, 4, 1, 'Asia/Kolkata');
        $c_u = \Carbon::createFromDate($current_year - 5, 3, 31, 'Asia/Kolkata');

        $level = \Models\Level::select('id', 'level')->find($request->level_id);

        $final_year = \Carbon::now()->subYears(3)->format('Y');
        $inter_year = \Carbon::now()->subYears(5)->format('Y');
        $ini_year = \Carbon::now()->subYears(6)->format('Y');

        if ($level->level == 'Pre-Primary') {

            if ($dob->lt($n_l) || $dob->gt($n_u)) {
                throw new EntityNotFoundException("For Pre-Primary admission, child should be been born on or after 1st April " . $inter_year . " and on or before 31 March " . $final_year);
            }
        }

        if ($level->level == 'Class 1') {

            if ($dob->lt($c_l) || $dob->gt($c_u)) {
                throw new EntityNotFoundException("For Class 1 admission, the child should have been born on or after 1st April " . $ini_year . " and on or before 31 March " . $inter_year);
            }
        }

        $registration->first_name = $request->first_name;
        $registration->middle_name = $request->middle_name;
        $registration->last_name = $request->last_name;
        $registration->gender = $request->gender;
        $registration->dob = $dob;
        $registration->level_id = $request->level_id;
        $registration->mobile = $request->mobile;
        $registration->email = isset($request->email) ? $request->email : '';
        $registration->aadhar_no = isset($request->aadhar_no) ? $request->aadhar_no : '';
        $registration->aadhar_enrollment_no = isset($request->aadhar_enrollment_no) ? $request->aadhar_enrollment_no : '';

        $registration->save();

        $data['redirect'] = url($this->state->slug . '/student-registration/' . $request->registration_no . '/parent-details');

        return api('Updated Personal Details', $data);
    }

    public function postRegistratonStep2(AddStep2Request $request)
    {
        $currentDate = \Carbon::now();

        $registration_no = $this->validateStudentSession($request, $request->registration_no);

        $parent_type = [];

        foreach ($request['parent_type'] as $key => $value) {

            if ($value == 'true') {

                array_push($parent_type, $key);
            }
        }

        if ($request->category == 'ews' && $request->certificate_details['ews_type'] == 'income_certificate') {

            if (!isset($request->certificate_details['bpl_cerificate_date'])) {
                throw new EntityNotFoundException("Please Enter Certificatie Date");
            }
            if (!isset($request->certificate_details['bpl_cerificate_month'])) {
                throw new EntityNotFoundException("Please Enter Certificatie Month");
            }
            if (!isset($request->certificate_details['bpl_cerificate_year'])) {
                throw new EntityNotFoundException("Please Enter Certificatie Year");
            }

            $certificateDate = $request->certificate_details['bpl_cerificate_year'] . '/' . $request->certificate_details['bpl_cerificate_month'] . '/' . $request->certificate_details['bpl_cerificate_date'];

            $certificateDate = \Carbon::parse($certificateDate);

            if ($certificateDate->diffInMonths($currentDate) > 11) {
                throw new EntityNotFoundException("Income certificate date should be within 12 months from the current date");
            }

            if ($certificateDate->gt($currentDate)) {
                throw new EntityNotFoundException("Income certificate date should not be grater than the current date");
            }
        }

        if ($request->category == 'dg' && $request->certificate_details['dg_type'] == 'obc') {
            if (!isset($request->certificate_details['dg_cerificate_date'])) {
                throw new EntityNotFoundException("Please Enter Certificatie Date");
            }
            if (!isset($request->certificate_details['dg_cerificate_month'])) {
                throw new EntityNotFoundException("Please Enter Certificatie Month");
            }
            if (!isset($request->certificate_details['dg_cerificate_year'])) {
                throw new EntityNotFoundException("Please Enter Certificatie Year");
            }

            // Date should within six month from current date

            $certificateDate = $request->certificate_details['dg_cerificate_year'] . '-' . $request->certificate_details['dg_cerificate_month'] . '-' . $request->certificate_details['dg_cerificate_date'];

            $certificateDate = \Carbon::parse($certificateDate);

            if ($certificateDate->diffInMonths($currentDate) > 11) {
                throw new EntityNotFoundException("Income certificate date should be within 12 months from the current date");
            }

            if ($certificateDate->gt($currentDate)) {
                throw new EntityNotFoundException("Income certificate date should not be grater than the current date");
            }
        }

        $registration = \Models\RegistrationBasicDetail::select('id', 'state', 'first_name', 'dob', 'mobile')->where('registration_no', $registration_no)->first();

        $parents_name = [];

        if ($request->parent_type['father'] == 'true') {
            $parents_name[] = $request['father']['parent_name'];
        }

        if ($request->parent_type['mother'] == 'true') {
            $parents_name[] = $request['mother']['parent_name'];
        }

        if ($request->parent_type['guardian'] == 'true') {
            $parents_name[] = $request['guardian']['parent_name'];
        }

        $current_cycle = $this->data['latest_application_cycle'];

        $all_student_dobs = \Models\RegistrationBasicDetail::where('status', 'completed')
            ->where('first_name', 'ilike', $registration['first_name'])
            ->where('dob', $registration['dob'])
            ->where('registration_no', '<>', $registration_no)
            ->whereHas('registration_cycle.application_details', function (Builder $query) use ($current_cycle) {
                $query->where('session_year', $current_cycle->session_year);
            })
            ->get()
            ->pluck('id')
            ->toArray();

        // redirect student with same Name, same DOB and same Parent name
        if (count($all_student_dobs) > 0) {

            $all_parent_names = \Models\RegistrationParentDetail::whereIn('registration_id', $all_student_dobs)
                ->whereIn('parent_name', $parents_name)
                ->get()
                ->pluck('parent_name')
                ->toArray();

            if (count($all_parent_names) > 0) {

                \Models\RegistrationBasicDetail::where('registration_no', $registration_no)->update(['status' => 'inactive']);

                $request->session()->forget('registration_no');

                $data['redirect'] = url('/');
                return api('This registration is found to be invalid. Please contact the administrator.', $data);
            }
        }

        //Following is for verification purpose as described by client.

        /*if ($request->parent_type['father'] == true) {

        $all_parent_names = \Models\RegistrationParentDetail::where('parent_type', 'father')
        ->get()
        ->pluck('parent_name')->toArray();

        if (in_array($request['father']['parent_name'], $all_parent_names)) {

        $all_student_dobs = \Models\RegistrationBasicDetail::where('state', 'step5')
        ->where('first_name', $registration['first_name'])
        ->get()
        ->pluck('dob')->toArray();

        if (in_array($registration['dob'], $all_student_dobs)) {

        $request->session()->forget('registration_no');

        $data['redirect'] = url('/');

        return api('This registration is found to be invalid. Please contact the administrator.', $data);

        }

        }

        }*/

        \Models\RegistrationParentDetail::where('registration_id', $registration->id)
            ->whereNotIn('parent_type', $parent_type)
            ->delete();

        $parentDetails = \Models\RegistrationPersonalDetail::firstOrNew(['registration_id' => $registration->id]);

        $parentDetails->category = $request->category;
        $parentDetails->certificate_details = $request->certificate_details;

        $parentDetails->save();

        for ($i = 0; $i < sizeof($parent_type); $i++) {

            $registrationParentDetail = \Models\RegistrationParentDetail::firstOrNew(['registration_id' => $registration->id, 'parent_type' => $parent_type[$i]]);

            $registrationParentDetail->parent_name = $request[$parent_type[$i]]['parent_name'];
            $registrationParentDetail->parent_mobile_no = $registration['mobile'];
            $registrationParentDetail->parent_profession = $request[$parent_type[$i]]['parent_profession'];

            $registrationParentDetail->save();
        }

        if (intval($registration->state[4]) == 2) {
            $registration->state = 'step3';
        }

        $registration->save();

        $data['redirect'] = route('state.registration.address', [$this->state->slug, $registration_no]);

        return api('Updated Parent Details', $data);
    }

    public function postAPIRegistratonStep2(AddStep2Request $request, $state, $reg_id, $token)
    {

        if ($token) {

            $decrypted_value = \Crypt::decrypt($token);

            if ($decrypted_value == $reg_id) {

                $registration_no = $reg_id;
            } else {

                throw new UnAuthorizedException("Token validation error");
            }
        } else {

            throw new UnAuthorizedException("Token validation error");
        }

        $parent_type = [];

        foreach ($request['parent_type'] as $key => $value) {

            if ($value == 'true') {

                array_push($parent_type, $key);
            }
        }

        $registration = \Models\RegistrationBasicDetail::select('id', 'state')->where('registration_no', $registration_no)->first();

        \Models\RegistrationParentDetail::where('registration_id', $registration->id)
            ->whereNotIn('parent_type', $parent_type)
            ->delete();

        $parentDetails = \Models\RegistrationPersonalDetail::firstOrNew(['registration_id' => $registration->id]);

        $parentDetails->category = $request->category;
        $parentDetails->certificate_details = $request->certificate_details;

        $parentDetails->save();

        for ($i = 0; $i < sizeof($parent_type); $i++) {

            $registrationParentDetail = \Models\RegistrationParentDetail::firstOrNew(['registration_id' => $registration->id, 'parent_type' => $parent_type[$i]]);

            $registrationParentDetail->parent_name = $request[$parent_type[$i]]['parent_name'];
            $registrationParentDetail->parent_mobile_no = $request[$parent_type[$i]]['parent_mobile_no'];
            $registrationParentDetail->parent_profession = $request[$parent_type[$i]]['parent_profession'];

            $registrationParentDetail->save();
        }

        if (intval($registration->state[4]) == 2) {
            $registration->state = 'step3';
        }

        $registration->save();

        $data['redirect'] = route('state.registration.address', [$this->state->slug, $registration_no]);

        return api('Updated Parent Details', $data);
    }

    public function getRegistratonStep2(Request $request)
    {

        $registration_no = $this->validateStudentSession($request, $request->registration_no);

        $parent_type = [];
        $parent_type['father'] = false;
        $parent_type['mother'] = false;
        $parent_type['guardian'] = false;

        $parentDetails = \Models\RegistrationParentDetail::select('parent_type', 'parent_mobile_no', 'parent_profession', 'parent_name')
            ->whereHas('basic_details', function ($query) use ($registration_no) {
                $query->where('registration_no', $registration_no);
            })
            ->get();

        if (!count($parentDetails)) {

            $parent_type['father'] = true;
        }

        if (empty($parentDetails)) {
            $parentDetails = (object) [];
        }

        /*$personalInfo = \Models\RegistrationPersonalDetail::select('category', 'certificate_details')
        ->whereHas('basic_details', function ($query) use ($registration_no) {
        $query->where('registration_no', $registration_no);
        })->first();

        if (empty($personalInfo)) {
        $personalInfo = (object) [];
        }

        foreach ($parentDetails as $key => $parentDetail) {
        $parent_type[$parentDetail['parent_type']] = true;
        $personalInfo[$parentDetail['parent_type']] = $parentDetail;
        }

        $personalInfo->registration_no = $registration_no;
         */

        $personalInfo = DB::select("SELECT category,certificate_details from registration_personal_details,registration_basic_details where registration_personal_details.registration_id=registration_basic_details.id and registration_no = '" . $registration_no . "'");
        if (!empty($personalInfo)) {
            $personalInfo = $personalInfo[0];
            $personalInfo->certificate_details = (array) (json_decode($personalInfo->certificate_details));
            if (isset($personalInfo->certificate_details['bpl_income'])) {
                $personalInfo->certificate_details['bpl_income'] = (int) $personalInfo->certificate_details['bpl_income'];
            }
            if (isset($personalInfo->certificate_details['bpl_cerificate_date'])) {
                $personalInfo->certificate_details['bpl_cerificate_date'] = (int) $personalInfo->certificate_details['bpl_cerificate_date'];
            }
            if (isset($personalInfo->certificate_details['bpl_cerificate_year'])) {
                $personalInfo->certificate_details['bpl_cerificate_year'] = (int) $personalInfo->certificate_details['bpl_cerificate_year'];
            }
            if (isset($personalInfo->certificate_details['bpl_cerificate_month'])) {
                $personalInfo->certificate_details['bpl_cerificate_month'] = (int) $personalInfo->certificate_details['bpl_cerificate_month'];
            }
            if (isset($personalInfo->certificate_details['dg_cerificate_date'])) {
                $personalInfo->certificate_details['dg_cerificate_date'] = (int) $personalInfo->certificate_details['dg_cerificate_date'];
            }
            if (isset($personalInfo->certificate_details['dg_cerificate_year'])) {
                $personalInfo->certificate_details['dg_cerificate_year'] = (int) $personalInfo->certificate_details['dg_cerificate_year'];
            }
            if (isset($personalInfo->certificate_details['dg_cerificate_month'])) {
                $personalInfo->certificate_details['dg_cerificate_month'] = (int) $personalInfo->certificate_details['dg_cerificate_month'];
            }
        } else {
            $personalInfo = (object) [];
        }

        foreach ($parentDetails as $key => $parentDetail) {
            $parent_type[$parentDetail['parent_type']] = true;
            $personalInfo->{$parentDetail['parent_type']} = $parentDetail;
        }
        $personalInfo->registration_no = $registration_no;
        $personalInfo->parent_type = $parent_type;

        return api('', $personalInfo);
    }

    public function getAPIRegistratonStep2(Request $request, $state, $reg_id, $token)
    {

        if ($token) {

            $decrypted_value = \Crypt::decrypt($token);

            if ($decrypted_value == $reg_id) {

                $registration_no = $reg_id;
            } else {

                throw new UnAuthorizedException("Token validation error");
            }
        } else {

            throw new UnAuthorizedException("Token validation error");
        }

        $parent_type = [];
        $parent_type['father'] = false;
        $parent_type['mother'] = false;
        $parent_type['guardian'] = false;

        $parentDetails = \Models\RegistrationParentDetail::select('parent_type', 'parent_mobile_no', 'parent_profession', 'parent_name')
            ->whereHas('basic_details', function ($query) use ($registration_no) {
                $query->where('registration_no', $registration_no);
            })
            ->get();

        if (!count($parentDetails)) {

            $parent_type['father'] = true;
        }

        if (empty($parentDetails)) {
            $parentDetails = (object) [];
        }

        $personalInfo = \Models\RegistrationPersonalDetail::select('category', 'certificate_details')
            ->whereHas('basic_details', function ($query) use ($registration_no) {
                $query->where('registration_no', $registration_no);
            })->first();

        if (empty($personalInfo)) {
            $personalInfo = (object) [];
        }

        foreach ($parentDetails as $key => $parentDetail) {
            $parent_type[$parentDetail['parent_type']] = true;
            $personalInfo[$parentDetail['parent_type']] = $parentDetail;
        }

        $personalInfo->registration_no = $registration_no;
        $personalInfo->parent_type = $parent_type;

        return api('', $personalInfo);
    }

    public function getRegistratonStep3(Request $request)
    {

        $registration_no = $this->validateStudentSession($request, $request->registration_no);

        $addressDetails = \Models\RegistrationPersonalDetail::select('residential_address', 'locality_id', 'sub_locality_id', 'sub_sub_locality_id', 'pincode', 'district_id', 'block_id', 'address_proof', 'lat', 'lng', 'venue', 'sub_block_id', 'state_type')
            ->with(['district', 'block', 'locality', 'sublocality', 'subsublocality'])
            ->whereHas('basic_details', function ($query) use ($registration_no) {
                $query->where('registration_no', $registration_no);
            })->first();

        if (!empty($addressDetails->district)) {
            $addressDetails->district_name = $addressDetails->district->name;
        }

        if (!empty($addressDetails->block)) {

            $addressDetails->block_name = $addressDetails->block->name;
            $addressDetails->block_type = $addressDetails->block->type;
        }

        if (!empty($addressDetails->sub_block_id)) {
            $subname = \Models\Block::select('name')->where('id', $addressDetails->sub_block_id)->first();
            $addressDetails->sub_block_name = $subname->name;
        }

        if (!empty($addressDetails->locality)) {
            $addressDetails->locality_name = $addressDetails->locality->name;
        }

        if (!empty($addressDetails->sublocality)) {
            $addressDetails->sub_locality_name = $addressDetails->sublocality->name;
        }

        if (!empty($addressDetails->subsublocality)) {
            $addressDetails->sub_sub_locality_name = $addressDetails->subsublocality->name;
        }

        $addressDetails->state = $this->state;
        $addressDetails->registration_no = $registration_no;

        $addressDetails = collect($addressDetails)->except(['district', 'block', 'locality', 'sublocality', 'subsublocality'])->all();

        return api('', $addressDetails);
    }

    public function getAPIRegistratonStep3(Request $request, $state, $reg_id, $token)
    {

        if ($token) {

            $decrypted_value = \Crypt::decrypt($token);

            if ($decrypted_value == $reg_id) {

                $registration_no = $reg_id;
            } else {

                throw new UnAuthorizedException("Token validation error");
            }
        } else {

            throw new UnAuthorizedException("Token validation error");
        }

        $addressDetails = \Models\RegistrationPersonalDetail::select('residential_address', 'locality_id', 'sub_locality_id', 'sub_sub_locality_id', 'pincode', 'district_id', 'block_id', 'address_proof', 'lat', 'lng', 'venue', 'sub_block_id', 'state_type')
            ->with(['district', 'block', 'locality', 'sublocality', 'subsublocality'])
            ->whereHas('basic_details', function ($query) use ($registration_no) {
                $query->where('registration_no', $registration_no);
            })->first();

        if (!empty($addressDetails->district)) {
            $addressDetails->district_name = $addressDetails->district->name;
        }

        if (!empty($addressDetails->block)) {

            $addressDetails->block_name = $addressDetails->block->name;
        }

        if (!empty($addressDetails->locality)) {
            $addressDetails->locality_name = $addressDetails->locality->name;
        }

        if (!empty($addressDetails->sublocality)) {
            $addressDetails->sub_locality_name = $addressDetails->sublocality->name;
        }

        if (!empty($addressDetails->subsublocality)) {
            $addressDetails->sub_sub_locality_name = $addressDetails->subsublocality->name;
        }

        $addressDetails->state = $this->state;
        $addressDetails->registration_no = $registration_no;

        $addressDetails = collect($addressDetails)->except(['district', 'block', 'locality', 'sublocality', 'subsublocality'])->all();

        return api('', $addressDetails);
    }

    public function postRegistratonStep3(AddStep3Request $request)
    {

        $registration_no = $this->validateStudentSession($request, $request->registration_no);

        $registration = \Models\RegistrationBasicDetail::select('id', 'state')->where('registration_no', $registration_no)->first();

        $parentDetails = \Models\RegistrationPersonalDetail::where(['registration_id' => $registration->id])->first();

        //New changes
        if ($parentDetails->district_id != $request->district_id || $parentDetails->block_id != $request->block_id || $parentDetails->locality_id != $request->locality_id) {

            $latest_app_cyc = $this->data['latest_application_cycle'];

            $previousAddedSchool = \Models\RegistrationCycle::where('registration_id', $registration->id)
                ->whereHas('application_details', function ($query) use ($latest_app_cyc) {
                    $query->where('id', $latest_app_cyc->id);
                })
                ->first();

            if (!empty($previousAddedSchool)) {

                $previousAddedSchool->preferences = null;
                $previousAddedSchool->nearby_preferences = null;
                $previousAddedSchool->save();
            }
        }

        $parentDetails->residential_address = $request->residential_address;
        $parentDetails->pincode = $request->pincode;

        $parentDetails->district_id = $request->district_id;
        $parentDetails->block_id = $request->block_id;
        $parentDetails->locality_id = $request->locality_id;
        // $parentDetails->sub_locality_id = isset($request->sub_locality_id) ? $request->sub_locality_id : null;
        // $parentDetails->sub_sub_locality_id = isset($request->sub_sub_locality_id) ? $request->sub_sub_locality_id : null;
        $parentDetails->address_proof = $request->address_proof;
        $parentDetails->lat = $request->lat;
        $parentDetails->lng = $request->lng;
        $parentDetails->venue = $request->venue;
        $parentDetails->state_type = $request->state_type;
        $parentDetails->sub_block_id = $request->sub_block_id;

        $parentDetails->save();

        if ($request->state['id'] != $registration->state_id) {

            $registration->state_id = $request->state['id'];

            $state = \Models\State::select('id', 'slug')->find($request->state['id']);

            $data['redirect'] = url($state->slug . '/student-registration/' . $registration_no . '/verify-documents');
        } else {

            $data['redirect'] = url($this->state->slug . '/student-registration/' . $registration_no . '/verify-documents');
        }

        if (intval($registration->state[4]) == 3) {
            $registration->state = 'step4';
        }

        $registration->save();

        return api('Updated Address Details', $data);
    }

    public function postAPIRegistratonStep3(AddStep3Request $request, $state, $reg_id, $token)
    {

        if ($token) {

            $decrypted_value = \Crypt::decrypt($token);

            if ($decrypted_value == $reg_id) {

                $registration_no = $reg_id;
            } else {

                throw new UnAuthorizedException("Token validation error");
            }
        } else {

            throw new UnAuthorizedException("Token validation error");
        }

        $registration = \Models\RegistrationBasicDetail::select('id', 'state')->where('registration_no', $registration_no)->first();

        $parentDetails = \Models\RegistrationPersonalDetail::where(['registration_id' => $registration->id])->first();

        $parentDetails->residential_address = $request->residential_address;
        $parentDetails->pincode = $request->pincode;

        $parentDetails->district_id = $request->district_id;
        $parentDetails->block_id = $request->block_id;
        $parentDetails->locality_id = $request->locality_id;
        // $parentDetails->sub_locality_id = isset($request->sub_locality_id) ? $request->sub_locality_id : null;
        // $parentDetails->sub_sub_locality_id = isset($request->sub_sub_locality_id) ? $request->sub_sub_locality_id : null;
        $parentDetails->address_proof = $request->address_proof;
        $parentDetails->lat = $request->lat;
        $parentDetails->lng = $request->lng;
        $parentDetails->venue = $request->venue;

        $parentDetails->save();

        if ($request->state['id'] != $registration->state_id) {

            $registration->state_id = $request->state['id'];

            $state = \Models\State::select('id', 'slug')->find($request->state['id']);

            $data['redirect'] = url($state->slug . '/student-registration/' . $registration_no . '/verify-documents');
        } else {

            $data['redirect'] = url($this->state->slug . '/student-registration/' . $registration_no . '/verify-documents');
        }

        if (intval($registration->state[4]) == 3) {
            $registration->state = 'step4';
        }

        $registration->save();

        return api('Updated Address Details', $data);
    }

    public function getRegistratonStep4(Request $request)
    {

        $registration_no = $this->validateStudentSession($request, $request->registration_no);

        $fileDetails = \Models\RegistrationPersonalDetail::select('files')
            ->whereHas('basic_details', function ($query) use ($registration_no) {
                $query->where('registration_no', $registration_no);
            })->first();

        if (empty($fileDetails)) {
            $fileDetails = (object) [];
        }

        $fileDetails->registration_no = $registration_no;

        return api('', $fileDetails);
    }

    public function getAPIRegistratonStep4(Request $request, $state, $reg_id, $token)
    {

        if ($token) {

            $decrypted_value = \Crypt::decrypt($token);

            if ($decrypted_value == $reg_id) {

                $registration_no = $reg_id;
            } else {

                throw new UnAuthorizedException("Token validation error");
            }
        } else {

            throw new UnAuthorizedException("Token validation error");
        }

        $fileDetails = \Models\RegistrationPersonalDetail::select('files')
            ->whereHas('basic_details', function ($query) use ($registration_no) {
                $query->where('registration_no', $registration_no);
            })->first();

        if (empty($fileDetails)) {
            $fileDetails = (object) [];
        }

        $fileDetails->registration_no = $registration_no;

        return api('', $fileDetails);
    }

    public function postRegistratonStep4(AddStep4Request $request)
    {
        $registration_no = $this->validateStudentSession($request, $request->registration_no);

        // validation

        if (!isset($request->documents['proof_of_birth']) || !isset($request->documents['proof_of_parent']) || !isset($request->documents['proof_of_address'])) {

            throw new EntityNotFoundException("Please select at least one document from each section");
        }

        if (!in_array("true", $request->documents['proof_of_birth'])) {

            throw new EntityNotFoundException("Please select at least one document from birth proof documents");
        }

        if (!in_array("true", $request->documents['proof_of_parent'])) {

            throw new EntityNotFoundException("Please select at least one document from parent ID documents");
        }

        if (!in_array("true", $request->documents['proof_of_address'])) {

            throw new EntityNotFoundException("Please select at least one document from address proof documents");
        }

        $registration = \Models\RegistrationBasicDetail::select('id', 'state')->where('registration_no', $registration_no)->first();

        $fileDetails = \Models\RegistrationPersonalDetail::firstOrNew(['registration_id' => $registration->id]);

        //$files = \Helpers\RegistrationHelperClass::uploadFiles($request);

        $fileDetails->files = $request->documents;

        $fileDetails->save();

        if (intval($registration->state[4]) == 4) {
            $registration->state = 'step5';
        }
        $registration->save();

        $data['redirect'] = url($this->state->slug . '/student-registration/' . $registration_no . '/school-selection');

        return api('Updated Documents', $data);
    }

    public function postAPIRegistratonStep4(AddStep4Request $request, $state, $reg_id, $token)
    {

        if ($token) {

            $decrypted_value = \Crypt::decrypt($token);

            if ($decrypted_value == $reg_id) {

                $registration_no = $reg_id;
            } else {

                throw new UnAuthorizedException("Token validation error");
            }
        } else {

            $registration_no = $this->validateStudentSession($request, $request->registration_no);
        }

        $registration = \Models\RegistrationBasicDetail::select('id', 'state')->where('registration_no', $registration_no)->first();

        // $fileDetails = \Models\RegistrationPersonalDetail::firstOrNew(['registration_id' => $registration->id]);

        // $files = \Helpers\RegistrationHelperClass::uploadFiles($request);

        // $fileDetails->files = $files;
        // $fileDetails->save();

        if (intval($registration->state[4]) == 4) {
            $registration->state = 'step5';
        }
        $registration->save();

        $data['redirect'] = url($this->state->slug . '/student-registration/' . $registration_no . '/school-selection');

        return api('Updated Documents', $data);
    }

    public function postRegistratonStep5(AddStep5Request $request)
    {

        $schools = \Helpers\NearBySchoolHelper::getNearBySchool($request, $this->state, $this->data['latest_application_cycle']);

        if (count($schools) > 0 && !isset($request->preferences)) {
            throw new UnAuthorizedException("Please select atleast one school from your ward");
        }

        if ((!isset($request->preferences)) && (!isset($request->nearby_preferences))) {
            throw new UnAuthorizedException("Please select atleast one school as your preference");
        }

        $registration_no = $this->validateStudentSession($request, $request->registration_no);

        $applicationCycle = $this->data['latest_application_cycle'];

        if (empty($applicationCycle)) {
            throw new EntityNotFoundException("Error Processing Request");
        }

        $registration = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'mobile', 'first_name', 'middle_name', 'last_name', 'email')
            ->where('registration_no', $registration_no)
            ->first();

        $request->merge(['registration_id' => $registration->id]);

        $schoolPreference = \Models\RegistrationCycle::where('registration_id', $registration->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (empty($schoolPreference)) {

            $schoolPreference = new \Models\RegistrationCycle();

        } elseif ($schoolPreference->status == 'dismissed' || $schoolPreference->status == 'rejected') {

            $schoolPreference = new \Models\RegistrationCycle();

        } elseif ($schoolPreference->status == 'applied' && $schoolPreference->application_cycle_id != $applicationCycle->id) {

            $schoolPreference = new \Models\RegistrationCycle();
        }

        $schoolPreference->registration_id = $registration->id;

        $schoolPreference->preferences = $request->preferences;

        $schoolPreference->nearby_preferences = $request->nearby_preferences;

        $schoolPreference->application_cycle_id = $applicationCycle->id;

        $schoolPreference->cycle = $applicationCycle->cycle;

        $schoolPreference->save();

        $data['redirect'] = url($this->state->slug . '/student-registration/' . $registration_no . '/preview');

        return api('Updated School Preferences', $data);
    }

    public function postRegistratonSaveStep5(AddStep5Request $request)
    {

        if ((!isset($request->preferences)) && (!isset($request->nearby_preferences))) {

            throw new UnAuthorizedException("Please select atleast one school as your preference");
        }

        $applicationCycle = $this->data['latest_application_cycle'];

        if (empty($applicationCycle)) {
            throw new EntityNotFoundException("Error Processing Request");
        }

        $registration_no = $this->validateStudentSession($request, $request->registration_no);

        $registration = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'mobile', 'first_name', 'middle_name', 'last_name', 'email', 'status')
            ->where('registration_no', $registration_no)
            ->first();

        $request->merge(['registration_id' => $registration->id]);

        $schoolPreference = \Models\RegistrationCycle::where('registration_id', $registration->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (empty($schoolPreference)) {

            $schoolPreference = new \Models\RegistrationCycle();

        } elseif ($schoolPreference->status == 'dismissed' || $schoolPreference->status == 'rejected') {

            $schoolPreference = new \Models\RegistrationCycle();

        } elseif ($schoolPreference->status == 'applied' && $schoolPreference->application_cycle_id != $applicationCycle->id) {

            $schoolPreference = new \Models\RegistrationCycle();
        }

        $schoolPreference->registration_id = $registration->id;

        $schoolPreference->preferences = $request->preferences;

        $schoolPreference->nearby_preferences = $request->nearby_preferences;

        $schoolPreference->application_cycle_id = $applicationCycle->id;

        $schoolPreference->cycle = $applicationCycle->cycle;

        $schoolPreference->save();

        $registration->status = 'active';

        $registration->save();

        $data['redirect'] = route('state.registration.logout', [$this->state->slug, $registration_no]);

        return api('Updated School Preferences', $data);
    }

    public function postSaveData(Request $request)
    {
        $applicationCycle = $this->data['latest_application_cycle'];

        $registration = \Models\RegistrationBasicDetail::where('registration_no', $request->registration_no)->first();

        if (empty($applicationCycle) || empty($registration)) {
            throw new EntityNotFoundException("Error Processing Request");
        }

        //verify whether student has selected the school
        $student_reg_cyc = \Models\RegistrationCycle::where('registration_id', $registration->id)
            ->where('application_cycle_id', $applicationCycle->id)
            ->first();

        if (is_null($student_reg_cyc->preferences) && is_null($student_reg_cyc->nearby_preferences)) {

            throw new UnAuthorizedException("Look's like, You have not Selected the Schools");
        }

        $registration_no = $this->validateStudentSession($request, $request->registration_no);

        $registration = \Models\RegistrationBasicDetail::select('id', 'dob', 'level_id', 'registration_no', 'mobile', 'first_name', 'middle_name', 'last_name', 'email', 'status')
            ->where('registration_no', $registration_no)
            ->first();

        // if ($registration->status == 'completed' && is_null($registration->edited_on)) {

        //     $registration->edited_on = \Carbon::now();
        // }

        $dob = \Carbon::parse($registration->dob);

        $current_year = \Carbon::now()->year;

        $n_l = \Carbon::createFromDate($current_year - 5, 4, 1, 'Asia/Kolkata')->startOfDay();
        $n_u = \Carbon::createFromDate($current_year - 3, 3, 31, 'Asia/Kolkata')->endOfDay();

        $c_l = \Carbon::createFromDate($current_year - 6, 4, 1, 'Asia/Kolkata')->startOfDay();
        $c_u = \Carbon::createFromDate($current_year - 5, 3, 31, 'Asia/Kolkata')->endOfDay();

        $level = \Models\Level::select('id', 'level')->find($registration->level_id);

        $final_year = \Carbon::now()->subYears(3)->format('Y');
        $inter_year = \Carbon::now()->subYears(5)->format('Y');
        $ini_year = \Carbon::now()->subYears(6)->format('Y');

        if ($level->level == 'Pre-Primary') {

            if ($dob->lt($n_l) || $dob->gt($n_u)) {
                throw new EntityNotFoundException("For Pre-Primary admission, child should be been born on or after 1st April " . $inter_year . " and on or before 31 March " . $final_year);
            }
        }

        if ($level->level == 'Class 1') {

            if ($dob->lt($c_l) || $dob->gt($c_u)) {
                throw new EntityNotFoundException("For Class 1 admission, the child should have been born on or after 1st April " . $ini_year . " and on or before 31 March " . $inter_year);
            }
        }

        $registration->status = 'completed';

        $input['phone'] = $registration->mobile;

        $input['message'] = 'Registration completed successfully. Your RTE registration number is ' . $registration->registration_no;

        \MsgHelper::sendSyncSMS($input);

        $registration->save();

        if (isset($registration->email) && !empty($registration->email)) {

            $EmailData = array(
                'registration_no' => $registration->registration_no,
                'first_name' => $registration->first_name,
                'middle_name' => $registration->middle_name,
                'last_name' => $registration->last_name,

            );

            $subject = 'RTE Registration Successfull';

            // \MailHelper::sendSyncMail('state::emails.student-registration-successful', $subject, $registration->email, $EmailData);
        }

        $data['redirect'] = url($this->state->slug . '/student-registration/' . $registration_no . '/success');

        return api('Submitted details successfully', $data);
    }

    public function getStudentResult(AddStudentResultRequest $request)
    {
        $data['redirect'] = url($this->state->slug . '/student-registration/' . $request->registration_no . '/result');

        return api('', $data);
    }

    public function getStates($state)
    {

        $states = \Models\State::select('id', 'name', 'slug')->get();

        return api('', $states);
    }

    public function getDistricts($state, $state_id, $keyword)
    {

        $states = [];

        if (isset($state_id) && isset($keyword)) {
            $states = \Models\District::where('state_id', $state_id)->where('name', 'ilike', '%' . $keyword . '%')->where('status', 'active')->get();
        }

        return api('', $states);
    }

    public function getAllStateDistricts($state, $state_id)
    {

        $states = [];

        if (isset($state_id)) {
            $states = \Models\District::where('state_id', $state_id)->where('status', 'active')->get();
        }

        return api('', $states);
    }

    public function searchBlock($state, $district_id, $keyword)
    {

        $blocks = \Models\Block::where('name', 'ilike', '%' . $keyword . '%')->where('district_id', $district_id)->get();
        $new = [];
        foreach ($blocks as $key => $value) {
            if ($value->sub_block != null && in_array('block', ($value->sub_block))) {
                $new[] = $value;
            }
        }
        return api('', $new);
    }

    public function getClusters($state, $block_id)
    {

        $clusters = \Models\Cluster::where('block_id', $block_id)
            ->get();

        return api('', $clusters);
    }

    public function getAllDistrictBlock($state, $district_id)
    {

        $blocks = \Models\Block::where('district_id', $district_id)->get();
        $new = [];
        foreach ($blocks as $key => $value) {
            if ($value->sub_block != null && in_array('block', ($value->sub_block))) {
                $new[] = $value;
            }
        }
        return api('', $new);
    }

    public function getAllDistrictSubBlock($state, $block_id, $stype, $district_id)
    {

        $blocks = \Models\Block::where('district_id', $block_id)->get();
        // $blocks = \Models\Block::get();
        $new = [];
        foreach ($blocks as $key => $value) {
            /*if($value->sub_block != null && in_array($stype.$block_id,json_decode($value->sub_block))){
            $new[] = $value;
            }*/
            if ($value->sub_block != null) {
                foreach (($value->sub_block) as $k => $v) {
                    // print_r($v);
                    if ((strpos($v, $stype) !== false) && (strpos($v, $district_id) !== false)) {
                        $new[] = $value;
                    }
                }
            }
        }
        return api('', $new);
    }

    public function getAllLocality($state, $block_id)
    {

        $localities = \Models\Locality::where('block_id', $block_id)->get();

        return api('', $localities);
    }

    public function searchLocality($state, $block_id, $keyword)
    {

        $localities = \Models\Locality::where('name', 'ilike', '%' . $keyword . '%')->where('block_id', $block_id)->get();

        return api('', $localities);
    }

    public function getNearBySchools(Request $request)
    {
        $schools = \Helpers\NearBySchoolHelper::getNearBySchool($request, $this->state, $this->data['latest_application_cycle']);

        return api('', $schools);
    }

    public function getStep5Data($slug, $registration_id)
    {
        $data = [];

        $latest_application_cycle = \Helpers\ApplicationCycleHelper::getLatestCycle();

        $pref = \Models\RegistrationCycle::select('preferences', 'nearby_preferences')
            ->where('registration_id', $registration_id)
            ->where('application_cycle_id', $latest_application_cycle->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (isset($pref->preferences)) {

            $data['selected_schools'] = \Models\School::select('id', 'name', 'address')->whereIn('id', $pref->preferences)
                ->whereHas('allotment_statistics', function ($query) {
                    $query->where('full_house', false);
                })
                ->get();
        }

        if (isset($pref->nearby_preferences)) {

            $data['selected_nearby_schools'] = \Models\School::select('id', 'name', 'address')->whereIn('id', $pref->nearby_preferences)
                ->whereHas('allotment_statistics', function ($query) {
                    $query->where('full_house', false);
                })
                ->get();
        }

        return api('', $data);
    }

    public function resumeRegistration(ResumeRegistrationRequest $request)
    {
        $applicant = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'mobile', 'status', 'dob', 'updated_at', 'status', 'edited_on')
            ->where('registration_no', $request->registration_id)
            ->first();

        if (is_null($applicant)) {
            throw new \Exceptions\ValidationFailedException("This registration number is not valid");
        }

        $latest_application_cycle = \Helpers\ApplicationCycleHelper::getLatestCycle();

        $previous_cyc_student = \Models\RegistrationCycle::whereHas('application_details', function ($subQuery) use ($latest_application_cycle) {

            $subQuery->where('session_year', '<>', $latest_application_cycle->session_year);
        })
            ->where('registration_id', $applicant->id)
            ->count();

        if ($previous_cyc_student) {

            throw new EntityNotFoundException("Seem's like you have already registered to the platform in last year. Only current session student allowed to resume application.");
        }

        if ($applicant->status == 'inactive') {

            $year = date('Y');

            $show['redirect'] = '/';

            return api('Looks like you have already applied for the application cycle ' . $year, $show);
        }

        // $applicationCycle = $this->data['latest_application_cycle'];

        // if (!empty($applicationCycle) && !is_null($applicant->edited_on)) {

        //     throw new \Exceptions\ValidationFailedException("Your application is complete and under observation please wait untill the results are out");
        // }

        $input['phone'] = $applicant->mobile;

        $input['user_id'] = $applicant->id;

        \MsgHelper::generateOTP($input);

        return api('OTP has been sent to your registered number, it may take a moment to receive the OTP', $applicant);
    }

    public function postVerifiyStudentOTP(VerifyOTPRequest $request)
    {
        $applicant = \Models\RegistrationBasicDetail::where('registration_no', $request->registration_id)
            ->with('statename')
            ->first();

        $input['phone'] = $applicant->mobile;
        $input['otp'] = $request->otp;

        \MsgHelper::verifyOTP($input);

        $latest_application_cycle = \Helpers\ApplicationCycleHelper::getLatestCycle();

        if ($latest_application_cycle->cycle > 1) {

            $current_cyc_details = \Models\RegistrationCycle::where('application_cycle_id', $latest_application_cycle->id)
                ->where('registration_id', $applicant->id)
                ->first();

            if (empty($current_cyc_details)) {

                $previous_cyc_student = \Models\RegistrationCycle::whereHas('application_details', function ($subQuery) use ($latest_application_cycle) {

                    $subQuery->where('session_year', $latest_application_cycle->session_year)
                        ->where('cycle', '<', $latest_application_cycle->cycle);
                })
                    ->where('registration_id', $applicant->id)
                    ->first();

                if (!empty($previous_cyc_student)) {

                    if ($previous_cyc_student->status == 'enrolled') {

                        throw new EntityNotFoundException('You are already enrolled by the school.');
                    }

                    if ($previous_cyc_student->status == 'allotted') {

                        throw new EntityNotFoundException('You are already allotted to the school.');
                    }

                    $applicant->status = 'active';

                    $applicant->save();
                }
            }
        }

        if ($applicant->state == 'step2') {
            $redirect = '/' . $applicant->statename->slug . '/student-registration/' . $applicant->registration_no . '/parent-details';
        } elseif ($applicant->state == 'step3') {
            $redirect = '/' . $applicant->statename->slug . '/student-registration/' . $applicant->registration_no . '/address-details';
        } elseif ($applicant->state == 'step4') {
            $redirect = '/' . $applicant->statename->slug . '/student-registration/' . $applicant->registration_no . '/verify-documents';
        } elseif ($applicant->state == 'step5') {
            $redirect = '/' . $applicant->statename->slug . '/student-registration/' . $applicant->registration_no . '/school-selection';
        }

        $show['redirect'] = $redirect;

        $request->session()->put('registration_no', $request->registration_id);

        $show['session_token'] = \Crypt::encrypt($request->registration_id);

        return api('OTP has been verified.', $show);
    }

    public function postResendStudentOTP(Request $request)
    {

        $applicant = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'mobile', 'state', 'state_id')->with('statename')->where('registration_no', $request->registration_id)->first();

        $input['phone'] = $applicant->mobile;

        \MsgHelper::resendOTP($input);

        return api('OTP has been resent to your registered number, it may take a moment to receive the OTP.', $applicant);
    }

    public function downloadApplication($state, $registration_no)
    {

        $data['state'] = $this->state;
        $data['title'] = 'Registration Form';
        $data['registration_no'] = $registration_no;

        // ->with('personal_details', 'level', 'parent_details', 'personal_details', 'personal_details.locality', 'personal_details.block', 'personal_details.subsublocality', 'registration_cycle')
        $candidate = \Models\RegistrationBasicDetail::where('registration_no', $registration_no)
            ->with('level', 'parent_details', 'registration_cycle', 'personal_details.district')
            ->first();

        $personal_details = DB::select("SELECT * from registration_personal_details where registration_id=" . $candidate->id . "")[0];

        if (!empty($personal_details->sub_block_id)) {

            $subname = \Models\Block::select('name')->where('id', $personal_details->sub_block_id)->first();

            $personal_details->sub_block_name = $subname->name;
        }

        $personal_details->certificate_details = (array) json_decode($personal_details->certificate_details);

        $candidate->documents = json_decode($personal_details->files);

        $locality_details = DB::select("SELECT * from localities where id=" . $personal_details->locality_id . "")[0];

        $block_details = DB::select("SELECT * from blocks where id=" . $personal_details->block_id . "")[0];

        if ($personal_details->sub_locality_id) {

            $subsublocality_details = DB::select("SELECT * from localities where id=" . $personal_details->sub_locality_id . "")[0];
        } else {

            $subsublocality_details = null;
        }

        $district = DB::select("SELECT * from districts where id=" . $personal_details->district_id . "")[0];

        $personal_details->district = (array) $district;

        $personal_details->locality = (array) $locality_details;
        $personal_details->block = (array) $block_details;
        $personal_details->subsublocality = (array) $subsublocality_details;
        $personal_details = $personal_details;
        // print_r($personal_details);

        $candidate['personal_details'] = $personal_details;
        // echo '<pre>';print_r($candidate);die();
        $schoolData = [];
        $schoolNearbyData = [];

        if ($candidate->registration_cycle->preferences) {

            foreach ($candidate->registration_cycle->preferences as $key => $value) {

                $school = \Models\School::select('id', 'name', 'udise')
                    ->where('id', $value)
                    ->first();

                if (!empty($school)) {

                    $schoolEntry = [];
                    $schoolEntry['id'] = $value;
                    $schoolEntry['name'] = $school->name;
                    $schoolEntry['udise'] = $school->udise;

                    array_push($schoolData, $schoolEntry);
                }
            }
        }

        if ($candidate->registration_cycle->nearby_preferences) {

            foreach ($candidate->registration_cycle->nearby_preferences as $key => $value) {

                $school = \Models\School::select('id', 'name', 'udise')
                    ->where('id', $value)
                    ->first();

                if (!empty($school)) {

                    $schoolEntry = [];
                    $schoolEntry['id'] = $value;
                    $schoolEntry['name'] = $school->name;
                    $schoolEntry['udise'] = $school->udise;

                    array_push($schoolNearbyData, $schoolEntry);
                }
            }
        }

        $data['schoolData'] = $schoolData;

        $data['schoolNearbyData'] = $schoolNearbyData;

        $data['candidate'] = $candidate;

        if ($candidate->registration_cycle->school) {

            $alloted_school['name'] = $candidate->registration_cycle->school->name;
            $alloted_school['udise'] = $candidate->registration_cycle->school->udise;

            $data['alloted_school'] = $alloted_school;
        }

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ])->loadView('state::registration.registration-form', $data);

        return $pdf->download($registration_no . '.pdf');

        // return view('state::registration.registration-form', $data);
    }

    public function downloadEmptyApplication($state)
    {
        $data['title'] = 'Registration Form';

        $pdf = PDF::loadView('state::registration.empty-registration-form', $data);

        return $pdf->download('Registration_form.pdf');
    }

    public function validateStudentSession(Request $request, $registration_no)
    {

        if ($request->session()->has('registration_no')) {
            $stored_registration_no = $request->session()->get('registration_no');

            if ($registration_no != $stored_registration_no) {

                $request->session()->pull('registration_no');

                throw new UnAuthorizedException("Session validation error");
            }

            return $stored_registration_no;
        } else {
            throw new UnAuthorizedException("Session error");
        }
    }

    public function postReportSchool(Request $request)
    {

        $student = \Models\RegistrationBasicDetail::select('id')->where('registration_no', $request->registration_no)->first();

        $district = \Models\RegistrationPersonalDetail::select('district_id')->where('registration_id', $student->id)->first();

        $request->merge(['district_id' => $district->district_id]);

        \Models\SchoolGrievance::create($request->all());

        return api('Thank you for reporting the absence of this school.');
    }

    public function getRegistrationStatus($slug)
    {

        $today = \Carbon::now()->tz('Asia/Kolkata');

        $state_id = $this->state->id;

        $districts = \Models\District::where('state_id', $state_id)
            ->pluck('id');

        $status = \Models\StudentRegistrationStatus::whereIn('district_id', $districts)
            ->with(['district'])
            ->get()
            ->transform(function ($item, $key) use ($today) {

                if ($item['closing_date']->tz('Asia/Kolkata') >= $today) {

                    $item['registration_status'] = 'open';
                } else {

                    $item['registration_status'] = 'close';
                }

                return $item;
            });

        return api('', $status);
    }

    public function getLotteryStatus($slug)
    {

        $lottery = \Models\ApplicationCycle::select('status')
            ->where('state_id', $this->state->id)
            ->first();

        return api('', $lottery);
    }

    public function getDistrictRegistrationStatus($slug, $district_id)
    {

        $district = \Models\StudentRegistrationStatus::where('district_id', $district_id)
            ->first();

        $today = \Carbon::now()->tz('Asia/Kolkata');

        if ($district) {

            if ($district->closing_date->tz('Asia/Kolkata') >= $today) {

                $status = 'open';
            } else {

                $status = 'close';
            }
        } else {

            $status = 'open';
        }

        return api('', $status);
    }

    public function reportAdmission($slug, $registration_id, Request $request)
    {

        $request->merge(['registration_id' => $registration_id]);

        $report = \Models\DenyAdmission::create($request->all());

        return api('', $report);
    }

    public function checkReportAdmission($slug, $registration_id)
    {

        $not_reported = false;

        $report = \Models\DenyAdmission::where('registration_id', $registration_id)->count();

        if ($report == 0) {

            $not_reported = true;
        }

        return api('', $not_reported);
    }
}
