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