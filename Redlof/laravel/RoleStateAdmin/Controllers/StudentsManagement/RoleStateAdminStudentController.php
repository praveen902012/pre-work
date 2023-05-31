<?php
namespace Redlof\RoleStateAdmin\Controllers\StudentsManagement;

use Exceptions\EntityNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class RoleStateAdminStudentController extends RoleStateAdminBaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getRegisteredStudents(Request $request)
    {
        $studentIDs = $this->getStudentIdsBySession($request);

        $students = \Models\RegistrationBasicDetail::where('state_id', $this->data['state_id'])
            ->whereIn('id', $studentIDs['registration_id'])
            ->where('status', 'completed')
            ->with('registration_cycle')
            ->page($request)
            ->get()
            ->trimTimeStamps()
            ->preparePage($request);

        return api('', $students);
    }

    public function searchRegisteredStudents(Request $request)
    {

        $studentIDs = $this->getStudentIdsBySession($request);

        $students = \Models\RegistrationBasicDetail::where('state_id', $this->data['state_id'])
            ->whereIn('id', $studentIDs['registration_id'])
            ->where('status', 'completed')
            ->search($request, ['first_name', 'registration_no', 'last_name'])
            ->with('registration_cycle')
            ->page($request)
            ->get()
            ->trimTimeStamps()
            ->preparePage($request);

        return api('', $students);
    }

    public function getAllottedStudents(Request $request)
    {

        $studentIDs = $this->getStudentIdsBySession($request);

        $students = \Models\RegistrationCycle::whereIn('status', ['allotted', 'enrolled', 'dismissed'])
            ->whereIn('registration_id', $studentIDs['registration_id'])
            ->whereHas('basic_details', function ($sub_query) {

                $sub_query->where('state_id', $this->data['state_id'])
                    ->where('status', 'completed');
            })
            ->with(['basic_details', 'school', 'basic_details.level'])
            ->page($request)
            ->get()
            ->trimTimeStamps()
            ->preparePage($request);

        return api('', $students);
    }

    public function getEnrolledStudents(Request $request)
    {
        $studentIDs = $this->getStudentIdsBySession($request);

        $students = \Models\RegistrationCycle::where('status', 'enrolled')
            ->whereIn('registration_id', $studentIDs['registration_id'])
            ->whereHas('basic_details', function ($sub_query) {

                $sub_query->where('state_id', $this->data['state_id'])
                    ->where('status', 'completed');
            })
            ->with(['basic_details', 'school', 'basic_details.level'])
            ->page($request)
            ->get()
            ->trimTimeStamps()
            ->preparePage($request);

        return api('', $students);
    }

    public function getDissmissedStudents(Request $request)
    {

        $studentIDs = $this->getStudentIdsBySession($request);

        $students = \Models\RegistrationCycle::where('status', 'dismissed')
            ->whereIn('registration_id', $studentIDs['registration_id'])
            ->whereHas('basic_details', function ($sub_query) {

                $sub_query->where('state_id', $this->data['state_id'])
                    ->where('status', 'completed');
            })
            ->with(['basic_details', 'school', 'basic_details.level'])
            ->page($request)
            ->get()
            ->trimTimeStamps()
            ->preparePage($request);

        return api('', $students);
    }

    public function searchDismissedStudents(Request $request)
    {

        $studentIDs = $this->getStudentIdsBySession($request);

        $students = \Models\RegistrationCycle::whereIn('status', ['dismissed'])
            ->whereIn('registration_id', $studentIDs['registration_id'])
            ->whereHas('basic_details', function ($sub_query) use ($request) {

                $sub_query->search($request, ['first_name', 'registration_no', 'last_name'])
                    ->where('state_id', $this->data['state_id'])
                    ->where('status', 'completed');
            })
            ->with(['basic_details', 'school', 'basic_details.level'])
            ->page($request)
            ->get()
            ->trimTimeStamps()
            ->preparePage($request);

        return api('', $students);
    }

    public function getDownoadRegisteredStudents(Request $request)
    {
        ini_set('memory_limit', '-1');

        $studentIDs = $this->getStudentIdsBySession($request);

        $registered_students = \Models\RegistrationCycle::whereIn('registration_id', $studentIDs['registration_id'])
            ->whereHas('basic_details', function ($query) {

                $query->where('status', 'completed');
            })->get();

        $items = $this->getStudentData($registered_students);

        $reports = \Excel::create('all-registered-students-list', function ($excel) use ($items) {

            $excel->sheet('All Students List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
                $sheet->setAutoSize(false);

            });

        })->store('csv', public_path('temp'));

        return response()->json(['filename' => 'all-registered-students-list.csv', 'data' => asset('temp/all-registered-students-list.csv')], 200);
    }

    public function getDownoadAllottedStudents(Request $request)
    {
        ini_set('memory_limit', '-1');

        $studentIDs = $this->getStudentIdsBySession($request);

        $allottedStudentCycles = \Models\RegistrationCycle::whereIn('registration_id', $studentIDs['registration_id'])
            ->whereIn('status', ['allotted', 'enrolled', 'dismissed'])
            ->whereIn('document_verification_status', ['verified'])
            ->whereHas('basic_details', function ($sub_query) {

                $sub_query->where('state_id', $this->data['state_id'])
                    ->where('status', 'completed');
            })
            ->get();

        $items = $this->getStudentData($allottedStudentCycles);

        $reports = \Excel::create('all-allotted-students-list', function ($excel) use ($items) {

            $excel->sheet('All Alloted Students List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
            });

        })->store('csv', public_path('temp'));

        return response()->json(['filename' => 'all-allotted-students-list.csv', 'data' => asset('temp/all-allotted-students-list.csv')], 200);
    }

    public function getDownoadEnrolledStudents(Request $request)
    {
        ini_set('memory_limit', '-1');

        $studentIDs = $this->getStudentIdsBySession($request);

        $enrolled_students = \Models\RegistrationCycle::whereIn('registration_id', $studentIDs['registration_id'])
            ->where('status', 'enrolled')
            ->whereIn('document_verification_status', ['verified'])
            ->get();

        $items = $this->getStudentData($enrolled_students);

        $reports = \Excel::create('all-enrolled-students-list', function ($excel) use ($items) {

            $excel->sheet('All Enrolled Students List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
                $sheet->setAutoSize(false);
            });

        })->store('csv', public_path('temp'));

        return response()->json(['filename' => 'all-enrolled-students-list.csv', 'data' => asset('temp/all-enrolled-students-list.csv')], 200);

    }

    public function getDownoadDismissedStudents(Request $request)
    {
        ini_set('memory_limit', '-1');

        $studentIDs = $this->getStudentIdsBySession($request);

        $enrolled_students = \Models\RegistrationCycle::whereIn('registration_id', $studentIDs['registration_id'])
            ->where('status', 'dismissed')
            ->whereIn('document_verification_status', ['verified'])
            ->whereHas('basic_details', function ($sub_query) {

                $sub_query->where('state_id', $this->data['state_id'])
                    ->where('status', 'completed');
            })
            ->get();

        $items = $this->getStudentData($enrolled_students);

        $reports = \Excel::create('all-dismissed-students-list', function ($excel) use ($items) {

            $excel->sheet('All Dismissed Students List', function ($sheet) use ($items) {
                $sheet->fromArray($items);
                $sheet->setAutoSize(false);
            });

        })->store('csv', public_path('temp'));

        return response()->json(['filename' => 'all-dismissed-students-list.csv', 'data' => asset('temp/all-dismissed-students-list.csv')], 200);

    }

    public function searchRegisterationCompletedStudents(Request $request)
    {
        $students = \Models\RegistrationBasicDetail::search($request, ['registration_no'])
            ->where('state_id', $this->data['state_id'])
            ->where('status', 'completed')
            ->page($request)
            ->get()
            ->trimTimeStamps()
            ->preparePage($request);

        return api('', $students);
    }

    public function registerationCompletedStudentsActivate($reg_no)
    {
        $student = \Models\RegistrationBasicDetail::where('registration_no', $reg_no)
            ->where('state_id', $this->data['state_id'])
            ->where('status', 'completed')
            ->first();

        if (!empty($student)) {

            $student->update([
                'status' => 'active',
            ]);
        }

        $apiData['reload'] = true;

        return api('', $apiData);
    }

    public function searchAllottedStudents(Request $request)
    {
        $studentIDs = $this->getStudentIdsBySession($request);

        $students = \Models\RegistrationCycle::whereIn('status', ['allotted', 'enrolled', 'dismissed'])
            ->whereIn('registration_id', $studentIDs['registration_id'])
            ->whereHas('basic_details', function ($sub_query) use ($request) {

                $sub_query->search($request, ['first_name', 'registration_no', 'last_name'])
                    ->where('state_id', $this->data['state_id'])
                    ->where('status', 'completed');
            })
            ->with(['basic_details', 'school', 'basic_details.level'])
            ->page($request)
            ->get()
            ->trimTimeStamps()
            ->preparePage($request);

        return api('', $students);
    }

    public function searchEnrolledStudents(Request $request)
    {
        $studentIDs = $this->getStudentIdsBySession($request);

        $students = \Models\RegistrationCycle::where('status', 'enrolled')
            ->whereIn('registration_id', $studentIDs['registration_id'])
            ->whereHas('basic_details', function ($sub_query) use ($request) {

                $sub_query->search($request, ['first_name', 'registration_no', 'last_name'])
                    ->where('state_id', $this->data['state_id'])
                    ->where('status', 'completed');
            })
            ->with(['basic_details', 'school', 'basic_details.level'])
            ->page($request)
            ->get()
            ->trimTimeStamps()
            ->preparePage($request);

        return api('', $students);
    }

    public function getDownloadStudentWithoutSchool(Request $request)
    {
        $studentIDs = $this->getStudentIdsBySession($request);

        $students = \Models\RegistrationCycle::whereIn('id', $studentIDs['registration_cycle_id'])
            ->whereHas('basic_details', function (Builder $query) {
                $query->where('status', 'completed');
            })
            ->get();

        $reg_cycle_ids = [];

        foreach ($students as $student) {

            if (is_null($student->preferences) && is_null($student->nearby_preferences)) {

                array_push($reg_cycle_ids, $student->id);
            }
        }

        $applied_student = \Models\RegistrationCycle::whereIn('id', $reg_cycle_ids)
            ->with('basic_details')
            ->get();

        $items = [];

        if (count($applied_student) != 0) {

            foreach ($applied_student as $result) {

                $result = $result->toArray();

                $InnData['Student Name'] = $result['basic_details']['first_name'] . ' ' . $result['basic_details']['last_name'];
                $InnData['Registration No.'] = $result['basic_details']['registration_no'];
                $InnData['Phone No'] = $result['basic_details']['mobile'];

                $items[] = $InnData;
            }
        }

        $reports = \Excel::create('registered-student-without-school', function ($excel) use ($items) {

            $excel->sheet('Student without School', function ($sheet) use ($items) {
                $sheet->fromArray($items);
                $sheet->setAutoSize(false);
            });

        })->store('csv', public_path('temp'));

        return response()->json(['filename' => 'registered-student-without-school.csv', 'data' => asset('temp/registered-student-without-school.csv')], 200);

    }

    public function postDismissedStudentsMarkAsAllotted($registration_cycle_id)
    {

        $registration_cycle = \Models\RegistrationCycle::where('id', $registration_cycle_id)->first();

        if (empty($registration_cycle)) {
            throw new EntityNotFoundException("Registration not found.");
        }

        if ($registration_cycle->status != 'dismissed') {
            throw new EntityNotFoundException("Registration is not in dismissed state.");
        }

        $registration_cycle->status = 'allotted';

        $registration_cycle->save();

        $data['reload'] = true;

        return api('Registration re-allotted successfully', $data);
    }

    private function getStudentData($students)
    {

        $items = [];

        if (count($students) <= 0) {
            return $items;
        }

        $schools = \Models\School::select('id', 'udise', 'name', 'district_id', 'block_id', 'locality_id', 'sub_block_id')
            ->whereIn('id', array_unique($students->pluck('allotted_school_id')->toArray()))
            ->with(['district', 'block', 'subblock', 'locality'])
            ->get()
            ->groupBy('id')->toArray();

        $studentsBasicDetails = \Models\RegistrationBasicDetail::select('id', 'state_id', 'first_name', 'last_name', 'registration_no', 'gender', 'dob', 'email', 'level_id', 'aadhar_enrollment_no', 'aadhar_no', 'mobile')
            ->whereIn('id', array_unique($students->pluck('registration_id')->toArray()))
            ->with(['country_state', 'level'])
            ->get()
            ->groupBy('id')->toArray();

        $studentsParentDetails = \Models\RegistrationParentDetail::select(['registration_id', 'parent_type', 'parent_name', 'parent_mobile_no', 'parent_profession'])
            ->whereIn('registration_id', array_unique($students->pluck('registration_id')->toArray()))
            ->get()
            ->groupBy('registration_id')
            ->toArray();

        $studentsPersonalDetails = \Models\RegistrationPersonalDetail::select(['registration_id', 'category', 'certificate_details', 'residential_address', 'district_id', 'locality_id', 'block_id', 'pincode', 'state_type', 'sub_block_id', 'files', 'sub_locality_id', 'sub_sub_locality_id'])
            ->whereIn('registration_id', array_unique($students->pluck('registration_id')->toArray()))
            ->with(['district', 'block', 'locality'])
            ->get()
            ->groupBy('registration_id')->toArray();

        foreach ($students as $result) {

            $result = $result->toArray();

            $school = isset($schools[$result['allotted_school_id']]) && count($schools[$result['allotted_school_id']]) > 0 ? $schools[$result['allotted_school_id']][0] : null;

            $basicDetails = isset($studentsBasicDetails[$result['registration_id']]) && count($studentsBasicDetails[$result['registration_id']]) > 0 ? $studentsBasicDetails[$result['registration_id']][0] : null;
            $personalDetails = isset($studentsPersonalDetails[$result['registration_id']]) && count($studentsPersonalDetails[$result['registration_id']]) > 0 ? $studentsPersonalDetails[$result['registration_id']][0] : null;
            $parentDetails = isset($studentsParentDetails[$result['registration_id']]) && count($studentsParentDetails[$result['registration_id']]) > 0 ? $studentsParentDetails[$result['registration_id']] : null;

            $InnData['Registration No.'] = $basicDetails ? $basicDetails['registration_no'] : '';
            $InnData['Student Name'] = $basicDetails ? $basicDetails['first_name'] . ' ' . $basicDetails['last_name'] : "";
            $InnData['Gender'] = $basicDetails ? $basicDetails['gender'] : "";
            $InnData['Date of Birth'] = $basicDetails ? $basicDetails['fmt_dob'] : "";
            $InnData['Phone'] = $basicDetails ? $basicDetails['mobile'] : "";
            $InnData['Email'] = str_replace('=', '', $basicDetails['email']);
            $InnData['Class/Grade'] = $basicDetails['level']['level'];
            $InnData['Aadhar No'] = $basicDetails['aadhar_no'];
            $InnData['Aadhar Enrollment No'] = $basicDetails['aadhar_enrollment_no'];

            $InnData['Block/Nagar/Panchayat'] = $personalDetails ? $personalDetails['block']['name'] : "";
            $InnData['Ward Name/Ward Number'] = $personalDetails ? $personalDetails['locality']['name'] : "";
            $InnData['Pincode'] = $personalDetails ? $personalDetails['pincode'] : "";
            $InnData['Residential address'] = $personalDetails ? $personalDetails['residential_address'] : "";
            $InnData['District'] = $personalDetails ? $personalDetails['district']['name'] : "";
            $InnData['State'] = $basicDetails ? $basicDetails['country_state']['name'] : '';

            $InnData['Father Name'] = 'NA';
            $InnData['Father Mobile No.'] = 'NA';
            $InnData['Father Profession'] = 'NA';
            $InnData['Mother Name'] = 'NA';
            $InnData['Mother Mobile No.'] = 'NA';
            $InnData['Mother Profession'] = 'NA';
            $InnData['Guardian Name'] = 'NA';
            $InnData['Guardian Mobile No.'] = 'NA';
            $InnData['Guardian Profession'] = 'NA';

            $InnData['Applied Category'] = 'NA';
            $InnData['Type of DG'] = 'NA';
            $InnData['Type of EWS'] = 'NA';
            $InnData['Total Annual Income of both the Parents from all sources'] = 'NA';

            if ($parentDetails) {

                foreach ($parentDetails as $key => $parent_details) {

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

            }

            if ($personalDetails['category'] == 'dg') {

                $InnData['Applied Category'] = 'DG (Disadvantaged Group)';

                if ($personalDetails['certificate_details']['dg_type'] == 'sc') {

                    $InnData['Type of DG'] = 'SC';

                } elseif ($personalDetails['certificate_details']['dg_type'] == 'st') {

                    $InnData['Type of DG'] = 'ST';

                } elseif ($personalDetails['certificate_details']['dg_type'] == 'obc') {

                    $InnData['Type of DG'] = 'OBC NCL (Income less than 4.5L)';

                } elseif ($personalDetails['certificate_details']['dg_type'] == 'orphan') {

                    $InnData['Type of DG'] = 'Orphan';

                } elseif ($personalDetails['certificate_details']['dg_type'] == 'with_hiv') {

                    $InnData['Type of DG'] = 'Child or Parent is HIV +ve';

                } elseif ($personalDetails['certificate_details']['dg_type'] == 'single_women') {

                    $InnData['Type of DG'] = 'Widow or Divorced women with income less than INR 80,000';

                } elseif ($personalDetails['certificate_details']['dg_type'] == 'kodh') {

                    $InnData['Type of DG'] = 'Kodh with income less than 4.5L';

                } elseif ($personalDetails['certificate_details']['dg_type'] == 'disable') {

                    $InnData['Type of DG'] = 'Child or Parent is Differently Abled';
                }

            } elseif ($personalDetails['category'] == 'bpl') {

                $InnData['Applied Category'] = 'BPL(EWS)';

                $InnData['Total Annual Income of both the Parents from all sources'] = $personalDetails['certificate_details']['bpl_income'];

            } elseif ($personalDetails['category'] == 'ews') {

                $InnData['Applied Category'] = 'EWS';

                if ($personalDetails['certificate_details']['ews_type'] == 'bpl_card') {

                    $InnData['Type of EWS'] = 'BPL card';

                } elseif ($personalDetails['certificate_details']['ews_type'] == 'income_certificate') {

                    $InnData['Type of EWS'] = 'Income certificate';
                }
            }

            $InnData['School'] = $school['name'];
            $InnData['School UDISE'] = $school['udise'];
            $InnData['School District'] = $school['district']['name'];
            $InnData['School Block'] = $school['block']['name'];
            $InnData['School Subblock'] = $school['subblock']['name'];
            $InnData['School ward'] = $school['locality']['name'];

            $InnData['Cycle'] = $result['cycle'];
            $InnData['App Cycle Id'] = $result['application_cycle_id'];
            $InnData['Enrollment status'] = ucfirst($result['status']);
            $InnData['Verification status'] = 'pending';

            if ($result['document_verification_status']) {
                $InnData['Verification status'] = $result['document_verification_status'];
            }

            $items[] = $InnData;

        }

        return $items;
    }

    private function getStudentIdsBySession($request)
    {
        $current_year = $this->data['latest_application_cycle']['session_year'];

        if (!empty($request->selectedCycle) && $request->selectedCycle != 'null') {

            $current_year = $request->selectedCycle;
        }

        $students = \Models\RegistrationCycle::whereHas('application_details', function ($query) use ($current_year) {

            $query->where('session_year', $current_year);
        })->get();

        $studentIDs = [
            'registration_id' => $students->pluck('registration_id')->toArray(),
            'registration_cycle_id' => $students->pluck('id')->toArray(),
        ];

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

            $studentIDs = [
                'registration_id' => $students->pluck('registration_id')->toArray(),
                'registration_cycle_id' => $students->pluck('id')->toArray(),
            ];
        }

        return $studentIDs;
    }

}
