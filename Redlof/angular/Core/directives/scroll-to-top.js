(function() {

  'use strict';

  var Directives = angular.module('app.core');

  Directives.directive('scrollOnClick', function() {
    return {
      restrict: 'A',
      link: function(scope, $elm, attrs) {

        var idToScroll = attrs.href;
        var offset = 300,
          offset_opacity = 1200,
          scroll_top_duration = 700;

        //hide or show the "back to top" link
        $(window).scroll(function() {
          if ($(this).scrollTop() > offset) {
            $elm.addClass('cd-is-visible');
          } else {
            $elm.removeClass('cd-is-visible cd-fade-out');
          }
          if ($(this).scrollTop() > offset_opacity) {
            $elm.addClass('cd-fade-out');
          }
        });

        $elm.on('click', function() {
          var $target;
          if (idToScroll) {
            $target = $(idToScroll);
          } else {
            $target = $elm;
          }
          $("body").animate({
            scrollTop: $target.offset().top
          }, scroll_top_duration);
        });
      }
    };
  });

})();