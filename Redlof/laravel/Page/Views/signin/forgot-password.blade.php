@include('page::includes.head')
@include('page::includes.header')

<section class="bg-lt-blue no-margin" ng-app="app" ng-controller="AppController">

  <div class="container">
    <div  class="form-lg-wrapper">
      <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="form-fields form-txt margin-t-30">
            <h3 class="text-center">
            Forgot Password
            </h3>
            <p class="">
              Enter your email address, and we'll send you a link so you can reset your password
            </p>
            <div class="form-content">
              <form class="common-form" name="forgotPassword" id="forgotPassword" ng-submit="create('password/email', formData, '')">
                <div class="row">
                  <div class="col-md-2 col-xs-12">
                      <label>Email</label>
                  </div>
                  <div class="col-md-10 col-xs-12">
                    <div class="form-group">
                      <input validator="required" valid-method="blur" type="email" class="form-control" ng-model="formData.email" required>

                    </div>
                  </div>
                </div>
                <div class="text-center margin-t-15 margin-b-15">
                  <button type="submit" class="btn-rounded btn-rounded-lg btn-signup">Reset Password</button>
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