(function() {

    "use strict";

    angular
        .module('app.role-stateadmin')
        .controller('LotteryController', LotteryController);

    LotteryController.$inject = ['Helper', 'AppTableListService', '$scope', 'ApiHelper', 'ServerMessage', '$rootScope', 'NgMap', 'Toast'];

    function LotteryController(Helper, AppTableListService, $scope, ApiHelper, ServerMessage, $rootScope, NgMap, Toast) {

        var vm = this;

        vm.previousLotterySessions = [];

        vm.triggerLottery = function(API) {

            $rootScope.openPopup('stateadmin', 'lottery', 'lottery-processing', 'create-popup-style sm-popup-style');

            ApiHelper.postData(API).then(function(response) {

                Toast.success(response.msg);
                location.reload();

            });

        };

        vm.triggerNotification = function(API) {

            $rootScope.openPopup('stateadmin', 'lottery', 'notification-processing', 'create-popup-style sm-popup-style');

            ApiHelper.postData(API).then(function(response) {

                Toast.success(response.msg);
                location.reload();

            });

        };

        vm.editLottery = function(lottery_id) {

            ApiHelper.getAPIData('stateadmin/lottery/' + lottery_id).then(function(response) {
                vm.formData = response.data;
                vm.formData.reg_start_date = response.data.orig_reg_start_date;
                vm.formData.reg_end_date = response.data.orig_reg_end_date;
                vm.formData.stu_reg_start_date = response.data.orig_stu_reg_start_date;
                vm.formData.stu_reg_end_date = response.data.orig_stu_reg_end_date;                                     
                                                
            });

        };

        vm.getPreviousLotteries = function(API) {

            Toast.success('Loading data. Please wait..');

            ApiHelper.getData(API).then(function(response) {

                if(response.data.items.length > 0){

                    vm.previousLotterySessions = response.data.items.map(e => e.session_year);
                }
            });

        };
        

    }

})();