(function() {

    "use strict";

    angular
        .module('app.role-schooladmin')
        .controller('SubjectController', SubjectController);

    SubjectController.$inject = ['Helper', 'AppTableListService', '$scope', 'ApiHelper', 'ServerMessage', '$rootScope', 'NgMap'];

    function SubjectController(Helper, AppTableListService, $scope, ApiHelper, ServerMessage, $rootScope, NgMap) {

        var vm = this;
        vm.formData = {};

        $scope.helper = Helper;
        $scope.pageId = Helper.findIdFromUrl();

        vm.classes = [];

        vm.formData.subjects = [];


        vm.getLevels = function() {


            ApiHelper.getData('schooladmin/get/class_levels').then(function(response) {

                vm.classes = response.data;

            });
        };

        vm.addSubject = function() {

            var subject = [];
            subject.name = '';

            vm.formData.subjects.push(subject);

        };



        vm.addSubject();



    }

})();