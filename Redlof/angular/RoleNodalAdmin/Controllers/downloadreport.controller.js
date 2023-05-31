(function() {

    "use strict";

    angular
        .module('app.role-nodaladmin')
        .controller('DownloadReportController', DownloadReportController)
        .controller('ToBeVerifiedStudent', ToBeVerifiedStudent);

    DownloadReportController.$inject = ['Helper', 'ApiHelper'];

    function DownloadReportController(Helper, ApiHelper) {

        /* jshint validthis: true */
        var vm = this;

        vm.inProcess = false;

        vm.triggerDownload = function(Api) {

            vm.inProcess = true;

            ApiHelper.addItem(Api, {}).then(function(response) {

                vm.inProcess = false;

                prepareDownload(response.data);

            }).catch(function () {
                
                vm.inProcess = false;
            });

        };

        function prepareDownload(response) {
            var anchor = angular.element('<a/>');
            anchor.css({
                display: 'none'
            });
            angular.element(document.body).append(anchor);
            anchor.attr({
                href: response.data,
                target: '_blank',
                download: response.filename
            })[0].click();
        }

    }

    ToBeVerifiedStudent.$inject = ['Helper', 'ApiHelper','Toast', '$scope', 'ngDialog'];

    function ToBeVerifiedStudent(Helper, ApiHelper,Toast,$scope, ngDialog) {

        var vm = this;
        vm.searchschool = '';
        vm.allschools = [];
        
        $scope.buttonData = 1;
        $scope.buttonValue = '';

        $scope.$watch('buttonData', function(){
            $(".btn-docverify"+$scope.buttonData).html('<button style="width:90%" class="btn btn-primary">'+$scope.buttonValue+'</button>')
        })

        vm.documentVerifyStudent = function(id,th) {

            ApiHelper.getAPIData('nodaladmin/students/verify/'+id).then(function(response) {
                $scope.buttonData = id;
                $scope.buttonValue = 'Verified';
                Toast.show('Student Verified');
                return;
            });
        };

        vm.documentRejectStudent = function(id, API, formData) {

            ApiHelper.addItem(API, formData).then(function(response) {
                $scope.buttonData = id;
                $scope.buttonValue = 'Rejected';
                Toast.show('Student Rejected');
                setTimeout(function() { ngDialog.closeAll() }, 1000);
                return;
            });
        };

    }


})();