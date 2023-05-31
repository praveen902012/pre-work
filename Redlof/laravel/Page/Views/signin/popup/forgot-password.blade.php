<section class="signin custom-popup" ng-app="app" ng-controller="AccountController as member">
    <div class="container-fluid">
        <div class="row">
            <div class="text-center">
                <div class="margin-b-30">
                    <img src="{!! asset('img/rte-logo-blue.png') !!}" class="img-responsive center-block">
                    <i class="fa fa-times close " aria-hidden="true" ng-click="closeThisDialog(0)"></i>
                </div>
                <ul class="list-unstyled no-margin">

                    <li class="margin-b-20">
                        <a href="" class="btn btn-rounded btn-rounded-color btn-gplus" ng-click="user.signinSocial('google')">
                            <i class="fa fa-google-plus " aria-hidden="true"></i>  &nbsp;
                            Google
                        </a>
                    </li>
                    <li class="margin-b-20">
                        <a href="" class="btn btn-rounded btn-rounded-color btn-fb" ng-click="user.signinSocial('facebook')">
                            <i class="fa fa-facebook " aria-hidden="true"></i>  &nbsp;
                            Facebook
                        </a>
                    </li>
                    <li class="margin-b-20">
                        <a href="" class="btn btn-rounded btn-rounded-color btn-twitter" ng-click="user.signinSocial('google')">
                            <i class="fa fa-twitter" aria-hidden="true"></i>  &nbsp;
                            Twitter
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-12 col-xs-12">
                <div class="form-wrapper form-fields text-center">
                    <form ng-submit="member.signin(member.signInData, 'signin_form')" id="signin_form" name="signin_form" class="">
                        <div class="form-group">
                            <input name="email" validator="required" valid-method="blur" type="email" class="form-control" ng-model="member.signInData.email" required placeholder="Email">
                        </div>
                        <div class="form-group" >
                            <input name="password" validator="required" valid-method="blur" type="password" class="form-control" id="password-input" ng-model="member.signInData.password" required placeholder="Password">
                        </div>
                        <div class="">
                            <div class="row">
                                <div class="col-sm-6 col-xs-6">
                                    <div class="text-center">
                                        <a href="{{ route('forgotpassword.get')}}" class="forgt-passwrd">
                                            Forgot Password?
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="text-center">
                                        <button type="submit" class="btn-signin btn-rounded">Sign In</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="text-center new-user">
                        <button class="btn-rounded btn-signin btn-rounded-lg" href="{{ route('signup.get')}}">Sign up with email</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <p>
                    Terms & Conditions
                </p>
            </div>
        </div>
    </div>
</section>