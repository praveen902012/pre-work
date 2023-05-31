<?php
namespace Redlof\RoleSchoolAdmin\Controllers\School;

use Exceptions\EntityAlreadyExistsException;
use Exceptions\ValidationFailedException;
use Illuminate\Http\Request;
use Models\Language;
use Models\Level;
use Models\School;
use Redlof\Engine\Auth\Repositories\SchoolAdminRepo;
use Redlof\RoleSchoolAdmin\Controllers\Role\RoleSchoolAdminBaseController;
use Redlof\RoleSchoolAdmin\Controllers\School\Requests\AddSchoolAddressRequest;
use Redlof\RoleSchoolAdmin\Controllers\School\Requests\AddSchoolBankDetailsRequest;
use Redlof\RoleSchoolAdmin\Controllers\School\Requests\AddSchoolDetailsRequest;
use Redlof\RoleSchoolAdmin\Controllers\School\Requests\AddSchoolLevelFeeRequest;
use Redlof\RoleSchoolAdmin\Controllers\School\Requests\AddSchoolLevelSeatRequest;
use Redlof\RoleSchoolAdmin\Controllers\School\Requests\AddSchoolNeighbourhoodRequest;
use Redlof\RoleSchoolAdmin\Controllers\School\Requests\AddSchoolRequest;

class SchoolController extends RoleSchoolAdminBaseController
{

    public function __construct()
    {

        parent::__construct();
    }

    public function checkSchoolCycle()
    {

        // Check if the school have entry for current cycle
        $cycleCheck = \Models\SchoolCycle::where('school_id', $this->school->id)
            ->where('application_cycle_id', $this->data['latest_application_cycle']->id)->first();

        if (empty($cycleCheck)) {

            $school = \Models\School::where('id',  $this->school->id)->first();

            // Migrate to new cycle
            \Models\SchoolCycle::create([
                'school_id' => $this->school->id,
                'application_cycle_id' => $this->data['latest_application_cycle']->id,
                'status' => "registered",
            ]);

            \Helpers\SchoolHelper::addSchoolLevels($this->school->id);

            $school->application_status = 'registered';

            $school->current_state = 'step1';

            $school->save();

            $seatInfos = \Models\SchoolLevelInfo::where('school_id', $this->school->id)
                ->whereIn('level_id', $this->school->levels)
                ->where('session_year', $this->data['latest_application_cycle']->session_year)
                ->first();

            if (!empty($seatInfos)) {

                $schoolSeatInfo = [
                    'school_id' => $this->school->id,
                    'level_id' => $seatInfos->level_id,
                    'year' => $this->data['latest_application_cycle']->session_year - 1,
                    'total_seats' => $seatInfos->total_seats,
                ];

                \Models\SchoolSeatInfo::create($schoolSeatInfo);
            }
        }

        return true;
    }

    public function getFeeStructure(Request $request)
    {
        $flag = true;

        $school = School::where('id', $this->school->id)->select('id', 'levels')->first();

        $levelsData = \Models\SchoolLevelInfo::where('school_id', $this->school->id)
            ->with(['level_info'])
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->orderBy('level_id', 'asc')
            ->get()
            ->toArray();

        foreach ($school['levels'] as $key => $value) {

            if ($value == 1) {

                $flag = false;

            }

            $checkLevel = \Models\SchoolLevelInfo::where('school_id', $school->id)
                ->where('session_year', $this->data['latest_application_cycle']['session_year'])
                ->where('level_id', $value)
                ->first();

            $classlevels2 = array("KG 1", "Pre-Primary");

            if (count($levelsData) == 0) {

                $classlevels = array("Pre-Primary", "KG 1", "KG 2", "Class 1", "Class 2", "Class 3", "Class 4", "Class 5", "Class 6", "Class 7", "Class 8");

                $fee = $school->levels;

                $least = min($fee);

                $j = $least;

                for ($i = 1; $i < $least; $i++) {

                    unset($classlevels[$least - $j]);

                    $j = $j - 1;

                }

                $levelsData = [];

                $idj = 1;

                foreach ($classlevels as $key => $value) {
                    $levelData = [];
                    $levelData['level_info']['level'] = $value;
                    if ($value == 'Class 1') {
                        $levelData['level_info']['id'] = 4;
                    } else {
                        $levelData['level_info']['id'] = $idj;
                    }
                    $levelData['tution_fee'] = 0;
                    $levelData['other_fee'] = 0;

                    array_push($levelsData, $levelData);

                    if ($levelData['level_info']['level'] == 'Class 1') {

                        $idj = 12;

                    } else {

                        $idj += 1;
                    }
                }

            } elseif (is_null($checkLevel)) {

                if ($value == 1) {

                    $imj = 2;

                    foreach ($classlevels2 as $key => $value) {
                        $levelData = [];
                        $levelData['level_info']['level'] = $value;
                        $levelData['level_info']['id'] = $imj;
                        $levelData['tution_fee'] = 0;
                        $levelData['other_fee'] = 0;

                        array_unshift($levelsData, $levelData);

                        $imj -= 1;
                    }

                }
            } elseif (count($levelsData) != 0) {

                if ($value == 4 && $flag) {

                    foreach ($levelsData as $key => $value) {
                        if ($value['level_info']['level'] == 'Pre-Primary') {
                            unset($levelsData[$key]);
                        } elseif ($value['level_info']['level'] == 'KG 1') {
                            unset($levelsData[$key]);
                        }

                    }

                }

            }
        }

        $finalData = [];

        foreach ($levelsData as $key => $levelData) {

            if ($levelData['level_info']['level'] == 'KG 1') {
                $levelData['level_info']['level'] = 'Pre-Primary 2';
            }

            if ($levelData['level_info']['level'] != 'KG 2') {

                array_push($finalData, $levelData);
            }

        }

        return api('', $finalData);

    }

