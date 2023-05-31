(function() {

  'use strict';

  var Directives = angular.module('app.core');

  Directives.directive('datetimez', function() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function(scope, element, attrs, ngModelCtrl) {
        element.datetimepicker({
          language: 'en',
          pickDate: false,
        }).on('changeDate', function(e) {
          ngModelCtrl.$setViewValue(e.date);
          scope.$apply();
        });
      }
    };
  });

})();