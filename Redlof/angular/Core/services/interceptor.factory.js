(function() {

    "use strict";

    angular
        .module('app.core')
        .factory('InterceptorFactory', InterceptorFactory);

    InterceptorFactory.$inject = ['$q', '$injector', '$rootScope'];

    function InterceptorFactory($q, $injector, $rootScope) {

        return {

            request: function(config) {
                // do something on success

                return config;
            },

            requestError: function(config) {
                // console.log( config );

                // do something on success
                return config;
            },

            response: function(responseObj) {
                // do something on success
                // console.log( responseObj );

                //return $q.resolve(responseObj.data);
                return responseObj || $q.when(responseObj);
            },

            responseError: function(rejection) {

                var Helper = $injector.get('Helper');
                var ServerMessage = $injector.get('ServerMessage');
                var Toast = $injector.get('Toast');
                var State = $injector.get('$state');
                var cookies = $injector.get('$cookies');
                var FormValidationService = $injector.get('FormValidationService');
                var rootScope = $injector.get('$rootScope');

                // validation error
                // check for the response status code
                // if its 422 that means its validation error
                // check the form-name from the view
                // for each of the msg in msgArray,loop through the data
                // now find the input element in the form
                // add class to the input element
                // in future we would make it such a way that text also starts appearing below the input

                if (rejection.status == 422) {

                    if (rejection.data.msgArray) {

                        var msgArray = rejection.data.msgArray;

                        FormValidationService.check(msgArray);
                    }

                }

                if (typeof rootScope.last_submitted_form_name !== 'undefined' && rootScope.last_submitted_form_name !== null) {

                    var formname = rootScope.last_submitted_form_name;
                    var formButtonObject = $("button[type=submit]", document.getElementsByName(formname)[0]);
                    $(formButtonObject).removeAttr('disabled');

                }


                if (typeof rejection.data === 'undefined') {

                    localStorage.removeItem('redlof_token');
                    cookies.remove('redlof_token', {
                        path: '/'
                    });

                    window.location = AppConst.url;

                    return;
                }

                Helper.hideSpinner();

                // Token is invalid or expired
                if (rejection.data.msg === 'Token expired' || rejection.data.msg === 'token_invalid') {
                    Toast.error("Your token has been expired or its invalid");
                    $rootScope.authenticated = false;
                    $rootScope.currentUser = null;
                    localStorage.removeItem('redlof_token');

                    cookies.remove('redlof_token', {
                        path: '/'
                    });

                    setTimeout(function() {
                        window.location = AppConst.url;
                    }, 1000);

                } else {
                    ServerMessage.show(rejection.data, {
                        timeOut: 6000
                    });
                }

                return $q.reject(rejection);
            }
        };
    }

})();