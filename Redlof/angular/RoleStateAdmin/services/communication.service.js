(function() {

   "use strict";

   angular
      .module('app.role-stateadmin')
      .service('CommunicationService', CommunicationService);

   CommunicationService.$inject = ['$http', '$q', '$state', 'ApiHelper', 'DataTableService'];

   function CommunicationService($http, $q, $state, ApiHelper, DataTableService) {

      /* jshint validthis: true */
      var vm = this;
      vm.selectedUsers = [];
      vm.unSelectedUsers = [];
      vm.showSelected = false;

      vm.sendMail = function(data) {
         return ApiHelper.postData("stateadmin/communication/email", data);
      };

      vm.clear = function() {
         vm.selectedUsers = [];
         vm.unSelectedUsers = [];
         vm.showSelected = false;
      };
   }


})();