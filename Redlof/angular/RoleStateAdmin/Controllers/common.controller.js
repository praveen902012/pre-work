(function() {

    "use strict";

    angular
        .module('app.role-stateadmin')
        .controller('CommonController', CommonController);

    CommonController.$inject = ['Helper', 'AppTableListService', '$scope', 'ApiHelper', 'ServerMessage', '$rootScope', 'NgMap'];

    function CommonController(Helper, AppTableListService, $scope, ApiHelper, ServerMessage, $rootScope, NgMap) {

        var vm = this;
        vm.assignData = [];
        vm.nodaladmins;
        vm.already_assigned_nodaladmins;
        vm.log = [];

        vm.getNodalAdmins = function(API) {

            vm.assignData = [];
            vm.nodaladmins = "";

            ApiHelper.getAPIData(API).then(function(response) {

                vm.nodaladmins = response.data.statenodal;

                vm.already_assigned_nodaladmins = response.data.block_assigned_admin;

                var log = [];

                angular.forEach(vm.already_assigned_nodaladmins, function(value, key) {

                    this.push(value.state_nodals_id);
                }, log);


                angular.forEach(vm.nodaladmins, function(nodalvalue, nodalkey) {

                    if(log.indexOf(nodalvalue.id) != -1){

                        nodalvalue.display = false;
                    }else{

                        nodalvalue.display = true;
                    }
                });

                console.log(vm.nodaladmins);
            });
        };

        vm.selectNodalAdmins = function(Data) {

            vm.assignData = Data;

            angular.forEach(vm.nodaladmins, function(nodalvalue, nodalkey) {

                nodalvalue.display = true;

            });

            angular.forEach(vm.nodaladmins, function(nodalvalue, nodalkey) {
                
                angular.forEach(Data.nodaladmin, function(value, key) {
                
                    if(nodalvalue.id == value ){
                        
                        nodalvalue.display = false;
                    }
                });
            });
        };

    }

})();