(function() {

    "use strict";

    angular
        .module('app.role-districtadmin')
        .controller('SchoolController', SchoolController);

    SchoolController.$inject = ['Helper', 'AppTableListService', '$scope', 'ApiHelper', 'ServerMessage', '$rootScope', 'NgMap', 'Toast'];

    function SchoolController(Helper, AppTableListService, $scope, ApiHelper, ServerMessage, $rootScope, NgMap, Toast) {

        var vm = this;
        vm.nodalData = {};
        vm.admissionCycle = {};
        vm.schoolData = {};

        vm.initNodalAdmin = function() {


            ApiHelper.getData('districtadmin/get/districtnodaladmin').then(function(response) {

                vm.nodalData = response.data;

            });
        };

        vm.initAdmissionCycle = function() {


            ApiHelper.getData('districtadmin/get/applicationcycle').then(function(response) {

                vm.admissionCycle = response.data;

            });

        };

        vm.initSchools = function() {


            ApiHelper.getData('districtadmin/get/schools/list').then(function(response) {

                vm.schoolData = response.data;

            });
        };



    }

})();