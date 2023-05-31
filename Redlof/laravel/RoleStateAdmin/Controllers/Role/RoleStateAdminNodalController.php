<?php
namespace Redlof\RoleStateAdmin\Controllers\Role;

use Illuminate\Http\Request;
use Models\Block;
use Models\NodaladminBlock;
use Models\StateNodal;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleStateAdmin\Controllers\Role\Requests\AddNodalAdminRequest;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class RoleStateAdminNodalController extends RoleStateAdminBaseController
{

    //This displays all nodal admins, it must be changed to display nodal admins of the respective state

    public function getNodalAdmins(Request $request)
    {

        $statenodal = StateNodal::where('status', 'active')
            ->where('state_id', $this->data['state_id'])
            ->with(['user', 'state'])
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $statenodal);
    }

    public function getDistrictNodalAdmins($district_id)
    {

        $statenodal = StateNodal::where('status', 'active')
            ->where('district_id', $district_id)
            ->with(['user', 'state'])
            ->get();

        $data['statenodal'] = $statenodal;

        $block_assigned_admin = NodaladminBlock::whereIn('state_nodals_id', $statenodal->pluck('id')->toArray())->get();

        $data['block_assigned_admin'] = $block_assigned_admin;

        return api('', $data);
    }

    public function postBulkAssignBlockToNodalAdmin(Request $request)
    {

        $assigndata = [];

        foreach ($request->nodaladmin as $key => $value) {

            $assigndata['block_id'] = $key;

            $assigndata['state_nodals_id'] = $value;

            $exist = NodaladminBlock::where('block_id', $key)->first();

            if (empty($exist)) {

                NodaladminBlock::create($assigndata);
            } else {

                $exist->update($assigndata);
            }
        }

        $apiData['reload'] = true;

        return api('Successfully assigned nodal admin to Blocks', $apiData);
    }

    public function searchNodalAdmins(Request $request)
    {

        $statenodal = StateNodal::where('status', 'active')
            ->where('state_id', $this->data['state_id'])
            ->with(['user', 'state'])
            ->whereHas('user', function ($query) use ($request) {
                $query->search($request, ['first_name', 'last_name']);
            })
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $statenodal);
    }

    public function addNodalAdmin(AddNodalAdminRequest $request, UserRepo $userRepo)
    {

        if (!$request->hasFile('file') && empty($request->email)) {
            throw new \Exceptions\ActionFailedException("Please upload csv file or Enter nodal admin");
        }

        $subject = 'RTE Credentials!';

        if (empty($request->email)) {

            $file = $request->file('file');

            $nodals = \Excel::load($file)->get();

            foreach ($nodals as $key => $nodal) {

                $userRepo = new UserRepo(new \Models\User());

                // Check if the user with email already exists
                $userCheck = \Models\User::where('email', strtolower($nodal->email))->first();

                if (!empty($userCheck)) {
                    continue;
                }

                // Create a user
                $nodalData = [
                    'role_type' => 'role-nodal-admin',
                    'password' => rand() . \Carbon::now()->timestamp,
                    'email' => strtolower($nodal->email),
                ];

                $user = $userRepo->create($nodalData);

                \Models\StateNodal::create([
                    'state_id' => $this->data['state_id'],
                    'district_id' => $request->district_id,
                    'user_id' => $user->id,
                ]);

                // Send Email to nodal admin
                $EmailData = array(
                    'first_name' => $user->first_name,
                    'email' => $user->email,
                    'password' => $nodalData['password'],
                );

                \MailHelper::sendSyncMail('admin::emails.welcome-nodaladmin', $subject, $user->email, $EmailData);

            }

        } else {

            $nodalAdmin = new \Models\StateNodal();

            $nodalAdmin->state_id = $this->data['state_id'];

            $nodalAdmin->district_id = $request->district_id;

            $request['role_type'] = 'role-nodal-admin';

            $request['password'] = rand() . \Carbon::now()->timestamp;

            $request->merge(['email' => strtolower($request->email)]);

            $user = $userRepo->create($request->all());

            $nodalAdmin->user_id = $user['id'];

            $nodalAdmin->save();

            $nodalAdmin['reload'] = true;

            $EmailData = array(
                'first_name' => $user->first_name,
                'email' => $request->email,
                'password' => $request['password'],
            );

            \MailHelper::sendSyncMail('admin::emails.welcome-nodaladmin', $subject, $user->email, $EmailData);
        }

        return api('Successfully added nodal admin', []);
    }

    public function getDeactivatedNodals(Request $request, $state_id)
    {

        $statenodal = StateNodal::where('status', 'inactive')
            ->where('state_id', $state_id)
            ->with(['user', 'state'])
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $statenodal);
    }

    public function searchDeactivatedNodals(Request $request)
    {

        $statenodal = StateNodal::where('status', 'inactive')
            ->where('state_id', $this->state_id)
            ->with(['user', 'state'])
            ->whereHas('user', function ($query) use ($request) {
                $query->search($request, ['first_name', 'last_name']);
            })
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

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

    public function getDistrictBlocks($district_id)
    {

        $ruralblocks = Block::where('district_id', $district_id)->get();

        $sorted_ids = [];

        foreach ($ruralblocks as $block) {

            if (in_array('block', $block->sub_block)) {
                array_push($sorted_ids, $block->id);
            }
        }

        $blocks = Block::with('assignednodaladmin')->whereIn('id', $sorted_ids)->get();

        return api('', $blocks);
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

    public function postNodalAdmin(AddNodalAdminRequest $request, UserRepo $userRepo)
    {

        $nodalAdmin = new StateNodal();

        $nodalAdmin->state_id = $request->state_id;

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

}
