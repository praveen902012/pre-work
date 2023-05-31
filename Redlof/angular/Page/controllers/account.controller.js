(function() {

    "use strict";

    angular
        .module('app.page')
        .controller('AccountController', AccountController);

    AccountController.$inject = ['$scope', '$state', '$auth', 'AuthService', 'Toast', '$stateParams', '$cookies'];

    function AccountController($scope, $state, $auth, AuthService, Toast, $stateParams, $cookies) {

        /* jshint validthis: true */
        var vm = this;
        vm.signInData = {};
        vm.signUpData = {};
        vm.authService = AuthService;

        vm.signin = function(credentials, url) {

            vm.authService.inProcess = true;

            var AuthObject = {};

            AuthObject.signin_url = AppConst.api_url + url;

            AuthObject.credentials = credentials;

            AuthService.signin(AuthObject);
        };

        vm.signup = function(signUpData) {
            signUpData.role_type = 'role-member';
            var options = {
                url: AppConst.api_url + 'member/signup'
            };

            $auth.signup(signUpData, options)
                .then(function(response) {
                    Toast.success(response.data.msg);
                    vm.signUpData = {};

                });
        };
    }

})();