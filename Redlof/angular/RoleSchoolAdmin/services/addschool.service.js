(function() {

  "use strict";

  angular
    .module('app.role-schooladmin')
    .service('AddSchoolService', AddSchoolService);

  AddSchoolService.$inject = ['$http', '$q', 'ApiHelper', '$rootScope', 'Helper'];

  function AddSchoolService($http, $q, ApiHelper, $rootScope, Helper) {

    /* jshint validthis: true */
    var vm = this;

    vm.config = {};



  }


})();