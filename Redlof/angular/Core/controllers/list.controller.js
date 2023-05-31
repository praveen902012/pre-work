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