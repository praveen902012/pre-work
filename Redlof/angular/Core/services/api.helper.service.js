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