(function() {

  'use strict';

  var Directives = angular.module('app.core');

  Directives.directive('redlofEmoji', function() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function(scope, element, attrs, ngModelCtrl) {

        setTimeout(function() {
          wdtEmojiBundle.defaults.type = 'facebook';
          wdtEmojiBundle.init('.comment-input textarea');

          wdtEmojiBundle.defaults.type = 'facebook';
          wdtEmojiBundle.init('.my-post-body textarea');
        }, 1000);

      }
    };
  });

})();