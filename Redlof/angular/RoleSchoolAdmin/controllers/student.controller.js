(function() {

    "use strict";

    angular
        .module('app.role-schooladmin')
        .controller('StudentController', StudentController);

    StudentController.$inject = ['Helper', 'AppTableListService', '$scope', 'ApiHelper', 'ServerMessage', '$rootScope', 'NgMap', 'Toast'];

    function StudentController(Helper, AppTableListService, $scope, ApiHelper, ServerMessage, $rootScope, NgMap, Toast) {

        var vm = this;

        vm.classData = {};

        vm.studentData = {};

        vm.monthData = {};

        vm.subjectData = {};

        vm.admissionCycle = {};

        vm.initAdmissionCycle = function() {


            ApiHelper.getData('schooladmin/get/applicationcycle').then(function(response) {

                vm.admissionCycle = response.data;

            });

        };

        vm.initClass = function() {


            ApiHelper.getData('schooladmin/get/class_levels').then(function(response) {

                vm.classData = response.data;

            });
        };

        vm.getAttendanceMonths = function(registration_id) {

            ApiHelper.getData('schooladmin/get/attendance/' + registration_id).then(function(response) {

                vm.monthData.attendances = response.data;

            });

        };

        vm.getSubjects = function(level_id, registration_id) {

            ApiHelper.getData('schooladmin/get/check/' + registration_id + '/allsubjects/' + level_id).then(function(response) {

                vm.subjectData.marks = response.data;

            });

        };

        vm.calcPerc = function(td, ad) {

            var p = (ad / td) * 100;

            if (p > 0) {
                return p;
            } else {
                return 0;
            }

        };

        vm.checkValid = function(td, ad) {

            if (ad > td) {
                return true;
            }


        };

        vm.checkValidMonth = function(td) {

            if (td > 31) {
                return true;
            }
        };

        vm.checkGrade = function(mm, om) {
            if (om > mm) {
                return true;
            }
        };

    }



})();