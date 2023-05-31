(function() {

    "use strict";

    angular
        .module('app.core')
        .service('AuthService', AuthService);

    AuthService.$inject = ['$http', '$auth', '$rootScope', 'ApiHelper', '$state', '$cookies', 'ngDialog'];

    function AuthService($http, $auth, $rootScope, ApiHelper, $state, $cookies, ngDialog) {

        /* jshint validthis: true */
        var vm = this;

        vm.inProcess = false;

        vm.signin = function(AuthObject) {

            AuthObject.credentials.role_type = AuthObject.role_type;

            $auth.login(AuthObject.credentials, {
                    url: AuthObject.signin_url
                })
                .then(function(response) {
                    vm.inProcess = false;
                    if (response) {
                        ngDialog.closeAll();
                        vm.setSignedUserDetails(response, AuthObject);
                    }
                }).catch(function(){
                    vm.inProcess = false;
                });
        };

        vm.SignOut = function(redirect_url) {

            // TODO need to make api and do proper signout with ttoken

            if (typeof redirect_url === 'undefined') {
                redirect_url = '/';
            }

            $http.get(AppConst.api_url + "auth/signout")
                .then(function(response) {

                    $auth.logout()
                        .then(function(resp) {

                            localStorage.removeItem('redlof_current_role');
                            localStorage.removeItem('redlof_token');

                            $cookies.remove('redlof_token', {
                                path: '/'
                            });

                            $cookies.remove('redlof_tw_token', {
                                path: '/'
                            });

                            $cookies.remove('redlof_tw_connect', {
                                path: '/'
                            });

                            window.location = root + '/' + redirect_url;
                        });

                });
        };

        vm.updateToken = function(redlof_token) {
            $auth.setToken(redlof_token);
        };

        vm.setSignedUserDetails = function(response, AuthObject) {
            $rootScope.authenticated = true;
            $rootScope.currentUser = $auth.getPayload(); // TODO::REMOVE

            localStorage.setItem('redlof_current_role', AuthObject.role_type);

            if (response.data.show) {
                AuthObject.redirect_state = response.data.show.redirect_state;
            }

            window.location = AuthObject.redirect_state;
        };

        $rootScope.signout = function(redirect_to) {
            vm.SignOut(redirect_to);
        };
    }

})();