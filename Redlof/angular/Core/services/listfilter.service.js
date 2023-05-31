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