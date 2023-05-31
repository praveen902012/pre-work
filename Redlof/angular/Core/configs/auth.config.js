(function() {

    "use strict";

    angular.module('app.core')
        .config(AuthConfiguration);

    AuthConfiguration.$inject = ['$authProvider', '$httpProvider', '$provide'];

    function AuthConfiguration($authProvider, $httpProvider, $provide) {

        $httpProvider.useApplyAsync(true);

        redirectWhenLoggedOut.$inject = ['$q', '$injector'];

        function redirectWhenLoggedOut($q, $injector) {

            return {

                responseError: function(rejection) {

                    var $state = $injector.get('$state');

                    var rejectionReasons = ['token_not_provided', 'token_expired', 'token_absent', 'token_invalid'];

                    angular.forEach(rejectionReasons, function(value, key) {
                        if (rejection.data !== null) {
                            if (rejection.data.error === value) {
                                localStorage.removeItem('redlof_token');

                                window.location = AppConst.url;
                            }
                        }

                    });

                    return $q.reject(rejection);
                }
            };
        }



        // Setup for the $httpInterceptor
        $provide.factory('redirectWhenLoggedOut', redirectWhenLoggedOut);

        // Push the new factory onto the $http interceptor array
        $httpProvider.interceptors.push('redirectWhenLoggedOut');

        $authProvider.tokenName = 'token';
        $authProvider.tokenPrefix = 'redlof';


    }


})();