    public function addSchoolLevelFeeInfo(AddSchoolLevelFeeRequest $request)
    {
        $levels_info = $request->all();

        $levels = Level::select('id', 'level')->whereIn('level', collect($request->all())->pluck('level')->all())->get();

        foreach ($levels_info as $key => $value) {

            $levels_info[$key]['school_id'] = $this->school->id;
            $level = $levels->where('level', $value['level'])
                ->first();

            $levels_info[$key]['level_id'] = $level['id'];
        }

        $validate = \Models\SchoolLevelInfo::where('school_id', $this->school->id)
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->get();

        if (count($validate) > 0) {
            throw new EntityAlreadyExistsException("Fee info has already been added");
        }

        $check = collect($levels_info)->transform(function ($item, $key) {

            $level = collect($item)->except(['$hashKey', 'level'])->toArray();

            $level['session_year'] = $this->data['latest_application_cycle']['session_year'];

            return $level;
        })->all();

        \Models\SchoolLevelInfo::insert($check);

        $data['redirect'] = route('schooladmin.add-seat-structure');

        return api('Updated fee info', $data);

    }

    public function getSchoolDetails($school_id)
    {

        $school = \Models\School::select('id', 'name', 'udise', 'logo', 'language_id', 'phone', 'website', 'levels', 'type', 'description', 'school_type', 'rte_certificate_no')
            ->where('id', $school_id)
            ->with(['schooladmin', 'schooladmin.user', 'language'])
            ->first();

        $level = '';

        foreach ($school['levels'] as $key => $l) {
            $value = intval($l);

            $level = $l;

        }

        $school['level'] = $level;

        return api('', $school);
    }

