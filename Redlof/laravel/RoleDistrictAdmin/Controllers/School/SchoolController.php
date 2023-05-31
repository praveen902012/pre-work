<?php
namespace Redlof\RoleDistrictAdmin\Controllers\School;

use Exceptions\ValidationFailedException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Models\School;
use Models\SchoolAdmin;
use Redlof\Core\Repositories\CommonRepo;
use Redlof\Engine\Auth\Repositories\UserRepo;
use Redlof\RoleDistrictAdmin\Controllers\Role\RoleDistrictAdminBaseController;
use Redlof\RoleDistrictAdmin\Controllers\School\Requests\AddSchoolAdminRequest;
use Redlof\RoleDistrictAdmin\Controllers\School\Requests\AddSchoolRequest;

class SchoolController extends RoleDistrictAdminBaseController
{

    protected $districtadmin;

    public function __construct()
    {

        $this->schoolRepo = new CommonRepo();
        $this->schoolRepo->init(new School);

        parent::__construct();

    }

    public function getSchoolsAll(Request $request)
    {

        $schools = $this->schoolRepo->getAll($request);

        return response()->json(['msg' => 'Showing all Schools', 'data' => $schools], 200);
    }

    public function getAllListSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise', 'application_status', 'status')
            ->whereIn('id', $schoolIds)
            ->where('state_id', $this->data['state_id'])
            ->where('district_id', $district_id)
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return response()->json(['msg' => '', 'data' => $schools], 200);
    }

    public function getAllVerifiedSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise')
            ->whereIn('id', $schoolIds)
            ->where('district_id', $district_id)
            ->where('application_status', 'verified')
            ->where('status', 'active')
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return response()->json(['msg' => '', 'data' => $schools], 200);
    }

    public function getAllAssignedSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise')
            ->whereIn('id', $schoolIds)
            ->whereIn('id', function ($query) {

                $query->select('school_id')
                    ->from(with(new \Models\SchoolNodal)->getTable());

            })
            ->where('district_id', $district_id)
            ->where(function ($query) {
                $query->where('application_status', 'registered')
                    ->orWhere('application_status', 'verified');
            })
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) use ($request) {

                $item->session_year = (!empty($request->selectedCycle) || $request->selectedCycle != 'null') ? $request->selectedCycle : $this->data['latest_application_cycle']['session_year'];

                return $item;
            })
            ->preparePage($request);

        return api('', $schools);
    }

    public function getDownloadAllSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::with('locality', 'school_ranges', 'block', 'district', 'state', 'language', 'schooladmin.user', 'school_nodal.nodaladmin.user', 'total_seats_available')
            ->whereHas('school_ranges', function (Builder $query) {
                $query->where('range', '1-3')->limit(1);
            })
            ->whereIn('id', $schoolIds)
            ->where('district_id', $this->district->id)
            ->get();

        $items = $this->getDownloadCsvData($schools, $request);

        $reports = \Excel::create('all-schools-list', function ($excel) use ($items) {

            $excel->sheet('All Schools List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'all-schools-list.xlsx', 'data' => asset('temp/all-schools-list.xlsx')], 200);
    }

    public function getDownloadAllRegisteredSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::with('locality', 'school_ranges', 'block', 'district', 'schooladmin.user', 'state', 'language', 'school_nodal.nodaladmin.user', 'total_seats_available')
            ->whereHas('school_ranges', function (Builder $query) {
                $query->where('range', '1-3')->limit(1);
            })
            ->whereIn('id', $schoolIds)
            ->where('application_status', 'registered')
            ->where('status', 'active')
            ->where('district_id', $this->district->id)
            ->get();

        $items = $this->getDownloadCsvData($schools, $request);

        $reports = \Excel::create('registered-schools-list', function ($excel) use ($items) {

            $excel->sheet('Registered Schools List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'registered-schools-list.xlsx', 'data' => asset('temp/registered-schools-list.xlsx')], 200);
    }

    public function getAllSchools(Request $request, $cycle, $payment_status, $nodal_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $school_query = School::select('id', 'name', 'udise')
            ->where('district_id', $this->district->id)
            ->whereIn('id', $schoolIds)
            ->where('application_status', 'verified')
            ->with(['school_reimbursement', 'school_nodal.nodaladmin.user', 'total_tution_fees', 'registration_cycle.application_details']);

        if ($payment_status != 'null') {

            $school_query->whereHas('school_reimbursement', function ($subQuery) use ($payment_status) {
                $subQuery = $subQuery->where('payment_status', $payment_status)
                    ->from(with(new \Models\SchoolReimbursement)->getTable());
            });
        }

        if ($nodal_id != 'null') {

            $school_query->whereHas('school_nodal', function ($subQuery) use ($nodal_id) {
                $subQuery = $subQuery->where('nodal_id', $nodal_id)
                    ->from(with(new \Models\SchoolNodal)->getTable());
            });
        }

        $schools = $school_query->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $schools);
    }

    public function getSearchAllSchools(Request $request, $cycle, $payment_status, $nodal_id)
    {

        $valSearch = $request['s'];

        $schoolIds = $this->getSchoolIdsBySession($request);

        $school_query = School::select('id', 'name', 'udise')
            ->where('district_id', $this->district->id)
            ->whereIn('id', $schoolIds)
            ->where('application_status', 'verified')
            ->where(function ($query) use ($valSearch) {
                $query->where('name', 'ilike', '%' . $valSearch . '%')
                    ->orWhere('udise', 'ilike', '%' . $valSearch . '%');
            })
            ->with(['school_reimbursement', 'school_nodal.nodaladmin.user', 'total_tution_fees', 'registration_cycle.application_details']);

        if ($payment_status != 'null') {

            $school_query->whereHas('school_reimbursement', function ($subQuery) use ($payment_status) {
                $subQuery = $subQuery->where('payment_status', $payment_status)
                    ->from(with(new \Models\SchoolReimbursement)->getTable());
            });
        }

        if ($nodal_id != 'null') {

            $school_query->whereHas('school_nodal', function ($subQuery) use ($nodal_id) {
                $subQuery = $subQuery->where('nodal_id', $nodal_id)
                    ->from(with(new \Models\SchoolNodal)->getTable());
            });
        }

        $schools = $school_query->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $schools);
    }

    public function getAllStudents(Request $request, $cycle, $payment_status, $nodal_id, $school_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $school_query = \Models\ReportCard::where('school_id', $school_id)
            ->whereIn('school_id', $schoolIds)
            ->with(['student', 'student.personal_details', 'student.level', 'total_months_present', 'student.bank_details', 'school.school_nodal']);

        if ($payment_status != 'null') {

            $school_query->where('tution_fee_status', $payment_status);
        }

        if ($nodal_id != 'null') {

            $school_query->whereHas('school.school_nodal', function ($subQuery) use ($nodal_id) {
                $subQuery = $subQuery->where('nodal_id', $nodal_id)
                    ->from(with(new \Models\SchoolNodal)->getTable());
            });
        }

        $schools = $school_query->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $schools);
    }

    public function getSearchAllStudents(Request $request, $cycle, $payment_status, $nodal_id, $school_id)
    {

        $searchVal = $request['s'];

        $schoolIds = $this->getSchoolIdsBySession($request);

        $school_query = \Models\ReportCard::where('school_id', $school_id)
            ->whereIn('school_id', $schoolIds)
            ->whereHas('student', function ($subQuery) use ($searchVal) {
                $subQuery = $subQuery->where('first_name', 'ilike', '%' . $searchVal . '%')
                    ->from(with(new \Models\RegistrationBasicDetail)->getTable());
            })
            ->with(['student', 'student.personal_details', 'student.level', 'total_months_present', 'student.bank_details', 'school.school_nodal']);

        if ($payment_status != 'null') {

            $school_query->where('tution_fee_status', $payment_status);
        }

        if ($nodal_id != 'null') {

            $school_query->whereHas('school.school_nodal', function ($subQuery) use ($nodal_id) {
                $subQuery = $subQuery->where('nodal_id', $nodal_id)
                    ->from(with(new \Models\SchoolNodal)->getTable());
            });
        }

        $schools = $school_query->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $schools);

    }

    public function getApplicationCycles()
    {

        $applicationcycle = \Models\ApplicationCycle::select('session_year')
            ->distinct('session_year')
            ->orderBy('session_year', 'DESC')
            ->get();

        return api('', $applicationcycle);
    }

    public function getSchoolList()
    {

        $schools = \Models\School::select('id', 'name')
            ->where('district_id', $this->district->id)
            ->get();

        return api('', $schools);
    }

    public function getSchoolsPaymentType(Request $request, $district_id, $type)
    {

        $schools = School::select('id', 'name', 'udise')
            ->where('district_id', $district_id)
            ->with(['report_card', 'school_nodal.nodaladmin.user', 'total_tution_fees'])
            ->whereHas('report_card', function ($subQuery) use ($type) {
                $subQuery = $subQuery->where('payment_status', $type)
                    ->from(with(new \Models\ReportCard)->getTable());
            })
            ->orderBy('created_at', 'desc')
            ->where('application_status', 'verified')
            ->get()
            ->preparePage($request);

        return response()->json(['msg' => '', 'data' => $schools], 200);
    }

    public function getSearchAllSchoolsList(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise', 'application_status', 'status')
            ->where('district_id', $district_id)
            ->whereIn('id', $schoolIds)
            ->where(function ($query) use ($request) {
                $query->where('name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('udise', $request['s']);
            })
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return response()->json(['msg' => '', 'data' => $schools], 200);
    }

    public function getSearchRegisteredSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise')
            ->whereIn('id', $schoolIds)
            ->where('district_id', $district_id)
            ->where('application_status', 'registered')
            ->where('status', 'active')
            ->where(function ($query) use ($request) {
                $query->where('name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('udise', $request['s']);
            })
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return response()->json(['msg' => '', 'data' => $schools], 200);
    }

    public function getSearchAssignedSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise')
            ->whereIn('id', $schoolIds)
            ->where('district_id', $district_id)
            ->where(function ($subquery) {
                $subquery->where('application_status', 'registered')
                    ->orWhere('application_status', 'verified');
            })
            ->where(function ($query) use ($request) {
                $query->where('name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('udise', $request['s']);
            })
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) use ($request) {

                $item->session_year = (!empty($request->selectedCycle) || $request->selectedCycle != 'null') ? $request->selectedCycle : $this->data['latest_application_cycle']['session_year'];

                return $item;
            })
            ->preparePage($request);

        return response()->json(['msg' => '', 'data' => $schools], 200);
    }

    public function getAllRegisteredSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise')
            ->whereIn('id', $schoolIds)
            ->where('district_id', $district_id)
            ->where('application_status', 'registered')
            ->where('status', 'active')
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $schools);
    }

    public function getDownloadAllVerifiedSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::with('locality', 'school_ranges', 'block', 'district', 'state', 'schooladmin.user', 'language', 'school_nodal.nodaladmin.user', 'total_seats_available')
            ->whereHas('school_ranges', function (Builder $query) {
                $query->where('range', '1-3')->limit(1);
            })
            ->whereIn('id', $schoolIds)
            ->where('application_status', 'verified')
            ->where('status', 'active')
            ->where('district_id', $this->district->id)
            ->get();

        $items = $this->getDownloadCsvData($schools, $request);

        $reports = \Excel::create('verified-schools-list', function ($excel) use ($items) {

            $excel->sheet('Verified Schools List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'verified-schools-list.xlsx', 'data' => asset('temp/verified-schools-list.xlsx')], 200);
    }

    public function getSearchVerifiedSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise')
            ->whereIn('id', $schoolIds)
            ->where('district_id', $district_id)
            ->where('application_status', 'verified')
            ->where(function ($query) use ($request) {
                $query->where('name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('udise', $request['s']);
            })
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return response()->json(['msg' => '', 'data' => $schools], 200);
    }

    public function getAllRejectedSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise')
            ->whereIn('id', $schoolIds)
            ->where('district_id', $district_id)
            ->where('application_status', 'rejected')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $schools);
    }

    public function getDownloadAllRejectedSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::with('locality', 'block', 'school_ranges', 'district', 'schooladmin.user', 'state', 'language', 'school_nodal.nodaladmin.user', 'total_seats_available')
            ->whereHas('school_ranges', function (Builder $query) {
                $query->where('range', '1-3')->limit(1);
            })
            ->whereIn('id', $schoolIds)
            ->where('application_status', 'rejected')
            ->where('status', 'active')
            ->where('district_id', $this->district->id)
            ->get();

        $items = $this->getDownloadCsvData($schools, $request);

        $reports = \Excel::create('rejected-schools-list', function ($excel) use ($items) {

            $excel->sheet('Rejected Schools List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'rejected-schools-list.xlsx', 'data' => asset('temp/rejected-schools-list.xlsx')], 200);
    }

    public function getSearchRejectedSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise')
            ->whereIn('id', $schoolIds)
            ->where('district_id', $district_id)
            ->where('application_status', 'rejected')
            ->where(function ($query) use ($request) {
                $query->where('name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('udise', $request['s']);
            })
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return response()->json(['msg' => '', 'data' => $schools], 200);
    }

    public function getAllBannedSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise')
            ->whereIn('id', $schoolIds)
            ->where('district_id', $district_id)
            ->where('status', 'ban')
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return api('', $schools);
    }

    public function getDownloadAllBannedSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::with('locality', 'school_ranges', 'block', 'district', 'schooladmin.user', 'state', 'language', 'school_nodal.nodaladmin.user', 'total_seats_available')
            ->whereHas('school_ranges', function (Builder $query) {
                $query->where('range', '1-3')->limit(1);
            })
            ->whereIn('id', $schoolIds)
            ->where('status', 'ban')
            ->where('district_id', $this->district->id)
            ->get();

        $items = $this->getDownloadCsvData($schools, $request);

        $reports = \Excel::create('banned-schools-list', function ($excel) use ($items) {

            $excel->sheet('Rejected Schools List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'rejected-schools-list.xlsx', 'data' => asset('temp/rejected-schools-list.xlsx')], 200);
    }

    public function getSearchBannedSchools(Request $request, $district_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $schools = School::select('id', 'name', 'udise')
            ->whereIn('id', $schoolIds)
            ->where('district_id', $district_id)
            ->where('status', 'ban')
            ->where(function ($query) use ($request) {
                $query->where('name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('udise', $request['s']);
            })
            ->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        return response()->json(['msg' => '', 'data' => $schools], 200);
    }

    public function getSchoolNodalAdmin($school_id)
    {

        $nodal = \Models\SchoolNodal::where('school_id', $school_id)
            ->with(['nodaladmin.user'])
            ->first();

        return api('', $nodal);

    }

    public function getAllNodalAdminList(Request $request, $district_id)
    {

        $schools = School::select('id', 'name')
            ->where('district_id', $district_id)
            ->where('application_status', 'rejected')
            ->get();

        return api('', $schools);
    }

    public function postSchoolAdd(AddSchoolRequest $request)
    {

        if ($request->hasFile('image')) {
            $file_name = rand() . \Carbon::now()->timestamp . '.' . $request['image']->getClientOriginalExtension();
            \ImageHelper::ImageUploadToS3($request['image'], $file_name, 'schools/', true, 1200, 600, true);

            $request->merge(['logo' => $file_name]);
        }

        $newSchool = $this->schoolRepo->create($request);

        return response()->json(['msg' => 'New school ' . $newSchool->name . ' is added', 'data' => $newSchool->name], 200);
    }

    public function postSchoolUpdate(Request $request)
    {

        $newSchool = School::where('id', $request->id)->update(['name' => $request->name]);

        $newSchool = School::where('id', $request->id)->first();

        return response()->json(['msg' => 'School updated', 'data' => $newSchool], 200);

    }

    public function postSchoolAssign(Request $request)
    {

        $already_exist = \Models\SchoolNodal::where('school_id', $request->school_id);

        if (!empty($already_exist)) {

            $already_exist->delete();
        }

        $schoolNodal = \Models\SchoolNodal::create($request->all());

        $schoolNodal['redirect'] = '/districtadmin/schools/registered';

        return response()->json(['msg' => 'School assigned', 'data' => $schoolNodal], 200);

    }

    public function postSchoolReAssign(Request $request)
    {

        $schoolNodal = \Models\SchoolNodal::where('school_id', $request->school_id)->update(['nodal_id' => $request->nodal_id]);

        $data['reload'] = 'true';

        return api('School assigned', $data);

    }

    public function postAddSchoolAdmin(AddSchoolAdminRequest $request, UserRepo $userRepo)
    {

        $newSchoolAdmin = new SchoolAdmin();
        $newSchoolAdmin->school_id = $request->school_id;
        $request['role_type'] = 'role--school-admin';
        $request['password'] = 'think201today';

        $user = $userRepo->create($request);

        $newSchoolAdmin->user_id = $user['id'];
        $newSchoolAdmin->save();

        return response()->json(['msg' => 'Created School Admin', 'data' => $user], 200);
    }

    public function postSchoolDelete($school_id)
    {

        $school = School::where('id', $school_id)->delete();

        $showObject['redirect'] = url('districtadmin/schools/requested');

        return api('School deleted', $showObject);
    }

    public function postSchoolPayReimbursement($school_id, $amount)
    {

        $school = \Models\SchoolReimbursement::where('school_id', $school_id)
            ->update(['reimbursement_amount' => $amount, 'payment_status' => 'paid', 'payed_on' => \Carbon::now()]);

        $reloadObj['reload'] = true;

        return api('School reimbursement marked as paid successfully', $reloadObj);

    }

    public function postStudentPayReimbursement($report_id)
    {

        $student = \Models\ReportCard::where('id', $report_id)
            ->update(['tution_fee_status' => 'paid']);

        $reloadObj['reload'] = true;

        return api('Student reimbursement marked as paid successfully', $reloadObj);

    }

    public function postSchoolPayAllReimbursement(Request $request)
    {

        $pay = \Models\SchoolReimbursement::whereIn('school_id', $request)
            ->update(['payment_status' => 'paid', 'payed_on' => \Carbon::now()]);

        return api('', $pay);

    }

    public function postPaySelected(Request $request)
    {

        $schools = [];

        foreach ($request->all() as $key => $value) {

            $check = \Models\SchoolReimbursement::where('school_id', $value)->first();

            if ($check['allow_status'] == 'no') {

                throw new ValidationFailedException("Please select only the payable schools");

            } else {

                array_push($schools, $check);

            }

        }

        foreach ($schools as $key => $school) {

            $amount = \Models\ReportCard::where('school_id', $school->school_id)->sum('tution_payable');

            \Models\SchoolReimbursement::where('school_id', $school->school_id)
                ->update(['reimbursement_amount' => $amount, 'payment_status' => 'paid', 'payed_on' => \Carbon::now()]);

        }

        return api('School reimbursements marked as paid successfully');

    }

    public function postPaySelectedStudents(Request $request)
    {

        $reports = [];

        foreach ($request->all() as $key => $value) {

            $candidate = \Models\ReportCard::select('registration_id')->find($value);

            $check = \Models\RegistrationBankDetail::where('registration_id', $candidate['registration_id'])->first();

            if (count($check) < 1) {

                throw new ValidationFailedException("Please select only the payable students");

            } else {

                array_push($reports, $value);

            }

        }

        \Models\ReportCard::whereIn('id', $reports)
            ->update(['tution_fee_status' => 'paid']);

        return api('Students reimbursements marked as paid successfully');

    }

    public function postStudentReportDownload(Request $request, $cycle, $payment_status, $nodal_id, $school_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $school_query = \Models\ReportCard::where('school_id', $school_id)
            ->whereIn('school_id', $schoolIds)
            ->with(['student', 'student.personal_details', 'student.level', 'total_months_present', 'student.bank_details', 'school.school_nodal']);

        if ($payment_status != 'null') {

            $school_query->where('tution_fee_status', $payment_status);
        }

        if ($nodal_id != 'null') {

            $school_query->whereHas('school.school_nodal', function ($subQuery) use ($nodal_id) {
                $subQuery = $subQuery->where('nodal_id', $nodal_id)
                    ->from(with(new \Models\SchoolNodal)->getTable());
            });
        }

        $schools = $school_query->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);
        $items = [];

        if (count($schools) != 0) {
            foreach ($schools as $result) {
                $result = $result->toArray();
                $InnData['Student Name'] = $result['student']['first_name'];
                $InnData['Student Category'] = $result['student']['personal_details']['category'];
                $InnData['Student Admission Class'] = $result['student']['level']['level'];
                $InnData['Present Class'] = $result['student']['level']['level'];
                $InnData['Months Present'] = $result['total_months_present']['total'];
                $InnData['Per Month/Day Reimbursement/govt'] = isset($result['amount_payable']) ? $result['amount_payable'] : '-';
                $InnData['Amount to be reimbursed'] = $result['tution_payable'];
                $InnData['Student Bank Name'] = $result['student']['bank_details']['bank_name'];
                $InnData['Student Bank Account Number'] = $result['student']['bank_details']['account_number'];
                $InnData['Student IFSC Code'] = $result['student']['bank_details']['ifsc_code'];
                $InnData['Status of Payment'] = $result['tution_fee_status'];
                $items[] = $InnData;
            }
        }

        $reports = \Excel::create('reimbursement-student-report', function ($excel) use ($items) {

            $excel->sheet('Reimbursement Student Report', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'reimbursement-student-report.xlsx', 'data' => asset('temp/reimbursement-student-report.xlsx')], 200);

    }

    public function postSchoolReportDownload(Request $request, $cycle, $payment_status, $nodal_id)
    {

        $schoolIds = $this->getSchoolIdsBySession($request);

        $school_query = School::select('id', 'name', 'udise')
            ->where('district_id', $this->district->id)
            ->whereIn('id', $schoolIds)
            ->where('application_status', 'verified')
            ->with(['school_reimbursement', 'school_nodal.nodaladmin.user', 'total_tution_fees', 'registration_cycle.application_details']);

        if ($payment_status != 'null') {

            $school_query->whereHas('school_reimbursement', function ($subQuery) use ($payment_status) {
                $subQuery = $subQuery->where('payment_status', $payment_status)
                    ->from(with(new \Models\SchoolReimbursement)->getTable());
            });
        }

        if ($nodal_id != 'null') {

            $school_query->whereHas('school_nodal', function ($subQuery) use ($nodal_id) {
                $subQuery = $subQuery->where('nodal_id', $nodal_id)
                    ->from(with(new \Models\SchoolNodal)->getTable());
            });
        }

        $schools = $school_query->page($request)
            ->orderBy('created_at', 'desc')
            ->get()
            ->preparePage($request);

        $items = [];

        if (count($schools) != 0) {
            foreach ($schools as $result) {
                $result = $result->toArray();
                $InnData['School Name'] = $result['name'];
                $InnData['UDISE'] = $result['udise'];
                $InnData['School Nodal'] = $result['school_nodal']['nodaladmin']['user']['display_name'];
                $InnData['Reimbursement Amount(INR)'] = isset($result['total_tution_fees']['total']) ? $result['total_tution_fees']['total'] : '-';
                $InnData['Status'] = $result['school_reimbursement']['payment_status'];
                $InnData['Date of payment'] = isset($result['school_reimbursement']['fmt_dop']) ? $result['school_reimbursement']['fmt_dop'] : '-';
                $InnData['Reimbursement Amount Due(INR)'] = (string) (isset($result['total_tution_fees']['total']) ? $result['total_tution_fees']['total'] - $result['school_reimbursement']['reimbursement_amount'] : '-');
                $items[] = $InnData;
            }
        }

        $reports = \Excel::create('reimbursement-school-report', function ($excel) use ($items) {

            $excel->sheet('Reimbursement School Report', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => 'reimbursement-school-report.xlsx', 'data' => asset('temp/reimbursement-school-report.xlsx')], 200);
    }

    private function getDownloadCsvData($schools, $request)
    {

        $current_year = $this->data['latest_application_cycle']['session_year'];

        if (!empty($request->selectedCycle) && $request->selectedCycle != 'null') {

            $current_year = $request->selectedCycle;
        }

        $items = [];

        if (count($schools) != 0) {

            foreach ($schools as $result) {

                $result = $result->toArray();

                $InnData['Registered School Name'] = $result['name'];

                $InnData['School Contact'] = $result['phone'];

                $InnData['School Admin Number'] = $result['schooladmin']['user']['phone'];

                $InnData['UDISE Code'] = $result['udise'];

                $InnData['Entry Class'] = '';

                $entry_class = \Models\Level::where('id', $result['levels'][0])
                    ->first();

                if ($entry_class) {

                    $InnData['Entry Class'] = $entry_class->level;

                }

                $InnData['Total seats in the entry level class'] = 0;
                $InnData['Total seats under the 25% quota'] = 0;

                $total_seats = \Models\SchoolLevelInfo::where('session_year', $current_year)
                    ->where('school_id', $result['id'])
                    ->where('level_id', $result['levels'][0])
                    ->first();

                if ($total_seats) {

                    $InnData['Total seats in the entry level class'] = $total_seats->total_seats;
                    $InnData['Total seats under the 25% quota'] = $total_seats->available_seats;

                }

                $InnData['Total Admissions'] = 0;

                $InnData['School address'] = $result['address'];

                $InnData['Block'] = $result['block']['name'];

                $InnData['Nodal Email ID'] = 'Not Assigned';

                if (!empty($result['school_nodal'])) {

                    if (!empty($result['school_nodal']['nodaladmin'])) {

                        if (!empty($result['school_nodal']['nodaladmin']['user'])) {

                            $InnData['Nodal Email ID'] = $result['school_nodal']['nodaladmin']['user']['email'];

                        }
                    }

                }

                $InnData['Ward/ Gram panchayat'] = $result['locality']['name'];

                $InnData['Status'] = ucfirst($result['application_status']);

                $regions = \Models\SchoolRange::where('school_id', $result['id'])
                    ->where('range', '1-3')
                    ->select('id', 'regions')
                    ->first();

                $selected_region = [];

                if (count($regions) > 0) {
                    $selected_region = $regions['regions'];
                }

                $regions = \Models\Locality::select('name')
                    ->where('block_id', $result['sub_block_id'])
                    ->whereNotIn('id', [$result['locality_id']])
                    ->whereIn('id', $selected_region)
                    ->get();

                $sub_regions = \Models\Locality::select('name')
                    ->whereHas('block.district', function ($subQuery) use ($result) {
                        $subQuery = $subQuery->where('id', $result['district_id']);
                    })
                    ->where('block_id', '!=', $result['sub_block_id'])
                    ->whereNotIn('id', [$result['locality_id']])
                    ->whereIn('id', $selected_region)
                    ->get();

                $neighbours = [];

                foreach ($regions as $key => $locality) {

                    if (!empty($locality)) {

                        array_push($neighbours, $locality->name);
                    }
                }

                $sub_neighbours = [];

                foreach ($sub_regions as $key => $locality) {

                    if (!empty($locality)) {

                        array_push($sub_neighbours, $locality->name);
                    }
                }

                $InnData['Neighbouring wards(In Block)'] = implode(",  ", $neighbours);
                $InnData['Neighbouring wards(In District)'] = implode(",  ", $sub_neighbours);

                $items[] = $InnData;
            }
        }

        return $items;
    }

    private function getSchoolIdsBySession($request)
    {
        $schoolIds = [];

        $current_year = $this->data['latest_application_cycle']['session_year'];

        if (!empty($request->selectedCycle) && $request->selectedCycle != 'null') {

            $current_year = $request->selectedCycle;
        }

        $schoolIds = \Models\SchoolCycle::whereHas('application_cycle', function ($query) use ($current_year) {

            $query->where('session_year', $current_year);
        })
            ->pluck('school_id');

        return $schoolIds;
    }

    public function getSchoolAllottmentDetails($schoolId)
    {

        $school = \Models\School::where('id', $schoolId)->first();

        if (empty($school)) {
            throw new EntityNotFoundException('School with this UDISE Not found');
        }

        $allotmentData = \Helpers\SchoolHelper::getSchoolAllotment($school);

        return api('', $allotmentData);
    }
}
