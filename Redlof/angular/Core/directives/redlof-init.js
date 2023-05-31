(function() {

  'use strict';

  var Directives = angular.module('app.core');

  Directives.directive('redlofInit', [function() {
    return {
      restrict: 'A',
      link: function(scope, element, attrs) {

        var functionName = attrs.redlofInit;
        var functionParam = attrs.redlofInitParam;

        if (typeof functionParam !== 'undefined') {
          window[functionName](functionParam);
        } else {
          window[functionName]();
        }

      }
    };
  }]);

})();