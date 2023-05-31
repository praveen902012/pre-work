<?php

namespace Redlof\State\Controllers;

use Exceptions\EntityNotFoundException;
use Exceptions\UnAuthorizedException;
use Illuminate\Http\Request;
use Models\School;
use Models\State;
use Redlof\State\Controllers\StateBaseController;

class StateViewController extends StateBaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getHome()
    {
        $blockObjs = [];

        $this->data['title'] = "";

        return view('state::state.state-single', $this->data);
    }

    public function getInstructions()
    {

        $this->data['title'] = "Instructions";

        return view('state::state.student-registration-instruction', $this->data);
    }
    public function getSchoolRegistrationInstructions()
    {

        $this->data['title'] = "School Registration Instructions";

        return view('state::state.school-registration-instruction', $this->data);
    }
    public function getStudentRegistrationInstructions()
    {

        $this->data['title'] = "Student Registration Instructions";

        return view('state::state.student-registration-instruction', $this->data);
    }
    public function getgovernmentRegistrationInstructions()
    {

        $this->data['title'] = "Government Officials";

        return view('state::state.government-registration-instruction', $this->data);
    }

    public function getRegisterYourSchool()
    {
        if ($this->data['state']['school_registration']) {

            $this->data['title'] = "School Registration";

            return view('state::state.school-registration-primary', $this->data);

        }

        throw new EntityNotFoundException("School Registration Process Is Closed.");
    }

    public function getSchoolAddress($slug, $udise, Request $request)
    {

        $this->data['title'] = "School Registration";

        $this->data['udise'] = $this->validateSchoolSession($request, $udise);

        $this->data['show_preview'] = false;

        $school = School::select('id', 'school_type', 'current_state')->where('udise', $udise)->first();

        if ($school->current_state == 'step5') {

            $this->data['show_preview'] = true;
        }

        return view('state::state.school-registration-address', $this->data);
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

    public function getSchoolPrimary($slug, $udise, Request $request)
    {

        $this->data['title'] = "School Registration";

        $this->data['udise'] = $this->validateSchoolSession($request, $udise);

        $this->data['show_preview'] = false;

        $school = School::select('id', 'school_type', 'current_state')->where('udise', $udise)->first();

        if ($school->current_state == 'step5') {

            $this->data['show_preview'] = true;
        }

        return view('state::state.school-registration-resume-primary', $this->data);
    }

    public function getSchoolRegion($state, $udise, Request $request)
    {

        $this->data['title'] = "School Registration";

        $this->data['udise'] = $this->validateSchoolSession($request, $udise);

        $this->data['show_preview'] = false;

        $school = School::select('id', 'school_type', 'current_state')->where('udise', $udise)->first();

        if ($school->current_state == 'step5') {

            $this->data['show_preview'] = true;
        }

        return view('state::state.school-registration-region-selection', $this->data);
    }

    public function getSchoolClassView($state, $udise, Request $request)
    {

        $this->data['title'] = "School Registration";

        $this->data['udise'] = $this->validateSchoolSession($request, $udise);

        $this->data['show_preview'] = false;

        $school = School::select('id', 'name', 'school_type', 'current_state', 'cycle')->where('udise', $udise)->first();

        if ($school->current_state == 'step5') {

            $this->data['show_preview'] = true;
        }

        $appCycle = \Models\ApplicationCycle::where('cycle', $school->cycle)
            ->where('status', 'new')
            ->first();

        if (empty($appCycle)) {

            $appCycle = $this->data['latest_application_cycle'];

            $school->cycle = $appCycle->cycle;

            $school->save();

        }

        $this->data['year'] = $appCycle->session_year;

        $this->data['school'] = $school;

        return view('state::state.school-registration-class', $this->data);
    }

    public function getSchoolBankDetailsView($state, $udise, Request $request)
    {

        if ($request->session()->has('udise')) {
            $this->data['udise'] = $request->session()->get('udise');

            if ($udise != $this->data['udise']) {

                throw new UnAuthorizedException("Session validation  error");
            }
        } else {
            throw new UnAuthorizedException("Session error");
        }

        $this->data['show_preview'] = false;

        $school = School::select('id', 'school_type', 'current_state')->where('udise', $udise)->first();

        if ($school->current_state == 'step5') {

            $this->data['show_preview'] = true;
        }

        $this->data['title'] = "School Registration";

        return view('state::state.school-registration-bank', $this->data);
    }

    public function getAllDetailsForPreview($state, $udise, Request $request)
    {

        $this->data['title'] = "Preview Registration Details";
        $this->data['udise'] = $this->validateSchoolSession($request, $udise);

        $this->data['show_preview'] = false;

        $school = School::select('id', 'name', 'school_type', 'current_state', 'cycle')->where('udise', $udise)->first();

        if ($school->current_state != 'step5') {

            return redirect()->route('state.register-your-school.resume-primary-details', [$state, $udise]);
        }

        if ($school->current_state == 'step5') {

            $this->data['show_preview'] = true;
        }

        // $year = \Models\ApplicationCycle::where('cycle', $school->cycle)
        //     ->where('status', 'new')
        //     ->first()
        //     ->session_year;

        $year = $this->data['latest_application_cycle']['session_year'];

        $this->data['year'] = $year;

        $this->data['school'] = $school;

        return view('state::state.school-registration-preview', $this->data);
    }

    public function getSchoolRegistrationSuccess($state, Request $request)
    {

        if ($request->session()->has('udise')) {
            $this->data['udise'] = $request->session()->get('udise');
        } else {
            throw new UnAuthorizedException("Session error");
        }

        $this->data['title'] = "School Registration Success";

        return view('state::state.register-school-success', $this->data);
    }

    public function getApplyForSeat()
    {

        $this->data['title'] = "Apply For A Seat";

        return view('state::student.apply-for-seat', $this->data);
    }

    public function getFaq()
    {

        $this->data['title'] = "FAQ";

        return view('state::state.state-instructions', $this->data);
    }

    public function getResults()
    {

        $this->data['title'] = "Student-Results";

        return view('state::state.student-result', $this->data);
    }

    public function getReports()
    {

        $this->data['title'] = "Results";

        return view('state::state.state-report', $this->data);
    }

    public function getInformation()
    {

        $this->data['title'] = "Information";

        return view('state::state.state-instructions', $this->data);
    }

    public function getDocuments()
    {

        $this->data['title'] = "Documents";

        $documents = \Models\Document::all();

        $this->data['documents'] = $documents;

        return view('state::state.state-documents', $this->data);
    }

    public function getTerms()
    {

        $this->data['title'] = "Terms to Use";

        return view('state::state.state-terms', $this->data);
    }

    public function getPrivacy()
    {

        $this->data['title'] = "Privacy Policy";

        return view('state::state.state-privacy', $this->data);
    }

    public function getgallery()
    {

        $this->data['title'] = "Gallery";

        return view('state::state.state-gallery', $this->data);
    }

    public function getStudentFaq()
    {

        $this->data['title'] = "Student FAQs";

        return view('state::state.student-faq', $this->data);
    }

    public function getSchoolDetails($slug, $school_id, $registration_id)
    {

        $this->data['title'] = "School Details";

        $this->data['school_id'] = $school_id;

        $this->data['registration_id'] = $registration_id;

        return view('state::state.school-details', $this->data);
    }

    public function getSchoolFaq()
    {

        $this->data['title'] = "School FAQs";

        return view('state::state.school-faq', $this->data);
    }

    public function getStateAdminSignIn()
    {

        $this->data['title'] = 'State Admin Signin';

        return view('state::signin.state-admin-signin', $this->data);
    }

    public function getDistrictAdminSignIn()
    {

        $this->data['title'] = 'District Admin Signin';

        return view('state::signin.district-admin-signin', $this->data);
    }

    public function getNodalAdminSignIn()
    {
        $this->data['title'] = 'Nodal Admin Signin';
        return view('state::signin.nodal-admin-signin', $this->data);
    }

    public function getSchoolAdminSignIn()
    {
        $this->data['title'] = 'School Admin Signin';
        return view('state::signin.school-admin-signin', $this->data);
    }

    public function getForgotPassword()
    {
        $this->data['title'] = 'Forgot Password';
        return view('state::signin.forgot-password', $this->data);
    }

    public function getForgotPasswordSchoolAdmin()
    {
        $this->data['title'] = 'Forgot Password';
        return view('state::signin.forgot-password-schooladmin', $this->data);
    }

    public function getResetPassword($state, $token)
    {

        $this->data['title'] = 'Forgot Password';
        $this->data['token'] = $token;

        return view('state::signin.reset-password', $this->data);
    }

    public function getGeneralInformation()
    {

        $this->data['title'] = "General Information";
        return view('state::state.state-general-information', $this->data);
    }

    public function getStudentGeneralInformation()
    {

        $this->data['title'] = " Student General Information";
        return view('state::state.student-general-information', $this->data);
    }

    public function getSchoolGeneralInformation()
    {

        $this->data['title'] = " School General Information";
        return view('state::state.school-general-information', $this->data);
    }

    public function getStudentRegisteredGeneralInformation()
    {

        $this->data['title'] = " Student Registered General Information";

        $now = \Carbon::now();
        $current_cycle = $now->year;
        $this->data['current_cycle'] = $current_cycle;

        return view('state::state.registered-student', $this->data);
    }

    public function getStudentAllottedGeneralInformation()
    {

        $this->data['title'] = " Student Allotted General Information";

        $now = \Carbon::now();
        $current_cycle = $now->year;
        $this->data['current_cycle'] = $current_cycle;

        return view('state::state.allotted-student', $this->data);
    }

    public function getStudentEnrolledGeneralInformation()
    {

        $this->data['title'] = " Student Enrolled General Information";

        $now = \Carbon::now();
        $current_cycle = $now->year;
        $this->data['current_cycle'] = $current_cycle;

        return view('state::state.enrolled-student', $this->data);
    }

    public function getStudentRejectedGeneralInformation()
    {

        $this->data['title'] = " Student Rejected General Information";

        $now = \Carbon::now();
        $current_cycle = $now->year;
        $this->data['current_cycle'] = $current_cycle;

        return view('state::state.rejected-student', $this->data);
    }

    public function getSchoolRegisteredGeneralInformation()
    {

        $this->data['title'] = " School Registered General Information";

        $current_cycle = $application_cycle = $this->data['latest_application_cycle']['session_year'];

        $this->data['current_cycle'] = $current_cycle;

        return view('state::state.school-registered', $this->data);
    }

    public function getSchoolRejectedGeneralInformation()
    {

        $this->data['title'] = " School Rejected General Information";

        $current_cycle = $application_cycle = $this->data['latest_application_cycle']['session_year'];

        $this->data['current_cycle'] = $current_cycle;

        return view('state::state.school-rejected', $this->data);
    }

    public function getSchoolVerifiedGeneralInformation()
    {

        $this->data['title'] = " School Verified General Information";

        $current_cycle = $application_cycle = $this->data['latest_application_cycle']['session_year'];

        $this->data['current_cycle'] = $current_cycle;

        return view('state::state.school-verified', $this->data);
    }

    public function getSchoolBannedGeneralInformation()
    {

        $this->data['title'] = " School Banned General Information";

        $current_cycle = $application_cycle = $this->data['latest_application_cycle']['session_year'];

        $this->data['current_cycle'] = $current_cycle;

        return view('state::state.school-banned', $this->data);
    }

    public function getSchoolStatusGeneralInformation()
    {

        $this->data['title'] = " School Status General Information";
        return view('state::state.school-status', $this->data);
    }
    public function publicInformationSchool()
    {
        $this->data['title'] = " School Information General Information";
        return view('state::state.public-school-info', $this->data);
    }
    public function getStudentStatusGeneralInformation()
    {
        $this->data['title'] = "Student Status";
        return view('state::state.public-student-info', $this->data);
    }

    public function getSchoolResults()
    {

        $this->data['title'] = "School-Results";

        return view('state::state.school-result', $this->data);
    }

    public function SchoolResultView($slug, $udiseCode)
    {

        $this->data['title'] = "School Result";

        $school = School::where('udise', $udiseCode)->first();

        if (empty($school)) {

            throw new UnAuthorizedException("You have entered an wrong UDISE code,");
        }

        $this->data['school'] = $school;

        return view('state::state.school-status-result', $this->data);
    }
}
