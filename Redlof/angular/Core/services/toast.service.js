(function() {

    "use strict";

    angular
        .module('app.core')
        .service('Toast', Toast);

    Toast.$inject = ['toastr'];

    function Toast(toastr) {

        /* jshint validthis: true */
        var vm = this;

        vm.options = {};

        vm.show = function(response, settings) {
            var msg = '';

            if (typeof settings !== 'undefined') {
                vm.options.timeOut = settings.timeOut;
            }

    
            msg = (typeof response.msg === 'undefined') ? response : response.msg;

            if (typeof msg === 'undefined') {
                return;
            }

            if (typeof msg !== 'string') {
                return;
            }

            if (typeof response.error !== 'undefined' && response.error === true) {
                return vm.error(msg);
            } else {
                return vm.success(msg);
            }
        };

        vm.success = function(msg, title) {
            return toastr.success(msg, title, vm.options);
        };

        vm.info = function(msg, title) {
            return toastr.info(msg, title, vm.options);
        };

        vm.error = function(msg, title) {
            return toastr.error(msg, title, vm.options);
        };

        vm.warning = function(msg, title) {
            return toastr.warning(msg, title, vm.options);
        };

        vm.hide = function(toastObject) {
            toastr.clear(toastObject);
        };
    }

})();