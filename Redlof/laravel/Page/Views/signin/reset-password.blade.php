@include('page::includes.head')
@include('page::includes.header')
<section class="bg-lt-blue" ng-app="app" ng-controller="AppController">
  <div class="container">
    <div  class="form-lg-wrapper form-fields">
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="form-sm-container reset-form">
            <h3 class="text-center">
            Reset Password
            </h3>
            <div class="">
              <form class="form-horizontal" name="forgotPassword" id="resetPassword" ng-submit="create('password/reset', formData, '')" ng-init="formData.token = '{!! $token !!}'">
                <div class="form-group">
                  <label class="col-md-4 control-label">New Password</label>
                  <div class="col-md-8">
                    <input ng-model="formData.password" validator="required" valid-method="blur" type="password" class="form-control" id="password-new" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-4 control-label">Confirm Password</label>
                  <div class="col-md-8">
                    <input ng-model="formData.password_confirmation" validator="required" valid-method="blur" type="password" class="form-control" id="password-input" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 col-xs-12">
                    <div class="text-center">
                      <button type="submit" class="btn-rounded btn-rounded-lg btn-signup">Reset Password</button>
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