<?php

namespace Redlof\State\Controllers\School;

use Carbon\Carbon;
use Exceptions\UnAuthorizedException;
use Exceptions\ValidationFailedException;
use Illuminate\Http\Request;
use Models\Language;
use Models\Level;
use Models\School;
use Models\State;
use PDF;
use Redlof\Engine\Auth\Repositories\SchoolAdminRepo;
use Redlof\State\Controllers\Registration\Requests\VerifyOTPRequest;
use Redlof\State\Controllers\School\Requests\AddSchoolAddressRequest;
use Redlof\State\Controllers\School\Requests\AddSchoolBankDetailsRequest;
use Redlof\State\Controllers\School\Requests\AddSchoolDetailsRequest;
use Redlof\State\Controllers\School\Requests\AddSchoolNeighbourhoodRequest;
use Redlof\State\Controllers\School\Requests\AddSchoolRequest;
use Redlof\State\Controllers\School\Requests\SchoolResumeRequest;
use Redlof\State\Controllers\School\Requests\UpdateSchoolRequest;
use Redlof\State\Controllers\StateBaseController;

class SchoolController extends StateBaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getSchools(Request $request, $state, $application_year)
    {
        $application_cycle_ids = [];

        if ($application_year) {

            $application_cycle_ids = \Helpers\ApplicationCycleHelper::getApplicationCycle($application_year)->pluck('id')->toArray();
        } else {

            $application_cycle = $this->data['latest_application_cycle']['id'];

            $application_cycle_ids = array_push($application_cycle_ids, $application_cycle);
        }

        $schoolIds = \Models\SchoolCycle::whereIn('application_cycle_id', $application_cycle_ids)
            ->pluck('school_id');

        $schools = School::select('id', 'name', 'udise', 'address')
            ->whereIn('id', $schoolIds)
            ->where('state_id', $this->state->id)
            ->where('application_status', 'registered')
            ->page($request)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function getVerifiedSchools(Request $request, $state, $application_year)
    {

        $application_cycle_ids = [];

        if ($application_year) {

            $application_cycle_ids = \Helpers\ApplicationCycleHelper::getApplicationCycle($application_year)->pluck('id')->toArray();
        } else {

            $application_cycle = $this->data['latest_application_cycle']['id'];

            $application_cycle_ids = array_push($application_cycle_ids, $application_cycle);
        }

        $schoolIds = \Models\SchoolCycle::whereIn('application_cycle_id', $application_cycle_ids)
            ->pluck('school_id');

        $schools = School::select('id', 'name', 'udise', 'address')
            ->where('state_id', $this->state->id)
            ->where('application_status', 'verified')
            ->whereIn('id', $schoolIds)
            ->page($request)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('Showing verified schools', $schools);
    }

    public function getRejectedSchools(Request $request, $state, $application_year)
    {

        $application_cycle_ids = [];

        if ($application_year) {

            $application_cycle_ids = \Helpers\ApplicationCycleHelper::getApplicationCycle($application_year)->pluck('id')->toArray();
        } else {

            $application_cycle = $this->data['latest_application_cycle']['id'];

            $application_cycle_ids = array_push($application_cycle_ids, $application_cycle);
        }

        $schoolIds = \Models\SchoolCycle::whereIn('application_cycle_id', $application_cycle_ids)
            ->pluck('school_id');

        $schools = School::select('id', 'name', 'udise', 'address')
            ->where('state_id', $this->state->id)
            ->where('application_status', 'rejected')
            ->whereIn('id', $schoolIds)
            ->page($request)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('Showing rejected schools', $schools);
    }

    public function getBannedSchools(Request $request, $state, $application_year)
    {

        $application_cycle_ids = [];

        if ($application_year) {

            $application_cycle_ids = \Helpers\ApplicationCycleHelper::getApplicationCycle($application_year)->pluck('id')->toArray();
        } else {

            $application_cycle = $this->data['latest_application_cycle']['id'];

            $application_cycle_ids = array_push($application_cycle_ids, $application_cycle);
        }

        $schoolIds = \Models\SchoolCycle::whereIn('application_cycle_id', $application_cycle_ids)
            ->pluck('school_id');

        $schools = School::select('id', 'name', 'udise', 'address')
            ->where('state_id', $this->state->id)
            ->where(function ($query) {
                $query->where('status', 'ban')
                    ->orWhere('status', 'banned');
            })
            ->whereIn('id', $schoolIds)
            ->page($request)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('Showing banned schools', $schools);
    }

    public function getSearchSchools(Request $request, $state, $application_year)
    {

        if ($application_year == 'null') {
            $now = \Carbon::now();
            $application_year = $now->year;
        }

        $schools = School::select('id', 'name', 'udise', 'address')
            ->where('state_id', $this->state->id)
            ->whereYear('updated_at', $application_year)
            ->search($request, ['name', 'udise'])
            ->orderBy('updated_at', 'desc')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('Showing all Schools', $schools);
    }

    public function getSearchVerifiedSchools(Request $request, $state, $application_year)
    {

        if ($application_year == 'null') {
            $now = \Carbon::now();
            $application_year = $now->year;
        }

        $schools = School::select('id', 'name', 'udise', 'address')
            ->where('state_id', $this->state->id)
            ->where('application_status', 'verified')
            ->whereYear('updated_at', $application_year)
            ->search($request, ['name', 'udise'])
            ->page($request)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('Showing verified schools', $schools);
    }

    public function getSearchRejectedSchools(Request $request, $state, $application_year)
    {

        if ($application_year == 'null') {
            $now = \Carbon::now();
            $application_year = $now->year;
        }

        $schools = School::select('id', 'name', 'udise', 'address')
            ->where('state_id', $this->state->id)
            ->where('application_status', 'rejected')
            ->whereYear('updated_at', $application_year)
            ->search($request, ['name', 'udise'])
            ->page($request)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('Showing rejected schools', $schools);
    }

    public function getSearchBannedSchools(Request $request, $state, $application_year)
    {

        if ($application_year == 'null') {
            $now = \Carbon::now();
            $application_year = $now->year;
        }

        $schools = School::select('id', 'name', 'udise', 'address')
            ->where('state_id', $this->state->id)
            ->where('status', 'ban')
            ->whereYear('updated_at', $application_year)
            ->search($request, ['name', 'udise'])
            ->page($request)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('Showing banned schools', $schools);
    }

    public function getSchoolResumeDetails($slug, $udise, Request $request)
    {

        $udise_code = $this->validateSchoolSession($request, $udise);

        $school = \Models\School::select('id', 'name', 'udise', 'logo', 'language_id', 'phone', 'website', 'levels', 'type', 'description', 'school_type', 'current_state', 'rte_certificate_no')
            ->where('udise', $udise_code)
            ->with(['schooladmin', 'schooladmin.user', 'language'])
            ->first();

        $level = '';

        foreach ($school['levels'] as $key => $l) {
            $value = intval($l);

            $level = $l;
        }

        $school['level'] = $level;

        $school['entry_class'] = \Models\Level::where('id', $level)
            ->first()
            ->level;

        if (!empty($school->schooladmin)) {

            if (!empty($school->schooladmin->user)) {

                if (!filter_var($school->schooladmin->user->email, FILTER_VALIDATE_EMAIL)) {
                    $school->schooladmin->user->email = null;
                }

            }
        }

        return api('', $school);
    }

    public function downloadApplication(Request $request, $state, $udise)
    {
        $data['title'] = 'School Registration';

        $data['udise'] = $this->validateSchoolSession($request, $udise);

        $school = School::select('id', 'name', 'school_type', 'current_state', 'cycle')
            ->where('udise', $udise)
            ->first();

        $data['year'] = $this->data['latest_application_cycle']['session_year'];

        $data['school'] = $school;

        $school_details = $this->getSchoolResumeDetails($state, $udise, $request);
        $school_details = json_decode($school_details->content(), true);
        $data['school_details'] = $school_details['data'];

        $school_address = $this->getSchoolAddressDetails($state, $request);
        $school_address = json_decode($school_address->content(), true);
        $data['school_address'] = $school_address['data'];

        $school_region = $this->getSchoolRegionDetails($state, $udise, $request);
        $school_region = json_decode($school_region->content(), true);
        $data['school_region'] = $school_region['data'];

        $school_fee_structure = $this->getSchoolFeeStructure($state, $udise, $request);
        $school_fee_structure = json_decode($school_fee_structure->content(), true);
        $data['school_fee_structure'] = $school_fee_structure['data'];

        $school_past_seat_info = $this->getPastSeatInfo($state, $udise, $request);
        $school_past_seat_info = json_decode($school_past_seat_info->content(), true);
        $data['school_past_seat_info'] = $school_past_seat_info['data'];

        $school_seat_info = $this->getSchoolSeatStructure($state, $udise, $request);
        $school_seat_info = json_decode($school_seat_info->content(), true);
        $data['school_seat_info'] = $school_seat_info['data'];

        $school_bank_details = $this->getSchoolBankDetails($state, $udise, $request);
        $school_bank_details = json_decode($school_bank_details->content(), true);
        $data['school_bank_details'] = $school_bank_details['data'];

        $pdf = PDF::loadView('state::state.registration-form', $data);

        return $pdf->download($udise . '.pdf');
    }

    public function getSchoolAddressDetails($slug, Request $request)
    {
        $udise_code = $this->validateSchoolSession($request, $request->udise);

        $school = \Models\School::select('id', 'address', 'state_id', 'district_id', 'locality_id', 'sub_locality_id', 'sub_sub_locality_id', 'block_id', 'lat', 'lng', 'pincode', 'state_type', 'sub_block_id', 'cluster_id')
            ->with(['state', 'district', 'block', 'locality', 'sublocality', 'subsublocality', 'cluster'])
            ->where('udise', $udise_code)
            ->first();

        if (!empty($school->state)) {
            $school->state_name = $school->state->name;
        }

        if (!empty($school->district)) {
            $school->district_name = $school->district->name;
        }

        if (!empty($school->block)) {

            $school->block_name = $school->block->name;
            $school->block_type = $school->block->type;
        }
        if (!empty($school->sub_block_id)) {
            $subname = \Models\Block::select('name')->where('id', $school->sub_block_id)->first();
            $school->sub_block_name = $subname->name;
        }
        if (!empty($school->locality)) {
            $school->locality_name = $school->locality->name;
        }

        if (!empty($school->sublocality)) {
            $school->sub_locality_name = $school->sublocality->name;
        }

        if (!empty($school->subsublocality)) {
            $school->sub_sub_locality_name = $school->subsublocality->name;
        }

        $school = collect($school)->except(['district', 'block', 'locality', 'sublocality', 'subsublocality'])->all();

        return api('', $school);
    }

    public function getSchoolRegionDetails($slug, $udise, Request $request)
    {

        $udise_code = $this->validateSchoolSession($request, $udise);

        $school = \Models\School::where('udise', $udise_code)
            ->select('id', 'sub_block_id', 'locality_id', 'district_id')
            ->first();

        $regions = \Models\SchoolRange::where('school_id', $school->id)
            ->where('range', '1-3')
            ->select('id', 'regions')
            ->first();

        $selected_region = [];

        if (count($regions) > 0) {
            $selected_region = $regions['regions'];
        }

        $subLocalities = \Models\Locality::select('id', 'name')
        /*->whereHas('block.district', function ($subQuery) use ($school) {
        $subQuery = $subQuery->where('id', $school->district_id);
        })*/
            ->where('block_id', $school->sub_block_id)
            ->whereNotIn('id', [$school->locality_id])
            ->whereNotIn('id', $selected_region);

        $Localities['unselected'] = $subLocalities->get();

        $subLocalities = \Models\Locality::select('id', 'name')
            ->whereHas('block.district', function ($subQuery) use ($school) {
                $subQuery = $subQuery->where('id', $school->district_id);
            })
            ->where('block_id', '!=', $school->sub_block_id)
            ->whereNotIn('id', [$school->locality_id])
            ->whereNotIn('id', $selected_region);

        $Localities['unselectedDist'] = $subLocalities->get();

        $subLocalities = \Models\Locality::select('id', 'name')
        /*->whereHas('block.district', function ($subQuery) use ($school) {
        $subQuery = $subQuery->where('id', $school->district_id);
        })*/
            ->where('block_id', $school->sub_block_id)
            ->whereNotIn('id', [$school->locality_id])
            ->whereIn('id', $selected_region);

        $Localities['selected'] = $subLocalities->get();

        $subLocalities = \Models\Locality::select('id', 'name')
            ->whereHas('block.district', function ($subQuery) use ($school) {
                $subQuery = $subQuery->where('id', $school->district_id);
            })
            ->where('block_id', '!=', $school->sub_block_id)
            ->whereNotIn('id', [$school->locality_id])
            ->whereIn('id', $selected_region);

        $Localities['selectedDist'] = $subLocalities->get();

        return api('', $Localities);
    }

    public function getLanguages(Request $request, $state)
    {

        $languages = Language::select('id', 'name')->get();

        return api('', $languages);
    }

    public function getLevels(Request $request, $state)
    {

        $levels = Level::select('id', 'level')
            ->where('entry_point', true)
            ->get();

        return api('', $levels);
    }

    public function verifySchoolPhone(AddSchoolRequest $request)
    {

        $input['phone'] = $request['admin_phone'];

        $data['phone'] = 'XXXXXXX' . substr($input['phone'], 7);

        $data['validation_check'] = true;

        \MsgHelper::generateOTP($input);

        return api('OTP has been sent to your admin phone number ' . $data['phone'] . ', it may take a moment to receive the OTP', $data);
    }

    public function resendSchoolOtp(Request $request)
    {

        $input['phone'] = $request['admin_phone'];

        \MsgHelper::resendOTP($input);

        return api('OTP has been resent to your registered number, it may take a moment to receive the OTP.');
    }

    public function verifySchoolOTP(Request $request)
    {

        $input['phone'] = $request['admin_phone'];
        $input['otp'] = $request->otp;

        \MsgHelper::verifyOTP($input);

        $data['success'] = true;

        return api('Phone number verified', $data);
    }

    public function getDistrictSubSubLocalities($state_slug, $school_id, Request $request)
    {

        $udise_code = $this->validateSchoolSession($request, $school_id);

        $school = \Models\School::where('udise', $udise_code)
            ->select('id', 'block_id', 'locality_id', 'district_id')
            ->first();

        $subLocalities = \Models\Locality::select('id', 'name')
            ->whereHas('block.district', function ($subQuery) use ($school) {
                $subQuery = $subQuery->where('id', $school->district_id);
            })
        // ->where('block_id', $school->block_id)
            ->whereNotIn('id', [$school->locality_id])
            ->get();

        return api('', $subLocalities);
    }

    public function addSchool(AddSchoolRequest $request, $state, SchoolAdminRepo $schoolRepo)
    {

        if ($request->type == 'kg2' && $request->level != 1) {
            throw new UnAuthorizedException('Class Upto Cannot be less than Entry classes');
        }

        if (!$this->state->school_registration) {

            throw new UnAuthorizedException('School registration is closed');
        }

        if ($request->hasFile('image')) {

            $file_name = \ImageHelper::createFileName($request['image']);

            \ImageHelper::ImageUploadToS3($request['image'], $file_name, 'school/', true, 1200, 600, true);
            $request->merge(['logo' => $file_name]);
        }

        $application_cycle = $this->data['latest_application_cycle'];

        $request->merge([
            'language_id' => $request->medium['id'],
            'cycle' => $application_cycle->cycle,
        ]);

        $req = $request->all();
        unset($req['levels']);
        $req['levels'][] = $req['level'];

        $newSchool = School::create($req);

        \Helpers\SchoolHelper::addSchoolLevels($newSchool->id);

        $newSchoolAdmin = new \Models\SchoolAdmin();

        $newSchoolAdmin->school_id = $newSchool->id;
        $input['first_name'] = $request['name'];
        $input['last_name'] = $request['name'];
        $input['email'] = $request['admin_email'];
        $input['phone'] = $request['admin_phone'];
        $input['role_type'] = 'role-school-admin';
        $input['password'] = str_random(8);

        $user = $schoolRepo->create($input);

        $newSchoolAdmin->user_id = $user['id'];
        $newSchoolAdmin->save();

        $schoolCycle = [
            'school_id' => $newSchool->id,
            'application_cycle_id' => $application_cycle->id,
            'status' => 'applied',
        ];

        \Models\SchoolCycle::create($schoolCycle);

        $data['redirect'] = route('state.register-your-school.address-details', [$state, $request->udise]);

        $request->session()->put('udise', $request->udise);

        return api('Primary details has been saved successfully', $data);
    }

    public function updateSchool(UpdateSchoolRequest $request, $state, SchoolAdminRepo $schoolRepo)
    {
        if ($request->type == 'kg2' && $request->level != 1) {
            throw new UnAuthorizedException('Class Upto Cannot be less than Entry classes');
        }

        $udise_code = $this->validateSchoolSession($request, $request->udise);

        if ($request->hasFile('image')) {

            $file_name = \ImageHelper::createFileName($request['image']);

            \ImageHelper::ImageUploadToS3($request['image'], $file_name, 'school/', true, 1200, 600, true);
            $request->merge(['logo' => $file_name]);
        }

        $previousData = School::select('id', 'levels', 'type')->where('udise', $request->udise)->first();

        $application_cycle = $this->data['latest_application_cycle'];

        School::where('udise', $udise_code)
            ->update([
                'name' => $request->name,
                'logo' => $request->logo,
                'udise' => $udise_code,
                'language_id' => $request->medium['id'],
                'phone' => $request->phone,
                'rte_certificate_no' => $request->rte_certificate_no,
                'type' => $request['type'],
                'school_type' => $request['school_type'],
                'cycle' => $application_cycle->cycle,
            ]);

        if ($previousData->type != $request['type'] || !in_array($request['level'], $previousData->levels)) {

            \Helpers\SchoolHelper::updateSchoolLevels($previousData->id, $request);
        }

        $level_type = [];
        $level_type[] = $request['level'];

        $updateClass = School::where('udise', $request->udise)->first();

        $updateClass->levels = $level_type;

        $updateClass->save();

        if (isset($request->website)) {

            $upSchool = School::where('udise', $udise_code)
                ->update([

                    'website' => $request->website,

                ]);
        }

        if (isset($request->description)) {

            $upSchool = School::where('udise', $udise_code)
                ->update([

                    'description' => $request->description,

                ]);
        }

        $schoolAdmin = \Models\User::find($request->schooladmin['user_id']);

        if ($request['email']) {

            $schoolAdmin['email'] = $request['email'];
        }

        $schoolAdmin['phone'] = $request['admin_phone'];

        $schoolAdmin['username'] = $request['admin_phone'];

        $schoolAdmin->save();

        $data['redirect'] = route('state.register-your-school.address-details', [$state, $udise_code]);

        return api('Primary details has been saved successfully', $data);
    }

    public function addSchoolAddress(AddSchoolAddressRequest $request, $state, $udise)
    {

        $this->validateSchoolSession($request, $udise);

        $school = School::with('regions')->where('udise', $udise)->first();

        if ($school->state_id != $request['state']['id'] || $school->district_id != $request['district_id'] || $school->block_id != $request['block_id'] || $school->locality_id != $request['locality_id'] || $school->sub_block_id != $request['sub_block_id']) {

            if (isset($school->regions)) {

                foreach ($school->regions as $region) {

                    \Models\SchoolRange::find($region->id)->delete();
                }
            }
        }

        $school->update([
            'state_id' => $request['state']['id'],
            'district_id' => $request['district_id'],
            'block_id' => $request['block_id'],
            'pincode' => $request['pincode'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
            'locality_id' => $request['locality_id'],
            // 'cluster_id' => $request->cluster_id,
            'address' => $request['address'],
            'state_type' => $request['state_type'],
            'sub_block_id' => $request['sub_block_id'],
            'current_state' => 'step2',
        ]);

        $data['redirect'] = route('state.register-your-school.region-selection', [$state, $udise]);

        return api('Address details has been saved successfully', $data);
    }

    public function AddSchoolNeighbourhood(AddSchoolNeighbourhoodRequest $request, $state, $udise)
    {

        if (!empty($request->range0)) {

            if (count($request->range0) > 7) {
                throw new ValidationFailedException("You can select maximum 5 wards from your block and maximum 2 wards from your district.");
            }

        }

        $this->validateSchoolSession($request, $udise);

        $school = School::where('udise', $udise)->select('id', 'district_id', 'locality_id')->first();

        $newSchoolRange = \Models\SchoolRange::updateOrCreate(

            [
                'school_id' => $school->id,
                'range' => '0-1',
                'type' => 'district',
            ],
            [
                'regions' => [(string) $school->locality_id],
            ]

        );

        $newSchoolRange = \Models\SchoolRange::updateOrCreate(

            [
                'school_id' => $school->id,
                'range' => '1-3',
                'type' => 'district',
            ],
            [
                'regions' => $request->range0,
            ]

        );

        $school = School::where('udise', $udise)->update([
            'current_state' => 'step3',
        ]);

        $data['redirect'] = route('state.register-your-school.class-info', [$state, $udise]);

        return api('Neighbourhood areas of the school have been saved successfully', $data);
    }

    public function getSchoolBankDetails($slug, $udise, Request $request)
    {

        $this->validateSchoolSession($request, $udise);

        $school = School::where('udise', $udise)->select('id')->first();

        $bank = \Models\SchoolBankDetails::where('school_id', $school->id)->first();

        if (!isset($bank->ifsc_code)) {
            $bank = collect($bank)->except(['ifsc_code']);
        }

        return api('', $bank);
    }

    public function postSchoolBankDetails($state, $udise, AddSchoolBankDetailsRequest $request)
    {
        $this->validateSchoolSession($request, $udise);

        $school = School::where('udise', $udise)->select('id', 'district_id', 'locality_id', 'udise')->with(['schooladmin', 'schooladmin.user'])->first();

        $request->merge(['school_id' => $school->id]);

        \Models\SchoolBankDetails::create($request->all());

        \Models\SchoolBankDetails::updateOrCreate(
            ['school_id' => $school->id],
            [
                'account_number' => $request->account_number,
                'account_holder_name' => $request->account_holder_name,
                'bank_name' => $request->bank_name,
                'ifsc_code' => $request->ifsc_code,
                'branch' => $request->branch,

            ]
        );

        $school = School::where('udise', $udise)->update([
            'current_state' => 'step5',
        ]);

        $data['redirect'] = route('state.school-registration-preview', [$state, $udise]);

        return api('Bank details has been saved successfully', $data);
    }

    public function postSaveData($state, $udise, Request $request)
    {
        $this->validateSchoolSession($request, $udise);

        $school = School::where('udise', $udise)->select('id', 'name', 'district_id', 'locality_id', 'udise')->with(['schooladmin', 'schooladmin.user'])->first();

        $checkState = School::where('udise', $udise)->select('id', 'state_id')
            ->first();

        if (empty($checkState->state_id)) {

            throw new ValidationFailedException("Please add your address details.");
        }

        $checkRange = \Models\SchoolRange::where('school_id', $school->id)
            ->first();

        if (empty($checkRange)) {

            throw new ValidationFailedException("Please add your region selection.");
        }

        $checkEntryLevel = \Helpers\SchoolHelper::getSchoolEntryLevel($school->id);

        if (empty($checkEntryLevel)) {

            throw new ValidationFailedException("Please add your seat and fee details.");
        }

        $newPass = str_random(8);
        $hashPasword = bcrypt($newPass);

        $newSchoolAdmin = \Models\User::where('id', $school->schooladmin->user->id)
            ->update(['password' => $hashPasword]);

        if (filter_var($school->schooladmin->user->email, FILTER_VALIDATE_EMAIL)) {

            if (!empty($school->schooladmin->user->email)) {

                $EmailData = array(
                    'first_name' => $school->schooladmin->user->first_name,
                    'email' => $school->schooladmin->user->email,
                    'phone' => $school->schooladmin->user->phone,
                    'password' => $newPass,
                );

                $subject = 'RTE Credentials!';

                \MailHelper::sendSyncMail('state::emails.school-registration-successful', $subject, $school->schooladmin->user->email, $EmailData);

                $subject2 = 'Welcome to RTE!';

                \MailHelper::sendSyncMail('admin::emails.welcome-schooladmin', $subject2, $school->schooladmin->user->email, $EmailData);
            }
        }

        $input['phone'] = $school->schooladmin->user->phone;
        $input['message'] = 'Registration completed successfully. Use your mobile number as username and following password to login ' . $newPass;

        \MsgHelper::sendSyncSMS($input);

        \Models\School::where('udise', $udise)->update(['application_status' => 'registered']);

        // Update the school cycle
        \Models\SchoolCycle::where('school_id', $school->id)
            ->where('application_cycle_id', $this->data['latest_application_cycle']['id'])
            ->update(['status' => 'registered']);

        $checkUdise = \Models\UdiseNodal::where('udise', $school->udise)->first();

        if (count($checkUdise) > 0) {

            if ($checkUdise->status != 'conflict') {

                $nodalUser = \Models\User::select('id')
                    ->where('email', $checkUdise->email)
                    ->first();

                if (count($nodalUser) > 0) {

                    $nodalAdmin = \Models\StateNodal::select('id')
                        ->where('user_id', $nodalUser->id)
                        ->first();

                    if (count($nodalAdmin) > 0) {

                        $alreadyassigned = \Models\SchoolNodal::where('school_id', $school->id)->first();

                        if (empty($alreadyassigned)) {

                            $newSchoolDetails = new \Models\SchoolNodal();

                            $newSchoolDetails['school_id'] = $school->id;

                            $newSchoolDetails['nodal_id'] = $nodalAdmin->id;

                            $newSchoolDetails->save();
                        }
                    }
                }
            }
        }

        $data['redirect'] = route('state.school-registration', [$state, $udise]);

        return api('School registration has been completed', $data);
    }

    public function getSchoolDetails($state, $school_id, $registration_id)
    {

        $levels = \Models\RegistrationBasicDetail::select('level_id')->where('registration_no', $registration_id)->first();

        $fees = \Models\SchoolLevelInfo::where('level_id', $levels->level_id)
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->where('school_id', $school_id)
            ->first();

        $school = School::where('id', $school_id)->with(['language', 'state', 'district', 'locality', 'block', 'sublocality', 'subsublocality'])->first();

        $school->total_fees = $fees->other_fee + $fees->dress_fee + $fees->books_fee;

        return api('', $school);
    }

    public function getSchoolFeeStructure($state, $udise, Request $request)
    {
        $this->validateSchoolSession($request, $udise);

        $school = School::where('udise', $udise)->select('id', 'levels', 'type')->first();

        $existing_fee_details = \Models\SchoolLevelInfo::where('school_id', $school->id)
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->with(['level_info'])
            ->orderBy('level_id', 'asc')
            ->get();

        return api('', $existing_fee_details);
    }

    public function getSendSmsAgain($state, $udise)
    {

        $school = School::where('udise', $udise)
            ->with(['schooladmin', 'schooladmin.user'])->first();

        $newPass = str_random(8);
        $hashPasword = bcrypt($newPass);

        $newSchoolAdmin = \Models\User::where('id', $school->schooladmin->user->id)
            ->update(['password' => $hashPasword]);

        $input['phone'] = $school->schooladmin->user->phone;
        $input['message'] = 'Registration completed successfully. Use your mobile number as username and following password to login ' . $newPass;

        \MsgHelper::sendSyncSMS($input);

        return api('SMS sent successfully', $school);
    }

    public function getSchoolSeatStructure($state, $udise, Request $request)
    {
        $this->validateSchoolSession($request, $udise);

        $school = School::where('udise', $udise)->select('id', 'levels')->first();

        $levels = \Models\Level::select('id', 'level')->whereIn('id', $school['levels'])->get();

        $stats = \Models\AllottmentStatistic::where('school_id', $school->id)
            ->select('year', 'allotted_seats', 'dropouts', 'level_id')
            ->get();

        $school_levels = \Models\SchoolLevelInfo::where('school_id', $school->id)
            ->select('level_id', 'available_seats', 'total_seats')
            ->whereIn('level_id', $school['levels'])
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->get();

        $legacyData = [];

        foreach ($school['levels'] as $key => $level_id) {

            $legacy = [];
            $legacy['level'] = $levels->where('id', $level_id)->pluck('level')->first();

            if ($legacy['level'] == 'Pre-Primary') {
                $legacy['dropouts_2017'] = 0;
            }

            $legacy['alloted_seats_2015'] = 0;
            $legacy['alloted_seats_2016'] = 0;
            $legacy['alloted_seats_2017'] = 0;
            $legacy['alloted_seats_2018'] = 0;
            $legacy['available_seats'] = 0;
            $legacy['total_seats'] = 0;

            if (count($stats) > 0) {

                $yearly_stats = $stats->where('level_id', intval($level_id))->all();

                if (count($yearly_stats) > 0) {

                    foreach ($yearly_stats as $key => $yearly_stats) {

                        $legacy['alloted_seats_' . $yearly_stats['year']] = $yearly_stats['allotted_seats'];

                        if ($yearly_stats['year'] == 2017 && $legacy['level'] == 'Pre-Primary') {

                            $legacy['dropouts_2017'] = $yearly_stats['dropouts'];
                        }
                    }
                }
            }

            if (count($school_levels) > 0) {
                $legacy['available_seats'] = $school_levels->where('level_id', $level_id)
                    ->pluck('available_seats')->first();
                $legacy['total_seats'] = $school_levels->where('level_id', $level_id)
                    ->pluck('total_seats')->first();
            }

            array_push($legacyData, $legacy);
        }

        return api('', $legacyData);
    }

    public function getPastSeatInfo($slug, $udise, Request $request)
    {
        $this->validateSchoolSession($request, $udise);

        $school = School::where('udise', $udise)->first();

        $levels = \Models\Level::select('id', 'level')->whereIn('id', $school['levels'])->get();

        $seat_info = \Models\SchoolSeatInfo::where('school_id', $school->id)
            ->where('level_id', $levels[0]->id)
            ->orderBy('year', 'desc')
            ->limit(3)
            ->get();

        if ($seat_info->count() == 0) {

            $pastInfo = (object) [];
            $pastInfo->level = $levels[0]->level;
            $pastInfo->first_year = 0;
            $pastInfo->second_year = 0;
            $pastInfo->third_year = 0;

        } else {

            $pastInfo = (object) [];
            $pastInfo->level = $levels[0]->level;
            $pastInfo->first_year = 0;
            $pastInfo->second_year = 0;
            $pastInfo->third_year = 0;

            if (isset($seat_info[0])) {
                $pastInfo->first_year = (int) $seat_info[0]->total_seats;
            }
            if (isset($seat_info[1])) {
                $pastInfo->second_year = (int) $seat_info[1]->total_seats;
            }
            if (isset($seat_info[2])) {
                $pastInfo->third_year = (int) $seat_info[2]->total_seats;
            }
        }

        return api('', $pastInfo);
    }

    public function postSchoolFeeStructure($state, $udise, AddSchoolDetailsRequest $request)
    {

        $this->validateSchoolSession($request, $udise);

        $school = School::where('udise', $udise)->select('id', 'levels', 'cycle')->first();

        $levels = Level::select('id', 'level')->whereIn('id', collect($request['feestructure'])->pluck('level_id')->all())->get();

        \Helpers\SchoolHelper::updateSchoolLevelSeats($school->id, $request);

        \Models\AllottmentStatistic::where('school_id', $school->id)->delete();

        foreach ($request['seatinfo'] as $key => $value) {

            $level_id = \Models\Level::where('level', $value['level'])
                ->first();

            foreach ($value as $key1 => $year_stat) {

                if (in_array($key1, ['alloted_seats_2015', 'alloted_seats_2016', 'alloted_seats_2017'])) {

                    $parts = explode("_", $key1);

                    if (count($parts) > 2 && $parts[0] == 'alloted') {
                        $year = $parts[2];

                        if (in_array($year, ['2015', '2016', '2017'])) {

                            $allottmentStats = new \Models\AllottmentStatistic();

                            if ($year == '2017' && isset($value['dropouts_2017']) && ($value['dropouts_2017'] != 'null')) {

                                $allottmentStats->dropouts = $value['dropouts_2017'];
                            }

                            $allottmentStats->year = $year;
                            $allottmentStats->allotted_seats = $value['alloted_seats_' . $year];
                            $allottmentStats->level_id = $level_id->id;
                            $allottmentStats->school_id = $school->id;

                            $allottmentStats->save();
                        }
                    }
                }
            }
        }

        //New Way to Store Past Allotment Statistics in better way.

        $seat_info = \Models\SchoolSeatInfo::where('school_id', $school->id)
            ->orderBy('year', 'desc')
            ->limit(3)
            ->get();

        $levels = \Models\Level::select('id', 'level')->whereIn('id', $school['levels'])->get();

        $year = $this->data['latest_application_cycle']['session_year'];

        if ($seat_info->count() == 0) {

            //Create new entries

            for ($i = 1; $i <= 3; $i++) {

                $pastInfo = [
                    'school_id' => $school->id,
                    'level_id' => $levels[0]->id,
                    'year' => $year - 3 + $i,

                ];

                if ($i == 1) {
                    $pastInfo['total_seats'] = $request->past_seat_info['third_year'];
                } elseif ($i == 2) {
                    $pastInfo['total_seats'] = $request->past_seat_info['second_year'];
                } else {
                    $pastInfo['total_seats'] = $request->past_seat_info['first_year'];
                }

                \Models\SchoolSeatInfo::create($pastInfo);
            }

        } else {

            //Update excisting entries

            for ($i = 1; $i <= 3; $i++) {

                $cycleYear = $year - 3 + $i;

                $pastInfo = \Models\SchoolSeatInfo::where('year', $cycleYear)
                    ->where('school_id', $school->id)
                    ->where('level_id', $levels[0]->id)
                    ->first();

                if (!empty($pastInfo)) {

                    if ($i == 1) {
                        $pastInfo['total_seats'] = $request->past_seat_info['third_year'];
                    } elseif ($i == 2) {
                        $pastInfo['total_seats'] = $request->past_seat_info['second_year'];
                    } else {
                        $pastInfo['total_seats'] = $request->past_seat_info['first_year'];
                    }

                    $pastInfo->save();

                } else {

                    $pastInfo = [
                        'school_id' => $school->id,
                        'level_id' => $levels[0]->id,
                        'year' => $cycleYear,

                    ];

                    if ($i == 1) {
                        $pastInfo['total_seats'] = $request->past_seat_info['third_year'];
                    } elseif ($i == 2) {
                        $pastInfo['total_seats'] = $request->past_seat_info['second_year'];
                    } else {
                        $pastInfo['total_seats'] = $request->past_seat_info['first_year'];
                    }

                    \Models\SchoolSeatInfo::create($pastInfo);
                }
            }
        }

        School::where('udise', $udise)->update(['current_state' => 'step4']);

        $data['redirect'] = route('state.register-your-school.bank-details', [$state, $udise]);

        return api('School fee & seat info have been saved successfully', $data);
    }

    public function postSchoolResume(SchoolResumeRequest $request)
    {

        if (!$this->state->school_registration) {

            throw new UnAuthorizedException('School registration is closed');
        }

        $school = \Models\School::where('udise', $request->udise_code)->with(['schooladmin.user'])->first();

        if (is_null($school['schooladmin'])) {
            throw new \Exceptions\ValidationFailedException("There seems to be no registered school admin for this school");
        }

        if ($school->application_status != 'applied') {

            throw new \Exceptions\ValidationFailedException("Your application is already completed. Please login to update necessary changes.!");
        }

        $count = \Models\SchoolCycle::where('school_id', $school->id)
            ->where('application_cycle_id', $this->data['latest_application_cycle']->id)
            ->count();

        if ($count == 0) {

            $schoolCycle = [
                'school_id' => $school->id,
                'application_cycle_id' => $this->data['latest_application_cycle']->id,
                'status' => $school->application_status,
            ];

            \Models\SchoolCycle::create($schoolCycle);

            \Helpers\SchoolHelper::addSchoolLevels($school->id);

        }

        $input['phone'] = $school['schooladmin']['user']['phone'];

        $input['user_id'] = $school['schooladmin']['user']->id;

        $data['phone'] = 'XXXXXXX' . substr($input['phone'], 7);

        \MsgHelper::generateOTP($input);

        return api('OTP has been sent to your registered number ' . $data['phone'] . ', it may take a moment to receive the OTP', $data);
    }

    public function postResendSchoolOTP(Request $request)
    {
        $school = \Models\School::where('udise', $request->udise_code)->with(['schooladmin.user'])->first();

        if (Carbon::parse($this->data['latest_application_cycle']['created_at']) > Carbon::parse($school->created_at)) {

            // allow school who created only after new app cyc
            throw new \Exceptions\ValidationFailedException("Seems like you are school is not registered for this application cycle");
        }

        if (is_null($school['schooladmin'])) {
            throw new \Exceptions\ValidationFailedException("There seems to be no registered school admin for this school");
        }

        if ($school->application_status != 'applied') {
            throw new \Exceptions\ValidationFailedException("Your application is already completed. Please login to update necessary changes.!");
        }

        $request['phone'] = $school['schooladmin']['user']['phone'];
        $request['user_id'] = $school['schooladmin']['user']->id;

        $data['phone'] = 'XXXXXXX' . substr($request['phone'], 7);

        \MsgHelper::resendOTP($request);

        $show = [
            'toast' => 'OTP has been resent to number ' . $data['phone'],
        ];

        return response()->json(['data' => $show], 200);
    }

    public function postVerifiySchoolOTP(VerifyOTPRequest $request)
    {

        $school = \Models\School::where('udise', $request->udise_code)->with(['schooladmin.user', 'state'])->first();

        if (is_null($school['schooladmin'])) {
            throw new \Exceptions\ValidationFailedException("There seems to be no registered school admin for this school");
        }

        if ($school->application_status != 'applied') {
            throw new \Exceptions\ValidationFailedException("Your application is already completed. Please login to update necessary changes.!");
        }

        $input['phone'] = $school['schooladmin']['user']['phone'];
        $input['otp'] = $request->otp;

        \MsgHelper::verifyOTP($input);

        $request->session()->put('udise', $request->udise_code);

        if (empty($school->state)) {

            $redirect = '/uttarakhand/registration/school-registration/' . $school->udise . '/address-details';
        } else {

            if ($school->current_state == 'step1') {
                $redirect = '/uttarakhand/registration/school-registration/' . $school->udise . '/primary-details';
            } elseif ($school->current_state == 'step2') {
                $redirect = '/uttarakhand/registration/school-registration/' . $school->udise . '/address-details';
            } elseif ($school->current_state == 'step3') {
                $redirect = '/' . $school->state->slug . '/registration/school-registration/' . $school->udise . '/region-selection';
            } elseif ($school->current_state == 'step4') {
                $redirect = '/' . $school->state->slug . '/registration/school-registration/' . $school->udise . '/class-info';
            } elseif ($school->current_state == 'step5') {
                $redirect = '/' . $school->state->slug . '/registration/school-registration/' . $school->udise . '/bank-details';
            }
        }

        $show['redirect'] = $redirect;

        return api('OTP has been verified.', $show);
    }

    public function postDownloadWards($state, $district_id)
    {

        $wards = \Models\Locality::with(['block.district'])
            ->whereHas('block.district', function ($subQuery) use ($district_id) {
                $subQuery = $subQuery->where('id', $district_id)
                    ->from(with(new \Models\District)->getTable());
            })
            ->get();

        $items = [];

        foreach ($wards as $ward) {

            $InnData['Block Name'] = $ward->block->name;

            $InnData['Ward Name'] = $ward->name;

            $items[] = $InnData;
        }

        $reports = \Excel::create('wards', function ($excel) use ($items) {

            $excel->sheet('Wards', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });
        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'wards.xlsx', 'data' => asset('temp/wards.xlsx')], 200);
    }

    public function validateSchoolSession(Request $request, $udise)
    {

        if ($request->session()->has('udise')) {
            $stored_udise = $request->session()->get('udise');

            if ($udise != $stored_udise) {

                $request->session()->pull('udise');

                throw new UnAuthorizedException("Session validation error");
            }

            return $stored_udise;
        } else {
            throw new UnAuthorizedException("Session error");
        }
    }

    public function getSchoolListDownload(Request $request, $state)
    {

        $all_schools = \Models\School::where('application_status', 'verified')
        // ->where('current_state', '!=', 'step5')
            ->where('district_id', 51)
            ->get()
            ->pluck('id')
            ->toArray();

        // $seats = \Models\SchoolLevelInfo::whereIn('school_id', $all_schools)
        //     ->distinct('school_id')
        //     ->pluck('school_id')
        //     ->toArray();

        // $result = array_diff($all_schools, $seats);
        //

        $seatInfos = \Models\SchoolLevelInfo::whereIn('school_id', $all_schools)
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->where('level_id', 1)
            ->whereNotNull('available_seats')
            ->with(['school'])
            ->get();

        $items = [];

        foreach ($seatInfos as $seatInfo) {

            $InnData['SchoolName'] = $seatInfo->school->name;

            $InnData['Udise'] = $seatInfo->school->udise;

            $InnData['Class'] = 'Pre-Primary';

            $InnData['Available Seats'] = $seatInfo->available_seats;

            $items[] = $InnData;
        }

        $reports = \Excel::create('wardsa', function ($excel) use ($items) {

            $excel->sheet('Wardsa', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });
        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'wardsa.xlsx', 'data' => asset('temp/wardsa.xlsx')], 200);
    }

    public function getNotSelectedSchoolsDownload(Request $request, $state)
    {

        $preferences_list = [];

        $nearby_preferences_list = [];

        $registration = \Models\RegistrationCycle::where('status', 'applied');

        $preferences = $registration->pluck('preferences');

        $nearby_preferences = $registration->pluck('nearby_preferences');

        foreach ($preferences as $key => $preference) {

            if (!empty($preference)) {

                foreach ($preference as $key => $value) {

                    array_push($preferences_list, $value);
                }
            }
        }

        foreach ($nearby_preferences as $key => $nearby_preference) {

            if (!empty($nearby_preference)) {

                foreach ($nearby_preference as $key => $value) {

                    array_push($nearby_preferences_list, $value);
                }
            }
        }

        $merged_list = array_merge($preferences_list, $nearby_preferences_list);

        $unique_list = array_unique($merged_list);

        $schools = \Models\School::where('application_status', 'verified')->pluck('id')->toArray();

        $not_select_list = array_diff($schools, $unique_list);

        $new_array = array_values($not_select_list);

        $newschools = \Models\School::select('id', 'name', 'udise')->whereIn('id', $new_array)->get();

        $items = [];

        foreach ($newschools as $school) {

            $InnData['SchoolName'] = $school->name;

            $InnData['Udise'] = $school->udise;

            $items[] = $InnData;
        }

        $reports = \Excel::create('unselected_list', function ($excel) use ($items) {

            $excel->sheet('Unselected Schools', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });
        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'unselected_list.xlsx', 'data' => asset('temp/unselected_list.xlsx')], 200);
    }

    public function getSchoolStatus($state, $udise)
    {

        $school = \Models\School::select('id', 'name', 'udise', 'status', 'application_status')->where('udise', $udise)->first();

        if (count($school) == 0) {

            $school['valid'] = false;
        } else {

            $school['valid'] = true;
        }

        return api('', $school);
    }

    public function getSchoolsDataCount(Request $request, $state)
    {

        /*$schools = School::select('id', 'name', 'udise', 'address')
        ->where('state_id', $this->state->id)
        ->page($request)
        ->orderBy('updated_at', 'desc')
        ->get()
        ->preparePage($request);*/
        $districtData = \Models\District::where('status', 'active')->get();
        foreach ($districtData as $dk => $dv) {
            $blockData = \Models\Block::where('district_id', $dv['id'])->orderBy('name')->get();
            $disdata = \Models\School::where('district_id', $dv['id'])->whereIn('application_status', ['verified', 'registered'])->count();
            $disdata1 = \Models\School::where('district_id', $dv['id'])->whereIn('application_status', ['applied'])->count();
            $disdataVerified = \Models\School::where('district_id', $dv['id'])->where('application_status', 'verified')->count();
            foreach ($blockData as $k => $v) {
                $data = \Models\School::where('block_id', $v['id'])->whereIn('application_status', ['verified', 'registered'])->count();
                $data1 = \Models\School::where('block_id', $v['id'])->where('application_status', 'verified')->count();
                $data2 = \Models\School::where('block_id', $v['id'])->where('application_status', 'applied')->count();
                if ($data) {
                    $schools['items'][$dk]['name'] = $dv['name'];
                    $schools['items'][$dk]['counttotal'] = $disdata;
                    $schools['items'][$dk]['countapplied'] = $disdata1;
                    $schools['items'][$dk]['countverified'] = $disdataVerified;
                    $schools['items'][$dk]['countverified'] = $disdataVerified;
                    $schools['items'][$dk]['data'][$k]['block'] = $v['name'];
                    $schools['items'][$dk]['data'][$k]['total_schools'] = $data;
                    $schools['items'][$dk]['data'][$k]['verified_schools'] = $data1;
                    $schools['items'][$dk]['data'][$k]['applied_schools'] = $data2;
                }
            }
        }
        return api('Showing all Schools', $schools);
    }

    public function getSchoolRegistrationResult(Request $request)
    {

        $data['redirect'] = url($this->state->slug . '/school-registration/' . $request->udise_code . '/result');

        return api('', $data);

    }
}
