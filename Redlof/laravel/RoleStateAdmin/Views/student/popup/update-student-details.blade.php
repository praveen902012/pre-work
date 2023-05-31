
<section class="form-popup" ng-controller="AppController">

	<div class="header-popup-ad">
		<h2>
		    Update Student Details
		</h2>
		<div class="popup-rt">
			<i class="ion-close-round close-icon" ng-click="closeThisDialog()"></i>
		</div>
    </div>

    <div ng-controller="Step1Controller as Step1" ng-init="student=helper.student;formData={}">

        <div class="popup-content-ad" ng-init="formData.id=student.id">
            <form name="add-subject" class="common-form add-area" ng-submit="create('stateadmin/student-phone/update', formData)">

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label>
                                First Name <span class="mand-field">*</span>
                                <p class="hindi-lbl">
                                    (पहला नाम) <span class="mand-field">*</span>
                                </p>
                            </span>
                            <input type="text" id="name" ng-init="formData.first_name=student.first_name" ng-model="formData.first_name" class="form-control" required>
                        </div>

                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label>
                                Middle Name
                                <p class="hindi-lbl">
                                    (मध्य नाम)
                                </p>

                            </label>
                            <input type="text" id="name" ng-init="formData.middle_name=student.middle_name" ng-model="formData.middle_name" class="form-control" >
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label>
                                Last Name
                                <p class="hindi-lbl">
                                    (आखिरी नाम)
                                </p>
                            </label>
                            <input type="text" id="name" ng-init="formData.last_name=student.last_name" ng-model="formData.last_name" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label>
                                Mobile Number
                                <p class="hindi-lbl">
                                    (आखिरी नाम)
                                </p>
                            </label>
                            <input type="text" id="mobile" ng-init="formData.mobile=student.mobile" ng-model="formData.mobile" placeholder="Mobile" class="form-control" required>
                        </div>
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
