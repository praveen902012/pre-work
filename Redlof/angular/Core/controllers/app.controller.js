(function () {

  "use strict";

  angular
    .module('app.core')
    .controller('AppController', AppController);

  AppController.$inject = ['$rootScope', '$scope', 'ApiHelper', 'ServerMessage', 'Helper', 'ngDialog', 'FormValidationService'];

  function AppController($rootScope, $scope, ApiHelper, ServerMessage, Helper, ngDialog, FormValidationService) {

    /* jshint validthis: true */
    var vm = this;
    $scope.helper = Helper;
    $scope.pageId = Helper.findIdFromUrl();

    $scope.inProcess = false;

    $scope.postAPI = function (API, data, refresh) {

      var loader = ServerMessage.loading($scope.msg);

      ApiHelper.postData(API, data).then(function (response) {

        ServerMessage.hideLoader(loader);

        ServerMessage.show(response);

        if (typeof refresh !== 'undefined' && refresh) {
          location.reload();
        }
      });
    };

    $scope.getAPI = function (API, params, dataHolder) {

      var loader = ServerMessage.loading($scope.msg);

      ApiHelper.getData(API, params).then(function (response) {

        ServerMessage.hideLoader(loader);

        ServerMessage.show(response, {
          timeOut: 6000
        });

        if (typeof dataHolder !== 'undefined') {
          $scope[dataHolder] = response.data;
        }
      });
    };

    $scope.getAPIData = function (API, dataHolder, key, secondkey) {

      var loader = ServerMessage.loading($scope.msg);



      ApiHelper.getAPIData(API).then(function (response) {
        ServerMessage.hideLoader(loader);


        ServerMessage.show(response, {
          timeOut: 6000
        });

        // TODO need to discuss and work on
        if (typeof key !== 'undefined') {
          response.data[key] = new Date(response.data[key]);
        }

        if (typeof secondkey !== 'undefined') {
          response.data.personal_details[secondkey] = new Date(response.data.personal_details[secondkey]);
        }



        $scope[dataHolder] = response.data;
      });
    };

    $scope.create = function (API, formData, formname, refresh) {

      var loader = ServerMessage.loading($scope.msg);

      $scope.inProcess = true;

      var formButtonObject = $("button[type=submit]", document.getElementsByName(formname)[0]);

      $(formButtonObject).attr('disabled', 'disabled');

      // Store formname in $rootscope variable so that we can use the form name for form valdiation
      $rootScope.last_submitted_form_name = formname;

      ApiHelper.addItem(API, formData).then(function (response) {

        if (typeof refresh !== 'undefined' && refresh) {
          location.reload();
          return;
        }

        $rootScope.$broadcast('created-' + formname);

        ServerMessage.hideLoader(loader);

        //Helper.hideSpinner();
        ServerMessage.show(response.data);

        // Reset last submitted form
        FormValidationService.resetForm();

        $scope.inProcess = false;
        $(formButtonObject).removeAttr('disabled');

        if (typeof formname !== 'undefined') {
          Helper.resetForm(formname);
        }
      }).catch(function () {
        $scope.inProcess = false;
      });
    };

    $scope.update = function (API, formData) {

      $scope.inProcess = true;

      var loader = ServerMessage.loading($scope.msg);

      var formButtonObject = $("button[type=submit]", document.getElementsByName(formname)[0]);

      $(formButtonObject).attr('disabled', 'disabled');

      ApiHelper.addItem(API, formData).then(function (response) {

        $scope.inProcess = false;

        $(formButtonObject).removeAttr('disabled');

        ServerMessage.hideLoader(loader);

        ServerMessage.show(response.data);

        ngDialog.closeAll();
      });
    };

    $scope.getDropdown = function (API, dataHolder) {

      var loader = ServerMessage.loading($scope.msg);

      ApiHelper.getDropdown(API).then(function (response) {

        $scope[dataHolder] = response.data;

        ServerMessage.hideLoader(loader);

      });
    };
  }
})();