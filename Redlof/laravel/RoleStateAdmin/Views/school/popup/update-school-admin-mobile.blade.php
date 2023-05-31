
<section class="" ng-controller="AppController">

	<div class="header-popup-ad">
		<h2>
		    Update School Admin Details
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
    </div>
    
    <div ng-controller="SchoolController as School">
        <div class="popup-content-ad" ng-init="School.getSchoolAdminDetails('stateadmin/get/school-admin/'+[[helper.school_id]])">
            <form name="add-subject" class="common-form add-area" ng-submit="create('stateadmin/school-admin/update', School.schoolData.user)">
                {{-- <div class="form-group row">
                    <label style="margin-left: 16px;">User Name</label>
                    <div class="col-sm-10">
                        <input type="text" ng-model="School.schoolData.user.username" class="form-control" id="username" placeholder="User Name" required>
                    </div>
                </div> --}}

                {{-- <div class="form-group row">
                    <label style="margin-left: 16px;">Email-ID</label>
                    <div class="col-sm-10">
                        <input type="email" ng-model="School.schoolData.user.email" class="form-control" id="email" placeholder="Email" required>
                    </div>
                </div> --}}

                <div class="form-group row">
                    <label style="margin-left: 16px;">Mobile Number</label>
                    <div class="col-sm-10">
                        <input type="text" ng-model="School.schoolData.user.phone" class="form-control" id="mobile" placeholder="Mobile" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-theme">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>