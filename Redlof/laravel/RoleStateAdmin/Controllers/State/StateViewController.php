<?php
namespace Redlof\RoleStateAdmin\Controllers\State;

use Models\State;
use Redlof\RoleStateAdmin\Controllers\Role\RoleStateAdminBaseController;

class StateViewController extends RoleStateAdminBaseController
{

    // State

    public function getStates()
    {

        $this->data['title'] = 'States';

        return view('stateadmin::state.states', $this->data);
    }

    public function getStateBriefView($state_id)
    {

        $state = State::with([
            'language',
            'stateadmin.user',
            'total_district_admins',
            'total_nodal_admins',
            'total_schools'])
            ->find($state_id);

        $this->data['state'] = $state;

        return view('stateadmin::state.state-brief-view', $this->data);
    }

    public function getStateSingleView($state)
    {

        $state = State::select('*')->where('slug', $state)->first();

        $this->data['state'] = $state;

        return view('stateadmin::state.state-single-view', $this->data);
    }

    // Disctrict

    public function getDistrictView($state)
    {

        $state = State::select('*')->where('slug', $state)->first();

        $this->data['state'] = $state;

        $this->data['title'] = 'District Administrators';

        return view('stateadmin::state.district-admin', $this->data);
    }

    // Nodal

    public function getNodalView($state)
    {

        $this->data['title'] = 'List of Nodal Admins';

        return view('stateadmin::state.nodal-admin', $this->data);
    }

    // School

    public function getSchoolView($state)
    {

        $state = State::select('id', 'name', 'slug')->where('slug', $state)->first();

        if (empty($state)) {
            throw new Exceptions\ValidationFailedException("This state is not registered with our platform yet");
        }

        $this->data['title'] = "StateAdmin | Schools";

        $this->data['state'] = $state;

        return view('stateadmin::school.viewschool', $this->data);
    }

    public function getSchoolSingleView($id)
    {

        $this->data['school'] = School::with(['schooladmin.user', 'language'])->find($id);

        return view('stateadmin::school.viewsingleschool', $this->data);
    }
    //GALLERY
    public function getGalleryView()
    {

        $state = $this->data['state_id'];

        $this->data['title'] = "StateAdmin | Gallery";
        $this->data['state'] = $state;

        return view('stateadmin::gallery.viewgallery', $this->data);
    }

    public function getFeaturedGalleryView()
    {

        $state = $this->data['state_id'];

        $this->data['title'] = "StateAdmin | Gallery";
        $this->data['state'] = $state;

        return view('stateadmin::gallery.view-featured-gallery', $this->data);
    }

    public function getMessageStudentsView()
    {

        $this->data['title'] = "Send Message";

        return view('stateadmin::message.students', $this->data);

    }

}
