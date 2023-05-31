(function () {

    "use strict";

    angular
        .module('app.role-admin')
        .controller('DownloadReportController', DownloadReportController);

    DownloadReportController.$inject = ['Helper', 'ApiHelper'];

    function DownloadReportController(Helper, ApiHelper) {

        /* jshint validthis: true */
        var vm = this;
        vm.inProcess = false;

        vm.triggerDownload = function (Api, data) {

            vm.inProcess = true;

            ApiHelper.addItem(Api, data)
                .then(function (response) {

                    vm.inProcess = false;

                    prepareDownload(response.data, function () {
                        location.reload();
                    });

                }).catch(function () {
                    vm.inProcess = false;
                });

        };

        function prepareDownload(response, callback) {
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

            callback();
        }

        vm.initDownload = function (Api, data = {}) {

            vm.inProcess = true;

            ApiHelper.addItem(Api, data)
                .then(function (response) {

                    vm.inProcess = false;

                    prepareDownload2(response.data);

                }).catch(function () {
                    vm.inProcess = false;
                });

        };

        function prepareDownload2(response) {
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