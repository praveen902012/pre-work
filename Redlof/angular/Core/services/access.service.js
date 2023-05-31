(function() {

    "use strict";

    angular
        .module('app.core')
        .service('AccessService', AccessService);

    AccessService.$inject = ['$http', '$rootScope', '$q', '$state', 'AuthService', 'Helper', '$compile'];

    function AccessService($http, $rootScope, $q, $state, AuthService, Helper, $compile) {

        /* jshint validthis: true */
        var vm = this;

        vm.authRedirectionHandler = function() {
            var user = Helper.getUser();

            if (!user) {
                $state.go('page.home');
            } else {
                $state.go(user.role + '.dashboard');
            }
        };

        vm.setRootScopeData = function() {

            var user = Helper.getUser();

            if (user) {
                $rootScope.authenticated = true;

            } else {
                $rootScope.authenticated = false;
                $rootScope.currentUser = null;
                $rootScope.User = null;
                $rootScope.Member = null;
            }
        };
    }

})();