<?php
namespace Redlof\RoleStateAdmin\Controllers\StudentsManagement;

use Illuminate\Database\Eloquent\Builder;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class RoleStateAdminStudentViewController extends RoleStateAdminBaseController
{

    public function getRegisteredStudentsView()
    {

        $this->data['title'] = 'Registered student';

        return view('stateadmin::student.registered-students', $this->data);
    }

    public function getSingleStudentsView($registration_id)
    {

        $this->data['title'] = 'Student Details';

        $student = \Models\RegistrationBasicDetail::select('id', 'registration_no', 'first_name', 'middle_name', 'last_name', 'mobile', 'email', 'gender', 'dob', 'level_id', 'state_id', 'rejected_document', 'rejected_reason')
            ->where('registration_no', $registration_id)
            ->with(['statename', 'level', 'personal_details', 'personal_details.subsublocality', 'personal_details.sublocality', 'personal_details.locality', 'personal_details.district', 'personal_details.block', 'parent_details', 'dropout_reason', 'registration_cycle', 'registration_cycle.school'])
            ->first();

        $schoolData = [];
        $schoolNearbyData = [];

        if (isset($student->registration_cycle)) {

            if ($student->registration_cycle->preferences) {

                foreach ($student->registration_cycle->preferences as $key => $value) {

                    $school = \Models\School::select('id', 'name', 'udise', 'address', 'phone')
                        ->where('id', $value)
                        ->first();

                    if (!empty($school)) {

                        $schoolEntry = [];
                        $schoolEntry['id'] = $value;
                        $schoolEntry['name'] = $school->name;
                        $schoolEntry['udise'] = $school->udise;
                        $schoolEntry['address'] = $school->address;
                        $schoolEntry['phone'] = $school->phone;

                        $schoolEntry['nodal'] = \Models\SchoolNodal::where('school_id', $school->id)
                            ->with('nodaladmin.user')
                            ->has('nodaladmin.user')
                            ->first();

                        array_push($schoolData, $schoolEntry);
                    }
                }
            }

            if ($student->registration_cycle->nearby_preferences) {

                foreach ($student->registration_cycle->nearby_preferences as $key => $value) {

                    $school = \Models\School::select('id', 'name', 'udise', 'address', 'phone')
                        ->where('id', $value)
                        ->first();

                    if (!empty($school)) {

                        $schoolEntry = [];
                        $schoolEntry['id'] = $value;
                        $schoolEntry['name'] = $school->name;
                        $schoolEntry['udise'] = $school->udise;
                        $schoolEntry['address'] = $school->address;
                        $schoolEntry['phone'] = $school->phone;

                        $schoolEntry['nodal'] = \Models\SchoolNodal::where('school_id', $school->id)
                            ->with('nodaladmin.user')
                            ->has('nodaladmin.user')
                            ->first();

                        array_push($schoolNearbyData, $schoolEntry);
                    }
                }
            }
        }

        $certificate_details = $student['personal_details']['certificate_details'];

        $this->data['student'] = $student;

        $this->data['certificate_details'] = $certificate_details;

        $this->data['schoolData'] = $schoolData;

        $this->data['schoolNearbyData'] = $schoolNearbyData;

        return view('stateadmin::student.single-students', $this->data);
    }

    public function getAllotedStudentsView()
    {

        $this->data['title'] = 'Allotted student';

        return view('stateadmin::student.allotted-students', $this->data);
    }

    public function getEnrolledStudentsView()
    {

        $this->data['title'] = 'Enrolled student';

        return view('stateadmin::student.enrolled-students', $this->data);
    }

    public function getDismissedStudentsView()
    {

        $this->data['title'] = 'Dismissed student';

        return view('stateadmin::student.dismissed-students', $this->data);
    }

    public function getStudentsWithoutSchool()
    {

        $this->data['title'] = 'Student without School';

        $students = \Models\RegistrationCycle::whereHas('application_details', function (Builder $query) {
            $query->where('session_year', '2020');
        })
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

        $this->data['applied_student'] = $applied_student;

        return view('stateadmin::student.student-without-school', $this->data);
    }
}
