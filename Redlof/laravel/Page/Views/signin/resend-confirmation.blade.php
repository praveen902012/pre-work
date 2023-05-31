<!-- Algo

1) Add resend verification link in signin page itself
2) Reset password link should take user to resend-verification page
3) In resend password link you have email field


4) there would be route with post method
5) Check whether email id entered by user exists or not
6) If not then message user not registered
7) Check if user registered and verified then message please login user already verifed
8)If user is not verified send him verification link on his mail id -->



@include('page::includes.head')
@include('page::includes.header')

<section class="content-area" ng-app="app" ng-controller="AppController">
  <div class="container">
    <div class="row">
      <div class=" col-sm-offset-4 col-sm-4 col-xs-12">
        <div class="form-box">
          <h3>
            Resend confirmation link
          </h3>

            <form ng-submit="create('member/resend/confirmation', formData)" class="common-form">
            <div class="form-group form-field">

              <label>Email</label>
              <input type="email" ng-model="formData.email" class="form-control" required>
            </div>
             <button type="submit" class="btn btn-block btn-success">Resend</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@include('page::includes.footer')
@include('page::includes.foot')