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