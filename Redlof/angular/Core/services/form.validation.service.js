(function() {

    "use strict";

    angular
        .module('app.core')
        .service('FormValidationService', FormValidationService);

    FormValidationService.$inject = ['$http', '$q', 'Helper', '$rootScope'];

    function FormValidationService($http, $q, Helper, $rootScope) {

        /* jshint validthis: true */
        var vm = this;

        vm.check = function(msgArray) {

            // Check the rootscope valiable to get the last submitted form name
            // if the formname is not undefined or null or empty
            // Then remove form-error class from all the form fields
            // Then add class

            removeClass();

            // check foir the attrribute show-msg in the form
            // if its true then only proceed further in the loop
            // if its nopt defined, we assume its true

            // Get the last submitted form name
            // Get the object of the last submitted form 
            // Get the attribute from the form for show-msg
            // Check if defined and value is false then
            // return dont process further

            var checkShowMsg = checkShowMSgAttr();
            if (checkShowMsg === false) {
                return;
            }

            for (var key in msgArray) {

                if (msgArray.hasOwnProperty(key)) {
                    var element = document.getElementsByName(key)[0];

                    if (element) {
                        element.classList.add("form-error");

                        $(element).parent().find('.form-error-msg').remove();

                        $(element).parent().append("<span class='form-error-msg'>" + msgArray[key] + "</span>");


                    }

                }
            }

            var last_submitted_form_name = $rootScope.last_submitted_form_name;
            var formButtonObject = $("button[type=submit]", document.getElementsByName(last_submitted_form_name)[0]);
            $(formButtonObject).removeAttr('disabled');

        };

        vm.resetForm = function() {
            removeClass();
        };

        var removeClass = function() {
            var last_submitted_form_name = $rootScope.last_submitted_form_name;

            if (typeof last_submitted_form_name === 'undefined' ||
                last_submitted_form_name === '' ||
                last_submitted_form_name === null) {

                return;

            }

            var formObject = document.getElementsByName(last_submitted_form_name);

            if (formObject.length === 0) {
                return;
            }

            formObject = formObject[0];

            $(formObject).find('input, select, textarea').removeClass('form-error');
            $(formObject).find('.form-error-msg').remove();
        };

        var checkShowMSgAttr = function() {
            var last_submitted_form_name = $rootScope.last_submitted_form_name;

            if (typeof last_submitted_form_name === 'undefined' ||
                last_submitted_form_name === '' ||
                last_submitted_form_name === null) {

                return true;

            }

            var formObject = document.getElementsByName(last_submitted_form_name);

            if (formObject.length === 0) {
                return true;
            }

            formObject = formObject[0];

            var showMsg = $(formObject).attr('show-msg');

            if (typeof showMsg === 'undefined' ||
                showMsg === '' ||
                showMsg === null) {

                return true;

            }

            if (showMsg === 'true' ||
                showMsg === true) {

                return true;

            }

            return false;
        };

    }
})();