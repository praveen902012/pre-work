(function() {

    "use strict";

    angular
        .module('app.role-stateadmin')
        .service('NotificationService', NotificationService);

    NotificationService.$inject = ['ApiHelper'];

    function NotificationService(ApiHelper) {

        /* jshint validthis: true */
        var vm = this;

        vm.all_users = [];

    }

})();