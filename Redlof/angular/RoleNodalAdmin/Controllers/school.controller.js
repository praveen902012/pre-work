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