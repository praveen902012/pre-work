(function() {

   'use strict';

   var Directives = angular.module('app.core');

   Directives.directive('icheck', ['$timeout', '$parse', function($timeout, $parse) {
      return {
         link: function($scope, element, $attrs) {
            return $timeout(function() {
               var ngModelGetter, value;
               ngModelGetter = $parse($attrs.ngModel);
               value = $parse($attrs.ngValue)($scope);
               var ngHasClick = $attrs.ngHasClick;

               $scope.$watch($attrs.ngModel, function(newValue) {
                  $(element).iCheck('update');
               });

               return $(element).iCheck({
                  checkboxClass: 'icheckbox_flat-green',
                  radioClass: 'iradio_flat-green'
               }).on('ifChanged', function(event) {
                  if ($(element).attr('type') === 'checkbox' && $attrs.ngModel) {
                     $scope.$apply(function() {
                        return ngModelGetter.assign($scope, event.target.checked);
                     });
                  }
                  if ($(element).attr('type') === 'radio' && $attrs.ngModel) {
                     return $scope.$apply(function() {
                        return ngModelGetter.assign($scope, value);
                     });
                  }
               }).on('ifClicked', function(event) {
                  if (ngHasClick === 'true') {
                     element.trigger('click');
                  }
               });
            });
         }
      };
   }]);

})();