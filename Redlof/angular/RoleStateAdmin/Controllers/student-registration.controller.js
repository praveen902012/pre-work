(function () {

    "use strict";

    angular
        .module('app.role-stateadmin')
        .controller('Step1Controller', Step1Controller)
        .controller('Step3Controller', Step3Controller)
        .controller('Step4Controller', Step4Controller)
        .controller('Step5Controller', Step5Controller)
        .controller('StudentRegistrationController', StudentRegistrationController)
        .controller('ResumeRegistrationController', ResumeRegistrationController)
        .controller('StuController', StuController);

    Step1Controller.$inject = ['$scope', '$state', 'Toast', '$stateParams', 'ApiHelper', 'Helper', 'ServerMessage'];
    Step3Controller.$inject = ['$scope', '$rootScope', '$state', 'Toast', '$stateParams', 'ApiHelper', 'Helper', 'NgMap'];
    Step4Controller.$inject = ['$scope', '$state', 'Toast', '$stateParams', 'ApiHelper', 'Helper', '$rootScope'];
    Step5Controller.$inject = ['$scope', '$state', 'Toast', '$stateParams', 'ApiHelper', 'Helper'];
    StuController.$inject = ['$scope', '$state', 'Toast', '$stateParams', 'ApiHelper', 'Helper', 'ServerMessage'];
    ResumeRegistrationController.$inject = ['$scope', '$state', 'Toast', '$stateParams', 'ApiHelper', 'Helper', 'ServerMessage'];
    StudentRegistrationController.$inject = ['$scope', '$state', 'Toast', '$stateParams', 'ApiHelper', 'Helper', 'ServerMessage'];


    function Step1Controller($scope, $state, Toast, $stateParams, ApiHelper, Helper, ServerMessage) {


        var vm = this;
        vm.formData = {};
        vm.years = [];
        vm.dates = [];
        vm.months = [];

        vm.inProcess = false;

        vm.level_selected = [];

        vm.income = [{
            value: 'caste_certificate',
            name: 'Caste certificate issued by Tehsildar/Competent authority'
        }, {
            value: 'medical_certificate',
            name: 'Medical certificate issued by government hospital in respect of child with special needs/Disabled'
        }, {
            value: 'transgender_certificate',
            name: 'Documentary Evidence for transgender'

        }];


        vm.getLevels = function (slug) {
            ApiHelper.getData(slug + '/levels/list').then(function (response) {

                vm.levels = response.data;

            });
        };

        vm.getDates = function () {

            var mindate = 1;

            var max = 31;

            for (var i = mindate; i <= max; i++) {
                var obejct = {};

                obejct.id = i;
                obejct.date = i;

                vm.dates.push(obejct);

            }

            return vm.dates;
        };

        vm.getMonths = function () {

            var minmonth = 1;

            var max = 12;

            var counter = 1;

            for (var i = minmonth; i <= max; i++) {
                var obejct = {};

                obejct.id = counter;
                obejct.month = moment().month(i - 1).format('MMMM');

                vm.months.push(obejct);

                counter++;
            }

            return vm.months;
        };

        vm.getYears = function () {

            var minyear = 2016;

            var max = 2019;

            var counter = 1;

            for (var i = minyear; i <= max; i++) {
                var obejct = {};

                obejct.id = counter;
                obejct.year = i;

                vm.years.push(obejct);

                counter++;
            }

            vm.years = vm.years.reverse();

            return vm.years;
        };

        vm.getYears1 = function () {


            var minyear = new Date().getFullYear() - 30;

            var max = new Date().getFullYear();

            var counter = 1;
            vm.years = [];
            for (var i = minyear; i <= max; i++) {
                var obejct = {};

                obejct.id = counter;
                obejct.year = i;

                vm.years.push(obejct);

                counter++;
            }

            vm.years = vm.years.reverse();

            return vm.years;
        };


        vm.initParentDetails = function (registration_no) {

            ApiHelper.getData('stateadmin/script/student/step2/get', {
                'registration_no': registration_no
            }).then(function (response) {

                vm.formData = response.data;

                if (vm.formData.parent_type === null || vm.formData.parent_type === undefined) {

                    vm.formData.parent_type = 'father';
                }
            });
        };

        vm.saveParentDetails = function (API, formname) {

            vm.inProcess = true;

            if (vm.formData.parent_type.father === false && vm.formData.parent_type.mother === false && vm.formData.parent_type.guardian === false) {

                Toast.error('Please select atleast one parent type');

                vm.inProcess = false;
            } else {

                Toast.success('Please wait till we save your details...');

                ApiHelper.addItem(API, vm.formData).then(function (response) {
                    ServerMessage.show(response.data);
                    vm.inProcess = false;
                }).catch(function () {
                    vm.inProcess = false;
                });
            }

        }


        vm.initPersonalDetails = function (slug) {

            ApiHelper.getData(slug + '/student-registration/step1/get', {
                'registration_no': Helper.findIdFromUrl()
            }).then(function (response) {

                vm.formData = response.data;

                if (vm.formData.email === '' || vm.formData.email === null || typeof vm.formData.email === undefined) {

                    delete vm.formData.email;
                }

                vm.level_selected = vm.formData.level_selected;

            });
        };

        vm.assignDGProof = function (dg_type) {
            var value = '';

            if (dg_type === 'sc' || dg_type === 'st' || dg_type === 'obc') {

                value = 'caste_certificate';
            } else if (dg_type === 'orphan' || dg_type === 'with_hiv' || dg_type === 'disable') {

                value = 'medical_certificate';

            } else if (dg_type === 'kodh') {

                value = 'relevant_certificate';

            } else if (dg_type === 'single_women') {


                value = 'death_certificate';
            }

            return value;
        };

        vm.getAppropriateClass = function (dob, step = 'create') {

            vm.level_selected = [];

            var now = moment();
            var current_year = now.year();

            var appropriate_level = [];

            if (dob === undefined || dob === null) {
                Toast.success('Please fill date of birth to continue');
                return;
            }

            var minDate = new Date(dob.year + '-' + dob.month + '-' + dob.date);

            var n_l = new Date((current_year - 5) + '-04-01').setHours(0, 0, 0, 0);
            var n_u = new Date((current_year - 3) + '-03-31').setHours(0, 0, 0, 0);
            var c_l = new Date((current_year - 6) + '-04-01').setHours(0, 0, 0, 0);
            var c_u = new Date((current_year - 5) + '-03-31').setHours(0, 0, 0, 0);

            if (minDate >= n_l && minDate <= n_u) {

                for (var i = 0; i < vm.levels.length; i++) {

                    if (vm.levels[i].level === 'Pre-Primary') {
                        appropriate_level = vm.levels[i];
                    }
                }

            } else if (minDate >= c_l && minDate <= c_u) {

                for (var j = 0; j < vm.levels.length; j++) {

                    if (vm.levels[j].level === 'Class 1') {
                        appropriate_level = vm.levels[j];
                    }
                }

            } else {

                Toast.success('The child is not applicable to apply for any of the entry classes');
                return;

            }

            vm.level_selected.push(appropriate_level);
        };


        vm.changeInParentInfo = function (parent_type, selected) {

            if (selected == true) {

                var parent_array = [];
                parent_array['parent_name'] = '';
                parent_array['parent_mobile_no'] = '';
                parent_array['parent_profession'] = '';

                vm.formData[parent_type] = parent_array;


            } else {

                delete vm.formData[parent_type];
            }

        };



    }

    function Step3Controller($scope, $rootScope, $state, Toast, $stateParams, ApiHelper, Helper, NgMap) {


        var vm = this;
        vm.districts = [];
        vm.blocks = [];
        vm.localities = [];
        vm.sub_localities = [];
        vm.sub_sub_localities = [];
        vm.formData = {};
        vm.stateTypeAll = [{ id: 'rural', name: 'Rural' }, { id: 'urban', name: 'Urban' }];

        vm.chooseBlock1 = function (block) {

            vm.formData.sub_block_id = block.id;
            vm.formData.sub_block_name = block.name;
            vm.formData.sub_block_type = block.type;

            vm.subblocks = {};

        };

        vm.choosestatetype = function (stype) {
            vm.formData.state_type = stype.id;
            vm.clearBlockData();
        };

        vm.initBlocks1 = function (slug, block_id, stype, district_id) {

            vm.clearBlockData();

            if (block_id === null || block_id === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/getall/subblock/' + district_id + '/' + stype + '/' + block_id).then(function (response) {

                vm.subblocks = response.data;

                if (response.data.length === 0) {
                    Toast.show('No relevant blocks found');
                }

            });
        };

        vm.locations = [{
            pos: [30.3165, 78.0322]
        }];

        NgMap.getMap().then(function (map) {
            vm.map = map;
        });


        vm.placeChanged = function () {
            vm.place = this.getPlace();
            vm.map.setCenter(vm.place.geometry.location);

            var lat = vm.place.geometry.location.lat();
            var lng = vm.place.geometry.location.lng();
            var address = vm.place.formatted_address;
            var place_id = vm.place.place_id;

            $scope.$apply(function () {

                vm.formData.venue = address;
                vm.formData.lat = lat;
                vm.formData.lng = lng;
                vm.formData.place_id = place_id;

                vm.locations = [{
                    pos: [lat, lng]
                }];
            });

        };

        vm.placeDragged = function (school) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'location': this.getPosition()
            }, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {

                    if (results[0]) {
                        vm.place = results[0];

                        var lat = vm.place.geometry.location.lat();
                        var lng = vm.place.geometry.location.lng();
                        var address = vm.place.formatted_address;
                        var place_id = vm.place.place_id;

                        $scope.$apply(function () {
                            vm.formData.lat = lat;
                            vm.formData.lng = lng;
                            vm.formData.venue = address;
                            vm.formData.place_id = place_id;
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


        vm.initAddress = function (slug) {


            ApiHelper.getData(slug + '/student-registration/step3/get', {
                'registration_no': Helper.findIdFromUrl()
            }).then(function (response) {

                vm.formData = response.data;

                vm.formData.type = 'ward';
                if (vm.formData.state_type == 'urban') {
                    vm.formData.stateType = { id: 'urban', name: 'Urban' };
                }
                if (vm.formData.state_type == 'rural') {
                    vm.formData.stateType = { id: 'rural', name: 'Rural' };
                }

                if (vm.formData.lat === '' || vm.formData.lat === null || typeof vm.formData.lat === undefined) {
                    vm.formData.lat = 30.3165;
                    vm.formData.lng = 78.0322;

                } else {
                    var latlng = [];
                    latlng[0] = vm.formData.lat;
                    latlng[1] = vm.formData.lng;

                    vm.locations = [{
                        pos: latlng
                    }];
                }


                if (vm.formData.block_type === null) {

                    vm.formData.block_type = 'ward';

                    vm.show_selection_type = true;

                } else {

                    vm.show_selection_type = false;

                }

            });
        };


        vm.clearStateData = function () {

            vm.districts = [];
            vm.blocks = [];
            vm.localities = [];
            vm.sub_localities = [];
            vm.sub_sub_localities = [];
            vm.formData.district_id = null;
            vm.formData.district_name = "";
            vm.formData.block_id = null;
            vm.formData.block_name = "";
            vm.formData.locality_id = null;
            vm.formData.locality_name = "";
            vm.formData.sub_locality_id = null;
            vm.formData.sub_locality_name = "";
            vm.formData.sub_sub_locality_id = null;
            vm.formData.sub_sub_locality_name = "";
        };

        vm.initDistricts = function (slug, state) {

            vm.clearDistrictData();

            if (state === null || state === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/getall/district/' + state.id).then(function (response) {

                vm.districts = response.data;

                if (response.data.length === 0) {
                    Toast.show('No relevant districts found');
                }

            });
        };

        vm.initBlocks = function (slug, district_id) {

            vm.clearBlockData();

            if (district_id === null || district_id === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/getall/block/' + district_id).then(function (response) {

                vm.blocks = response.data;

                if (response.data.length === 0) {
                    Toast.show('No relevant blocks found');
                }

            });
        };


        vm.getDistricts = function (slug, state, keyword) {

            vm.clearDistrictData();

            if (state === null || state === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/search/district/' + state.id + '/' +
                keyword).then(function (response) {

                    vm.districts = response.data;

                    if (response.data.length === 0) {
                        Toast.success('No relevant districts found');
                    }

                });
        };

        vm.chooseDistrict = function (district) {
            vm.formData.district_id = district.id;
            vm.formData.district_name = district.name;

            vm.clearDistrictData();

            vm.districts = {};

        };

        vm.clearDistrictData = function () {


            vm.blocks = [];
            vm.localities = [];
            vm.sub_localities = [];
            vm.sub_sub_localities = [];

            vm.formData.block_id = null;
            vm.formData.block_name = "";
            vm.formData.locality_id = null;
            vm.formData.locality_name = "";
            vm.formData.sub_locality_id = null;
            vm.formData.sub_locality_name = "";
            vm.formData.sub_sub_locality_id = null;
            vm.formData.sub_sub_locality_name = "";
        };

        vm.getBlocks = function (slug, district_id, keyword) {
            vm.clearBlockData();

            if (district_id === null || district_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/search/block/' + district_id + '/' +
                keyword).then(function (response) {

                    vm.blocks = response.data;

                    if (response.data.length === 0) {
                        Toast.success('No relevant blocks found');
                    }

                });
        };

        vm.chooseBlock = function (block) {
            vm.formData.block_id = block.id;
            vm.formData.block_name = block.name;
            vm.formData.block_type = block.type;

            if (vm.formData.block_type === null) {

                vm.show_selection_type = true;

            } else {

                vm.show_selection_type = false;

            }

            vm.clearBlockData();

            vm.blocks = {};

        };

        vm.clearBlockData = function () {

            vm.localities = [];
            vm.subblocks = [];
            vm.formData.sub_block_name = '';
            vm.formData.sub_block_type = '';
            vm.formData.sub_block_id = '';
            vm.sub_localities = [];
            vm.sub_sub_localities = [];

            vm.formData.locality_id = null;
            vm.formData.locality_name = "";
            vm.formData.sub_locality_id = null;
            vm.formData.sub_locality_name = "";
            vm.formData.sub_sub_locality_id = null;
            vm.formData.sub_sub_locality_name = "";
        };

        vm.getAllLocalities = function (slug, block_id) {

            vm.clearLocalityData();

            if (block_id === null || block_id === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/search/locality/' + block_id).then(function (response) {

                vm.localities = response.data;

                if (response.data.length === 0) {
                    Toast.success('No relevant localities found');
                }

            });
        };

        vm.getLocalities = function (slug, block_id, keyword) {

            vm.clearLocalityData();

            if (block_id === null || block_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/search/locality/' + block_id + '/' +
                keyword).then(function (response) {

                    vm.localities = response.data;

                    if (response.data.length === 0) {
                        Toast.success('No relevant localities found');
                    }

                });
        };

        vm.chooseLocality = function (locality) {
            vm.formData.locality_id = locality.id;
            vm.formData.locality_name = locality.name;


            vm.clearLocalityData();

            vm.localities = {};


        };

        vm.clearLocalityData = function () {

            vm.sub_localities = [];
            vm.sub_sub_localities = [];

            vm.formData.sub_locality_id = null;
            vm.formData.sub_locality_name = "";
            vm.formData.sub_sub_locality_id = null;
            vm.formData.sub_sub_locality_name = "";
        };

        vm.getSubLocalities = function (slug, locality_id, keyword) {
            vm.clearSubLocalityData();
            if (locality_id === null || locality_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/search/sublocality/' + locality_id + '/' +
                keyword).then(function (response) {

                    vm.sub_localities = response.data;

                    if (response.data.length === 0) {
                        Toast.success('No relevant sub localities found');
                    }

                });
        };

        vm.chooseSubLocality = function (sub_locality) {
            vm.formData.sub_locality_id = sub_locality.id;
            vm.formData.sub_locality_name = sub_locality.name;

            vm.clearSubLocalityData();

            vm.sub_localities = {};

        };

        vm.clearSubLocalityData = function () {
            vm.sub_sub_localities = [];

            vm.formData.sub_sub_locality_id = null;
            vm.formData.sub_sub_locality_name = "";
        };

        vm.getSubSubLocalities = function (slug, sub_locality_id, keyword) {

            if (sub_locality_id === null || sub_locality_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData(slug + '/search/subsublocality/' + sub_locality_id + '/' +
                keyword).then(function (response) {

                    vm.sub_sub_localities = response.data;

                    if (response.data.length === 0) {
                        Toast.success('No relevant sub-sub localities found');
                    }

                });
        };

        vm.chooseSubSubLocality = function (slug, sub_sub_locality) {
            vm.formData.sub_sub_locality_id = sub_sub_locality.id;
            vm.formData.sub_sub_locality_name = sub_sub_locality.name;

            vm.sub_sub_localities = {};

        };

        vm.checkDistrictStatus = function (slug, district_id) {

            ApiHelper.getAPIData(slug + '/check/district/status/' + district_id).then(function (response) {

                vm.status = response.data;

                if (vm.status == 'close') {

                    $rootScope.openPopup('state', 'registration', 'registration-not-allowed', 'create-popup-style sm-popup-style');

                }

            });



        };

    }

    function Step4Controller($scope, $state, Toast, $stateParams, ApiHelper, Helper, $rootScope) {


        var vm = this;

        vm.Registration = {};

        vm.formData = {};

        vm.initFileDetails = function (slug) {

            ApiHelper.getData(slug + '/student-registration/step4/get', {
                'registration_no': Helper.findIdFromUrl()
            }).then(function (response) {

                vm.formData = response.data;

                vm.Registration.documents = vm.formData.files;

            });
        };

        vm.initChecked = function (state) {

            if (state > 4) {
                vm.Registration.birth_accept = true;
                vm.Registration.parent_accept = true;
                vm.Registration.address_accept = true;
                vm.Registration.category_accept = true;

            }

        };

        vm.reportSchoolDeny = function (slug, registration_id) {

            $rootScope.openPopup('state', 'registration', 'reported-admission-denied', 'create-popup-style sm-popup-style');

            ApiHelper.getData(slug + '/student-registration/report/admission-deny/' + registration_id).then(function (response) {

                vm.checkReport(slug, registration_id);


            });

        };

        vm.checkReport = function (slug, registration_id) {

            ApiHelper.getData(slug + '/student-registration/report/check/' + registration_id).then(function (response) {

                vm.reported = response.data;

            });
        };
    }

    function Step5Controller($scope, $state, Toast, $stateParams, ApiHelper, Helper) {


        var vm = this;
        vm.formData = {};
        vm.schools = [];
        vm.nearby_schools = [];
        vm.selected_schools = [];
        vm.selected_nearby_schools = [];
        vm.formData.preferences = [];
        vm.formData.nearby_preferences = [];
        vm.formData.registration_no = Helper.findIdFromUrl();

        vm.initSchools = function (slug, distance) {

            ApiHelper.getData(slug + '/student-registration/schools/get', {
                'distance': distance,
                'registration_no': vm.formData.registration_no
            }).then(function (response) {

                vm.schools = response.data;

                angular.forEach(vm.formData.preferences, function (val, key) {

                    angular.forEach(vm.schools, function (s_val, s_key) {

                        if (parseInt(val) === parseInt(s_val.id)) {
                            vm.schools.splice(s_key, 1);
                        }

                    });

                });

            });
        };

        vm.initNearbySchools = function (slug, distance) {

            ApiHelper.getData(slug + '/student-registration/schools/get', {
                'distance': distance,
                'registration_no': vm.formData.registration_no
            }).then(function (response) {

                vm.nearby_schools = response.data;

                angular.forEach(vm.formData.nearby_preferences, function (val, key) {

                    angular.forEach(vm.nearby_schools, function (s_val, s_key) {

                        if (parseInt(val) === parseInt(s_val.id)) {
                            vm.nearby_schools.splice(s_key, 1);
                        }

                    });

                });

            });
        };

        vm.selectSchool = function (index, school) {

            if (vm.formData.preferences.indexOf(school.id) !== -1) {
                Toast.show('You have already added this school to your preference');
                return;
            }

            vm.selected_schools.push(school);
            vm.formData.preferences.push(school.id);

            vm.schools.splice(index, 1);
        };

        vm.selectNearbySchool = function (index, school) {



            if (vm.formData.nearby_preferences.indexOf(school.id) !== -1) {
                Toast.show('You have already added this school to your preference');
                return;
            }

            vm.selected_nearby_schools.push(school);
            vm.formData.nearby_preferences.push(school.id);

            vm.nearby_schools.splice(index, 1);
        };

        vm.removeNearbySchool = function (index, school) {
            vm.selected_nearby_schools.splice(index, 1);
            vm.formData.nearby_preferences.splice(index, 1);

            vm.nearby_schools.push(school);
        };

        vm.removeSchool = function (index, school) {
            vm.selected_schools.splice(index, 1);
            vm.formData.preferences.splice(index, 1);

            vm.schools.push(school);
        };

        vm.getStep5Data = function (slug, registration_id) {

            ApiHelper.getAPIData(slug + '/student-registration/schools/get/step5/' + registration_id).then(function (response) {

                if (response.data.selected_schools != null && response.data.selected_schools != 'undefined') {

                    vm.selected_schools = response.data.selected_schools;

                    angular.forEach(vm.selected_schools, function (value, key) {

                        vm.formData.preferences.push(value.id);

                    });
                }

                if (response.data.selected_nearby_schools != null && response.data.selected_nearby_schools != 'undefined') {

                    vm.selected_nearby_schools = response.data.selected_nearby_schools;

                    angular.forEach(vm.selected_nearby_schools, function (value, key) {

                        vm.formData.nearby_preferences.push(value.id);

                    });

                }


            });

        };

    }

    function ResumeRegistrationController($scope, $state, Toast, $stateParams, ApiHelper, Helper, ServerMessage) {

        var vm = this;
        $scope.helper = Helper;
        vm.registrationData = {};

        vm.is_validApplicant = false;

        vm.resumeRegistration = function (API) {

            vm.inProcess = true;

            ApiHelper.addItem(API, vm.registrationData).then(function (response) {

                vm.inProcess = false;
                ServerMessage.show(response.data);
                vm.is_validApplicant = true;

            }).catch(function () {
                vm.inProcess = false;
            });
        };

        vm.verifyRegistration = function (API) {

            vm.inProcess = true;

            ApiHelper.addItem(API, vm.registrationData).then(function (response) {

                vm.inProcess = false;
                ServerMessage.show(response.data);

            }).catch(function () {
                vm.inProcess = false;
            });
        };

        vm.resendOTP = function (API) {

            ApiHelper.addItem(API, vm.registrationData).then(function (response) {

                Toast.success(response.data.msg);

            });
        };

    }

    function StudentRegistrationController($scope, $state, Toast, $stateParams, ApiHelper, Helper, ServerMessage) {

        var vm = this;
        $scope.helper = Helper;
        vm.districtStatus = [];

        vm.checkRegistrationStatus = function (slug) {


            ApiHelper.getAPIData(slug + '/check/lottery/status').then(function (response) {

                vm.lotteryStatus = response.data;


            });

            ApiHelper.getAPIData(slug + '/check/registration/status').then(function (response) {


                if (vm.lotteryStatus.status != 'completed') {

                    vm.districtStatus = response.data;
                }

            });

        };
    }

    function StuController($scope, $state, Toast, $stateParams, ApiHelper, Helper, ServerMessage) {

        var vm = this;
        $scope.helper = Helper;
        vm.student = {};

        vm.search = function (stateid, keyword) {
            ApiHelper.getData(stateid + '/student/search', { registration: keyword }).then(function (response) {
                vm.student = response.data;
            })
        }
        vm.searchname = function (stateid, firstname, parentname, studob) {
            ApiHelper.getData(stateid + '/student/searchByName', { firstname, parentname, studob }).then(function (response) {
                vm.student = response.data;
            })
        }

        vm.getStuInfo = function (slug) {


            ApiHelper.getAPIData(slug + '/check/lottery/status').then(function (response) {

                vm.lotteryStatus = response.data;


            });

            ApiHelper.getAPIData(slug + '/check/registration/status').then(function (response) {



            });

        };
    }

})();