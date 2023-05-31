(function() {

    "use strict";

    angular
        .module('app.role-admin')
        .controller('SchoolController', SchoolController);

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

        NgMap.getMap().then(function(map) {
            vm.map = map;
        });

        vm.placeChanged = function() {
            vm.place = this.getPlace();
            vm.map.setCenter(vm.place.geometry.location);

            var lat = vm.place.geometry.location.lat();
            var lng = vm.place.geometry.location.lng();
            var address = vm.place.formatted_address;

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

        vm.saveSchool = function(API, slug) {

            vm.schoolData.levels = [];

            if (vm.schoolData.level != 'undefined') {

                angular.forEach(vm.schoolData.level, function(val, key) {

                    if (val != 'undefined' && val != false) {
                        vm.schoolData.levels.push(key);
                    }
                });

            }

            ApiHelper.addItem(API, vm.schoolData).then(function(response) {
                window.location = root + "/admin/states/" + slug + "/schools";
                Toast.success(response.data.msg);
            });

        };

        vm.initAddress = function() {


            ApiHelper.getData('admin/student-registration/step3/get', {
                'registration_no': Helper.findIdFromUrl()
            }).then(function(response) {

                vm.schoolData = response.data;

            });
        };

        vm.clearStateData = function() {

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


        vm.getDistricts = function(state_id, keyword) {

            vm.clearDistrictData();

            if (keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData('admin/search/district/' + state_id + '/' +
                keyword).then(function(response) {

                vm.districts = response.data;

                if (response.data.length === 0) {
                    Toast.success('No relevant districts found');
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

        vm.getBlocks = function(district_id, keyword) {
            vm.clearBlockData();

            if (district_id === null || district_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData('admin/search/block/' + district_id + '/' +
                keyword).then(function(response) {

                vm.blocks = response.data;

                if (response.data.length === 0) {
                    Toast.success('No relevant blocks found');
                }


            });
        };

        vm.chooseBlock = function(block) {
            vm.schoolData.block_id = block.id;
            vm.schoolData.block_name = block.name;

            vm.clearBlockData();

            vm.blocks = {};

        };

        vm.clearBlockData = function() {

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

        vm.getLocalities = function(block_id, keyword) {

            vm.clearLocalityData();

            if (block_id === null || block_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData('admin/search/locality/' + block_id + '/' +
                keyword).then(function(response) {

                vm.localities = response.data;

                if (response.data.length === 0) {
                    Toast.success('No relevant localities found');
                }

            });
        };

        vm.chooseLocality = function(locality) {
            vm.schoolData.locality_id = locality.id;
            vm.schoolData.locality_name = locality.name;


            vm.clearLocalityData();

            vm.localities = {};

        };

        vm.clearLocalityData = function() {

            vm.sub_localities = [];
            vm.sub_sub_localities = [];

            vm.schoolData.sub_locality_id = null;
            vm.schoolData.sub_locality_name = "";
            vm.schoolData.sub_sub_locality_id = null;
            vm.schoolData.sub_sub_locality_name = "";
        };

        vm.getSubLocalities = function(locality_id, keyword) {
            vm.clearSubLocalityData();
            if (locality_id === null || locality_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData('admin/search/sublocality/' + locality_id + '/' +
                keyword).then(function(response) {

                vm.sub_localities = response.data;

                if (response.data.length === 0) {
                    Toast.success('No relevant sub localities found');
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

        vm.getSubSubLocalities = function(sub_locality_id, keyword) {

            if (sub_locality_id === null || sub_locality_id === undefined || keyword === null || keyword === undefined) {
                return;
            }

            ApiHelper.getAPIData('admin/search/subsublocality/' + sub_locality_id + '/' +
                keyword).then(function(response) {

                vm.sub_sub_localities = response.data;

                if (response.data.length === 0) {
                    Toast.success('No relevant sub-sub localities found');
                }

            });
        };

        vm.chooseSubSubLocality = function(sub_sub_locality) {
            vm.schoolData.sub_sub_locality_id = sub_sub_locality.id;
            vm.schoolData.sub_sub_locality_name = sub_sub_locality.name;

            vm.sub_sub_localities = {};

        };

    }

})();