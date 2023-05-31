<?php
namespace Redlof\RoleSchoolAdmin\Controllers\Student;

use Exceptions\ValidationFailedException;
use Illuminate\Http\Request;
use Models\RegistrationCycle;
use Redlof\RoleSchoolAdmin\Controllers\Role\RoleSchoolAdminBaseController;
use Redlof\RoleSchoolAdmin\Controllers\Student\Requests\AddStudentBankDetailsRequest;
use Redlof\RoleSchoolAdmin\Controllers\Student\Requests\AddSubjectRequest;
use Redlof\RoleSchoolAdmin\Controllers\Student\Requests\DropoutReasonRequest;
use Redlof\RoleSchoolAdmin\Controllers\Student\Requests\UpdateStudentBankDetailsRequest;

class StudentController extends RoleSchoolAdminBaseController
{

    public function getAllottedStudents(Request $request)
    {

        $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
            ->where('status', 'allotted')
            ->with(['basic_details'])
            ->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getAllListStudents(Request $request, $cycle, $class)
    {

        if ($cycle == 'null') {

            $cycle = $this->data['latest_application_cycle']['session_year'];
        }

        $query = RegistrationCycle::where('allotted_school_id', $this->school->id)
            ->with(['basic_details', 'application_details'])
            ->whereHas('application_details', function ($subQuery) use ($cycle) {

                $subQuery->where('session_year', $cycle);
            });

        if ($class != 'null') {

            $query->whereHas('basic_details', function ($subQuery) use ($class) {
                $subQuery = $subQuery->where('level_id', $class)
                    ->from(with(new \Models\RegistrationBasicDetail)->getTable());
            });
        }

        $students = $query->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getSearchAllListStudents(Request $request, $cycle, $class)
    {

        if ($cycle == 'null') {

            $cycle = $this->data['latest_application_cycle']['session_year'];
        }

        $searchVal = $request['s'];

        $query = RegistrationCycle::where('allotted_school_id', $this->school->id)
            ->with(['basic_details', 'application_details'])
            ->whereHas('basic_details', function ($subQuery) use ($searchVal) {
                $subQuery->where('first_name', 'ilike', '%' . $searchVal . '%')
                    ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%');
            })
            ->whereHas('application_details', function ($subQuery) use ($cycle) {

                $subQuery->where('session_year', $cycle);
            });

        if ($class != 'null') {

            $query->whereHas('basic_details', function ($subQuery) use ($class) {
                $subQuery = $subQuery->where('level_id', $class)
                    ->from(with(new \Models\RegistrationBasicDetail)->getTable());
            });
        }

        $students = $query->distinct()
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getAllAllottedStudents(Request $request, $cycle, $class)
    {

        if (empty($cycle) || $cycle == 'null' || $cycle == null) {

            $cycle = date('Y');
        }

        if ($cycle != 'null' && $class == 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'allotted')
                ->with(['basic_details', 'application_details'])
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->distinct()
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle == 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'allotted')
                ->with(['basic_details', 'application_details'])
                ->whereHas('basic_details', function ($subQuery) use ($class) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->distinct()
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle != 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'allotted')
                ->with(['basic_details', 'application_details'])
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->whereHas('basic_details', function ($subQuery) use ($class) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->distinct()
                ->page($request)
                ->get()
                ->preparePage($request);
        } else {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'allotted')
                ->with(['basic_details'])
                ->distinct()
                ->page($request)
                ->get()
                ->preparePage($request);

        }

        return api('', $students);
    }

    public function getSearchAllAllottedStudents(Request $request, $cycle, $class)
    {

        if (empty($cycle) || $cycle == 'null' || $cycle == null) {

            $cycle = date('Y');
        }

        $searchVal = $request['s'];
        if ($cycle != 'null' && $class == 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'allotted')
                ->with(['basic_details', 'application_details'])
                ->whereHas('basic_details', function ($subQuery) use ($searchVal) {
                    $subQuery = $subQuery->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->distinct()
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle == 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'allotted')
                ->with(['basic_details', 'application_details'])
                ->whereHas('basic_details', function ($subQuery) use ($class, $searchVal) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->distinct()
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle != 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'allotted')
                ->with(['basic_details', 'application_details'])
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->whereHas('basic_details', function ($subQuery) use ($class, $searchVal) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->distinct()
                ->page($request)
                ->get()
                ->preparePage($request);
        } else {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'allotted')
                ->with(['basic_details'])
                ->whereHas('basic_details', function ($subQuery) use ($searchVal) {
                    $subQuery = $subQuery->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->distinct()
                ->page($request)
                ->get()
                ->preparePage($request);

        }

        return api('', $students);
    }

    public function getAllEnrolledStudents(Request $request, $cycle, $class)
    {

        if (empty($cycle) || $cycle == 'null' || $cycle == null) {

            $cycle = date('Y');
        }

        if ($cycle != 'null' && $class == 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'enrolled')
                ->with(['basic_details', 'application_details'])
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle == 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'enrolled')
                ->with(['basic_details', 'application_details'])
                ->whereHas('basic_details', function ($subQuery) use ($class) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle != 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'enrolled')
                ->with(['basic_details', 'application_details'])
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->whereHas('basic_details', function ($subQuery) use ($class) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } else {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'enrolled')
                ->with(['basic_details'])
                ->page($request)
                ->get()
                ->preparePage($request);

        }

        return api('', $students);
    }

    public function getSearchAllEnrolledStudents(Request $request, $cycle, $class)
    {

        if (empty($cycle) || $cycle == 'null' || $cycle == null) {

            $cycle = date('Y');
        }

        $searchVal = $request['s'];
        if ($cycle != 'null' && $class == 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'enrolled')
                ->with(['basic_details', 'application_details'])
                ->whereHas('basic_details', function ($subQuery) use ($searchVal) {
                    $subQuery = $subQuery->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle == 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'enrolled')
                ->with(['basic_details', 'application_details'])
                ->whereHas('basic_details', function ($subQuery) use ($class, $searchVal) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle != 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'enrolled')
                ->with(['basic_details', 'application_details'])
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->whereHas('basic_details', function ($subQuery) use ($class, $searchVal) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } else {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where('status', 'enrolled')
                ->with(['basic_details'])
                ->whereHas('basic_details', function ($subQuery) use ($searchVal) {
                    $subQuery = $subQuery->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);

        }

        return api('', $students);
    }

    public function getAllRejectedStudents(Request $request, $cycle, $class)
    {

        if (empty($cycle) || $cycle == 'null' || $cycle == null) {

            $cycle = date('Y');
        }

        if ($cycle != 'null' && $class == 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'rejected')
                        ->orWhere('status', 'dismissed');
                })
                ->with(['basic_details', 'application_details'])
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle == 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'rejected')
                        ->orWhere('status', 'dismissed');
                })
                ->with(['basic_details', 'application_details'])
                ->whereHas('basic_details', function ($subQuery) use ($class) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle != 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'rejected')
                        ->orWhere('status', 'dismissed');
                })
                ->with(['basic_details', 'application_details'])
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->whereHas('basic_details', function ($subQuery) use ($class) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } else {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'rejected')
                        ->orWhere('status', 'dismissed');
                })
                ->with(['basic_details'])
                ->page($request)
                ->get()
                ->preparePage($request);

        }

        return api('', $students);
    }

    public function getAllDropoutStudents(Request $request, $cycle, $class)
    {

        if (empty($cycle) || $cycle == 'null' || $cycle == null) {

            $cycle = date('Y');
        }

        if ($cycle != 'null' && $class == 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'dropout')
                        ->orWhere('status', 'withdraw');
                })
                ->with(['basic_details', 'application_details'])
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle == 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'dropout')
                        ->orWhere('status', 'withdraw');
                })
                ->with(['basic_details', 'application_details'])
                ->whereHas('basic_details', function ($subQuery) use ($class) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle != 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'dropout')
                        ->orWhere('status', 'withdraw');
                })
                ->with(['basic_details', 'application_details'])
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->whereHas('basic_details', function ($subQuery) use ($class) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } else {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'dropout')
                        ->orWhere('status', 'withdraw');
                })
                ->with(['basic_details'])
                ->page($request)
                ->get()
                ->preparePage($request);

        }

        return api('', $students);
    }

    public function getSearchAllRejectedStudents(Request $request, $cycle, $class)
    {

        if (empty($cycle) || $cycle == 'null' || $cycle == null) {

            $cycle = date('Y');
        }

        $searchVal = $request['s'];
        if ($cycle != 'null' && $class == 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'rejected')
                        ->orWhere('status', 'dismissed');
                })
                ->with(['basic_details', 'application_details'])
                ->whereHas('basic_details', function ($subQuery) use ($searchVal) {
                    $subQuery = $subQuery->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle == 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'rejected')
                        ->orWhere('status', 'dismissed');
                })
                ->with(['basic_details', 'application_details'])
                ->whereHas('basic_details', function ($subQuery) use ($class, $searchVal) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle != 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'rejected')
                        ->orWhere('status', 'dismissed');
                })
                ->with(['basic_details', 'application_details'])
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->whereHas('basic_details', function ($subQuery) use ($class, $searchVal) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } else {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'rejected')
                        ->orWhere('status', 'dismissed');
                })
                ->with(['basic_details'])
                ->whereHas('basic_details', function ($subQuery) use ($searchVal) {
                    $subQuery = $subQuery->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);

        }

        return api('', $students);
    }

    public function getSearchAllDropoutStudents(Request $request, $cycle, $class)
    {

        if (empty($cycle) || $cycle == 'null' || $cycle == null) {

            $cycle = date('Y');
        }

        $searchVal = $request['s'];
        if ($cycle != 'null' && $class == 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'withdraw')
                        ->orWhere('status', 'dropout');
                })
                ->with(['basic_details', 'application_details'])
                ->whereHas('basic_details', function ($subQuery) use ($searchVal) {
                    $subQuery = $subQuery->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle == 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'withdraw')
                        ->orWhere('status', 'dropout');
                })
                ->with(['basic_details', 'application_details'])
                ->whereHas('basic_details', function ($subQuery) use ($class, $searchVal) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } elseif ($cycle != 'null' && $class != 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'withdraw')
                        ->orWhere('status', 'dropout');
                })
                ->with(['basic_details', 'application_details'])
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->whereHas('basic_details', function ($subQuery) use ($class, $searchVal) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);
        } else {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->where(function ($query) {
                    $query->where('status', 'withdraw')
                        ->orWhere('status', 'dropout');
                })
                ->with(['basic_details'])
                ->whereHas('basic_details', function ($subQuery) use ($searchVal) {
                    $subQuery = $subQuery->where('first_name', 'ilike', '%' . $searchVal . '%')
                        ->orWhere('registration_no', 'ilike', '%' . $searchVal . '%')
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->page($request)
                ->get()
                ->preparePage($request);

        }

        return api('', $students);
    }

    public function getClassLevels()
    {

        $class_levels = \Models\Level::select('id', 'level')
            ->orderBy('id')
            ->get();

        return api('', $class_levels);

    }

    public function getSchoolSubjects(Request $request)
    {

        $subjects = \Models\SchoolSubject::where('school_id', $this->school->id)
            ->with(['subject', 'level'])
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $subjects);
    }

    public function getAllSchoolSubjects($registration_id, $level_id)
    {

        $report = \Models\ReportCard::select('id')
            ->where('registration_id', $registration_id)
            ->first();

        $grade = \Models\GradeReport::where('report_id', $report->id)
            ->with(['subject'])
            ->orderBy('id')
            ->get();

        $subjects = \Models\SchoolSubject::where('school_id', $this->school->id)
            ->where('level_id', $level_id)
            ->with(['subject', 'level'])
            ->orderBy('id')
            ->get();

        if (count($grade) == count($subjects)) {

            return api('', $grade);

        }if (count($grade) > 0 && count($grade) < count($subjects)) {

            $subjects->transform(function ($item, $key) use ($grade) {

                $grad = $grade->where('subject_id', $item->subject_id)->first();

                if (!empty($grad)) {

                    $item['total_marks'] = $grad->total_marks;
                    $item['scored_marks'] = $grad->scored_marks;
                    $item['avg_marks'] = $grad->avg_marks;

                }

                return $item;

            });

            return api('', $subjects);

        } else {

            return api('', $subjects);

        }

    }

    public function getStudentsByClass(Request $request, $level_id)
    {

        $class_levels = \Models\RegistrationBasicDetail::where('level_id', $level_id)

            ->with(['registration_cycle', 'level'])

            ->whereHas('registration_cycle', function ($subQuery) {

                $subQuery->where('status', 'enrolled')
                    ->where('allotted_school_id', $this->school->id)
                    ->from(with(new \Models\RegistrationCycle)->getTable());
            })
            ->page($request)
            ->orderBy('first_name')
            ->get()
            ->preparePage($request);

        return api('', $class_levels);

    }

    public function getSearchStudentsByClass(Request $request, $level_id)
    {
        $valSearch = $request['s'];
        $class_levels = \Models\RegistrationBasicDetail::where('level_id', $level_id)
            ->where(function ($query) use ($valSearch) {
                $query->where('first_name', 'ilike', '%' . $valSearch . '%')
                    ->orWhere('registration_no', 'ilike', '%' . $valSearch . '%');
            })
            ->with(['registration_cycle', 'level'])
            ->whereHas('registration_cycle', function ($subQuery) {

                $subQuery->where('status', 'enrolled')
                    ->where('allotted_school_id', $this->school->id)
                    ->from(with(new \Models\RegistrationCycle)->getTable());
            })

            ->page($request)
            ->orderBy('first_name')
            ->get()
            ->preparePage($request);

        return api('', $class_levels);

    }

    public function getMonthDetails($registration_id)
    {

        $report = \Models\ReportCard::select('id')
            ->where('registration_id', $registration_id)
            ->first();

        $months = \Models\AttendanceReport::where('report_id', $report->id)
            ->orderBy('id')
            ->get();

        return api('', $months);

    }

    public function getEnrolledStudents(Request $request)
    {

        $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
            ->where('status', 'enrolled')
            ->with(['basic_details'])
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getRejectedStudents(Request $request)
    {

        $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
            ->where('status', 'dismissed')
            ->with(['basic_details'])
            ->page($request)
            ->get()
            ->preparePage($request);

        return api('', $students);
    }

    public function getStudentBankDetails($registration_id)
    {

        $bank = \Models\RegistrationBankDetail::where('registration_id', $registration_id)
            ->first();

        return api('', $bank);
    }

    public function getApplicationCycles()
    {
        $applicationcycle = \Models\ApplicationCycle::select('session_year')
            ->distinct('session_year')
            ->orderBy('session_year', 'DESC')
            ->get();

        return api('', $applicationcycle);
    }

    public function getBankDetails($ifsc)
    {

        try {

            $json = file_get_contents('https://ifsc.razorpay.com/' . $ifsc);
            $obj = json_decode($json);

            return api('Ifsc code verified successfully', $obj);

        } catch (\Exception $e) {

            throw new ValidationFailedException("No bank details found for the above IFSC code");
        }

    }

    public function postDeleteSubject($subject_id)
    {

        $sschoolSubDelete = \Models\SchoolSubject::where('subject_id', $subject_id)
            ->delete();

        $subDelete = \Models\Subject::where('id', $subject_id)
            ->delete();

        $reloadObj['reload'] = true;

        return api('Subject deleted sucessfully', $reloadObj);
    }

    public function postAddSubject(AddSubjectRequest $request)
    {

        foreach ($request->subjects as $key => $sub) {

            $subject = \Models\Subject::create($sub);

            $stateSub = new \Models\SchoolSubject();

            $stateSub['subject_id'] = $subject->id;

            $stateSub['level_id'] = $request->level_id;

            $stateSub['schooladmin_id'] = $this->schooladmin->id;

            $stateSub['school_id'] = $this->school->id;

            $stateSub->save();

        }

        $reloadObj['reload'] = true;

        return api('Subject added sucessfully', $reloadObj);

    }

    public function postMarkStudentDropout(DropoutReasonRequest $request, $registration_id)
    {

        $dropout = \Models\DropoutReason::updateOrCreate(
            ['registration_id' => $registration_id],
            ['reason' => $request->reason]
        );

        $mark = \Models\RegistrationCycle::where('registration_id', $registration_id)
            ->update(['status' => 'withdraw']);

        $markReport = \Models\ReportCard::where('registration_id', $registration_id)
            ->update(['dropped_at' => \Carbon::now()]);

        $nodal = \Models\SchoolNodal::where('school_id', $this->school->id)
            ->with(['nodaladmin', 'nodaladmin.user'])
            ->first();

        $student = \Models\RegistrationBasicDetail::select('id', 'first_name')->where('id', $registration_id)->first();

        $EmailData = array(

            'first_name' => $student->first_name,
            'registration_id' => $registration_id,
            'school' => $this->school->name,
        );

        $subject = 'RTE Student dropout notification';

        \MailHelper::sendSyncMail('schooladmin::emails.student-dropout-notification', $subject, $nodal->nodaladmin->user->email, $EmailData);

        $redirect_state = route('schooladmin.attendance');

        $reloadObj['redirect'] = $redirect_state;

        return api('Student has been marked dropout', $reloadObj);

    }

    public function postEnrollStudent(AddStudentBankDetailsRequest $request, $registration_id)
    {

        $registrationCycle = \Models\RegistrationCycle::where('registration_id', $registration_id)->orderBy('id', 'desc')->first();

        if ($registrationCycle->document_verification_status == 'rejected') {
            throw new ValidationFailedException("Student Documents are rejected by nodal");
        }

        if ($registrationCycle->document_verification_status == null) {
            throw new ValidationFailedException("Student documents are not verified by nodal");
        }

        if ($request->suspicious) {
            $request->merge(['district_id' => $this->school->district_id]);
            $request->merge(['registration_id' => $registration_id]);
            $request->merge(['schooladmin_id' => $this->adminschool->id]);

            \Models\SuspiciousStudent::create($request->all());
        }

        if (count($request['account_number']) > 0 && count($request['ifsc_code']) > 0) {

            $studentBank = new \Models\RegistrationBankDetail();

            $studentBank['registration_id'] = $registration_id;

            $studentBank['account_number'] = $request['account_number'];

            $studentBank['account_holder_name'] = $request['account_holder_name'];

            if ($request['bank_name']) {

                $studentBank['bank_name'] = $request['bank_name'];

            } else {

                throw new ValidationFailedException("Please verify the IFSC Code");

            }

            $studentBank['ifsc_code'] = $request['ifsc_code'];

            $studentBank->save();
        }

        $registrationCycle->status = 'enrolled';
        $registrationCycle->enrolled_on = \Carbon::now();
        $registrationCycle->save();

        $reportCard = \Models\RegistrationCycle::where('registration_id', $registration_id)
            ->with(['basic_details', 'application_details', 'school'])
            ->orderBy('id', 'desc')
            ->first();

        $newReportCard = new \Models\ReportCard();

        $newReportCard['school_id'] = $reportCard->school->id;

        $newReportCard['registration_id'] = $registration_id;

        $newReportCard['application_year'] = $reportCard->application_details->session_year;

        $newReportCard['level_id'] = $reportCard->basic_details->level_id;

        $newReportCard->save();

        $months = array();

        for ($i = 0; $i < 12; $i++) {

            $timestamp = mktime(0, 0, 0, 4 + $i, 1);

            $months[date('n', $timestamp)] = date('F', $timestamp);

        }

        foreach ($months as $key => $month) {

            $newAttendance = new \Models\AttendanceReport();

            $newAttendance['report_id'] = $newReportCard->id;

            $newAttendance['month'] = $month;

            $newAttendance['total_days'] = 0;

            $newAttendance['attended_days'] = 0;

            $newAttendance->save();

        }

        $applicant = \Models\RegistrationBasicDetail::select('first_name', 'middle_name', 'last_name', 'id', 'email', 'mobile', 'registration_no')
            ->where('id', $registration_id)
            ->first();

        if (isset($applicant->email) && !empty($applicant->email)) {

            $EmailData = array(
                'registration_no' => $applicant->registration_no,
                'first_name' => $applicant->first_name,
                'middle_name' => $applicant->middle_name,
                'last_name' => $applicant->last_name,
                'school' => $this->school->name,
            );

            $subject = 'RTE Enrollment Confirmation';

            // \MailHelper::sendSyncMail('state::emails.student-enrollment-accepted', $subject, $applicant->email, $EmailData);
        }

        $input['phone'] = $applicant->mobile;

        $input['message'] = "RTE your enrollment has been confirmed at your prefered school " . $this->school->name;

        // \MsgHelper::sendSyncSMS($input);

        $showObject = [
            'reload' => true,
        ];

        return api('Student has been enrolled', $showObject);
    }

    public function postUnEnrollStudent(Request $request, $registration_id)
    {

        $registrationCycle = \Models\RegistrationCycle::where('registration_id', $registration_id)
            ->with(['basic_details', 'application_details', 'school'])
            ->where('allotted_school_id', $this->school->id)
            ->first();

        $registrationCycle->status = 'allotted';

        $registrationCycle->save();

        $reportCard = \Models\ReportCard::where('school_id', $registrationCycle->school->id)
            ->where('registration_id', $registration_id)
            ->where('level_id', $registrationCycle->basic_details->level_id)
            ->first();

        if (!empty($reportCard)) {

            \Models\AttendanceReport::where('report_id', $reportCard->id)->delete();

            $reportCard->delete();
        }

        \Models\RegistrationBankDetail::where('registration_id', $registration_id)->delete();

        $msg = \AuthHelper::getCurrentUser()->email . "-School admin has un-enroll the student Reg. No : " . $registrationCycle->basic_details->registration_no . " at " . \Carbon::now()->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s A');

        \Log::info($msg);

        $showObject = [
            'reload' => true,
        ];

        return api('Student has un-enrolled', $showObject);
    }

    public function postUpdateStudentBank(UpdateStudentBankDetailsRequest $request, $registration_id)
    {

        if (count($request['account_number']) > 0) {

            $studentBank = new \Models\RegistrationBankDetail();

            $studentBank['registration_id'] = $registration_id;

            $studentBank['account_number'] = $request['account_number'];

            $studentBank['account_holder_name'] = $request['account_holder_name'];

            if ($request['bank_name']) {

                $studentBank['bank_name'] = $request['bank_name'];

            } else {

                throw new ValidationFailedException("Please verify the IFSC Code");

            }

            $studentBank['ifsc_code'] = $request['ifsc_code'];

            $studentBank->save();

            $showObject = [
                'reload' => true,
            ];

            return api('Student bank details updated successfully', $showObject);
        }

    }

    public function postUpdateStudentBankDetails(UpdateStudentBankDetailsRequest $request, $registration_id)
    {

        if (count($request['account_number']) > 0) {

            $studentBank = \Models\RegistrationBankDetail::where('registration_id', $registration_id)->first();

            $studentBank['registration_id'] = $registration_id;

            $studentBank['account_number'] = $request['account_number'];

            $studentBank['account_holder_name'] = $request['account_holder_name'];

            if ($request['bank_name']) {

                $studentBank['bank_name'] = $request['bank_name'];

            } else {

                throw new ValidationFailedException("Please verify the IFSC Code");

            }

            $studentBank['ifsc_code'] = $request['ifsc_code'];

            $studentBank->update();

            $showObject = [
                'reload' => true,
            ];

            return api('Student bank details updated successfully', $showObject);
        }

    }

    public function postAddAttendance(Request $request)
    {

        $registration_id = $request['registration_id'];

        foreach ($request->attendances as $key => $attendance) {

            if ($attendance['total_days'] > 31) {

                throw new ValidationFailedException("Invalid number total days");

            } elseif ($attendance['attended_days'] > $attendance['total_days']) {

                throw new ValidationFailedException("No. of days present cannot be more then total working days");

            }

            $updateAttendance = \Models\AttendanceReport::find($attendance['id']);

            $updateAttendance->month = $attendance['month'];

            $updateAttendance->total_days = $attendance['total_days'];

            $updateAttendance->attended_days = $attendance['attended_days'];

            $updateAttendance->save();

        }

        $report = \Models\ReportCard::where('registration_id', $registration_id)->first();

        $check = \Models\AttendanceReport::where('report_id', $report->id)
            ->where('total_days', '>', '0')->count();

        if ($check == 12) {

            $fee = \Models\SchoolLevelInfo::select('tution_fee', 'other_fee')
                ->where('school_id', $report->school_id)
                ->where('level_id', $report->level_id)
                ->where('session_year', $this->data['latest_application_cycle']['session_year'])
                ->first();

            $total = $fee->tution_fee * 12;

            $othertotal = $fee->other_fee * 12;

            $reportUpdate = \Models\ReportCard::where('registration_id', $registration_id)
                ->update(['tution_payable' => $total, 'amount_payable' => $total, 'other_payable' => $othertotal]);

        } else {

            $fee = \Models\SchoolLevelInfo::select('tution_fee')
                ->where('school_id', $report->school_id)
                ->where('level_id', $report->level_id)
                ->where('session_year', $this->data['latest_application_cycle']['session_year'])
                ->first();

            $reportUpdate = \Models\ReportCard::where('registration_id', $registration_id)
                ->update(['tution_payable' => 0]);

        }

        $redirect_state = route('schooladmin.attendance');

        $reloadObj['redirect'] = $redirect_state;

        return api('Attendance details has been updated', $reloadObj);

    }

    public function postAddMarks(Request $request)
    {

        $report = \Models\ReportCard::select('id')
            ->where('registration_id', $request['registration_id'])
            ->first();

        foreach ($request->marks as $key => $mark) {

            if ($mark['scored_marks'] > $mark['total_marks']) {

                throw new ValidationFailedException("Marks obtained cannot be more than maximum marks");

            }

            $updateMark = \Models\GradeReport::updateOrCreate([
                'report_id' => $report->id,
                'subject_id' => $mark['subject_id'],
            ], [
                'total_marks' => $mark['total_marks'],
                'scored_marks' => $mark['scored_marks'],
                'avg_marks' => $mark['avg_marks'],
            ]);

        }

        $cardSchools = \Models\ReportCard::where('school_id', $this->school->id)
            ->distinct('id')
            ->count('id');

        $cardreports = \Models\ReportCard::select('id')
            ->where('school_id', $this->school->id)
            ->get();

        $totalGrade = 0;

        foreach ($cardreports as $key => $cardreport) {

            $port = \Models\GradeReport::where('report_id', $cardreport->id)
                ->distinct('report_id')
                ->count('report_id');

            $totalGrade = $totalGrade + $port;

        }

        if (($cardSchools > 0) && ($cardSchools == $totalGrade)) {

            $updateStatus = \Models\SchoolReimbursement::where('school_id', $this->school->id)
                ->update(['allow_status' => 'yes']);

        }

        $redirect_state = route('schooladmin.grade');

        $reloadObj['redirect'] = $redirect_state;

        return api('Grades has been updated', $reloadObj);

    }

    public function postRejectStudent(Request $request)
    {

        if (empty($request->reason)) {
            throw new ValidationFailedException("Please select any one of the options.");
        }

        if ($request->reason == 'False document') {

            if (empty($request->rejected_reason)) {
                throw new ValidationFailedException("Please write your reason.");
            }
        }

        if ($request->rejected_document) {

            $file_name = upload('rejected_documents', $request->rejected_document, 'private');

            \Models\RegistrationBasicDetail::where('id', $request->registration_id)
                ->update([
                    'rejected_document' => $file_name,
                    'rejected_reason' => $request->rejected_reason,
                ]);

        } else {

            if ($request->reason == 'False document') {
                throw new ValidationFailedException("Please upload the scanned copy of document submited by student");
            }
        }

        $meta_data = ['reason' => $request->reason];

        $studentUpdate = \Models\RegistrationCycle::where('registration_id', $request->registration_id)
            ->where('allotted_school_id', $this->school->id)
            ->orderBy('cycle', 'desc')
            ->first();

        $studentUpdate->meta_data = $meta_data;
        $studentUpdate->status = 'dismissed';

        $studentUpdate->save();

        $nodal = \Models\SchoolNodal::where('school_id', $this->school->id)
            ->with(['nodaladmin', 'nodaladmin.user'])
            ->first();

        $student = \Models\RegistrationBasicDetail::select('id', 'first_name')->where('id', $request->registration_id)->first();

        $EmailData = array(

            'first_name' => $student->first_name,
            'registration_id' => $student->id,
            'school' => $this->school->name,
        );

        $subject = 'RTE Student reject notification';

        \MailHelper::sendSyncMail('schooladmin::emails.student-rejected-notification', $subject, $nodal->nodaladmin->user->email, $EmailData);

        $showObject = [
            'reload' => true,
        ];

        return api('Student has been rejected', $showObject);
    }

    public function postDownloadAllStudents($cycle, $class)
    {

        if (empty($cycle) || $cycle == 'null' || $cycle == null) {

            $cycle = date('Y');
        }

        if ($class == 'null') {

            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->with(['application_details', 'basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->get();
        } else {

            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->with(['application_details', 'basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])

                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->whereHas('basic_details', function ($subQuery) use ($class) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->get();
        }

        $type = 'all-students-list';

        return $this->downloadStudents($students, $type);
    }

    public function postDownloadAllottedStudents($cycle, $class)
    {

        if (empty($cycle) || $cycle == 'null' || $cycle == null) {

            $cycle = date('Y');
        }

        if ($class == 'null') {

            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->with(['application_details', 'basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
                ->where('status', 'allotted')
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->get();
        } else {

            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->with(['application_details', 'basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
                ->where('status', 'allotted')
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->whereHas('basic_details', function ($subQuery) use ($class) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->get();
        }

        $type = 'all-allotted-list';

        return $this->downloadStudents($students, $type);
    }

    public function postDownloadEnrolledStudents($cycle, $class)
    {

        if (empty($cycle) || $cycle == 'null' || $cycle == null) {

            $cycle = date('Y');
        }

        if ($class == 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->with(['application_details', 'basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
                ->where('status', 'enrolled')
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->get();
        } else {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->with(['application_details', 'basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
                ->where('status', 'enrolled')
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->whereHas('basic_details', function ($subQuery) use ($class) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->get();
        }

        $type = 'all-enrolled-list';

        return $this->downloadStudents($students, $type);
    }

    public function postDownloadRejectedStudents($cycle, $class)
    {

        if (empty($cycle) || $cycle == 'null' || $cycle == null) {

            $cycle = date('Y');
        }

        if ($class == 'null') {

            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->with(['application_details', 'basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
                ->where(function ($query) {
                    $query->where('status', 'rejected')
                        ->orWhere('status', 'dismissed');
                })
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->get();
        } else {

            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->with(['application_details', 'basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
                ->where(function ($query) {
                    $query->where('status', 'rejected')
                        ->orWhere('status', 'dismissed');
                })
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->whereHas('basic_details', function ($subQuery) use ($class) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->get();
        }

        $type = 'all-rejected-list';

        return $this->downloadStudents($students, $type);
    }

    public function postDownloadDropoutStudents($cycle, $class)
    {

        if (empty($cycle) || $cycle == 'null' || $cycle == null) {

            $cycle = date('Y');
        }

        if ($class == 'null') {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->with(['application_details', 'basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
                ->where(function ($query) {
                    $query->where('status', 'dropout')
                        ->orWhere('status', 'withdraw');
                })
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->get();
        } else {
            $students = RegistrationCycle::where('allotted_school_id', $this->school->id)
                ->with(['application_details', 'basic_details.level', 'basic_details', 'school', 'school.district', 'school.block', 'school.subblock', 'school.locality', 'basic_details.personal_details', 'basic_details.all_parent_details', 'basic_details.country_state', 'basic_details.personal_details.district', 'basic_details.personal_details.block', 'basic_details.personal_details.locality'])
                ->where(function ($query) {
                    $query->where('status', 'dropout')
                        ->orWhere('status', 'withdraw');
                })
                ->whereHas('application_details', function ($subQuery) use ($cycle) {
                    $subQuery = $subQuery->where('session_year', $cycle)
                        ->from(with(new \Models\ApplicationCycle)->getTable());
                })
                ->whereHas('basic_details', function ($subQuery) use ($class) {
                    $subQuery = $subQuery->where('level_id', $class)
                        ->from(with(new \Models\RegistrationBasicDetail)->getTable());
                })
                ->get();
        }

        $type = 'all-dropout-list';

        return $this->downloadStudents($students, $type);
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
                $InnData['Status of verification'] = '';
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

        $reports = \Excel::create($type, function ($excel) use ($items, $type) {

            $excel->sheet($type, function ($sheet) use ($items) {

                $sheet->fromArray($items);
            });

        })->store('xlsx', public_path('temp'));

        return response()->json(['filename' => $type . '.xlsx', 'data' => asset('temp/' . $type . '.xlsx')], 200);

    }

    private function getSchoolStudentIdsBySession($request)
    {
        $studentIDs = [];

        $current_year = $this->data['latest_application_cycle']['session_year'];

        if (!empty($request->selectedCycle) && $request->selectedCycle != 'null') {

            $current_year = $request->selectedCycle;
        }

        $students = \Models\RegistrationCycle::whereHas('application_details', function ($query) use ($current_year) {

            $query->where('session_year', $current_year);
        })
            ->get();

        if ($this->data['latest_application_cycle']['cycle'] > 1) {

            // get users which registered for second cycle
            // remove there first cycle entry

            $usersUnique = $students->unique('registration_id');

            $usersDupesRegistrationId = $students->diff($usersUnique)->pluck('registration_id')->toArray();

            $delStudentIds = $students->whereIn('registration_id', $usersDupesRegistrationId)
                ->where('cycle', '<>', $this->data['latest_application_cycle']['cycle'])
                ->pluck('id')
                ->toArray();

            $studentIDs = $students->whereNotIn('id', $delStudentIds)
                ->pluck('id')
                ->toArray();
        }

        return $studentIDs;
    }

}
