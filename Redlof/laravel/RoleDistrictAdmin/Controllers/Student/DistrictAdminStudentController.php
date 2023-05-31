<?php
namespace Redlof\RoleDistrictAdmin\Controllers\Student;

use Illuminate\Http\Request;
use Redlof\RoleDistrictAdmin\Controllers\Role\RoleDistrictAdminBaseController;

class DistrictAdminStudentController extends RoleDistrictAdminBaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllStudents(Request $request)
    {

        $studentIDs = $this->getDistrictStudentIdsBySession($request);

        $students = \Models\RegistrationBasicDetail::with(['registration_cycle'])
            ->whereHas('registration_cycle', function ($query) use ($studentIDs) {

                $query->whereIn('registration_id', $studentIDs);
            })
            ->where('status', 'completed')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getSearchAllStudents(Request $request)
    {

        $studentIDs = $this->getDistrictStudentIdsBySession($request);

        $students = \Models\RegistrationBasicDetail::with(['registration_cycle'])
            ->where(function ($query) use ($request) {
                $query->where('first_name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('registration_no', $request['s']);
            })
            ->whereHas('registration_cycle', function ($query) use ($studentIDs) {

                $query->whereIn('registration_id', $studentIDs);
            })
            ->where('status', 'completed')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function postDownloadAllStudents(Request $request)
    {

        $studentIDs = $this->getDistrictStudentIdsBySession($request);

        $students = \Models\RegistrationCycle::with(['application_details', 'basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
            ->whereHas('basic_details', function ($query) {

                $query->where('status', 'completed');
            })
            ->whereIn('registration_id', $studentIDs)
            ->get();

        $type = 'all-students-list';

        return $this->downloadStudents($students, $type);
    }

    public function getRegisteredStudents(Request $request)
    {

        $studentIDs = $this->getDistrictStudentIdsBySession($request);

        $students = \Models\RegistrationBasicDetail::with(['registration_cycle'])
            ->whereHas('registration_cycle', function ($query) use ($studentIDs) {

                $query->whereIn('registration_id', $studentIDs)
                    ->where('status', 'applied');
                // ->where('document_verification_status', 'verified');
            })
            ->where('status', 'completed')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getSearchRegisteredStudents(Request $request)
    {

        $studentIDs = $this->getDistrictStudentIdsBySession($request);

        $students = \Models\RegistrationBasicDetail::with(['registration_cycle'])
            ->where(function ($query) use ($request) {
                $query->where('first_name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('registration_no', $request['s']);
            })
            ->whereHas('registration_cycle', function ($query) use ($studentIDs) {

                $query->whereIn('registration_id', $studentIDs)
                    ->where('status', 'applied');
                // ->where('document_verification_status', 'verified');
            })
            ->where('status', 'completed')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function postDownloadRegisteredStudents(Request $request)
    {

        $studentIDs = $this->getDistrictStudentIdsBySession($request);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
            ->whereIn('registration_id', $studentIDs)
            ->where('status', 'applied')
        // ->where('document_verification_status', 'verified')
            ->get();

        $type = 'all-registered-list';

        return $this->downloadStudents($students, $type);
    }

    public function getAllottedStudents(Request $request)
    {

        $studentIDs = $this->getDistrictStudentIdsBySession($request);

        $students = \Models\RegistrationBasicDetail::with(['registration_cycle', 'registration_cycle.school', 'level'])
            ->whereHas('registration_cycle', function ($query) use ($studentIDs) {

                $query->whereIn('registration_id', $studentIDs)
                    ->whereIn('status', ['allotted', 'enrolled', 'dismissed']);
            })
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getSearchAllottedStudents(Request $request)
    {

        $studentIDs = $this->getDistrictStudentIdsBySession($request);

        $students = \Models\RegistrationBasicDetail::with(['registration_cycle', 'registration_cycle.school', 'level'])
            ->where(function ($query) use ($request) {
                $query->where('first_name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('registration_no', $request['s']);
            })
            ->whereHas('registration_cycle', function ($query) use ($studentIDs) {

                $query->whereIn('registration_id', $studentIDs)
                    ->whereIn('status', ['allotted', 'enrolled', 'dismissed']);
            })
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function postDownloadAllottedStudents(Request $request)
    {

        $studentIDs = $this->getDistrictStudentIdsBySession($request);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
            ->whereIn('registration_id', $studentIDs)
            ->whereIn('status', ['allotted', 'enrolled', 'dismissed'])
            ->get();

        $type = 'all-alloted-list';

        return $this->downloadStudents($students, $type);
    }

    public function getEnrolledStudents(Request $request)
    {

        $studentIDs = $this->getDistrictStudentIdsBySession($request);

        $students = \Models\RegistrationBasicDetail::with(['registration_cycle', 'registration_cycle.school', 'level'])
            ->whereHas('registration_cycle', function ($query) use ($studentIDs) {

                $query->whereIn('registration_id', $studentIDs)
                    ->where('status', 'enrolled');
            })
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getSearchEnrolledStudents(Request $request)
    {

        $studentIDs = $this->getDistrictStudentIdsBySession($request);

        $students = \Models\RegistrationBasicDetail::with(['registration_cycle', 'registration_cycle.school', 'level'])
            ->where(function ($query) use ($request) {
                $query->where('first_name', 'ilike', '%' . $request['s'] . '%')
                    ->orWhere('registration_no', $request['s']);
            })
            ->whereHas('registration_cycle', function ($query) use ($studentIDs) {

                $query->whereIn('registration_id', $studentIDs)
                    ->where('status', 'enrolled');
            })
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function postDownloadEnrolledStudents(Request $request)
    {

        $studentIDs = $this->getDistrictStudentIdsBySession($request);

        $students = \Models\RegistrationCycle::with(['basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
            ->where('status', 'enrolled')
            ->whereIn('registration_id', $studentIDs)
            ->get();

        $type = 'all-enrolled-list';

        return $this->downloadStudents($students, $type);
    }

    public function getSchoolReports(Request $request)
    {

        $schools = \Models\SchoolGrievance::with('basic_details', 'basic_details.personal_details.block', 'basic_details.personal_details.locality')
            ->where('district_id', $this->district->id)
            ->orderBy('created_at', 'desc')
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $schools);

    }

    public function getDenialReports(Request $request)
    {

        $schools = \Models\DenyAdmission::with('basic_details', 'basic_details.personal_details', 'basic_details.registration_cycle', 'basic_details.registration_cycle.school')
            ->wherehas('basic_details.personal_details', function ($query) {

                $query->where('district_id', $this->district->id);

            })
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $schools);

    }

    public function getSuspiciousStudents(Request $request)
    {

        $schools = \Models\SuspiciousStudent::with(['basic_details', 'schooladmin.school'])
            ->where('district_id', $this->district->id)
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $schools);

    }

    private function downloadStudents($students, $type)
    {

        $items = [];

        if (count($students) != 0) {

            foreach ($students as $key => $result) {

                $result = $result->toArray();

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

        \Excel::create($type, function ($excel) use ($items, $type) {

            $excel->sheet($type, function ($sheet) use ($items) {

                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => $type . '.xlsx', 'data' => asset('temp/' . $type . '.xlsx')], 200);

    }

    private function getDistrictStudentIdsBySession($request)
    {

        $current_year = $this->data['latest_application_cycle']['session_year'];

        if (!empty($request->selectedCycle) && $request->selectedCycle != 'null') {

            $current_year = $request->selectedCycle;
        }

        $registration_ids = \Models\RegistrationPersonalDetail::where('district_id', $this->district->id)
            ->pluck('registration_id');

        $students = \Models\RegistrationCycle::whereHas('application_details', function ($query) use ($current_year) {

            $query->where('session_year', $current_year);
        })
            ->whereIn('registration_id', $registration_ids) // for this district
            ->get();

        $studentRegistrationIDs = $students->pluck('registration_id')->toArray();

        if ($this->data['latest_application_cycle']['cycle'] > 1) {

            // get users which registered for second cycle
            // remove there first cycle entry

            $usersUnique = $students->unique('registration_id');

            $usersDupesRegistrationId = $students->diff($usersUnique)->pluck('id')->toArray();

            $delStudentIds = $students->whereIn('id', $usersDupesRegistrationId)
                ->where('cycle', '<', $this->data['latest_application_cycle']['cycle'])
                ->pluck('id')
                ->toArray();

            $studentRegistrationIDs = $students->whereNotIn('id', $delStudentIds)
                ->pluck('registration_id')
                ->toArray();

        }

        return $studentRegistrationIDs;
    }

}
