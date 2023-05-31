(function() {

	"use strict";

	angular.module('app', [

		'app.core',
		'app.role-nodaladmin'

	]);

})();
(function() {

	"use strict";

	angular
		.module('app')
		.run(appStart);

	appStart.$inject = ['AccessService', '$rootScope'];

	function appStart(AccessService, $rootScope) {

		// Handle rootscope variables
		AccessService.setRootScopeData();

		$rootScope.$back = function() {
			window.history.back();
		};

		$rootScope.$on('$locationChangeStart', function() {
			$("html, body").animate({
				scrollTop: 0
			}, 0);
		});
	}

})();
(function() {

"use strict";

angular.module('app.role-nodaladmin', ['app.core']);

})();

(function() {

    "use strict";

    angular.module('app.core', [

        'ui.router',
        'satellizer',
        'ngAnimate',
        'ngMaterial',
        'ngFileUpload',
        'ngSanitize',
        'ngDialog',
        'ui.select',
        'ui.bootstrap',
        'angularSpinner',
        'toastr',
        'oitozero.ngSweetAlert',
        'uiSwitch',
        'ui.bootstrap.datetimepicker',
        'angularTrix',
        'ngCookies',
        'angular-flexslider',
        'angularScreenfull',
        'infinite-scroll',
        '720kb.socialshare',
        'mdPickers',
        'ngclipboard',
        'sn.addthis',
        'ngEmoticons',
        'ngMap',
        'nvd3',
    ]);

})();
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
(function() {

    "use strict";

    angular
        .module('app.core')
        .service('ListFilterService', ListFilterService);

    ListFilterService.$inject = ['$http', '$q', 'Helper'];

    function ListFilterService($http, $q, Helper) {

        /* jshint validthis: true */
        var vm = this;

        vm.Lists = [];

        vm.init = function(ListId, API) {
            // you are gonna do some cool features... 
            // I am sure as a developer you dont mind doing some initilization at the fist
            // what all?
            // how about you pass me the API you would be talking to
            // I would store it for you, so that you dont need to tell me that every time?
            // yeah thats sounds cool...
            // Also... I would pass you and unqiue key to talk to me... so that next time you call.. I know who are you
            // Yeah.. is that neccarssy?
            // yea... I server many clients and it becomes nightmare for me to manage stuff at times...
            // Not only that... I would store all the data for you... so you need not worry about data storagae

            // ListId - unque slug name which you want give for your list... make sure its unqie in the platform
            // API - your API to fecth the results

            vm.Lists[ListId] = [];
            vm.Lists[ListId].API = API;
            vm.Lists[ListId].results = [];
            vm.Lists[ListId].needle = 0;
            vm.Lists[ListId].pagesize = 6;
            vm.Lists[ListId].totalCount = 0;
            vm.Lists[ListId].params = [];
            vm.Lists[ListId].lastpage = true;

            // initialize the list & call next page
            vm.nextPage(ListId);

            return vm.Lists[ListId];
        };

        vm.nextPage = function(ListId) {
            // get the data based on the needle & offset
            vm.getPage(ListId)
                .then(function(response) {
                    vm.Lists[ListId].results = vm.Lists[ListId].results.concat(response.items);
                    vm.Lists[ListId].totalCount = response.total;

                    // incement the page count .. offsetr
                    vm.Lists[ListId].needle = vm.Lists[ListId].needle + response.items.length;
                    // Last page flag
                    vm.Lists[ListId].lastpage = response.items.length < vm.Lists[ListId].pagesize ? true : false;

                    if (response.items.id !== 'undefined') {
                        vm.Lists[ListId].lastpage = true;
                    }
                });
        };

        vm.getPage = function(ListId) {
            var deferred = $q.defer();

            Helper.showSpinner();

            var listparams = vm.createParams(ListId);

            $http.get(AppConst.api_url + vm.Lists[ListId].API, {
                    params: listparams
                })
                .success(function(response) {
                    Helper.hideSpinner();
                    deferred.resolve(response.data);
                });

            return deferred.promise;
        };

        vm.createParams = function(ListId) {
            // here I would smartly create the param object for your API
            // as of now I don't need anything extra from your side
            // But I see that in very near future.. I would need the data/selections done by your user on the left panel
            // basically your filter data

            // I would take the data & create the params for you & smartly inject the same to the query
            // Also.. I keep contextual information, so your subequent call can have just the difference data

            var Params = [];
            Params.skip = vm.Lists[ListId].needle;
            Params.limit = vm.Lists[ListId].pagesize;

            vm.Lists[ListId].params = Params;

            return Params;
        };

    }
})();
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
(function() {

    "use strict";

    angular
        .module('app.core')
        .service('Helper', Helper);

    Helper.$inject = ['$state', '$sce', '$rootScope', 'SatellizerShared', 'Upload', 'ngDialog', '$timeout', '$location', 'usSpinnerService', '$mdpDatePicker', '$mdpTimePicker'];

    function Helper($state, $sce, $rootScope, SatellizerShared, Upload, ngDialog, $timeout, $location, usSpinnerService, $mdpDatePicker, $mdpTimePicker) {

        /* jshint validthis: true */
        var vm = this;
        vm.currentObject = {};

        vm.handlePageShow = function() {
            var user = vm.getUser();
            if (user) {
                var role = user.role.substring(5);
                $rootScope.authenticated = true;
                $rootScope.currentUser = user;
                $state.go(role + '.dashboard');

            } else {

                $rootScope.authenticated = false;
                $rootScope.currentUser = null;

            }
            return;
        };

        vm.getTheArrIndex = function(data, id) {
            if (data.length === 0) {
                return null;
            }
            var keepGoing = true;
            var keyVal = null;
            angular.forEach(data, function(val, key) {

                if (keepGoing) {

                    if (parseInt(val.id) === parseInt(id)) {
                        keyVal = key;
                        keepGoing = false;
                    }
                }
            });

            return keyVal;
        };

        vm.getTheArrIndexByKey = function(data, id, keymatch) {
            if (data.length === 0) {
                return null;
            }

            if (typeof keymatch === 'undefined') {
                keymatch = 'id';
            }

            var keepGoing = true;
            var keyVal = null;
            angular.forEach(data, function(val, key) {

                if (keepGoing) {

                    if (val[keymatch] === id) {
                        keyVal = key;
                        keepGoing = false;
                    }
                }
            });

            return keyVal;
        };


        vm.resetForm = function(FormName) {
            $('form[name="' + FormName + '"]')[0].reset();
        };

        vm.getUser = function() {
            return SatellizerShared.getPayload();
        };

        $rootScope.openPopup = function(role, module, file, classname, dataToSend) {

            if (typeof classname == 'undefined' || classname === '') {
                classname = 'create-popup-style';
            }

            ngDialog.open({
                template: AppConst.url + "/popup/" + role + "/" + module + '.popup.' + file,
                className: classname + ' ngdialog-theme-default',
                closeByDocument: false,
                closeByEscape: true,
                data: dataToSend
            });
        };


        $rootScope.openPopupInstant = function(templateId, classname, dataToSend) {

            if (typeof classname == 'undefined' || classname === '') {
                classname = 'create-popup-style';
            }

            ngDialog.open({
                template: templateId,
                className: classname + ' ngdialog-theme-default',
                closeByDocument: false,
                closeByEscape: false,
                data: dataToSend
            });
        };


        $rootScope.switchRole = function(role) {
            localStorage.setItem('redlof_current_role', role);
            var state = $state.get(role + '.dashboard');
            $location.replace();
            window.location.href = root + state.url;
        };

        vm.slugify = function(text) {
            return text.toString().toLowerCase().trim()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/&/g, '-and-') // Replace & with 'and'
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/\-\-+/g, '-'); // Replace multiple - with single -
        };

        vm.showSpinner = function() {
            usSpinnerService.spin('redlofspinner');
            $rootScope.showspinner = true;
        };

        vm.hideSpinner = function() {
            usSpinnerService.stop('redlofspinner');
            $rootScope.showspinner = false;
        };

        vm.showLoader = function() {

            angular.element(document.getElementById('loader')).css('display', 'block');

        };

        vm.hideLoader = function() {

            angular.element(document.getElementById('loader')).css('display', 'none');

        };

        vm.findGetParameter = function(parameterName) {
            var result = null,
                tmp = [];
            location.search
                .substr(1)
                .split("&")
                .forEach(function(item) {
                    tmp = item.split("=");
                    if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
                });
            return result;
        };

        vm.findIdFromUrl = function() {
            var ID;
            var urls = location.pathname.split("/");

            if (urls.length === 0) {
                return false;
            }

            angular.forEach(urls, function(value, key) {

                var valueCheck = isNaN(parseInt(value));
                if (!valueCheck) {
                    ID = value;
                }

            });

            return ID;
        };

        vm.findParameterFromUrl = function() {
            var urls = location.pathname.split("/");
            return urls[urls.length - 1];
        };

        vm.createFirstAndLastName = function(fullName, type) {
            var arrfullName = [];
            var last_name = '';
            arrfullName = fullName.split(' ');

            if (type === 'first_name') {
                return arrfullName[0];
            } else {
                for (var i = 1; i <= arrfullName.length - 1; i++) {
                    last_name += arrfullName[i] + ' ';
                }

                return last_name;
            }

            return fullName;
        };

        $rootScope.switchBackToUser = function(redirect_url) {
            window.location = redirect_url;
        };

        $rootScope.getActivePage = function(path) {
            var urls = location.pathname.split("/");
            if (urls[urls.length - 1] === path) {
                return true;
            } else {
                return false;
            }
        };

        vm.findGetParameter = function(parameterName) {
            var result = null,
                tmp = [];
            location.search
                .substr(1)
                .split("&")
                .forEach(function(item) {
                    tmp = item.split("=");
                    if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
                });
            return result;
        };

        vm.findIdFromUrl = function() {
            var ID;
            var urls = location.pathname.split("/");

            if (urls.length === 0) {
                return false;
            }

            angular.forEach(urls, function(value, key) {

                var valueCheck = isNaN(parseInt(value));
                if (!valueCheck) {
                    ID = value;
                }

            });

            return ID;
        };

        vm.getYears = function(minyear) {

            var years = [];

            if (typeof minyear === 'undefined') {
                minyear = 1970;
            }

            var max = new Date().getFullYear();

            minyear = parseInt(minyear);

            var counter = 1;

            for (var i = minyear; i <= max; i++) {
                var obejct = {};

                obejct.id = counter;
                obejct.year = i.toString();

                years.push(obejct);

                counter++;
            }

            years = years.reverse();

            return years;
        };

        vm.getMonths = function() {

            var months = [];

            for (var i = 1; i <= 12; i++) {
                var obejct = {};

                obejct.id = i;
                obejct.month = moment().month(i - 1).format('MMMM');

                months.push(obejct);
            }

            return months;
        };

        vm.showDatePicker = function(ev, dateHolder, dateKey, minDateKey) {

            var minDate = new Date();
            minDate = new Date(new Date().getTime() - 24 * 60 * 60 * 1000);

            // Check if min date is not passed use the current date object
            if (typeof minDateKey !== 'undefined') {
                minDate = new Date(dateHolder[minDateKey]);
            }

            // Initiate date picker with given values
            $mdpDatePicker(dateHolder[dateKey], {
                targetEvent: ev,
                minDate: minDate,
            }).then(function(selectedDate) {
                dateHolder[dateKey] = selectedDate;
            });

        };

        vm.showTimePicker = function(ev, dateHolder, dateKey) {

            // Initiate time picker with given values
            $mdpTimePicker(dateHolder[dateKey], {
                targetEvent: ev,
            }).then(function(selectedDate) {
                dateHolder[dateKey] = selectedDate;
            });
        };

        $rootScope.showDatePickerPopup = function(ev, dateHolder, dateKey, minDateKey) {

            var minDate = new Date();
            minDate = new Date(new Date().getTime() - 24 * 60 * 60 * 1000);

            // Check if min date is not passed use the current date object
            if (typeof minDateKey !== 'undefined') {
                minDate = new Date(dateHolder[minDateKey]);
            }

            // Initiate date picker with given values
            $mdpDatePicker(dateHolder[dateKey], {
                targetEvent: ev,
                minDate: minDate,
            }).then(function(selectedDate) {
                dateHolder[dateKey] = selectedDate;
            });

        };

        $rootScope.showDateTimePickerPopup = function(ev, dateHolder, dateKey, minDateKey, showtimePicker) {

            var minDate = new Date();
            minDate = new Date(new Date().getTime() - 24 * 60 * 60 * 1000);

            // Check if min date is not passed use the current date object
            if (typeof minDateKey !== 'undefined') {
                minDate = new Date();

                if (minDateKey === 'today') {
                    minDate = minDate;

                } else if (minDateKey === 'tomorrow') {

                    minDate.setDate(minDate.getDate() + 1);

                } else if (minDateKey === 'yesterday') {

                    minDate.setDate(minDate.getDate() - 1);

                } else {

                    if (typeof dateHolder[minDateKey] === 'undefined') {
                        minDate = new Date();
                    } else {
                        minDate = new Date(dateHolder[minDateKey]);
                    }

                    minDate.setDate(minDate.getDate() + 1);
                }
            }

            // Initiate date picker with given values
            $mdpDatePicker(dateHolder[dateKey], {
                targetEvent: ev,
                minDate: minDate,
            }).then(function(selectedDate) {
                dateHolder[dateKey] = selectedDate;

                if (typeof showtimePicker !== 'undefined') {
                    vm.showTimePicker(ev, dateHolder, dateKey);
                }
            });

        };

        $rootScope.showDOBDatePickerPopup = function(ev, dateHolder, dateKey, minAge) {

            var minDate = moment();
            minDate.subtract('year', 13);

            var upperLimit = moment();
            upperLimit.subtract('year', 100);

            // Check if min date is not passed use the current date object
            if (typeof minDateKey !== 'undefined') {
                minDate.subtract('year', parseInt(minAge));
            }

            // Initiate date picker with given values
            $mdpDatePicker(dateHolder[dateKey], {
                targetEvent: ev,
                maxDate: new Date(minDate),
                minDate: new Date(upperLimit),
            }).then(function(selectedDate) {
                dateHolder[dateKey] = selectedDate;
            });

        };


        $rootScope.showExpDatePickerPopup = function(ev, dateHolder, dateKey) {

            var minDate = moment();

            $mdpDatePicker(dateHolder[dateKey], {
                targetEvent: ev,
                maxDate: new Date(minDate),
            }).then(function(selectedDate) {
                dateHolder[dateKey] = selectedDate;
            });

        };

        vm.validateEmail = function(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        };

        $rootScope.showFlatpickerForDate = function(ID, timeEnable) {

            var options = {};

            options.minDate = new Date('tomorrow');
            options.minDate = new Date(new Date().getTime() - 24 * 60 * 60 * 1000);

            if (typeof timeEnable !== 'undefined') {
                options.enableTime = timeEnable;
            }

            setTimeout(function() {
                flatpickr('#' + ID, options);
            }, 1000);

        };

        vm.activateEvent = function(id) {

            angular.element(document.querySelector('#' + id)).addClass('activate_element');

        };

        vm.deActivateEvent = function(id) {

            angular.element(document.querySelector('#' + id)).addClass('deactivate_element');

        };

    }

})();
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
(function() {

    "use strict";

    angular
        .module('app.core')
        .service('AuthService', AuthService);

    AuthService.$inject = ['$http', '$auth', '$rootScope', 'ApiHelper', '$state', '$cookies', 'ngDialog'];

    function AuthService($http, $auth, $rootScope, ApiHelper, $state, $cookies, ngDialog) {

        /* jshint validthis: true */
        var vm = this;

        vm.inProcess = false;

        vm.signin = function(AuthObject) {

            AuthObject.credentials.role_type = AuthObject.role_type;

            $auth.login(AuthObject.credentials, {
                    url: AuthObject.signin_url
                })
                .then(function(response) {
                    vm.inProcess = false;
                    if (response) {
                        ngDialog.closeAll();
                        vm.setSignedUserDetails(response, AuthObject);
                    }
                }).catch(function(){
                    vm.inProcess = false;
                });
        };

        vm.SignOut = function(redirect_url) {

            // TODO need to make api and do proper signout with ttoken

            if (typeof redirect_url === 'undefined') {
                redirect_url = '/';
            }

            $http.get(AppConst.api_url + "auth/signout")
                .then(function(response) {

                    $auth.logout()
                        .then(function(resp) {

                            localStorage.removeItem('redlof_current_role');
                            localStorage.removeItem('redlof_token');

                            $cookies.remove('redlof_token', {
                                path: '/'
                            });

                            $cookies.remove('redlof_tw_token', {
                                path: '/'
                            });

                            $cookies.remove('redlof_tw_connect', {
                                path: '/'
                            });

                            window.location = root + '/' + redirect_url;
                        });

                });
        };

        vm.updateToken = function(redlof_token) {
            $auth.setToken(redlof_token);
        };

        vm.setSignedUserDetails = function(response, AuthObject) {
            $rootScope.authenticated = true;
            $rootScope.currentUser = $auth.getPayload(); // TODO::REMOVE

            localStorage.setItem('redlof_current_role', AuthObject.role_type);

            if (response.data.show) {
                AuthObject.redirect_state = response.data.show.redirect_state;
            }

            window.location = AuthObject.redirect_state;
        };

        $rootScope.signout = function(redirect_to) {
            vm.SignOut(redirect_to);
        };
    }

})();
(function() {

  "use strict";

  angular
    .module('app.core')
    .service('AppTableListService', AppTableListService);

  AppTableListService.$inject = ['$rootScope', '$http', '$q', 'Helper'];

  function AppTableListService($rootScope, $http, $q, Helper) {

    /* jshint validthis: true */
    var vm = this;

    vm.TableList = [];
    vm.inProcess = false;

    vm.init = function(ListId, config) {

      // gimme the API
      vm.TableList[ListId] = [];

      vm.TableList[ListId].API = config.API;
      vm.TableList[ListId].list = [];
      vm.TableList[ListId].results = [];
      vm.TableList[ListId].isAnySelected = false;

      vm.TableList[ListId].pagination = true;
      vm.TableList[ListId].needle = 0;
      vm.TableList[ListId].totalCount = 0;
      vm.TableList[ListId].pagesize = config.pagesize || 10;

      vm.TableList[ListId].currentPage = 1;
      vm.TableList[ListId].totalPage = 1;

      vm.TableList[ListId].firstpage = true;
      vm.TableList[ListId].lastpage = true;
      vm.TableList[ListId].params = [];
      vm.TableList[ListId].searchKey = '';

      // initialize the list & call next page
      vm.getPage(ListId, 1);

      // Create event handlers
      vm.createEventHandlers(ListId);

      return vm.TableList[ListId];
    };

    vm.resetListData = function(ListId) {
      // Clean all the existing data & reset values to normal

      vm.TableList[ListId].list = [];
      vm.TableList[ListId].results = [];

      vm.TableList[ListId].totalCount = 0;
      vm.TableList[ListId].needle = 0;

      vm.TableList[ListId].currentPage = 1;
      vm.TableList[ListId].totalPage = 1;
    };

    vm.nextList = function(ListId) {

      var APIParams = vm.createParams(ListId);

      // get the data based on the needle & offset
      vm.getList(ListId, vm.TableList[ListId].API.getall, APIParams)
        .then(function(response) {
          vm.TableList[ListId].totalCount = response.total;
          vm.TableList[ListId].currentPage = response.currentslice;
          vm.TableList[ListId].totalPage = response.pagination;

          vm.TableList[ListId].lastpage = response.items.length < vm.TableList[ListId].pagesize ? true : false;

          vm.TableList[ListId].pagination = true;

          vm.TableList[ListId].results = response.items;
          vm.TableList[ListId].list[vm.TableList[ListId].currentPage] = response.items;

          vm.toggleSelectAll(ListId, false);
        });
    };

    vm.nextListSearch = function(ListId) {

      var APIParams = vm.createParamsSearch(ListId);

      // get the data based on the needle & offset
      vm.getList(ListId, vm.TableList[ListId].API.search1, APIParams)
        .then(function(response) {
          vm.TableList[ListId].totalCount = response.total;
          vm.TableList[ListId].currentPage = response.currentslice;
          vm.TableList[ListId].totalPage = response.pagination;

          vm.TableList[ListId].lastpage = response.items.length < vm.TableList[ListId].pagesize ? true : false;

          vm.TableList[ListId].pagination = true;

          vm.TableList[ListId].results = response.items;
          vm.TableList[ListId].list[vm.TableList[ListId].currentPage] = response.items;

          vm.toggleSelectAll(ListId, false);
        });
    };

    vm.getList = function(ListId, ApiUrl, listparams) {
      var deferred = $q.defer();

      $http.get(AppConst.api_url + ApiUrl, {
          params: listparams
        })
        .then(function(response) {
          deferred.resolve(response.data.data);
        });
      return deferred.promise;
    };

    vm.getPage = function(ListId, PageNo) {
      // always it would return the page number

      vm.TableList[ListId].pagination = true;

      if (typeof vm.TableList[ListId].list[PageNo] !== 'undefined' &&

        vm.TableList[ListId].list[PageNo].length) {
        // Setting the page's data to result
        vm.TableList[ListId].results = vm.TableList[ListId].list[PageNo];
        vm.TableList[ListId].currentPage = PageNo;


      } else {
        // make the API Call to fetch the data
        // needle should be the current page -1 multiplied by pagesize
        vm.TableList[ListId].needle = (PageNo - 1) * vm.TableList[ListId].pagesize;

        vm.nextList(ListId);
      }
    };
    vm.getPageSearch = function(ListId, PageNo) {
      // always it would return the page number

      vm.TableList[ListId].pagination = true;

      if (typeof vm.TableList[ListId].list[PageNo] !== 'undefined' &&

        vm.TableList[ListId].list[PageNo].length) {
        // Setting the page's data to result
        vm.TableList[ListId].results = vm.TableList[ListId].list[PageNo];
        vm.TableList[ListId].currentPage = PageNo;


      } else {
        // make the API Call to fetch the data
        // needle should be the current page -1 multiplied by pagesize
        vm.TableList[ListId].needle = (PageNo - 1) * vm.TableList[ListId].pagesize;

        vm.nextListSearch(ListId);
      }
    };

    vm.nextPage = function(ListId) {

      if (vm.TableList[ListId].currentPage === vm.TableList[ListId].totalPage) {
        return;
      }

      vm.getPage(ListId, vm.TableList[ListId].currentPage + 1);
    };

    vm.prevPage = function(ListId) {

      if (vm.TableList[ListId].currentPage === 1) {
        return;
      }

      vm.getPage(ListId, vm.TableList[ListId].currentPage - 1);
    };

    vm.nextPageSearch = function(ListId) {

      if (vm.TableList[ListId].currentPage === vm.TableList[ListId].totalPage) {
        return;
      }

      vm.getPageSearch(ListId, vm.TableList[ListId].currentPage + 1);
    };

    vm.prevPageSearch = function(ListId) {

      if (vm.TableList[ListId].currentPage === 1) {
        return;
      }

      vm.getPageSearch(ListId, vm.TableList[ListId].currentPage - 1);
    };

    vm.createParams = function(ListId) {

      var Params = [];
      Params.skip = vm.TableList[ListId].needle;
      Params.limit = vm.TableList[ListId].pagesize;

      vm.TableList[ListId].params = Params;

      return Params;
    };
    vm.createParamsSearch = function(ListId) {

      var Params = [];
      Params.skip = vm.TableList[ListId].needle;
      Params.limit = vm.TableList[ListId].pagesize;
      Params.s = vm.TableList[ListId].searchKey;

      vm.TableList[ListId].params = Params;

      return Params;
    };

    vm.toggleSelectItem = function(ListId, itemId, selected) {

      var index = Helper.getTheArrIndex(vm.TableList[ListId].results, itemId);
      vm.TableList[ListId].results[index].selected = selected;

      vm.updatedSelectedStatus(ListId);
    };

    vm.toggleSelectAll = function(ListId, selected) {
      vm.changeSelectedAll(ListId, selected);
      vm.TableList[ListId].isAnySelected = selected;
    };

    vm.changeSelectedAll = function(ListId, selected) {
      for (var i = 0; i < vm.TableList[ListId].results.length; i++) {
        vm.TableList[ListId].results[i].selected = selected;
      }
    };

    vm.getSelectedIds = function(ListId) {
      var SelectedIds = [];

      for (var i = 0; i < vm.TableList[ListId].results.length; i++) {
        if (vm.TableList[ListId].results[i].selected === true) {
          SelectedIds.push(vm.TableList[ListId].results[i].id);
        }
      }

      return SelectedIds;
    };

    vm.updatedSelectedStatus = function(ListId, selected) {
      var Status = false;

      for (var i = 0; i < vm.TableList[ListId].results.length; i++) {
        if (vm.TableList[ListId].results[i].selected) {
          Status = true;
          break;
        }
      }

      vm.TableList[ListId].isAnySelected = Status;
    };

    vm.delete = function(ListId) {
      // call the api, on response fire the event
      var toDeleteIds = vm.getSelectedIds(ListId);

      vm.postListAction(ListId, vm.TableList[ListId].API.delete, toDeleteIds)
        .then(function(response) {
          $rootScope.$broadcast('deleted-' + ListId);
        });
    };

    vm.postTask = function(ListId) {
      // call the api, on response fire the event
      var toPostIds = vm.getSelectedIds(ListId);

      vm.postListAction(ListId, vm.TableList[ListId].API.postTask, toPostIds)
        .then(function(response) {
          $rootScope.$broadcast('posted-' + ListId);
        });
    };

    vm.search = function(ListId, keyword) {

      vm.resetListData(ListId);
      if (typeof keyword === 'undefined' || keyword === '') {
        vm.getPage(ListId, 1);
        vm.inProcess = false;
        return;
      }

      var params = [];
      params.s = keyword;

      vm.getList(ListId, vm.TableList[ListId].API.search, params)
        .then(function(response) {
          vm.inProcess = false;
          vm.TableList[ListId].results = response.items;
          vm.TableList[ListId].pagination = false;

          $rootScope.$broadcast('searched-' + ListId);
        }).catch(function(){
          vm.inProcess = false;
        });
    };

    vm.search1 = function(ListId, keyword) {

      vm.resetListData(ListId);
      if (typeof keyword === 'undefined' || keyword === '') {
        vm.getPage(ListId, 1);
        return;
      }

      var params = [];
      params.s = keyword;
      
      vm.TableList[ListId].searchKey = keyword;

      vm.nextListSearch(ListId);
    };

    vm.postListAction = function(ListId, ApiUrl, SelectedIds) {
      var deferred = $q.defer();

      $http.post(AppConst.api_url + ApiUrl, SelectedIds)
        .then(function(response) {
          deferred.resolve(response.data);
        });

      return deferred.promise;
    };

    vm.createEventHandlers = function(ListId) {
      // create an event handler for created event
      $rootScope.$on('created-' + ListId, function() {
        vm.resetListData(ListId);
        vm.getPage(ListId, 1);
      });

      // create an event handler for deleted event
      $rootScope.$on('deleted-' + ListId, function() {
        vm.resetListData(ListId);
        vm.getPage(ListId, 1);
      });

      // create an event handler for post event
      $rootScope.$on('posted-' + ListId, function() {
        vm.resetListData(ListId);
        vm.getPage(ListId, 1);
      });

      // create an event handler for fetchall event
      $rootScope.$on('fetchall-' + ListId, function() {
        vm.resetListData(ListId);
        vm.getPage(ListId, 1);
      });

      // Search reset
      $rootScope.$on('reset-' + ListId, function() {
        vm.getPage(ListId, 1);
      });
    };
  }
})();
(function() {

    "use strict";

    angular
        .module('app.core')
        .service('ApiHelper', ApiHelper);

    ApiHelper.$inject = ['$http', '$q', 'Upload'];

    function ApiHelper($http, $q, Upload) {

        /* jshint validthis: true */
        var vm = this;
        var Results = [];

        vm.getData = function(API, queryParams) {
            var deferred = $q.defer();

            $http.get(AppConst.api_url + API, {
                    params: queryParams
                })
                .then(function(response) {
                    deferred.resolve(response.data);
                });

            return deferred.promise;
        };

        vm.getWidgetData = function(API, queryParams) {
            var deferred = $q.defer();

            $http.get(AppConst.url + '/' + API, {
                    params: queryParams
                })
                .then(function(response) {
                    deferred.resolve(response.data);
                });

            return deferred.promise;
        };

        vm.postData = function(API, data) {
            var deferred = $q.defer();

            $http.post(AppConst.api_url + API, data)
                .then(function(response) {
                    deferred.resolve(response.data);
                });

            return deferred.promise;
        };

        vm.addItem = function(API, data) {
            return Upload.upload({
                url: AppConst.api_url + API,
                data: data
            });
        };

        vm.getItem = function(API, id) {
            return vm.getData(API + id);
        };

        vm.getAPIData = function(API) {
            return vm.getData(API);
        };

        vm.getDropdown = function(API) {
            return vm.getData(API);
        };
    }
})();
(function() {

    "use strict";

    angular
        .module('app.core')
        .service('AccessService', AccessService);

    AccessService.$inject = ['$http', '$rootScope', '$q', '$state', 'AuthService', 'Helper', '$compile'];

    function AccessService($http, $rootScope, $q, $state, AuthService, Helper, $compile) {

        /* jshint validthis: true */
        var vm = this;

        vm.authRedirectionHandler = function() {
            var user = Helper.getUser();

            if (!user) {
                $state.go('page.home');
            } else {
                $state.go(user.role + '.dashboard');
            }
        };

        vm.setRootScopeData = function() {

            var user = Helper.getUser();

            if (user) {
                $rootScope.authenticated = true;

            } else {
                $rootScope.authenticated = false;
                $rootScope.currentUser = null;
                $rootScope.User = null;
                $rootScope.Member = null;
            }
        };
    }

})();
(function() {

    'use strict';

    var Filters = angular.module('app.core');

    Filters.filter('labelCase', function($sce) {
            return function(input) {
                input = input.replace(/([A-Z])/g, ' $1');
                return input[0].toUpperCase() + input.slice(1);
            };
        })
        .filter('keyFilter', function() {
            return function(obj, query) {
                var result = {};

                angular.forEach(obj, function(val, key) {
                    if (key !== query) {
                        result[key] = val;
                    }
                });

                return result;
            };
        })
        .filter('unique', function() {
            return function(collection, keyname) {
                var output = [],
                    keys = [];

                angular.forEach(collection, function(item) {
                    var key = item[keyname];
                    if (keys.indexOf(key) === -1) {
                        keys.push(key);
                        output.push(item);
                    }
                });

                return output;
            };
        })
        .filter('trustUrl', function($sce) {
            return function(url) {
                return $sce.trustAsResourceUrl(url);
            };
        })
        .filter('capitalize', function() {
            return function(input) {
                return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
            };
        })
        .filter('num', function() {
            return function(input) {
                return parseInt(input, 10);
            };
        })
        .filter('stringToDate', function() {
            return function(input) {
                if (!input)
                    return null;

                var date = moment(input);
                return date.isValid() ? date.toDate() : null;
            };
        })
        .filter('hourmin', function() {
            return function(input) {
                return input.slice(0, -3);
            };
        });
})();
(function() {

   'use strict';

   var Directives = angular.module('app.core');

   Directives.directive('trimStr', [function() {
      return {
         restrict: 'A',
         link: function(scope, element, attrs) {
            var message = attrs.trimStr;
            var limit = attrs.trimStrLimit;

            var trimmed = message.substr(0, parseInt(limit));
            if (message.length > parseInt(limit)) {
               $(element).text(trimmed + '...');
            } else {
               $(element).text(message);
            }
         }
      };
   }]);

})();
(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('pageTitle', ['$rootScope', '$timeout', function($rootScope, $timeout) {
        return {
            link: function(scope, element, attrs) {

                $timeout(function() {
                    $rootScope.title = attrs.pageTitle + ' | MyMily';
                });
            }
        };
    }]);

})();
(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('showHideContainer', function() {
        return {
            scope: {

            },
            controller: ['$scope', '$element', '$attrs', function($scope, $element, $attrs) {
                $scope.show = false;

                $scope.toggleType = function($event) {
                    $event.stopPropagation();
                    $event.preventDefault();

                    $scope.show = !$scope.show;

                    // Emit event
                    $scope.$broadcast("toggle-type", $scope.show);
                };
            }],
            template: '<div class="show-hide-input" ng-transclude></div><a class="password-show toggle-view-anchor" ng-click="toggleType($event)"><span ng-show="show"><i class="fa fa-eye"></i></span><span ng-show="!show"><i class="fa fa-eye"></i></span></a>',
            restrict: 'A',
            replace: false,
            transclude: true
        };
    })


    .directive('showHideInput', function() {
        return {
            scope: {},

            link: function(scope, element, attrs) {
                // listen to event
                scope.$on("toggle-type", function(event, show) {
                    var password_input = element[0],
                        input_type = password_input.getAttribute('type');

                    if (!show) {
                        password_input.setAttribute('type', 'password');
                    }

                    if (show) {
                        password_input.setAttribute('type', 'text');
                    }
                });
            },
            require: '^showHideContainer',
            restrict: 'A',
            replace: false,
            transclude: false
        };
    });

})();
(function() {

  'use strict';

  var Directives = angular.module('app.core');

  Directives.directive('scrollToSection', function() {
    return {
      link: function(scope, element, attrs) {
        var value = attrs.scrollToSection;
        element.click(function() {
          scope.$apply(function() {
            var selector = "[scroll-section='" + value + "']";
            var element = $(selector);

            if (element.length) {
              $("body").animate({
                scrollTop: element[0].offsetTop
              }, 1000);
            }
          });
        });
      }
    };
  });

})();
(function() {

  'use strict';

  var Directives = angular.module('app.core');

  Directives.directive('scrollOnClick', function() {
    return {
      restrict: 'A',
      link: function(scope, $elm, attrs) {

        var idToScroll = attrs.href;
        var offset = 300,
          offset_opacity = 1200,
          scroll_top_duration = 700;

        //hide or show the "back to top" link
        $(window).scroll(function() {
          if ($(this).scrollTop() > offset) {
            $elm.addClass('cd-is-visible');
          } else {
            $elm.removeClass('cd-is-visible cd-fade-out');
          }
          if ($(this).scrollTop() > offset_opacity) {
            $elm.addClass('cd-fade-out');
          }
        });

        $elm.on('click', function() {
          var $target;
          if (idToScroll) {
            $target = $(idToScroll);
          } else {
            $target = $elm;
          }
          $("body").animate({
            scrollTop: $target.offset().top
          }, scroll_top_duration);
        });
      }
    };
  });

})();
(function() {

  'use strict';

  var Directives = angular.module('app.core');

  Directives.directive('redlofInit', [function() {
    return {
      restrict: 'A',
      link: function(scope, element, attrs) {

        var functionName = attrs.redlofInit;
        var functionParam = attrs.redlofInitParam;

        if (typeof functionParam !== 'undefined') {
          window[functionName](functionParam);
        } else {
          window[functionName]();
        }

      }
    };
  }]);

})();
(function() {

  'use strict';

  var Directives = angular.module('app.core');

  Directives.directive('redlofEmoji', function() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function(scope, element, attrs, ngModelCtrl) {

        setTimeout(function() {
          wdtEmojiBundle.defaults.type = 'facebook';
          wdtEmojiBundle.init('.comment-input textarea');

          wdtEmojiBundle.defaults.type = 'facebook';
          wdtEmojiBundle.init('.my-post-body textarea');
        }, 1000);

      }
    };
  });

})();
(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('ngReallyClick', [function() {
        return {
            restrict: 'A',
            link: function(scope, element, attrs, SweetAlert) {
                element.bind('click', function() {
                    var message = attrs.ngReallyMessage;
                    var action = attrs.ngReallyAction;
                    var actiontext = attrs.ngActionText;

                    action = "Yes, " + action + " it!";

                    if (typeof actiontext !== 'undefined') {
                        console.log(actiontext);
                        action = actiontext;
                    }

                    console.log(action);

                    swal({
                        title: "Are you sure?",
                        text: message,
                        type: "warning",
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: action,
                        closeOnConfirm: true
                    }, function() {
                        scope.$apply(attrs.ngReallyClick);
                    });
                });
            }
        };
    }]);

})();
(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('ngEnter', function() {
        return function(scope, element, attrs) {
            element.bind("keydown keypress", function(event) {
                if (event.which === 13) {
                    scope.$apply(function() {
                        scope.$eval(attrs.ngEnter, {
                            'event': event
                        });
                    });

                    event.preventDefault();
                }
            });
        };
    });

    Directives.directive('clickOff', ['$parse', '$document', function($parse, $document) {
        var dir = {
            compile: function($element, attr) {
                // Parse the expression to be executed
                // whenever someone clicks _off_ this element.
                var fn = $parse(attr.clickOff);
                return function(scope, element, attr) {
                    // add a click handler to the element that
                    // stops the event propagation.
                    element.bind("click", function(event) {
                        event.stopPropagation();
                    });
                    angular.element($document[0].body).bind("click", function(event) {
                        scope.$apply(function() {
                            fn(scope, {
                                $event: event
                            });
                        });

                        $("#search-input").val('');
                    });
                };
            }
        };
        return dir;
    }]);

})();
(function() {

	'use strict';

	var Directives = angular.module('app.core');

	Directives.directive('elementInit', function() {
		return {
			link: function(scope, elem, attrs) {

				angular.element(elem).removeClass('hide_element');
				angular.element(elem).addClass('show_element');

			}
		};
	});

	Directives.directive('escKey', function() {
		return function(scope, element, attrs) {
			element.bind('keydown keypress', function(event) {
				if (event.which === 27) { // 27 = esc key
					scope.$apply(function() {
						scope.$eval(attrs.escKey);
					});

					event.preventDefault();
				}
			});
		};
	});

})();
(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('ngCustomAlertClick', [function() {
        return {
            restrict: 'A',
            link: function(scope, element, attrs, SweetAlert) {

                element.bind('click', function() {

                    var message = attrs.ngCustomAlertMessage;
                    var action = attrs.ngCustomAlertAction;
                    var actiontext = attrs.ngActionText;
                    var cancletext = attrs.ngCancleText;
                    var titletext = attrs.ngTitleText;

                    action = "Yes, " + action + " it!";

                    if (typeof actiontext !== 'undefined') {
                        action = actiontext;
                    }

                    if (typeof actiontext !== 'undefined') {
                        action = actiontext;
                    }

                    if (typeof titletext !== 'undefined') {
                        titletext = titletext;
                    } else {
                        titletext = 'Are you sure?';
                    }

                    swal({
                        title: titletext,
                        text: message,
                        type: "warning",
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: action,
                        cancelButtonText: cancletext,
                        closeOnConfirm: true
                    }, function() {
                        scope.$apply(attrs.ngCustomAlertClick);
                    });
                });
            }
        };
    }]);

})();
(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('inputEnter', function() {
        return function(scope, element, attrs) {
            element.bind("keydown keypress", function(event) {
                if (event.which === 13) {
                    scope.$apply(function() {
                        scope.$eval(attrs.inputEnter);
                    });

                    event.preventDefault();
                }
            });
        };
    });

    Directives.directive('clickOff', ['$parse', '$document', function($parse, $document) {
        var dir = {
            compile: function($element, attr) {
                // Parse the expression to be executed
                // whenever someone clicks _off_ this element.
                var fn = $parse(attr.clickOff);
                return function(scope, element, attr) {
                    // add a click handler to the element that
                    // stops the event propagation.
                    element.bind("click", function(event) {
                        event.stopPropagation();
                    });
                    angular.element($document[0].body).bind("click", function(event) {
                        scope.$apply(function() {
                            fn(scope, {
                                $event: event
                            });
                        });

                        $("#search-input").val('');
                    });
                };
            }
        };
        return dir;
    }]);

})();
(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('initSlider', [function() {
        return {
            restrict: 'A',
            link: function(rootScope, element, attrs) {
                setTimeout(function() {
                    initHomeGallery();
                }, 2000);

            }
        };
    }]);

})();
(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('redlofSidebar', [function() {
        return {
            restrict: 'A',
            link: function(rootScope, element, attrs) {
                rootScope.sidebarInitiated = false;
                if (rootScope.sidebarInitiated === false) {
                    $.RedlofDashboard.load();
                    rootScope.sidebarInitiated = true;
                }
            }
        };
    }]);

})();
(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('errSrc', function() {
        return {
            link: function(scope, element, attrs) {
                element.bind('error', function() {
                    if (attrs.src != attrs.errSrc) {
                        attrs.$set('src', attrs.errSrc);
                    }
                });
            }
        };
    });


})();
(function() {

   'use strict';

   var Directives = angular.module('app.core');

   Directives.directive('icheck', ['$timeout', '$parse', function($timeout, $parse) {
      return {
         link: function($scope, element, $attrs) {
            return $timeout(function() {
               var ngModelGetter, value;
               ngModelGetter = $parse($attrs.ngModel);
               value = $parse($attrs.ngValue)($scope);
               var ngHasClick = $attrs.ngHasClick;

               $scope.$watch($attrs.ngModel, function(newValue) {
                  $(element).iCheck('update');
               });

               return $(element).iCheck({
                  checkboxClass: 'icheckbox_flat-green',
                  radioClass: 'iradio_flat-green'
               }).on('ifChanged', function(event) {
                  if ($(element).attr('type') === 'checkbox' && $attrs.ngModel) {
                     $scope.$apply(function() {
                        return ngModelGetter.assign($scope, event.target.checked);
                     });
                  }
                  if ($(element).attr('type') === 'radio' && $attrs.ngModel) {
                     return $scope.$apply(function() {
                        return ngModelGetter.assign($scope, value);
                     });
                  }
               }).on('ifClicked', function(event) {
                  if (ngHasClick === 'true') {
                     element.trigger('click');
                  }
               });
            });
         }
      };
   }]);

})();
(function() {

  'use strict';

  var Directives = angular.module('app.core');

  Directives.directive('ngInitial', function() {
    return {
      restrict: 'A',
      controller: [
        '$scope', '$element', '$attrs', '$parse',
        function($scope, $element, $attrs, $parse) {
          var getter, setter, val;
          val = $attrs.ngInitial || $attrs.value;
          getter = $parse($attrs.ngModel);
          setter = getter.assign;
          setter($scope, val);
        }
      ]
    };
  });

})();
(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive("outsideClick", ['$document', '$parse', function($document, $parse) {
        return {
            link: function($scope, $element, $attributes) {
                var scopeExpression = $attributes.outsideClick,
                    onDocumentClick = function(event) {
                        var isChild = $element.find(event.target).length > 0;

                        if (!isChild) {
                            $scope.$apply(scopeExpression);
                        }
                    };

                $document.on("click", onDocumentClick);

                $element.on('$destroy', function() {
                    $document.off("click", onDocumentClick);
                });
            }
        };
    }]);

})();
(function() {

  'use strict';

  var Directives = angular.module('app.core');

  Directives.directive('dynamicContent', ['$http', '$compile', '$rootScope', function($http, $compile, $rootScope) {
    return {
      restrict: 'A',
      link: function(scope, element, attrs) {

        $rootScope.clickedSlide = false;

        element.bind('click', function() {

          var dynamicContent = attrs.dynamicContent;
          var dynamicURL = attrs.dynamicContentUrl;
          var is_url;

          if(typeof dynamicURL === 'undefined'){
            is_url = false;
          }

          if(is_url == false){
            dynamicContent = "dynamic/content/" + dynamicContent;
          }

          var htmlcontent = $('.dynamic-content-container');

          $http.get(AppConst.url + '/' + dynamicContent)
            .then(function(data) {

              htmlcontent.html($compile(data.data)(scope));

            });


        });
      }
    };
  }]);

})();
(function() {

  'use strict';

  var Directives = angular.module('app.core');

  Directives.directive('datetimez', function() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function(scope, element, attrs, ngModelCtrl) {
        element.datetimepicker({
          language: 'en',
          pickDate: false,
        }).on('changeDate', function(e) {
          ngModelCtrl.$setViewValue(e.date);
          scope.$apply();
        });
      }
    };
  });

})();
(function() {

  'use strict';

  var Directives = angular.module('app.core');

  Directives.directive('dynamic', function($compile) {
    return {
      restrict: 'A',
      replace: true,
      link: function(scope, ele, attrs) {
        scope.$watch(attrs.dynamic, function(html) {
          ele.html(html);
          $compile(ele.contents())(scope);
        });
      }
    };
  });

})();
(function() {

    'use strict';

    var Directives = angular.module('app.core');

    Directives.directive('bindRedlofHtml', ['$compile', function($compile) {
        return {
            restrict: 'A',
            link: function(scope, element, attrs) {
                scope.$watch(function() {
                    return scope.$eval(attrs.bindRedlofHtml);
                }, function(value) {
                    // In case value is a TrustedValueHolderType, sometimes it
                    // needs to be explicitly called into a string in order to
                    // get the HTML string.
                    element.html(value && value.toString());
                    // If scope is provided use it, otherwise use parent scope
                    var compileScope = scope;
                    if (attrs.bindHtmlScope) {
                        compileScope = scope.$eval(attrs.bindHtmlScope);
                    }
                    $compile(element.contents())(compileScope);
                });
            }
        };
    }]);
}(window.angular));
(function() {

    "use strict";

    angular
        .module('app.core')
        .controller('WidgetController', WidgetController);

    WidgetController.$inject = ['$scope', 'ApiHelper', 'ServerMessage', 'Helper'];

    function WidgetController($scope, ApiHelper, ServerMessage, Helper) {

        /* jshint validthis: true */
        var vm = this;

        $scope.getWidget = function(API, dataHolder) {

            Helper.showSpinner();

            ApiHelper.getWidgetData(API).then(function(response) {
                Helper.hideSpinner();
                $scope[dataHolder] = response;
            });

        };

    }

})();
(function() {

    "use strict";

    angular
        .module('app.core')
        .controller('ListController', ListController);

    ListController.$inject = ['AppTableListService'];

    function ListController(AppTableListService) {

        /* jshint validthis: true */
        var vm = this;

        vm.ListName = "";
        vm.keyword1 = "";
        vm.appTableService = AppTableListService;
        
        vm.config = {
            'API': {
                'getall': '',
                'search': '',
                'search1': '',
                'delete': '',
                'postTask': ''
            },
            'pagesize': 10
        };

        vm.init = function(listName, apis, pagesize) {

            if (typeof apis == 'undefined') {
                console.error('Please define atleast one API for the ListController');
                return;
            }

            vm.ListName = listName;

            vm.config.pagesize = pagesize || 10;
            vm.config.API.getall = typeof apis.getall === 'undefined' ? '' : apis.getall;
            vm.config.API.search = typeof apis.search === 'undefined' ? '' : apis.search;
            vm.config.API.search1 = typeof apis.search1 === 'undefined' ? '' : apis.search1;
            vm.config.API.delete = typeof apis.delete === 'undefined' ? '' : apis.delete;
            vm.config.API.postTask = typeof apis.postTask === 'undefined' ? '' : apis.postTask;

            vm.ListService = AppTableListService.init(vm.ListName, vm.config);
        };

        vm.delete = function() {
            AppTableListService.delete(vm.ListName);
        };

        vm.postTask = function() {
            AppTableListService.postTask(vm.ListName);
        };

        vm.search = function(keyword) {
            vm.appTableService.inProcess = true;
            vm.keyword1 = '';
            AppTableListService.search(vm.ListName, keyword);
        };

         vm.search1 = function(keyword) {
            vm.keyword1 = keyword;
            AppTableListService.search1(vm.ListName, keyword);
        };

        vm.nextPage = function() {
            AppTableListService.nextPage(vm.ListName);
        };

        vm.prevPage = function() {
            AppTableListService.prevPage(vm.ListName);
        };
        vm.nextPageSearch = function() {
            if(vm.keyword1 == ''){
                AppTableListService.nextPage(vm.ListName);
            }else{
                AppTableListService.nextPageSearch(vm.ListName);
            }
        };

        vm.prevPageSearch = function() {
            if(vm.keyword1 == ''){
                AppTableListService.prevPage(vm.ListName);
            }else{
                AppTableListService.prevPageSearch(vm.ListName);
            }
        };
        vm.toggleSelectItem = function(id, selected) {
            AppTableListService.toggleSelectItem(vm.ListName, id, selected);
        };

        vm.toggleSelectAll = function(selected) {
            AppTableListService.toggleSelectAll(vm.ListName, selected);
        };

    }

})();
(function () {

  "use strict";

  angular
    .module('app.core')
    .controller('AppController', AppController);

  AppController.$inject = ['$rootScope', '$scope', 'ApiHelper', 'ServerMessage', 'Helper', 'ngDialog', 'FormValidationService'];

  function AppController($rootScope, $scope, ApiHelper, ServerMessage, Helper, ngDialog, FormValidationService) {

    /* jshint validthis: true */
    var vm = this;
    $scope.helper = Helper;
    $scope.pageId = Helper.findIdFromUrl();

    $scope.inProcess = false;

    $scope.postAPI = function (API, data, refresh) {

      var loader = ServerMessage.loading($scope.msg);

      ApiHelper.postData(API, data).then(function (response) {

        ServerMessage.hideLoader(loader);

        ServerMessage.show(response);

        if (typeof refresh !== 'undefined' && refresh) {
          location.reload();
        }
      });
    };

    $scope.getAPI = function (API, params, dataHolder) {

      var loader = ServerMessage.loading($scope.msg);

      ApiHelper.getData(API, params).then(function (response) {

        ServerMessage.hideLoader(loader);

        ServerMessage.show(response, {
          timeOut: 6000
        });

        if (typeof dataHolder !== 'undefined') {
          $scope[dataHolder] = response.data;
        }
      });
    };

    $scope.getAPIData = function (API, dataHolder, key, secondkey) {

      var loader = ServerMessage.loading($scope.msg);



      ApiHelper.getAPIData(API).then(function (response) {
        ServerMessage.hideLoader(loader);


        ServerMessage.show(response, {
          timeOut: 6000
        });

        // TODO need to discuss and work on
        if (typeof key !== 'undefined') {
          response.data[key] = new Date(response.data[key]);
        }

        if (typeof secondkey !== 'undefined') {
          response.data.personal_details[secondkey] = new Date(response.data.personal_details[secondkey]);
        }



        $scope[dataHolder] = response.data;
      });
    };

    $scope.create = function (API, formData, formname, refresh) {

      var loader = ServerMessage.loading($scope.msg);

      $scope.inProcess = true;

      var formButtonObject = $("button[type=submit]", document.getElementsByName(formname)[0]);

      $(formButtonObject).attr('disabled', 'disabled');

      // Store formname in $rootscope variable so that we can use the form name for form valdiation
      $rootScope.last_submitted_form_name = formname;

      ApiHelper.addItem(API, formData).then(function (response) {

        if (typeof refresh !== 'undefined' && refresh) {
          location.reload();
          return;
        }

        $rootScope.$broadcast('created-' + formname);

        ServerMessage.hideLoader(loader);

        //Helper.hideSpinner();
        ServerMessage.show(response.data);

        // Reset last submitted form
        FormValidationService.resetForm();

        $scope.inProcess = false;
        $(formButtonObject).removeAttr('disabled');

        if (typeof formname !== 'undefined') {
          Helper.resetForm(formname);
        }
      }).catch(function () {
        $scope.inProcess = false;
      });
    };

    $scope.update = function (API, formData) {

      $scope.inProcess = true;

      var loader = ServerMessage.loading($scope.msg);

      var formButtonObject = $("button[type=submit]", document.getElementsByName(formname)[0]);

      $(formButtonObject).attr('disabled', 'disabled');

      ApiHelper.addItem(API, formData).then(function (response) {

        $scope.inProcess = false;

        $(formButtonObject).removeAttr('disabled');

        ServerMessage.hideLoader(loader);

        ServerMessage.show(response.data);

        ngDialog.closeAll();
      });
    };

    $scope.getDropdown = function (API, dataHolder) {

      var loader = ServerMessage.loading($scope.msg);

      ApiHelper.getDropdown(API).then(function (response) {

        $scope[dataHolder] = response.data;

        ServerMessage.hideLoader(loader);

      });
    };
  }
})();
(function() {

  "use strict";

  angular.module('app.core')
    .config(CoreConfiguration);

  CoreConfiguration.$inject = ['$httpProvider', '$qProvider', 'toastrConfig', '$sceDelegateProvider', 'usSpinnerConfigProvider', '$interpolateProvider', '$compileProvider'];

  function CoreConfiguration($httpProvider, $qProvider, toastrConfig, $sceDelegateProvider, usSpinnerConfigProvider, $interpolateProvider, $compileProvider) {

    $httpProvider.interceptors.push('InterceptorFactory');


    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

    $compileProvider.preAssignBindingsEnabled(true);
    $qProvider.errorOnUnhandledRejections(false);

    usSpinnerConfigProvider.setDefaults({
      color: '#f39200',
      lines: 13,
      length: 18,
      width: 7,
      radius: 26,
      scale: 0.75,
      corners: 0.9,
      opacity: 0.25,
      rotate: 0,
      direction: 1,
      speed: 1.1,
      trail: 61,
      left: 50,
      top: 50
    });

    $sceDelegateProvider.resourceUrlWhitelist(['self', new RegExp('^(http[s]?):\/\/(w{3}.)?youtube\.com/.+$')]);

    angular.extend(toastrConfig, {
      autoDismiss: true,
      allowHtml: true,
      closeButton: true,
      progressBar: true,
      newestOnTop: true,
      maxOpened: 4,
      tapToDismiss: true,
      preventOpenDuplicates: true,
      positionClass: 'toast-bottom-left',
      timeOut: 3000,
      extendedTimeOut: 1000,
    });

  }

  angular.module('app.core').directive('custominit', function() {
    return {
      link: function(scope, elem, attrs) {

        angular.element(elem).removeClass('hide_element');
        angular.element(elem).addClass('show_element');

      }
    };
  });


})();
(function() {

    "use strict";

    angular.module('app.core')
        .config(AuthConfiguration);

    AuthConfiguration.$inject = ['$authProvider', '$httpProvider', '$provide'];

    function AuthConfiguration($authProvider, $httpProvider, $provide) {

        $httpProvider.useApplyAsync(true);

        redirectWhenLoggedOut.$inject = ['$q', '$injector'];

        function redirectWhenLoggedOut($q, $injector) {

            return {

                responseError: function(rejection) {

                    var $state = $injector.get('$state');

                    var rejectionReasons = ['token_not_provided', 'token_expired', 'token_absent', 'token_invalid'];

                    angular.forEach(rejectionReasons, function(value, key) {
                        if (rejection.data !== null) {
                            if (rejection.data.error === value) {
                                localStorage.removeItem('redlof_token');

                                window.location = AppConst.url;
                            }
                        }

                    });

                    return $q.reject(rejection);
                }
            };
        }



        // Setup for the $httpInterceptor
        $provide.factory('redirectWhenLoggedOut', redirectWhenLoggedOut);

        // Push the new factory onto the $http interceptor array
        $httpProvider.interceptors.push('redirectWhenLoggedOut');

        $authProvider.tokenName = 'token';
        $authProvider.tokenPrefix = 'redlof';


    }


})();
(function() {

    "use strict";

    angular
        .module('app.role-nodaladmin')
        .controller('SchoolController', SchoolController)
        .controller('SchoolFeeNSeatController', SchoolFeeNSeatController);

    SchoolController.$inject = ['Helper', 'AppTableListService', '$scope', 'ApiHelper', 'ServerMessage', '$rootScope', 'NgMap', 'Toast'];

    function SchoolController(Helper, AppTableListService, $scope, ApiHelper, ServerMessage, $rootScope, NgMap, Toast) {

        var vm = this;
        vm.schoolData = {};
        vm.schoolData.stateType = [];
        vm.bank = {};
        vm.bankdetail = {};
        vm.schoolData.lat = 12.9714;
        vm.schoolData.lng = 77.5944;
        vm.range0 = [];
        vm.range0Dist = [];
        vm.range1 = [];
        vm.range3 = [];
        vm.range6 = [];
        $scope.helper = Helper;
        $scope.pageId = Helper.findIdFromUrl();

        vm.districts = [];
        vm.blocks = [];
        vm.localities = [];
        vm.sub_localities = [];
        vm.sub_sub_localities = [];
        vm.states = [];
        vm.regions = [];
        vm.regionsDist = [];
        vm.stateTypeAll = [{id:'rural',name:'Rural'},{id:'urban',name:'Urban'}];

        vm.locations = [{
            pos: [12.9714, 77.5944]
        }];

        NgMap.getMap().then(function(map) {
            vm.map = map;
        });

        vm.reInitializeMap = function() {
            setTimeout(function() {

                google.maps.event.trigger(vm.map, 'resize');
                var center = vm.map.getCenter();
                vm.map.setCenter(center);

            }, 1000);
        };

        vm.placeChanged = function() {
            vm.place = this.getPlace();
            vm.map.setCenter(vm.place.geometry.location);

            var lat = vm.place.geometry.location.lat();
            var lng = vm.place.geometry.location.lng();
            var address = vm.place.formatted_address;
            var place_id = vm.place.place_id;

            $scope.$apply(function() {

                vm.schoolData.venue = address;
                vm.schoolData.lat = lat;
                vm.schoolData.lng = lng;
                vm.schoolData.place_id = place_id;

                vm.locations = [{
                    pos: [vm.place.geometry.location.lat(), vm.place.geometry.location.lng()]
                }];
            });

        };

        vm.placeDragged = function(school) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'location': this.getPosition()
            }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {

                    if (results[0]) {
                        vm.place = results[0];

                        var lat = vm.place.geometry.location.lat();
                        var lng = vm.place.geometry.location.lng();
                        var address = vm.place.formatted_address;
                        var place_id = vm.place.place_id;

                        $scope.$apply(function() {
                            vm.schoolData.lat = lat;
                            vm.schoolData.lng = lng;
                            vm.schoolData.venue = address;
                            vm.schoolData.place_id = place_id;
                        });

                    } else {
                        Toast.warning('No results found');
                    }
                } else {
                    Toast.warning('No results found');
                }
            });

            $('#selectlocation').val('');
        };

        vm.deleteSchool = function() {

            ApiHelper.getAPIData('nodaladmin/delete/schools').then(function(response) {
                vm.seatinfo = response.data;

            });

        };

        vm.saveSchool = function(API, formname) {

            var formButtonObject = $("button[type=submit]", document.getElementsByName(formname)[0]);

            $(formButtonObject).attr('disabled', 'disabled');

            vm.schoolData.levels = [];

            if (vm.schoolData.level != 'undefined') {

                angular.forEach(vm.schoolData.level, function(val, key) {

                    if (val != 'undefined' && val != false) {
                        vm.schoolData.levels.push(key);
                    }
                });

            }

            Toast.success('Please wait till we save  your primary details...');

            ApiHelper.addItem(API, vm.schoolData).then(function(response) {
                ServerMessage.show(response.data);

            });

        };


        vm.saveSchoolNeighbourhood = function(udise) {

            vm.schoolData.levels = [];

            if (vm.schoolData.level != 'undefined') {

                angular.forEach(vm.schoolData.level, function(val, key) {

                    if (val != 'undefined' && val != false) {
                        vm.schoolData.levels.push(key);
                    }
                });

            }

            if (vm.range0.length > 0 || vm.range0Dist.length > 0) {
                var range01 = [];
                vm.schoolData.range0 = [];

                angular.forEach(vm.range0, function(val, key) {
                    range01.push(val.id);
                });

                if (vm.range0Dist.length > 0) {
                    angular.forEach(vm.range0Dist, function(val, key) {
                        range01.push(val.id);
                    });                    
                }
                
                vm.schoolData.range0 = range01;

            } else {
                Toast.success('select atleast one area under the neighbourhood area');
                return;
            }

            Toast.success('Please wait till we save  your  details...');

            ApiHelper.addItem('nodaladmin/school/update/region/' + udise, vm.schoolData).then(function(response) {
                ServerMessage.show(response.data);

            });

        };


        vm.saveSchoolAddress = function(API) {

            Toast.success('Please wait till we save  your address details...');

            ApiHelper.addItem(API, vm.schoolData).then(function(response) {
                ServerMessage.show(response.data);
            });

        };

        vm.getSchoolDetails = function(id) {


            ApiHelper.getData('nodaladmin/get/school-details/' + id).then(function(response) {

                vm.schoolData = response.data;

                vm.schoolData.admin_phone = vm.schoolData.schooladmin.user.phone;

                vm.schoolData.email = vm.schoolData.schooladmin.user.email;

                vm.schoolData.medium = vm.schoolData.language;

                vm.schoolData.photo = vm.schoolData.fmt_logo;

            });
        };

        vm.getStudentBankDetails = function(id) {


            ApiHelper.getData('schooladmin/get/student/bank-details/' + id).then(function(response) {

                vm.bankdetail = response.data;

                vm.bankdetail.account_number_confirmation = vm.bankdetail.account_number;


            });
        };

        vm.getSchoolAddressDetails = function(id) {


            ApiHelper.getData('nodaladmin/get/school-address-details/' + id).then(function(response) {

                vm.schoolData = response.data;
                vm.schoolData.type = 'ward';

                if(vm.schoolData.state_type == 'urban'){
                    vm.schoolData.stateType = {id:'urban',name:'Urban'};
                }
                if(vm.schoolData.state_type == 'rural'){
                    vm.schoolData.stateType = {id:'rural',name:'Rural'};
                }


                if (vm.schoolData.lat === '' || vm.schoolData.lat === null || typeof vm.schoolData.lat === undefined) {
                    vm.schoolData.lat = 30.3165;
                    vm.schoolData.lng = 78.0322;

                } else {
                    var latlng = [];
                    latlng[0] = vm.schoolData.lat;
                    latlng[1] = vm.schoolData.lng;

                    vm.locations = [{
                        pos: latlng
                    }];
                }


                if (vm.schoolData.block_type === null) {

                    vm.schoolData.block_type = 'ward';

                    vm.show_selection_type = true;

                } else {

                    vm.show_selection_type = false;

                }

                if(response.data.cluster){
                    vm.getClusters(vm.schoolData.block_id);
                }

            });
        };

        vm.getClusters = function (block_id) {

            if (block_id === undefined) {
                return;
            }

            ApiHelper.getAPIData(vm.stateSlug + '/get/clusters/' + block_id).then(function (response) {

                vm.clusters = response.data;

                if (response.data.length === 0) {
                    Toast.show('No relevant clusters found');
                }

            });

        };


        vm.getSchoolRegionDetails = function(udise) {



            ApiHelper.getAPIData('nodaladmin/get/school-region-details/' + udise).then(function(response) {

                vm.regions = response.data.unselected;
                vm.regionsDist = response.data.unselectedDist;
                vm.range0 = response.data.selected;
                vm.range0Dist = response.data.selectedDist;
                vm.dump_regions = vm.regions;

                if (response.data.length === 0) {
                    Toast.show('No relevant sub localities found');
                }

            });


        };

        vm.getSchoolBankDetails = function(id) {



            ApiHelper.getAPIData('nodaladmin/get/school-bank-details/' + id).then(function(response) {

                vm.bankdetail = response.data;
                vm.bankdetail.account_number_confirmation = vm.bankdetail.account_number;
                vm.bankdetail.ifsc_code_confirmation = vm.bankdetail.ifsc_code;

            });


        };

        vm.initStates = function(slug) {

            vm.stateSlug = slug;


            ApiHelper.getData(slug + '/states', {
                'registration_no': Helper.findIdFromUrl()
            }).then(function(response) {

                vm.states = response.data;

                angular.forEach(vm.states, function(s_val, s_key) {

                    if (slug === s_val.slug) {
                        vm.schoolData.state = s_val;
                        return;
                    }

                });

            });
        };

        vm.initDistricts = function(slug, state) {

            vm.clearDistrictData();

            if (state === null || state === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/getall/district/' + state.id).then(function(response) {

                vm.districts = response.data;

                if (response.data.length === 0) {
                    Toast.show('No relevant districts found');
                }

            });
        };

        vm.initSub_Sub_Localities = function(district_id) {


            ApiHelper.getAPIData('/search/subsublocality/' + district_id).then(function(response) {

                vm.sub_sub_localities_all = response.data;

                if (response.data.length === 0) {
                    Toast.show('No relevant sub-sub localities found');
                }


            });
        };

        vm.clearStateData = function() {

            vm.districts = [];
            vm.blocks = [];
            vm.subblocks = [];
            vm.localities = [];
            vm.sub_localities = [];
            vm.sub_sub_localities = [];
            vm.schoolData.sub_block_name = '';
            vm.schoolData.sub_block_type = '';
            vm.schoolData.sub_block_id = '';
            vm.schoolData.district_id = null;
            vm.schoolData.district_name = "";
            vm.schoolData.block_id = null;
            vm.schoolData.block_name = "";
            vm.schoolData.locality_id = null;
            vm.schoolData.locality_name = "";
            vm.schoolData.sub_locality_id = null;
            vm.schoolData.sub_locality_name = "";
            vm.schoolData.sub_sub_locality_id = null;
            vm.schoolData.sub_sub_locality_name = "";
        };


        vm.getDistricts = function(slug, state, keyword) {

            vm.clearDistrictData();

            if (state === null || state === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/search/district/' + state.id + '/' +
                keyword).then(function(response) {

                vm.districts = response.data;

                if (response.data.length === 0) {
                    Toast.show('No relevant districts found');
                }

            });
        };

        vm.initBlocks = function(slug, district_id) {

            vm.clearBlockData();

            if (district_id === null || district_id === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/getall/block/' + district_id).then(function(response) {

                vm.blocks = response.data;

                if (response.data.length === 0) {
                    Toast.show('No relevant blocks found');
                }

            });
        };

        vm.initBlocks1 = function(slug, block_id,stype,district_id) {

            vm.clearBlockData();

            if (block_id === null || block_id === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/getall/subblock/'+district_id+'/'+stype+'/'+ block_id).then(function(response) {

                vm.subblocks = response.data;

                if (response.data.length === 0) {
                    Toast.show('No relevant blocks found');
                }

            });
        };

        vm.chooseDistrict = function(district) {
            vm.schoolData.district_id = district.id;
            vm.schoolData.district_name = district.name;

            vm.clearDistrictData();
            vm.districts = {};

        };

        vm.clearDistrictData = function() {


            vm.blocks = [];
            vm.subblocks = [];
            vm.localities = [];
            vm.sub_localities = [];
            vm.sub_sub_localities = [];

            vm.schoolData.block_id = null;
            vm.schoolData.block_name = "";
            vm.schoolData.sub_block_name = '';
            vm.schoolData.sub_block_type = '';
            vm.schoolData.sub_block_id = '';
            vm.schoolData.locality_id = null;
            vm.schoolData.locality_name = "";
            vm.schoolData.sub_locality_id = null;
            vm.schoolData.sub_locality_name = "";
            vm.schoolData.sub_sub_locality_id = null;
            vm.schoolData.sub_sub_locality_name = "";
        };

        vm.getBlocks = function(slug, district_id, keyword) {
            vm.clearBlockData();

            if (district_id === null || district_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/search/block/' + district_id + '/' +
                keyword).then(function(response) {

                vm.blocks = response.data;

                if (response.data.length === 0) {
                    Toast.show('No relevant blocks found');
                }

            });
        };

        vm.chooseBlock = function(block) {
            vm.schoolData.block_id = block.id;
            vm.schoolData.block_name = block.name;
            vm.schoolData.block_type = block.type;
            vm.schoolData.sub_block_id = '';
            vm.schoolData.sub_block_name = '';
            vm.schoolData.sub_block_type = '';

            if (vm.schoolData.block_type === null) {

                vm.show_selection_type = true;

            } else {

                vm.show_selection_type = false;

            }

            vm.getClusters(vm.schoolData.block_id);

            vm.clearBlockData();
            vm.blocks = {};

        };
        vm.chooseBlock1 = function(block) {
            vm.schoolData.sub_block_id = block.id;
            vm.schoolData.sub_block_name = block.name;
            vm.schoolData.sub_block_type = block.type;

            vm.subblocks = {};

        };
        vm.choosestatetype = function(stype) {
            vm.schoolData.state_type = stype.id;
            vm.clearBlockData();
        };

        vm.clearBlockData = function() {

            vm.localities = [];
            vm.subblocks = [];
            vm.schoolData.sub_block_name = '';
            vm.schoolData.sub_block_type = '';
            vm.schoolData.sub_block_id = '';
            vm.sub_localities = [];
            vm.sub_sub_localities = [];

            vm.schoolData.locality_id = null;
            vm.schoolData.locality_name = "";
            vm.schoolData.sub_locality_id = null;
            vm.schoolData.sub_locality_name = "";
            vm.schoolData.sub_sub_locality_id = null;
            vm.schoolData.sub_sub_locality_name = "";
            vm.schoolData.cluster_id = null;

        };

        vm.getLocalities = function(slug, block_id, keyword) {

            vm.clearLocalityData();

            if (block_id === null || block_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/search/locality/' + block_id + '/' +
                keyword).then(function(response) {

                vm.localities = response.data;

                if (response.data.length === 0) {
                    Toast.show('No relevant localities found');
                }

            });
        };

        vm.chooseLocality = function(locality) {
            vm.schoolData.locality_id = locality.id;
            vm.schoolData.locality_name = locality.name;


            vm.clearLocalityData();

            vm.localities = {};

        };

        vm.getWardName = function(locality) {
            if( locality.ward_number === null){
                return locality.name;
            }
            return locality.ward_number+'. '+locality.name;
        };

        vm.clearLocalityData = function() {

            vm.sub_localities = [];
            vm.sub_sub_localities = [];

            vm.schoolData.sub_locality_id = null;
            vm.schoolData.sub_locality_name = "";
            vm.schoolData.sub_sub_locality_id = null;
            vm.schoolData.sub_sub_locality_name = "";
        };

        vm.getSubLocalities = function(slug, locality_id, keyword) {
            vm.clearSubLocalityData();
            if (locality_id === null || locality_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/search/sublocality/' + locality_id + '/' +
                keyword).then(function(response) {

                vm.sub_localities = response.data;

                if (response.data.length === 0) {
                    Toast.show('No relevant sub localities found');
                }

            });
        };

        vm.chooseSubLocality = function(sub_locality) {
            vm.schoolData.sub_locality_id = sub_locality.id;
            vm.schoolData.sub_locality_name = sub_locality.name;

            vm.clearSubLocalityData();

            vm.sub_localities = {};

        };

        vm.clearSubLocalityData = function() {
            vm.sub_sub_localities = [];

            vm.schoolData.sub_sub_locality_id = null;
            vm.schoolData.sub_sub_locality_name = "";
        };

        vm.getSubSubLocalities = function(slug, sub_locality_id, keyword) {

            if (sub_locality_id === null || sub_locality_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/search/subsublocality/' + sub_locality_id + '/' +
                keyword).then(function(response) {

                vm.sub_sub_localities = response.data;

                if (response.data.length === 0) {
                    Toast.show('No relevant sub-sub localities found');
                }


            });
        };

        vm.chooseSubSubLocality = function(sub_sub_locality) {
            vm.schoolData.sub_sub_locality_id = sub_sub_locality.id;
            vm.schoolData.sub_sub_locality_name = sub_sub_locality.name;

            vm.sub_sub_localities = {};


        };

        vm.regionSelection = function(state) {

            if (vm.schoolData.district_id === undefined || vm.schoolData.district_id === null) {
                Toast.show('Fill in address details to proceed further');
            }

            if (vm.regions.length === 0) {

                ApiHelper.getAPIData(state + '/school/' +
                    Helper.findIdFromUrl() + '/district/subsublocality/all').then(function(response) {

                    vm.regions = response.data;
                    vm.dump_regions = vm.regions;

                    if (response.data.length === 0) {
                        Toast.show('No relevant sub localities found');
                    }

                });
            }
        };

        vm.selectRegion = function(index, region, range) {

            if (range === undefined || range === null) {
                Toast.show('Specify the range for the region');
            }

            if (range === '0-1') {
                vm.range0.push(region);
            } else if (range === '1-3') {
                vm.range1.push(region);
            } else if (range === '3-6') {
                vm.range3.push(region);
            }


            vm.regions.splice(index, 1);
        };

        vm.removeRegion = function(index, region, range) {

            if (range === '0-1') {
                vm.range0.splice(index, 1);
            } else if (range === '1-3') {
                vm.range1.splice(index, 1);
            } else if (range === '3-6') {
                vm.range3.splice(index, 1);
            }

            vm.regions.push(region);
        };
        vm.selectRegionDist = function(index, region, range) {

            if (range === undefined || range === null) {
                Toast.show('Specify the range for the region');
            }

            if (range === '0-1') {
                vm.range0Dist.push(region);
            } else if (range === '1-3') {
                vm.range1.push(region);
            } else if (range === '3-6') {
                vm.range3.push(region);
            }


            vm.regionsDist.splice(index, 1);
        };

        vm.removeRegionDist = function(index, region, range) {

            if (range === '0-1') {
                vm.range0Dist.splice(index, 1);
            } else if (range === '1-3') {
                vm.range1.splice(index, 1);
            } else if (range === '3-6') {
                vm.range3.splice(index, 1);
            }

            vm.regionsDist.push(region);
        };
        vm.getBankDetails = function(ifsc) {



            if (ifsc === null || ifsc === undefined) {

                Toast.show('Please enter a IFSC code');
                return;
            }

            ApiHelper.getAPIData('schooladmin/get/bankdetail/' + ifsc).then(function(response) {

                vm.bank = response.data;

                vm.bankdetail.bank_name = vm.bank.BANK;
                vm.bankdetail.bankcount = vm.bank.BANK;
                vm.bankdetail.branch = vm.bank.BRANCH;
                vm.bankdetail.bank_code = vm.bank.BANKCODE;

            });
        };

        vm.clearBankDetails = function() {

            vm.bankdetail.bankcount = null;


        };

    }

    SchoolFeeNSeatController.$inject = ['Helper', 'AppTableListService', '$scope', 'ApiHelper', 'ServerMessage', '$rootScope', 'Toast'];

    function SchoolFeeNSeatController(Helper, AppTableListService, $scope, ApiHelper, ServerMessage, $rootScope, Toast) {

        var vm = this;

        vm.seatinfo = [];

        vm.pastSeatInfo = [];


        vm.errorToast = [];

        vm.current_year = new Date().getFullYear();

        vm.show_save_button = true;

        vm.alloted_year_seats = 'alloted_seats_' + vm.current_year;

        vm.checkValidSeat = function(item) {

            vm.show_save_button = true;

            if (item.available_seats < item[vm.alloted_year_seats]) {

                vm.errorToast = Toast.show('Available seats cannot be less then allotted seats for Admission Cycle ' + vm.current_year);

                vm.show_save_button = false;

            } else {

                Toast.hide(vm.errorToast);
            }
        };

        vm.initSeatDetails = function(udise) {

            ApiHelper.getAPIData('nodaladmin/get/school-seat-details/' + udise).then(function(response) {
                vm.seatinfo = response.data;

            });

        };

        vm.initSeatInfo = function (slug, udise) {

            ApiHelper.getAPIData('nodaladmin/get/past-seat-details/' + udise).then(function (response) {
                vm.pastSeatInfo = response.data;
            });

        };


        vm.process25per = function(item){
            item.available_seats = 0;
            if(item.total_seats !== null && item.total_seats !== undefined){
                item.available_seats = Math.ceil(item.total_seats/100*25);
            }
            
            return item;
        }

        vm.calculateMaxSeat = function() {
            vm.non_dropouts = 0;

            angular.forEach(vm.seatinfo, function(val, key) {

                if (val.dropouts_2017 === undefined || val.dropouts_2017 === '') {

                    if (val.level == 'Pre-Primary') {

                        Toast.show('Please fill out droupouts for the year 2017');
                    }


                }

                if (val.level == 'Pre-Primary') {

                    vm.non_dropouts = val.alloted_seats_2017 - val.dropouts_2017;
                }

                // if (typeof val.alloted_seats_2015 !== undefined && typeof val.alloted_seats_2016 !== undefined && typeof val.alloted_seats_2017 !== undefined && typeof val.alloted_seats_2018 !== undefined && val.alloted_seats_2015 > 0 && val.alloted_seats_2016 > 0 && val.alloted_seats_2017 > 0 && val.alloted_seats_2018 > 0) {

                vm.seatinfo[key]['available_seats'] = Math.max(val.alloted_seats_2015, val.alloted_seats_2016, val.alloted_seats_2017, val.alloted_seats_2018);


                if (vm.seatinfo.length > 1) {

                    if (val.dropouts_2017 !== undefined || val.dropouts_2017 !== '') {

                        if (val.level == 'Class 1') {

                            vm.seatinfo[key]['available_seats'] = vm.seatinfo[key]['available_seats'] - vm.non_dropouts;

                        }

                    }


                } else {

                    if (val.level == 'Class 1') {

                        vm.seatinfo[key]['available_seats'] = vm.seatinfo[key]['available_seats'] - vm.non_dropouts;

                    }

                }



            });

        };


        vm.calculateTotalFee = function(value) {
            value.total = 0;

            if (typeof value.tution_fee !== undefined && value.tution_fee !== undefined) {
                value.total = value.total + (value.tution_fee * 12);
            }

            if (typeof value.other_fee !== undefined && value.other_fee !== undefined) {
                value.total = value.total + value.other_fee;
            }

            return value;

        };



        vm.submitDetails = function(feestructure, seatinfo, udise) {

            var data = [];
            data.feestructure = feestructure;
            data.seatinfo = seatinfo;
            data.past_seat_info = vm.pastSeatInfo;


            ApiHelper.addItem('nodaladmin/school/update/seat/' + udise, data).then(function(response) {

                ServerMessage.show(response.data);



            });

        };


    }

})();
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
(function() {

    "use strict";

    angular
        .module('app.role-nodaladmin')
        .controller('DashboardController', DashboardController);

    DashboardController.$inject = ['Helper', 'AppTableListService', '$scope', 'ApiHelper', 'ServerMessage', '$rootScope', 'NgMap', 'Toast', '$sce'];

    function DashboardController(Helper, AppTableListService, $scope, ApiHelper, ServerMessage, $rootScope, NgMap, Toast, $sce) {

        var vm = this;
        vm.admissionCycle = {};
        vm.districts = {};
        vm.nodals = {};
        vm.schoolInfo = {};
        vm.schools = {};
        vm.all_class = {};
        vm.studentFilteredData = {};
        vm.overviewFilterData = {};
        vm.show_school_information = false;
        vm.show_overview_metrics = false;
        vm.show_student_details = false;

        function showPieChart(chartData, divId, svgId) {

            d3.select('#' + svgId).remove();
            var height = 400;
            var width = 400;

            var chart = nv.models.pieChart()
                .x(function(d) {
                    return d.label;
                })
                .y(function(d) {
                    return d.value;
                })
                .labelSunbeamLayout(true)
                // .pieLabelsOutside(true)
                .valueFormat(d3.format(".0f"))
                .width(width)
                .height(height)
                .noData('No Data')
                .showLabels(false);

            d3.select('#' + divId).append("svg")
                .attr("id", svgId);

            d3.select('#' + svgId)
                .datum(chartData)
                .transition().duration(500)
                .attr('width', width)
                .attr('height', height)
                .call(chart);

            return chart;

        }

        function showBarChart(chartData, divId, svgId) {
            d3.select('#' + svgId).remove();
            var historicalBarChart = [{
                key: "Cumulative Return",
                values: chartData
            }];
            var width = 400;
            var height = 400;

            var chart = nv.models.discreteBarChart()
                .x(function(d) {
                    return d.label;
                })
                .y(function(d) {
                    return d.value;
                })
                .valueFormat(d3.format(".1f"))
                .showValues(false)
                .staggerLabels(true)
                // .showLabels(false)
                .width(width)
                .height(height)
                .noData('No Data')
                .duration(250);
            chart.yAxis
                .axisLabel("Enrollment/Application percentage")

            d3.select('#' + divId).append("svg")
                .attr("id", svgId);

            d3.select('#' + svgId)
                .datum(historicalBarChart)
                .attr('width', width)
                .attr('height', height)
                .call(chart);

            nv.utils.windowResize(chart.update);
            return chart;

        }

        vm.initAdmissionCycle = function() {


            ApiHelper.getData('nodaladmin/get/applicationcycle').then(function(response) {

                vm.admissionCycle = response.data;

            });

        };

        vm.initDistricts = function() {


            ApiHelper.getData('nodaladmin/get/district/list').then(function(response) {

                vm.districts = response.data;

            });
        };

        vm.initNodals = function(district_id) {

            ApiHelper.getData('nodaladmin/get/nodal/' + district_id + '/list').then(function(response) {

                vm.nodals = response.data;

            });
        };

        vm.getSchoolInfo = function(application_cycle_year, district_id, nodal_id, refresh) {


            vm.show_school_information = false;

            ApiHelper.getData('nodaladmin/get/schoolinfo/application_cycle_year/' + application_cycle_year + '/district_id/' + district_id + '/nodal_id/' + nodal_id + '/' + refresh).then(function(response) {

                vm.show_school_information = true;

                vm.schoolInfo = response.data;

                showPieChart(response.data.data.rejection_graph, 'rejectionGraph', 'rejectionGraphSvg');

            });
        };

        vm.initSchools = function(district_id) {

            ApiHelper.getData('nodaladmin/get/schools/' + district_id + '/list').then(function(response) {

                vm.schools = response.data;

            });
        };

        vm.initClass = function() {

            ApiHelper.getData('nodaladmin/get/class/list').then(function(response) {

                vm.all_class = response.data;

            });
        };


        vm.applyFilterStudentDetails = function(API, formData) {

            vm.show_student_details = false;

            ApiHelper.postData(API, formData).then(function(response) {

                vm.show_student_details = true;
                
                vm.studentFilteredData = response.data;

                showPieChart(response.data.data.ews_vs_dg, 'ewsDg', 'ewsDgSvg');

                showPieChart(response.data.data.boys_vs_girls, 'boyGirl', 'boyGirlSvg');

            });


        };

        vm.applyFilterOverviewMetrics = function(API, formData) {

            vm.show_overview_metrics = false;

            ApiHelper.postData(API, formData).then(function(response) {

                vm.show_overview_metrics = true;

                vm.overviewFilterData = response.data;

                showPieChart(response.data.data.school_registration, 'schoolRegistration', 'schoolRegistrationSvg');

                showPieChart(response.data.data.school_participation, 'schoolParticipation', 'schoolParticipationSvg');

                showBarChart(response.data.data.top_schools, 'topSchools', 'topSchoolsSvg');

            });


        };



    }

})();