(function() {

    "use strict";

    angular
        .module('app.role-stateadmin')
        .controller('DownloadReportController', DownloadReportController);

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
})();