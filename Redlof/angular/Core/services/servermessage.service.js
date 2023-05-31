(function () {

    "use strict";

    angular
        .module('app.core')
        .service('ServerMessage', ServerMessage);

    ServerMessage.$inject = ['Toast', '$rootScope', '$state', 'ngDialog'];

    function ServerMessage(Toast, $rootScope, $state, ngDialog) {

        /* jshint validthis: true */
        var vm = this;

        vm.show = function (response, options) {

            if (response === '') {
                return;
            }

            if (response.close != 'undefined' && response.close === true) {
                ngDialog.closeAll();
            }


            if (response.data !== undefined) {


                if (response.data.redirect != undefined) {
                    vm.redirect(response);
                }

                if (response.data.reload != undefined) {
                    vm.reload(response);
                }

                if (response.data.popup != undefined) {
                    vm.showPopUp(response);
                }

                if (response.msg !== undefined && response.msg !== null && response.msg.length > 0) {
                    return Toast.show(response, options);
                }

            }

            if (response.error === true) {
                return Toast.show(response, options);
            }

            return true;

        };

        vm.hideLoader = function (toastObject) {
            Toast.hide(toastObject);
        };

        vm.showPopUp = function (response) {

            var role = response.data.popup[0];
            var module = response.data.popup[1];
            var file = response.data.popup[2];
            var uiclass = response.data.popup[3];
            var data = response.data.popup[4];

            $rootScope.openPopup(role, module, file, uiclass, data);
        };

        vm.redirect = function (response) {

            if (typeof response.data.redirect !== 'undefined') {
                window.location = response.data.redirect;
            }

        };

        vm.reload = function (response) {

            if (typeof response.data.reload !== 'undefined') {
                window.location.reload();
            }

        };

        vm.loading = function (msg) {

            if (typeof msg === 'undefined') {
                msg = "Loading...";
            }

            var loader = vm.show({
                'msg': msg,
                'data': []
            }, {
                timeOut: 0,
                loader: true,
            });

            $rootScope.showingLoader = loader;

            return loader;

        };
    }

})();