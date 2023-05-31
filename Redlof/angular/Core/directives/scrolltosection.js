(function() {

  'use strict';

  var Directives = angular.module('app.core');

  Directives.directive('scrollToSection', function() {
    return {
      link: function(scope, element, attrs) {
        var value = attrs.scrollToSection;
        element.click(function() {
          scope.$apply(function() {
            var selector = "[scroll-section='" + value + "']";
            var element = $(selector);

            if (element.length) {
              $("body").animate({
                scrollTop: element[0].offsetTop
              }, 1000);
            }
          });
        });
      }
    };
  });

})();