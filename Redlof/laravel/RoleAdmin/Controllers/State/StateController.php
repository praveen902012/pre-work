<?php

namespace Redlof\RoleAdmin\Controllers\State;

use Illuminate\Http\Request;
use Models\Language;
use Models\School;
use Models\State;
use Models\StateAdmin;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleAdmin\Controllers\State\Requests\AddLanguageRequest;
use Redlof\RoleAdmin\Controllers\State\Requests\AddStateAdminRequest;
use Redlof\RoleAdmin\Controllers\State\Requests\UpdateNewStateRequest;
use Redlof\RoleAdmin\Controllers\State\Requests\UpdateStateRequest;
use Redlof\RoleAdmin\Controllers\State\StateBaseController;

class StateController extends StateBaseController
{

    protected $admin;

    public function __construct()
    {
        parent::__construct();
    }

    public function getLanguages(Request $request)
    {

        $languages = Language::select('id', 'name')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $languages);
    }

    public function getLanguagesList()
    {

        $languages = Language::select('id', 'name')->get();

        return api('', $languages);
    }

    public function postLanguagesAdd(AddLanguageRequest $request)
    {

        $newLanguage = Language::create($request->all());

        return api('New language ' . $newLanguage->name . ' added', $newLanguage);
    }

    public function postStateAdd(UpdateNewStateRequest $request)
    {

        $file_name = null;

        if ($request->hasFile('image')) {

            $file_name = \ImageHelper::createFileName($request['image']);

            \ImageHelper::ImageUploadToS3($request['image'], $file_name, 'state/', true, 1200, 600, true);
        }

        $state = State::where('id', $request['state_id']['id'])->update(['in_platform' => true, 'language_id' => $request['language']['id'], 'logo' => $file_name]);

        $show['redirect'] = '/admin/states';

        return api('Added new state', $show);
    }

    public function postUpdateState(UpdateStateRequest $request)
    {

        $newState = State::find($request->id);
        $newState->name = $request->name;
        $newState->language_id = $request->language_id;

        if ($request->hasFile('image')) {

            $file_name = \ImageHelper::createFileName($request['image']);
            \ImageHelper::ImageUploadToS3($request['image'], $file_name, 'state/', true, 1200, 600, true);

            $newState->logo = $file_name;
        }

        $newState->save();

        $showObject = [
            'reload' => true,
        ];

        return api('Updated state info', $showObject);
    }

    public function getStatesAll(Request $request)
    {

        $states = State::select('id', 'name', 'logo', 'language_id')
            ->with(['language'])
            ->where('in_platform', true)
            ->orderBy('created_at', 'desc')
            ->page($request)

            ->get()
            ->preparePage($request);

        return api('All states', $states);
    }

    public function getLocalityAll(Request $request, $block_id)
    {

        $localities = \Models\Locality::select('id', 'name')
            ->where('block_id', $block_id)
            ->orderBy('name')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $localities);
    }

    public function getSearchStatesAll(Request $request)
    {

        $states = State::select('id', 'name', 'logo', 'language_id')
            ->with(['language'])
            ->where('in_platform', true)
            ->where('name', 'ilike', '%' . $request['s'] . '%')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $states);
    }
    public function getNewStates()
    {

        $states = State::select('id', 'name', 'slug')
            ->where('in_platform', false)
            ->orderBy('name')
            ->get();

        return api('', $states);
    }

    public function getAllStates()
    {

        $states = State::select('id', 'name', 'slug')
            ->orderBy('name')
            ->get();

        return api('', $states);
    }

    public function getStateDetails($state_id)
    {

        $state = State::select('id', 'name', 'language_id')
            ->with(['total_state_admins', 'total_district_admins', 'total_nodal_admins', 'total_schools', 'total_districts', 'total_students'])
            ->find($state_id);

        return api('', $state);
    }

    public function getStates()
    {

        $states = State::select('id', 'name', 'slug', 'language_id')->get();

        return api('All states', $states);
    }

    public function getStateAdminAll(Request $request)
    {

        $stateadmin = StateAdmin::page($request)
            ->with('user', 'state')
            ->get()
            ->preparePage($request);

        return api('', $stateadmin);
    }

    public function getStateAdmins(Request $request, $state_id)
    {

        $stateadmin = StateAdmin::where('state_id', $state_id)
            ->where('status', 'active')
            ->with(['user'])
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->trimTimeStamps()
            ->preparePage($request);

        return api('', $stateadmin);
    }

    public function getDeactivatedStateAdmins(Request $request, $state_id)
    {

        $stateadmin = StateAdmin::where('state_id', $state_id)
            ->where('status', 'inactive')
            ->with(['user'])
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->trimTimeStamps()
            ->preparePage($request);

        return api('', $stateadmin);
    }

    public function getSearchStateAdmins(Request $request, $state_id)
    {

        $stateadmin = StateAdmin::where('state_id', $state_id)
            ->whereIn('user_id', function ($query) use ($request) {

                $query->select('id')
                    ->where('first_name', 'ilike', '%' . $request['s'] . '%')
                    ->from(with(new \Models\User)->getTable());
            })
            ->with(['user'])
            ->page($request)
            ->get()
            ->trimTimeStamps()
            ->preparePage($request);

        return api('', $stateadmin);
    }

    public function deactivateStateAdmin($stateadmin_id)
    {

        $stateAdminUpdate = StateAdmin::where('id', $stateadmin_id)->update(['status' => 'inactive']);
        $showObject = [
            'reload' => true,
        ];
        return api('State admin deactivated', $showObject);
    }

    public function activateStateAdmin($stateadmin_id)
    {

        $stateAdminUpdate = StateAdmin::where('id', $stateadmin_id)->update(['status' => 'active']);
        $showObject = [
            'reload' => true,
        ];
        return api('State admin activated', $showObject);
    }

    public function stateAdminDelete($stateadmin_id)
    {

        $stateadmin = StateAdmin::find($stateadmin_id)->delete();

        $showObject = [
            'reload' => true,
        ];

        return api('Stateadmin is deleted', $showObject);
    }

    public function postAddStateAdmin(AddStateAdminRequest $request, UserRepo $userRepo)
    {

        $request['role_type'] = 'role-state-admin';

        $request['password'] = rand() . \Carbon::now()->timestamp;

        $request->merge(['email' => strtolower($request->email)]);

        $user = $userRepo->create($request);

        $newStateAdmin = StateAdmin::firstOrCreate(['state_id' => $request->state_id, 'user_id' => $user['id']]);

        $newStateAdmin['redirect'] = '/admin/states/' . $request->state_slug . '/stateadmins';

        $EmailData = array(
            'first_name' => $user->first_name,
            'email' => $request->email,
            'password' => $request['password'],
        );

        $subject = 'RTE Credentials!';

        \MailHelper::sendSyncMail('admin::emails.welcome-stateadmin', $subject, $user->email, $EmailData);

        return api('Mapped admin to the state', $newStateAdmin);
    }

    public function getSchool(Request $request, $state_id)
    {

        $school = School::where('state_id', $state_id)
            ->where('application_status', 'verified')
            ->page($request)
            ->get()
            ->trimTimeStamps()
            ->preparePage($request);

        return api('', $school);
    }

    public function getStateDistricts(Request $request, $state_id)
    {

        $district = \Models\District::where('status', 'active')
            ->where('state_id', $state_id)
            ->get();

        return api('', $district);
    }

    public function getDistrictsBlocks(Request $request, $district_id)
    {

        $block = \Models\Block::where('district_id', $district_id)
            ->get();

        return api('', $block);
    }

    public function getStudents(Request $request, $state_id)
    {

        $students = \Models\RegistrationBasicDetail::where('state_id', $state_id)
            ->where('status', 'completed')
            ->page($request)
            ->get()
            ->trimTimeStamps()
            ->preparePage($request);

        return api('', $students);
    }

    public function getAllottedStudents(Request $request, $state_id)
    {

        $students_id = \Models\RegistrationBasicDetail::where('state_id', $state_id)
            ->where('status', 'completed')
            ->get()
            ->pluck('id');

        $students = \Models\RegistrationCycle::where('status', 'allotted')
            ->whereIn('registration_id', $students_id)
            ->with(['basic_details'])
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getEnrolledStudents(Request $request, $state_id)
    {

        $students_id = \Models\RegistrationBasicDetail::where('state_id', $state_id)
            ->where('status', 'completed')
            ->get()
            ->pluck('id');

        $students = \Models\RegistrationCycle::where('status', 'enrolled')
            ->whereIn('registration_id', $students_id)
            ->with(['basic_details'])
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getRejectedStudents(Request $request, $state_id)
    {

        $students_id = \Models\RegistrationBasicDetail::where('state_id', $state_id)
            ->where('status', 'completed')
            ->get()
            ->pluck('id');

        $students = \Models\RegistrationCycle::where('status', 'rejected')
            ->whereIn('registration_id', $students_id)
            ->with(['basic_details'])
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getUsers()
    {

        $users = \Models\User::get();

        return api('', $users);
    }

    public function postStateDelete($state_id)
    {

        $state = State::find($state_id)->delete();

        return api($state->name . ' state deleted');
    }

    public function UpdateStateAdmin(Request $request)
    {

        $stateadmin = StateAdmin::where('id', $request->id)->update(['status' => $request->status]);

        return api('State admin updated', $stateadmin);
    }

    public function postAddLocality(Request $request)
    {

        if (!$request->hasFile('file')) {
            throw new \Exceptions\ActionFailedException("Please upload csv file");
        }

        $file = $request->file('file');

        $localities = \Excel::load($file)->get();

        foreach ($localities as $key => $locality) {

            if ($locality->name == null) {
                throw new \Exceptions\ActionFailedException("Please check the csv file! It might be missing some fields. Please add all the information and try again later!");
            } else {

                $locality['block_id'] = $request['sub_block_id'];

                $locality->timestamps = false;

                $newEntry = \Models\Locality::create($locality->all());
            }
        }

        $showObject = [
            'reload' => true,
        ];

        return api('Uploaded successfully', $showObject);
    }

    public function getSubBlocks($district_id, $type)
    {

        $blocks = \Models\Block::where('district_id', $district_id)->get();

        $newBlocks = [];

        foreach ($blocks as $key => $value) {

            if ($value->sub_block != null) {
                foreach (($value->sub_block) as $k => $v) {
                    if (strpos($v, $type) !== false) {
                        $newBlocks[] = $value;
                    }
                }
            }
        }

        return api('', $newBlocks);

    }

    public function postAddBlock(Request $request)
    {

        if (!$request->hasFile('file') && empty($request->block_name)) {
            throw new \Exceptions\ActionFailedException("Please upload csv file or Enter block name");
        }

        if (empty($request->block_name)) {

            $file = $request->file('file');

            $blocks = \Excel::load($file)->get();

            foreach ($blocks as $key => $block) {

                if ($block->name == null) {
                    throw new \Exceptions\ActionFailedException("Please check the csv file! It might be missing some fields. Please add all the information and try again later!");
                } else {

                    $block['district_id'] = $request['district_id'];

                    $newEntry = \Models\Block::create($block->all());

                    $sub_block = ['block', 'rural' . $newEntry->id];

                    $newEntry->sub_block = $sub_block;

                    $newEntry->save();
                }
            }
        } else {

            $block = [];

            $block['name'] = $request['block_name'];

            $block['district_id'] = $request['district_id'];

            $newEntry = \Models\Block::create($block);

            $sub_block = ['block', 'rural' . $newEntry->id];

            $newEntry->sub_block = $sub_block;

            $newEntry->save();
        }

        $showObject = [
            'reload' => true,
        ];

        return api('Uploaded successfully', $showObject);
    }
    public function postAddSubBlock(Request $request)
    {

        if (!$request->hasFile('file') && empty($request->sub_block_name)) {
            throw new \Exceptions\ActionFailedException("Please upload csv file or Enter Sub block name");
        }

        if (empty($request->sub_block_name)) {

            $file = $request->file('file');

            $blocks = \Excel::load($file)->get();

            foreach ($blocks as $key => $block) {

                if ($block->name == null) {
                    throw new \Exceptions\ActionFailedException("Please check the csv file! It might be missing some fields. Please add all the information and try again later!");
                } else {

                    $block['district_id'] = $request['district_id'];

                    $newEntry = \Models\Block::create($block->all());

                    if ($request->sub_block_type == 'urban') {

                        $sub_block = ['urban' . $request['block_id']];

                        $newEntry->sub_block = $sub_block;
                    } else {

                        $sub_block = ['block', 'rural' . $newEntry->id];

                        $newEntry->sub_block = $sub_block;
                    }

                    $newEntry->save();
                }
            }
        } else {

            $block = [];

            $block['name'] = $request['sub_block_name'];

            $block['district_id'] = $request['district_id'];

            $newEntry = \Models\Block::create($block);

            if ($request->sub_block_type == 'urban') {

                $sub_block = ['urban' . $request['block_id']];

                $newEntry->sub_block = $sub_block;
            } else {

                $sub_block = ['block', 'rural' . $newEntry->id];

                $newEntry->sub_block = $sub_block;
            }

            $newEntry->save();
        }

        $showObject = [
            'reload' => true,
        ];

        return api('Uploaded successfully', $showObject);
    }

    public function postUpdateLocality(Request $request)
    {

        $locality = \Models\Locality::where('id', $request->id)
            ->update(['name' => $request->name]);

        $showObject = [
            'reload' => true,
        ];

        return api('Updated successfully', $showObject);
    }

    public function postAddCluster(Request $request)
    {

        if (!$request->hasFile('file') && empty($request->cluster_name)) {
            throw new \Exceptions\ActionFailedException("Please upload csv file or Enter Cluster name");
        }

        if (empty($request->cluster_name)) {

            $file = $request->file('file');

            $clusters = \Excel::load($file)->get();

            foreach ($clusters as $key => $cluster) {

                if ($cluster->name == null) {
                    throw new \Exceptions\ActionFailedException("Please check the csv file! It might be missing some fields. Please add all the information and try again later!");
                } else {

                    $cluster['block_id'] = $request['block_id'];

                    $newEntry = \Models\Cluster::create($cluster->all());

                }
            }
        } else {

            $cluster = [];

            $cluster['name'] = $request['cluster_name'];

            $cluster['block_id'] = $request['block_id'];

            $newEntry = \Models\Cluster::create($cluster);

        }

        $showObject = [
            'reload' => true,
        ];

        return api('Uploaded successfully', $showObject);

    }

    public function getLocalityDependency($id)
    {

        $data = [];

        $data['schools'] = \Models\School::select('id', 'name', 'udise', 'locality_id')->where('locality_id', $id)
            ->get();

        $registartion_ids = \Models\RegistrationPersonalDetail::where('locality_id', $id)->pluck('registration_id');

        $data['students'] = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name', 'last_name')->whereIn('id', $registartion_ids)->get();

        return api('', $data);

    }

    public function postDeleteLocality(Request $request)
    {

        $schools = \Models\School::select('id', 'name', 'udise', 'locality_id')
            ->where('locality_id', $request->id)
            ->get()
            ->toArray();

        $registartion_ids = \Models\RegistrationPersonalDetail::where('locality_id', $request->id)
            ->pluck('registration_id');

        $students = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name', 'last_name')
            ->whereIn('id', $registartion_ids)
            ->get()
            ->toArray();

        \Models\School::where('locality_id', $request->id)
            ->update([
                'locality_id' => null,
                'block_id' => null,
                'sub_block_id' => null,
            ]);

        \Models\RegistrationPersonalDetail::where('locality_id', $request->id)
            ->update([
                'locality_id' => null,
                'block_id' => null,
            ]);

        $locality = \Models\Locality::where('id', $request->id)
            ->first();

        \Excel::create('schools-list-of-' . str_slug($locality->name, "-"), function ($excel) use ($schools, $locality) {

            $excel->sheet('Schools List', function ($sheet) use ($schools) {
                $sheet->fromArray($schools);
            });

        })->store('xlsx', public_path('temp'));

        \Excel::create('students-list-of-' . str_slug($locality->name, "-"), function ($excel) use ($students, $locality) {

            $excel->sheet('Students List', function ($sheet) use ($students) {
                $sheet->fromArray($students);
            });

        })->store('xlsx', public_path('temp'));

        $zip_file = str_slug($locality->name, "_") . '_for_deletion.zip';

        $zip = new \ZipArchive();

        $zip->open(public_path('temp/' . $zip_file), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $zip->addFile(public_path('temp/students-list-of-' . str_slug($locality->name, "-") . ".xlsx"), 'students-list-' . str_slug($locality->name, "-") . ".xlsx");
        $zip->addFile(public_path('temp/schools-list-of-' . str_slug($locality->name, "-") . ".xlsx"), 'schools-list-' . str_slug($locality->name, "-") . ".xlsx");

        $zip->close();

        \Models\Locality::where('id', $request->id)
            ->delete();

        return response()->json(['filename' => $zip_file, 'data' => asset('temp/' . $zip_file)], 200);

    }

    public function postReassignLocality(Request $request)
    {

        if (empty($request->block_id)) {
            throw new \Exceptions\ValidationFailedException("Please select the block");
        }

        $schools = \Models\School::select('id', 'name', 'udise', 'locality_id')
            ->where('locality_id', $request->id)
            ->get()
            ->toArray();

        $registartion_ids = \Models\RegistrationPersonalDetail::where('locality_id', $request->id)
            ->pluck('registration_id');

        $students = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name', 'last_name')
            ->whereIn('id', $registartion_ids)
            ->get()
            ->toArray();

        \Models\School::where('locality_id', $request->id)
            ->update([
                'locality_id' => null,
                'block_id' => null,
                'sub_block_id' => null,
            ]);

        \Models\RegistrationPersonalDetail::where('locality_id', $request->id)
            ->update([
                'locality_id' => null,
                'block_id' => null,
            ]);

        $locality = \Models\Locality::where('id', $request->id)
            ->first();

        \Excel::create('schools-list-of-' . str_slug($locality->name, "-"), function ($excel) use ($schools, $locality) {

            $excel->sheet('Schools List', function ($sheet) use ($schools) {
                $sheet->fromArray($schools);
            });

        })->store('xlsx', public_path('temp'));

        \Excel::create('students-list-of-' . str_slug($locality->name, "-"), function ($excel) use ($students, $locality) {

            $excel->sheet('Students List', function ($sheet) use ($students) {
                $sheet->fromArray($students);
            });

        })->store('xlsx', public_path('temp'));

        $zip_file = str_slug($locality->name, "_") . '_for_reassign.zip';

        $zip = new \ZipArchive();

        $zip->open(public_path('temp/' . $zip_file), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $zip->addFile(public_path('temp/students-list-of-' . str_slug($locality->name, "-") . ".xlsx"), 'students-list-' . str_slug($locality->name, "-") . ".xlsx");
        $zip->addFile(public_path('temp/schools-list-of-' . str_slug($locality->name, "-") . ".xlsx"), 'schools-list-' . str_slug($locality->name, "-") . ".xlsx");

        $zip->close();

        \Models\Locality::where('id', $request->id)
            ->update(['block_id' => $request->block_id]);

        return response()->json(['filename' => $zip_file, 'data' => asset('temp/' . $zip_file)], 200);

    }

    public function downloadBlock(Request $request, $district_id)
    {

        $district = \Models\District::where('id', $district_id)->first();

        $blocks = \Models\Block::select('id', 'name')
            ->where('district_id', $district_id)
            ->get()
            ->toArray();

        \Excel::create('blocks-of-' . str_slug($district->name, "-"), function ($excel) use ($blocks) {

            $excel->sheet('Blocks', function ($sheet) use ($blocks) {
                $sheet->fromArray($blocks);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'blocks-of-' . str_slug($district->name, "-") . '.xlsx', 'data' => asset('temp/' . 'blocks-of-' . str_slug($district->name, "-") . '.xlsx')], 200);

    }

    public function downloadLocality(Request $request, $block_id)
    {

        $block = \Models\Block::where('id', $block_id)->first();

        $localities = \Models\Locality::select('id', 'name')
            ->where('block_id', $block_id)
            ->get()
            ->toArray();

        \Excel::create('wards-of-' . str_slug($block->name, "-"), function ($excel) use ($localities) {

            $excel->sheet('Wards', function ($sheet) use ($localities) {
                $sheet->fromArray($localities);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'wards-of-' . str_slug($block->name, "-") . '.xlsx', 'data' => asset('temp/' . 'wards-of-' . str_slug($block->name, "-") . '.xlsx')], 200);

    }
}