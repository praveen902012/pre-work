(function () {

    "use strict";

    angular
        .module('app.role-stateadmin')
        .controller('SchoolController', SchoolController)
        .controller('SchoolFeeNSeatController', SchoolFeeNSeatController);

    SchoolController.$inject = ['Helper', 'AppTableListService', '$scope', 'ApiHelper', 'ServerMessage', '$rootScope', 'NgMap', 'Toast'];

    function SchoolController(Helper, AppTableListService, $scope, ApiHelper, ServerMessage, $rootScope, NgMap, Toast) {

        var vm = this;
        vm.schoolData = {};
        vm.schoolData.lat = 12.9716;
        vm.schoolData.lng = 77.5946;
        $scope.helper = Helper;
        $scope.pageId = Helper.findIdFromUrl();

        vm.districts = [];
        vm.blocks = [];
        vm.localities = [];
        vm.sub_localities = [];
        vm.sub_sub_localities = [];

        vm.locations = [{
            pos: [12.9716, 77.5946]
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

            $scope.$apply(function () {
                vm.schoolData.venue = address;
                vm.schoolData.lat = lat;
                vm.schoolData.lng = lng;
                vm.schoolData.place_id = place_id;

                vm.locations = [{
                    pos: [vm.place.geometry.location.lat(), vm.place.geometry.location.lng()]
                }];
            });

        };

        vm.getSchoolAdminDetails = function (API) {

            ApiHelper.getAPIData(API).then(function (response) {
                vm.schoolData = response.data;
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

        vm.saveSchool = function (API, slug) {

            ApiHelper.addItem(API, vm.schoolData).then(function (response) {
                window.location = root + "/stateadmin/state/" + slug + "/schools";
                Toast.success(response.data.msg);
            });

        };

        vm.initAddress = function () {


            ApiHelper.getData('stateadmin/student-registration/step3/get', {
                'registration_no': Helper.findIdFromUrl()
            }).then(function (response) {

                vm.schoolData = response.data;

            });
        };

        vm.clearStateData = function () {

            vm.districts = [];
            vm.blocks = [];
            vm.localities = [];
            vm.sub_localities = [];
            vm.sub_sub_localities = [];
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


        vm.getDistricts = function (state, keyword) {

            vm.clearDistrictData();

            if (state === null || state === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData('stateadmin/search/district/' + state.id + '/' +
                keyword).then(function (response) {

                    vm.districts = response.data;

                });
        };

        vm.chooseDistrict = function (district) {
            vm.schoolData.district_id = district.id;
            vm.schoolData.district_name = district.name;

            vm.clearDistrictData();

        };

        vm.clearDistrictData = function () {


            vm.blocks = [];
            vm.localities = [];
            vm.sub_localities = [];
            vm.sub_sub_localities = [];

            vm.schoolData.block_id = null;
            vm.schoolData.block_name = "";
            vm.schoolData.locality_id = null;
            vm.schoolData.locality_name = "";
            vm.schoolData.sub_locality_id = null;
            vm.schoolData.sub_locality_name = "";
            vm.schoolData.sub_sub_locality_id = null;
            vm.schoolData.sub_sub_locality_name = "";
        };

        vm.getBlocks = function (district_id, keyword) {
            vm.clearBlockData();

            if (district_id === null || district_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData('stateadmin/search/block/' + district_id + '/' +
                keyword).then(function (response) {

                    vm.blocks = response.data;

                });
        };

        vm.chooseBlock = function (block) {
            vm.schoolData.block_id = block.id;
            vm.schoolData.block_name = block.name;

            vm.clearBlockData();

        };

        vm.clearBlockData = function () {

            vm.localities = [];
            vm.sub_localities = [];
            vm.sub_sub_localities = [];

            vm.schoolData.locality_id = null;
            vm.schoolData.locality_name = "";
            vm.schoolData.sub_locality_id = null;
            vm.schoolData.sub_locality_name = "";
            vm.schoolData.sub_sub_locality_id = null;
            vm.schoolData.sub_sub_locality_name = "";
        };

        vm.getLocalities = function (block_id, keyword) {

            vm.clearLocalityData();

            if (block_id === null || block_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData('stateadmin/search/locality/' + block_id + '/' +
                keyword).then(function (response) {

                    vm.localities = response.data;

                });
        };

        vm.chooseLocality = function (locality) {
            vm.schoolData.locality_id = locality.id;
            vm.schoolData.locality_name = locality.name;


            vm.clearLocalityData();

        };

        vm.clearLocalityData = function () {

            vm.sub_localities = [];
            vm.sub_sub_localities = [];

            vm.schoolData.sub_locality_id = null;
            vm.schoolData.sub_locality_name = "";
            vm.schoolData.sub_sub_locality_id = null;
            vm.schoolData.sub_sub_locality_name = "";
        };

        vm.getSubLocalities = function (locality_id, keyword) {
            vm.clearSubLocalityData();
            if (locality_id === null || locality_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData('stateadmin/search/sublocality/' + locality_id + '/' +
                keyword).then(function (response) {

                    vm.sub_localities = response.data;

                });
        };

        vm.chooseSubLocality = function (sub_locality) {
            vm.schoolData.sub_locality_id = sub_locality.id;
            vm.schoolData.sub_locality_name = sub_locality.name;

            vm.clearSubLocalityData();

        };

        vm.clearSubLocalityData = function () {
            vm.sub_sub_localities = [];

            vm.schoolData.sub_sub_locality_id = null;
            vm.schoolData.sub_sub_locality_name = "";
        };

        vm.getSubSubLocalities = function (sub_locality_id, keyword) {

            if (sub_locality_id === null || sub_locality_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData('stateadmin/search/subsublocality/' + sub_locality_id + '/' +
                keyword).then(function (response) {

                    vm.sub_sub_localities = response.data;

                });
        };

        vm.chooseSubSubLocality = function (sub_sub_locality) {
            vm.schoolData.sub_sub_locality_id = sub_sub_locality.id;
            vm.schoolData.sub_sub_locality_name = sub_sub_locality.name;

        };

        vm.getSchoolRegionDetails = function (udise) {

            ApiHelper.getAPIData('stateadmin/get/school-region-details/' + udise).then(function (response) {

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

        vm.saveSchoolNeighbourhood = function (udise) {

            vm.schoolData.levels = [];

            if (vm.schoolData.level != 'undefined') {

                angular.forEach(vm.schoolData.level, function (val, key) {

                    if (val != 'undefined' && val != false) {
                        vm.schoolData.levels.push(key);
                    }
                });

            }

            if (vm.range0.length > 0 || vm.range0Dist.length > 0) {
                var range01 = [];
                vm.schoolData.range0 = [];

                angular.forEach(vm.range0, function (val, key) {
                    range01.push(val.id);
                });

                if (vm.range0Dist.length > 0) {
                    angular.forEach(vm.range0Dist, function (val, key) {
                        range01.push(val.id);
                    });
                }

                vm.schoolData.range0 = range01;

            } else {
                Toast.success('select atleast one area under the neighbourhood area');
                return;
            }

            Toast.success('Please wait till we save  your  details...');

            ApiHelper.addItem('stateadmin/school/update/region/' + udise, vm.schoolData).then(function (response) {
                ServerMessage.show(response.data);

            });

        };

        vm.selectRegion = function (index, region, range) {

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

        vm.removeRegion = function (index, region, range) {

            if (range === '0-1') {
                vm.range0.splice(index, 1);
            } else if (range === '1-3') {
                vm.range1.splice(index, 1);
            } else if (range === '3-6') {
                vm.range3.splice(index, 1);
            }

            vm.regions.push(region);
        };
        vm.selectRegionDist = function (index, region, range) {

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

        vm.removeRegionDist = function (index, region, range) {

            if (range === '0-1') {
                vm.range0Dist.splice(index, 1);
            } else if (range === '1-3') {
                vm.range1.splice(index, 1);
            } else if (range === '3-6') {
                vm.range3.splice(index, 1);
            }

            vm.regionsDist.push(region);
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

        vm.checkValidSeat = function (item) {

            vm.show_save_button = true;

            if (item.available_seats < item[vm.alloted_year_seats]) {

                vm.errorToast = Toast.show('Available seats cannot be less then allotted seats for Admission Cycle ' + vm.current_year);

                vm.show_save_button = false;

            } else {

                Toast.hide(vm.errorToast);
            }
        };

        vm.initSeatDetails = function (udise) {

            ApiHelper.getAPIData('stateadmin/get/school-seat-details/' + udise).then(function (response) {
                vm.seatinfo = response.data;

            });

        };

        vm.initSeatInfo = function (slug, udise) {

            ApiHelper.getAPIData('stateadmin/get/past-seat-details/' + udise).then(function (response) {
                vm.pastSeatInfo = response.data;
            });

        };


        vm.process25per = function (item) {
            item.available_seats = 0;
            if (item.total_seats !== null && item.total_seats !== undefined) {
                item.available_seats = Math.ceil(item.total_seats / 100 * 25);
            }

            return item;
        }

        vm.calculateMaxSeat = function () {
            vm.non_dropouts = 0;

            angular.forEach(vm.seatinfo, function (val, key) {

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

        vm.calculateTotalFee = function (value) {
            value.total = 0;

            if (typeof value.tution_fee !== undefined && value.tution_fee !== undefined) {
                value.total = value.total + (value.tution_fee * 12);
            }

            if (typeof value.other_fee !== undefined && value.other_fee !== undefined) {
                value.total = value.total + value.other_fee;
            }

            return value;

        };



        // vm.submitDetails = function(feestructure, seatinfo, udise) {

        //     var data = [];
        //     data.feestructure = feestructure;
        //     data.seatinfo = seatinfo;
        //     data.past_seat_info = vm.pastSeatInfo;


        //     ApiHelper.addItem('stateadmin/school/update/seat/' + udise, data).then(function(response) {

        //         ServerMessage.show(response.data);



        //     });

        // };


    }

})();