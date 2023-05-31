<?php
namespace Redlof\RoleDistrictAdmin\Controllers\Role;

use Exceptions\ActionFailedException;
use Illuminate\Http\Request;
use Models\Block;
use Models\NodaladminBlock;
use Models\NodalRequest;
use Models\StateNodal;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleDistrictAdmin\Controllers\Role\Requests\AddNodalAdminRequest;
use Redlof\RoleDistrictAdmin\Controllers\Role\RoleDistrictAdminBaseController;

class RoleDistrictAdminNodalController extends RoleDistrictAdminBaseController
{

    public function getNodalAdminsList(Request $request, $district_id)
    {
        $statenodal = StateNodal::where('status', 'active')
            ->where('state_id', $this->data['district']->state_id)
            ->where('district_id', $district_id)
            ->with(['user', 'state'])
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $statenodal);
    }

    public function getNodalAdminsUnAssignedBlocksList(Request $request, $nodal_admin_id)
    {

        $district_id = $this->data['district']['id'];

        $asignedblocks = NodaladminBlock::where('state_nodals_id', '!=', $nodal_admin_id)->get();

        $allblocks = Block::where('district_id', $district_id)
            ->whereNotIn('id', $asignedblocks->pluck('block_id')->toArray())
            ->get();

        $sorted_ids = [];

        foreach ($allblocks as $block) {

            if (in_array('block', $block->sub_block)) {
                array_push($sorted_ids, $block->id);
            }
        }

        $blocks = Block::whereIn('id', $sorted_ids)->get();

        return api('', $blocks);
    }

    public function postNodalAdminBlockAssign(Request $request, $nodal_admin_id)
    {

        $request->merge([
            'state_nodals_id' => $nodal_admin_id,
        ]);

        $asignedblock = NodaladminBlock::where('state_nodals_id', $nodal_admin_id)->first();

        if (empty($asignedblock)) {

            NodaladminBlock::create($request->all());
        } else {

            $asignedblock->update($request->all());
        }

        $apiData['reload'] = true;

        return api('', $apiData);
    }

    public function getDistrictNodalAdmins()
    {
        $district_nodaladmin = StateNodal::where('status', 'active')
            ->where('district_id', $this->data['district']->id)
            ->with(['user', 'state'])
            ->orderBy('created_at', 'desc')
            ->get();

        return api('', $district_nodaladmin);
    }

    public function getAssignNodalAdminsList(Request $request, $district_id)
    {
        $statenodal = StateNodal::where('status', 'active')
            ->where('state_id', $this->data['district']->state_id)
            ->where('district_id', $district_id)
            ->with(['user', 'state'])
            ->orderBy('created_at', 'desc')
            ->get();

        return api('', $statenodal);
    }

    public function deactivateNodalAdmin($nodal_id)
    {

        $nodalUpdate = StateNodal::where('id', $nodal_id)->update(['status' => 'inactive']);
        $showObject = [
            'reload' => true,
        ];

        return api('Nodal Admin Deactivated', $showObject);
    }

    public function postNodalAdmin(AddNodalAdminRequest $request, UserRepo $userRepo)
    {

        $nodalAdmin = new StateNodal();

        $nodalAdmin->state_id = $request->state_id;

        $request['email'] = strtolower($request['email']);

        $nodalAdmin->district_id = $this->data['districtadmin_user']->district_id;

        $request['role_type'] = 'role-nodal-admin';

        $request['password'] = rand() . \Carbon::now()->timestamp;

        $user = $userRepo->create($request->all());

        $nodalAdmin->user_id = $user['id'];

        $nodalAdmin->save();

        $nodalAdmin['redirect'] = '/districtadmin/nodaladmin/';

        $EmailData = array(
            'first_name' => $user->first_name,
            'email' => $request->email,
            'password' => $request['password'],
        );

        $subject = 'RTE Credentials!';

        \MailHelper::sendSyncMail('admin::emails.welcome-nodaladmin', $subject, $user->email, $EmailData);

        return api('successfully added nodal admin', $nodalAdmin);

    }

    public function postAddBulkUdise(Request $request)
    {

        if (!$request->hasFile('file')) {
            throw new ActionFailedException("Please upload csv file");
        }

        $file = $request->file('file');

        $users = \Excel::load($file)->get();

        foreach ($users as $key => $user) {

            if ($user->udise == null || $user->email == null) {

                throw new ActionFailedException("Please check the csv file! It might be missing some fields. Please add all the information and try again later!");

            } else {

                $user['email'] = str_replace(' ', '', $user['email']);

                $user['email'] = strtolower($user['email']);

                $userCheck = \Models\User::where('email', $user['email'])->first();

                if (empty($userCheck)) {

                    throw new ActionFailedException("Nodal with email " . $user['email'] . " does not exists. Please register the Nodal before uploading the sheet.");
                }

            }
        }

        foreach ($users as $key => $user) {

            $checkUdise = \Models\UdiseNodal::where('udise', $user['udise'])->delete();
            // Check for the email in the users table,

            $user['email'] = str_replace(' ', '', $user['email']);

            $user['email'] = strtolower($user['email']);

            $user['district_id'] = $request['district_id'];

            $newEntry = \Models\UdiseNodal::create($user->all());
        }

        $showObject = [
            'reload' => true,
        ];

        return api('Uploaded successfully', $showObject);

    }

    public function postRequestNodal()
    {

        $input = array('district_id' => $this->district->id);

        NodalRequest::create($input);

        $showObject = [
            'reload' => true,
        ];

        return api('Requested successfully', $showObject);

    }

    public function getStateDistricts(Request $request, $state_id)
    {

        $district = \Models\District::where('status', 'active')
            ->where('state_id', $state_id)

            ->get();

        return api('', $district);

    }

    public function getSearchNodalAdmin(Request $request, $district_id)
    {

        $nodaladmin = StateNodal::where('status', 'active')
            ->where('state_id', $this->data['district']->state_id)
            ->where('district_id', $district_id)
            ->with(['user', 'state'])
            ->whereIn('user_id', function ($query) use ($request) {

                $query->where('first_name', 'ilike', '%' . $request['s'] . '%')
                    ->select('id')
                    ->from(with(new \Models\User)->getTable());
            })
            ->page($request)
            ->orderBy('created_at', 'desc')

            ->get()
            ->preparePage($request);

        return response()->json(['msg' => '', 'data' => $nodaladmin], 200);
    }

    public function activateNodalAdmin($nodal_id)
    {

        $nodal = StateNodal::where('id', $nodal_id)
            ->with('user')
            ->first();

        $password = rand() . \Carbon::now()->timestamp;

        $updateStatus = StateNodal::where('id', $nodal_id)->update(['status' => 'active']);

        $encryp = bcrypt($password);

        $updatePassword = \Models\User::where('id', $nodal->user->id)
            ->update(['password' => $encryp]);

        $EmailData = array(
            'first_name' => $nodal->user->first_name,
            'email' => $nodal->user->email,
            'password' => $password,
        );

        $subject = 'RTE Credentials - Account Activated';

        \MailHelper::sendSyncMail('admin::emails.reactivated-nodaladmin', $subject, $nodal->user->email, $EmailData);

        $showObject = [
            'reload' => true,
        ];

        return api('Nodal admin Activated', $showObject);
    }

    public function getDeactivatedNodals(Request $request, $district_id)
    {

        $statenodal = StateNodal::where('status', 'inactive')
            ->where('district_id', $district_id)
            ->with(['user', 'state'])
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $statenodal);
    }

    public function getUdiseNodals(Request $request, $district_id)
    {

        $udiseNodal = \Models\UdiseNodal::where('district_id', $district_id)
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $udiseNodal);
    }

    public function getSearchUdiseNodals(Request $request, $district_id)
    {

        $udiseNodal = \Models\UdiseNodal::where('district_id', $district_id)
            ->where('email', 'ilike', '%' . $request['s'] . '%')
            ->orWhere('udise', $request['s'])
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $udiseNodal);
    }

    public function postUnAssignNodalBlock(Request $request, $nodal_block_id)
    {

        \Models\NodaladminBlock::where('id', $nodal_block_id)->delete();

        $showObject = ['reload' => true];

        return api('Nodal admin removed successfully.', $showObject);

    }
}
