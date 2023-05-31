(function() {

    "use strict";

    angular
        .module('app.core')
        .controller('WidgetController', WidgetController);

    WidgetController.$inject = ['$scope', 'ApiHelper', 'ServerMessage', 'Helper'];

    function WidgetController($scope, ApiHelper, ServerMessage, Helper) {

        /* jshint validthis: true */
        var vm = this;

        $scope.getWidget = function(API, dataHolder) {

            Helper.showSpinner();

            ApiHelper.getWidgetData(API).then(function(response) {
                Helper.hideSpinner();
                $scope[dataHolder] = response;
            });

        };

    }

})();