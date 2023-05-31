(function() {

  "use strict";

  angular.module('app.core')
    .config(CoreConfiguration);

  CoreConfiguration.$inject = ['$httpProvider', '$qProvider', 'toastrConfig', '$sceDelegateProvider', 'usSpinnerConfigProvider', '$interpolateProvider', '$compileProvider'];

  function CoreConfiguration($httpProvider, $qProvider, toastrConfig, $sceDelegateProvider, usSpinnerConfigProvider, $interpolateProvider, $compileProvider) {

    $httpProvider.interceptors.push('InterceptorFactory');


    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');

    $compileProvider.preAssignBindingsEnabled(true);
    $qProvider.errorOnUnhandledRejections(false);

    usSpinnerConfigProvider.setDefaults({
      color: '#f39200',
      lines: 13,
      length: 18,
      width: 7,
      radius: 26,
      scale: 0.75,
      corners: 0.9,
      opacity: 0.25,
      rotate: 0,
      direction: 1,
      speed: 1.1,
      trail: 61,
      left: 50,
      top: 50
    });

    $sceDelegateProvider.resourceUrlWhitelist(['self', new RegExp('^(http[s]?):\/\/(w{3}.)?youtube\.com/.+$')]);

    angular.extend(toastrConfig, {
      autoDismiss: true,
      allowHtml: true,
      closeButton: true,
      progressBar: true,
      newestOnTop: true,
      maxOpened: 4,
      tapToDismiss: true,
      preventOpenDuplicates: true,
      positionClass: 'toast-bottom-left',
      timeOut: 3000,
      extendedTimeOut: 1000,
    });

  }

  angular.module('app.core').directive('custominit', function() {
    return {
      link: function(scope, elem, attrs) {

        angular.element(elem).removeClass('hide_element');
        angular.element(elem).addClass('show_element');

      }
    };
  });


})();