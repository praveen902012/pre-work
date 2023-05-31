(function() {

  'use strict';

  var Directives = angular.module('app.core');

  Directives.directive('ngInitial', function() {
    return {
      restrict: 'A',
      controller: [
        '$scope', '$element', '$attrs', '$parse',
        function($scope, $element, $attrs, $parse) {
          var getter, setter, val;
          val = $attrs.ngInitial || $attrs.value;
          getter = $parse($attrs.ngModel);
          setter = getter.assign;
          setter($scope, val);
        }
      ]
    };
  });

})();