    public function getSchoolAddressDetails($school_id)
    {

        $school = \Models\School::select('id', 'address', 'state_id', 'district_id', 'locality_id', 'sub_locality_id', 'sub_sub_locality_id', 'block_id', 'lat', 'lng', 'pincode', 'state_type', 'sub_block_id', 'cluster_id')
            ->with(['state', 'district', 'block', 'locality', 'sublocality', 'subsublocality', 'cluster'])
            ->where('id', $school_id)
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

    public function getSchoolRegionDetails($school_id)
    {

        $school = \Models\School::where('id', $school_id)
            ->select('id', 'sub_block_id', 'locality_id', 'district_id')
            ->first();

        $regions = \Models\SchoolRange::where('school_id', $school_id)
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

    public function getSchoolFeeDetails($id)
    {
        $school = School::where('id', $this->school->id)->select('id', 'levels', 'type')->first();

        $existing_fee_details = \Models\SchoolLevelInfo::where('school_id', $school->id)
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->with(['level_info'])
            ->orderBy('level_id', 'asc')
            ->get();

        return api('', $existing_fee_details);
    }

    public function getPastSeatDetails($udise)
    {
        $school = School::where('udise', $this->school->udise)->first();

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

    public function getSchoolSeatDetails($udise)
    {
        $school = School::where('udise', $udise)->select('id', 'levels')->first();

        $levels = \Models\Level::select('id', 'level')->whereIn('id', $school['levels'])->get();

        $stats = \Models\AllottmentStatistic::where('school_id', $school->id)
            ->select('year', 'allotted_seats', 'dropouts', 'level_id')
            ->get();

        $school_levels = \Models\SchoolLevelInfo::where('school_id', $school->id)
            ->select('level_id', 'available_seats', 'total_seats')
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->whereIn('level_id', $school['levels'])
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

    public function getSchoolBankDetails($school_id)
    {

        $bank = \Models\SchoolBankDetails::where('school_id', $school_id)->first();

        if (!isset($bank->ifsc_code)) {
            $bank = collect($bank)->except(['ifsc_code']);
        }

        return api('', $bank);
    }

    public function updateSchool(AddSchoolRequest $request, $school_id, SchoolAdminRepo $schoolRepo)
    {

        // if (!$this->data['school_registration_on']) {

        //     throw new ValidationFailedException("School registration is closed, You are not eligible to apply for Current Session");
        // }

        if ($request->eshtablished > \Carbon::now()->year) {

            throw new ValidationFailedException("Established year should be less than the current year");
        }

        self::checkSchoolCycle();

        if ($request->hasFile('photo')) {

            $file_name = \ImageHelper::createFileName($request['photo']);

            \ImageHelper::ImageUploadToS3($request['photo'], $file_name, 'school/', true, 1200, 600, true);
            $request->merge(['logo' => $file_name]);
        }

        $request->merge(['language_id' => $request->medium['id']]);

        $previousData = School::find($school_id);

        $newSchool = School::find($school_id);

        $newSchool['phone'] = $request['phone'];
        $newSchool['name'] = $request['name'];
        $new_level[] = $request['level'];
        $newSchool['levels'] = $new_level;

        $newSchool['udise'] = $request['udise'];

        $newSchool['logo'] = $request['logo'];

        $newSchool['language_id'] = $request['language_id'];

        $newSchool['type'] = $request['type'];

        $newSchool['rte_certificate_no'] = $request['rte_certificate_no'];

        $newSchool['school_type'] = $request['school_type'];

        $newSchool->save();

        if ($previousData->type != $request['type'] || !in_array($request['level'], $previousData->levels)) {

            \Helpers\SchoolHelper::updateSchoolLevels($previousData->id, $request);
        }

        if (isset($request['website'])) {

            $upSchool = School::where('id', $school_id)
                ->update([

                    'website' => $request['website'],

                ]);
        }

        if (isset($request['description'])) {

            $upSchool = School::where('id', $school_id)
                ->update([

                    'description' => $request['description'],

                ]);
        }

        $newSchoolAdmin = \Models\User::find($request->schooladmin['user_id']);

        if ($request['email']) {

            $newSchoolAdmin['email'] = $request['email'];
        }

        $newSchoolAdmin['phone'] = $request['admin_phone'];

        $newSchoolAdmin->save();

        $data['redirect'] = route('schooladmin.update-address', $request->udise);

        return api('Primary details has been updated successfully', $data);
    }

    public function getSeatInfo()
    {
        $seatsData = \Models\SchoolLevelInfo::select('id', 'total_seats', 'available_seats', 'level_id')
            ->with(['level_info'])
            ->orderBy('level_id', 'asc')
            ->where('school_id', $this->school->id)
            ->whereIn('level_id', $this->school->levels)
            ->where('session_year', $this->data['latest_application_cycle']['session_year'])
            ->get();

        foreach ($seatsData as $key => $seatData) {

            $seatData['level'] = $seatData['level_info']['level'];

            if ($seatData['total_seats'] == null) {
                $seatData['total_seats'] = 0;
            }

            if ($seatData['available_seats'] == null) {
                $seatData['available_seats'] = 0;
            }
        }

        return api('', $seatsData);
    }

    public function updateSchoolAddress(AddSchoolAddressRequest $request, $udise)
    {

        // if (!$this->data['school_registration_on']) {

        //     throw new ValidationFailedException("School registration is closed, You are not eligible to apply for Current Session");
        // }

        self::checkSchoolCycle();

        $school = School::where('udise', $udise)
            ->update([
                'state_id' => $request['state']['id'],
                'district_id' => $request['district_id'],
                'block_id' => $request['block_id'],
                'sub_block_id' => $request['sub_block_id'],
                'state_type' => $request['state_type'],
                'locality_id' => $request['locality_id'],
                // 'cluster_id' => $request['cluster_id'],
                'address' => $request['address'],
                'pincode' => $request['pincode'],
                'lat' => $request['lat'],
                'lng' => $request['lng'],
            ]);

        $data['redirect'] = route('schooladmin.update-region', $udise);

        return api('Address details has been saved successfully', $data);

    }

    public function updateSchoolRegion(AddSchoolNeighbourhoodRequest $request, $udise)
    {

        // if (!$this->data['school_registration_on']) {

        //     throw new ValidationFailedException("School registration is closed, You are not eligible to apply for Current Session");
        // }

        self::checkSchoolCycle();

        if (!empty($request->range0)) {

            if (count($request->range0) > 7) {
                throw new ValidationFailedException("You can select maximum 5 wards from your block and maximum 2 wards from your district.");
            }

        }

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

        $data['redirect'] = route('schooladmin.update-fee', $udise);

        return api('Neighbourhood areas of the school have been saved successfully', $data);

    }

    public function updateSchoolSeat($udise, AddSchoolDetailsRequest $request)
    {

        // if (!$this->data['school_registration_on']) {

        //     throw new ValidationFailedException("School registration is closed, You are not eligible to apply for Current Session");
        // }

        self::checkSchoolCycle();

        $school = School::where('udise', $udise)->select('id', 'levels', 'cycle')->first();

        \Helpers\SchoolHelper::updateSchoolLevelSeats($school->id, $request);

        $levels = Level::select('id', 'level')->whereIn('id', collect($request['feestructure'])->pluck('level_id')->all())->get();

        \Models\AllottmentStatistic::where('school_id', $school->id)->delete();

        foreach ($request['seatinfo'] as $key => $value) {

            $level_id = $levels->where('level', $value['level'])
                ->pluck('id')
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
                            $allottmentStats->level_id = $level_id;
                            $allottmentStats->school_id = $school->id;

                            $allottmentStats->save();
                        }
                    }
                }
            }
        }

        //New Way to Store Past Allotment Statistics in better way.

        $seat_info = \Models\SchoolSeatInfo::where('school_id', $this->school->id)
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

        };

