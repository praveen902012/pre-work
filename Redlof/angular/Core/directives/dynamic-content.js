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