@include('member::includes.head')
@include('member::includes.header')
<section class="bg-lt-blue">
  <div class="container">
    <div  class="form-lg-wrapper form-fields">
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="form-sm-container reset-form">
            <div class="row">
              <div class="col-md-3 col-xs-12">
              </div>
              <div class="col-md-9 col-xs-12">
                <h3 class="text-center">
                Change Password
                </h3>
              </div>
            </div>
            <div class="">
              <form class="form-horizontal" name="forgotPassword" id="resetPassword">
                <div class="form-group">
                  <label class="col-md-4 control-label">Old Password</label>
                  <div class="col-md-8">
                    <input ng-model="formData.password" validator="required" valid-method="blur" type="password" class="form-control" id="password-new" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">New Password</label>
                  <div class="col-md-8" >
                    <input ng-model="formData.password" show-hide-input validator="required" valid-method="blur" type="password" class="form-control" id="password-new" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Confirm Password</label>
                  <div class="col-md-8">
                    <input ng-model="formData.password_confirmation" show-hide-input validator="required" valid-method="blur" type="password" class="form-control" id="password-input" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-xs-12">
                    <div class="text-center">
                      <button style="submit" class="btn-rounded btn-rounded-lg btn-signup">Change Password</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@include('page::includes.footer-static')
@include('page::includes.foot')