        $data['redirect'] = route('schooladmin.update-bank', $udise);

        return api('School fee & seat info have been saved successfully', $data);
    }

    public function updateSchoolBank($udise, AddSchoolBankDetailsRequest $request)
    {

        // if (!$this->data['school_registration_on']) {

        //     throw new ValidationFailedException("School registration is closed, You are not eligible to apply for Current Session");
        // }

        self::checkSchoolCycle();

        $school = School::where('udise', $udise)->select('id', 'district_id', 'locality_id', 'udise')->with(['schooladmin', 'schooladmin.user'])->first();

        $schoolBank = \Models\SchoolBankDetails::where('school_id', $school->id)->first();

        if (empty($schoolBank)) {

            $schoolBank = new \Models\SchoolBankDetails();
        };

        $schoolBank->school_id = $school->id;

        $schoolBank->account_number = $request['account_number'];

        $schoolBank->account_holder_name = $request['account_holder_name'];

        $schoolBank->bank_name = $request['bank_name'];

        $schoolBank->ifsc_code = $request['ifsc_code'];

        if (!isset($request['ifsc_code']) || empty($request['ifsc_code'])) {
            $schoolBank->ifsc_code = null;
        }

        $schoolBank->branch = $request['branch'];

        $schoolBank->save();

        $input['phone'] = $school->schooladmin->user->phone;
        $input['message'] = 'Registration details has been updated successfully.';

        \MsgHelper::sendSyncSMS($input);

        \Models\School::where('udise', $udise)
            ->update(['application_status' => 'registered']);

        $checkUdise = \Models\UdiseNodal::where('udise', $school->udise)
            ->first();

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

        $data['redirect'] = route('schooladmin.dashboard');

        return api('School registration details has been updated', $data);
    }

    public function addSchoolLevelSeatInfo(AddSchoolLevelSeatRequest $request)
    {
        $all_seats = $request->all();

        foreach ($all_seats as $key => $value) {

            if ($value['total_seats'] < $value['available_seats']) {
                throw new ValidationFailedException("Total seats cannot be less then available seats");
            }
        }

        foreach ($all_seats as $key => $value) {

            \Models\SchoolLevelInfo::where('school_id', $this->school->id)
                ->where('level_id', $value['level_id'])
                ->where('session_year', $this->data['latest_application_cycle']['session_year'])
                ->update(['total_seats' => $value['total_seats'], 'available_seats' => $value['available_seats']]);
        }

        \Models\School::where('id', $this->school->id)
            ->update(['application_status' => 'registered']);

        $data['redirect'] = route('schooladmin.dashboard');

        return api('Updated seat info', $data);
    }

    public function getLanguages(Request $request, $state)
    {

        $languages = Language::select('id', 'name')->get();

        return api('', $languages);
    }

    public function getLevels(Request $request, $state)
    {

        $levels = Level::select('id', 'level')->get();

        return api('', $levels);
    }

    public function getStudentsForReimbursement(Request $request)
    {

        $students = \Models\ReportCard::where('school_id', $this->school->id)
            ->with('student', 'student.personal_details', 'student.bank_details', 'student.level', 'total_months_present')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getStudentsForReimbursementDownload(Request $request)
    {

        $students = \Models\ReportCard::where('school_id', $this->school->id)
            ->with('student', 'student.personal_details', 'student.bank_details', 'student.level', 'total_months_present')
            ->get();

        $items = [];

        if (count($students) != 0) {
            foreach ($students as $student) {

                $total = 0;

                $student = $student->toArray();
                $InnData['Application Year'] = $student['application_year'];
                $InnData['Registration No.'] = $student['student']['registration_no'];
                $InnData['Student Name'] = $student['student']['first_name'] . ' ' . $student['student']['last_name'];
                $InnData['Student Category'] = $student['student']['personal_details']['category'];
                $InnData['Class Admitted'] = $student['student']['level']['level'];
                $InnData['Present Class'] = $student['student']['level']['level'];
                $InnData['Months Present'] = $student['total_months_present']['total'];
                $InnData['Per-Month Fee'] = $student['amount_payable'] / 12;
                $InnData['Total Reimbursement for the Year'] = $total + ($student['total_months_present']['total'] * ($student['amount_payable'] / 12));
                $InnData['Bank first_name'] = $student['student']['bank_details']['bank_name'];
                $InnData['Bank Account Number'] = $student['student']['bank_details']['account_number'];
                $InnData['Bank IFSC Code'] = $student['student']['bank_details']['ifsc_code'];
                $items[] = $InnData;
            }
        }

        $reports = \Excel::create('all-students-list', function ($excel) use ($items) {

            $excel->sheet('All Students List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'all-students-list.xlsx', 'data' => asset('temp/all-students-list.xlsx')], 200);
    }

    public function updateReimbursement()
    {

        $reimburse = \Models\SchoolReimbursement::where('school_id', $this->school->id)
            ->update(['payment_status' => 'not_received']);

        $reloadObj['reload'] = true;

        return api('Reimbursement marked as not received', $reloadObj);

    }

    public function updateReimbursementReceived()
    {

        $reimburse = \Models\SchoolReimbursement::where('school_id', $this->school->id)
            ->update(['payment_status' => 'received']);

        $reloadObj['reload'] = true;

        return api('Reimbursement marked as received', $reloadObj);

    }

    public function getResetAll()
    {

        //This function was written to update production changes. Do not use this code.

        $schoolNo = 0;

        $schools = \Models\School::select('id', 'levels')->get();

        foreach ($schools as $key => $school) {

            if (count($school->levels) < 2) {

                if ($school->levels[0] == 4) {

                    $schoolNo = $schoolNo + 1;

                    $updateLevel = \Models\SchoolLevelInfo::where('school_id', $school->id)
                        ->where('session_year', $this->data['latest_application_cycle']['session_year'])
                        ->where('level_id', 1)
                        ->update(['level_id' => 4]);

                }

            }

        }

        http_response_code(500);
        dd($schoolNo);

    }

    public function verifySchoolPhone(AddSchoolRequest $request)
    {

        $input['phone'] = $request['admin_phone'];

        $data['phone'] = 'XXXXXXX' . substr($input['phone'], 7);

        $data['validation_check'] = true;

        \MsgHelper::generateOTP($input);

        return api('OTP has been sent to your admin phone number ' . $data['phone'] . ', it may take a moment to receive the OTP', $data);

    }

    public function verifySchoolOTP(Request $request)
    {

        $input['phone'] = $request['admin_phone'];
        $input['otp'] = $request->otp;

        \MsgHelper::verifyOTP($input);

        $data['success'] = true;

        return api('Phone number verified', $data);
    }

}
