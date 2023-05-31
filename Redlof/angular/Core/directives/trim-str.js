(function() {

   'use strict';

   var Directives = angular.module('app.core');

   Directives.directive('trimStr', [function() {
      return {
         restrict: 'A',
         link: function(scope, element, attrs) {
            var message = attrs.trimStr;
            var limit = attrs.trimStrLimit;

            var trimmed = message.substr(0, parseInt(limit));
            if (message.length > parseInt(limit)) {
               $(element).text(trimmed + '...');
            } else {
               $(element).text(message);
            }
         }
      };
   }]);

})();