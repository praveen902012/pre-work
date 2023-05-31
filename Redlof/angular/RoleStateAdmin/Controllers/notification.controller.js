(function() {

    "use strict";

    angular
        .module('app.role-stateadmin')
        .controller('NotificationController', NotificationController);

    NotificationController.$inject = ['$scope', 'ApiHelper', 'NotificationService', 'Toast', 'Helper', 'ngDialog', 'ServerMessage'];

    function NotificationController($scope, ApiHelper, NotificationService, Toast, Helper, ngDialog, ServerMessage) {
        /* jshint validthis: true */
        var vm = this;

        vm.disable_trigger_btn = true;

        vm.disable_student_trigger_btn = true;

        vm.processing = false;

        vm.school_count = 0;

        vm.student_count = 0;

        vm.notificationService = NotificationService;

        vm.notificationData = {};
        vm.selected_users = [];
        vm.all_users = [];

        vm.notificationData.trigger_time = new Date();
        vm.notificationData.trigger_time = moment(vm.notificationData.trigger_time).format('DD-MM-YYYY');

        vm.notificationData.expiry_time = new Date();
        vm.notificationData.expiry_time.setMonth(vm.notificationData.expiry_time.getMonth() + 1);
        vm.notificationData.expiry_time = moment(vm.notificationData.expiry_time).format('DD-MM-YYYY');

        var triggerOptions = {
            dateFormat: "d-m-Y H:i",
            defaultDate: vm.notificationData.trigger_time,
            minDate: 'today',
            enableTime: true,
            onChange: function() {
                //handel min date
            }
        };

        var expiryOptions = {
            dateFormat: "d-m-Y H:i",
            defaultDate: vm.notificationData.expiry_time,
            minDate: vm.notificationData.trigger_time,
            enableTime: true,
        };

        vm.triggerDateObject = flatpickr("#trigger_time", triggerOptions);
        vm.expiryDateObject = flatpickr("#expiry_time", expiryOptions);

        vm.getNewUsers = function(keyword) {
            if (keyword.length < 2) {
                return;
            }

            ApiHelper.getAPIData('stateadmin/users/search?s=' + keyword).then(function(response) {
                vm.all_users = response.data;
            });
        };

        vm.getUserByFilter = function(filter) {
            ApiHelper.getAPIData('stateadmin/users/filter?filter=' + filter).then(function(response) {

                angular.forEach(response.data, function(member, key) {
                    __addUser(member);
                });

            });
        };


        vm.getSchoolCount = function(school_status) {

            ApiHelper.getAPIData('stateadmin/notification/get/school_count?school_status=' + school_status).then(function(response) {

                vm.school_count = response.data;

                if (vm.school_count > 0) {

                    vm.disable_trigger_btn = false;

                } else {

                    vm.disable_trigger_btn = true;

                }

            });


        };

        vm.getStudentCount = function(student_status) {

            ApiHelper.getAPIData('stateadmin/notification/get/student_count?student_status=' + student_status).then(function(response) {

                vm.student_count = response.data;

                if (vm.student_count > 0) {

                    vm.disable_student_trigger_btn = false;

                } else {

                    vm.disable_student_trigger_btn = true;
                }
            });
        };

        function __addUser(member) {

            var Index = Helper.getTheArrIndex(vm.selected_users, member.id);

            if (Index === null) {
                vm.selected_users.push(member);
            }

        }

        vm.emptyUsers = function() {
            vm.all_users = [];
            vm.search_user = "";
        };

        vm.selectMember = function(member) {
            __addUser(member);
        };

        vm.removeMember = function(member, index) {
            vm.selected_users.splice(index, 1);
        };

        vm.triggerNotification = function() {

            //check if user has selected any of the member
            //if not return

            if (vm.selected_users.length === 0) {
                Toast.info('Please select users to send notification');
                return;
            }

            vm.notificationData.member_ids = __filterIds(vm.selected_users);

            ApiHelper.addItem("stateadmin/notification/popup/add", vm.notificationData).then(function(response) {
                ServerMessage.show(response.data, {
                    timeOut: 6000
                });

            });
        };

        vm.triggerEmailNotification = function() {

            if (vm.school_count == 0) {

                Toast.error('Please select atleast one school from the filters');
            }

            vm.processing = true;

            ApiHelper.getAPIData('stateadmin/notification/get/school-admin?school_status=' + vm.search_filter + '&notification_type=mail').then(function(response) {

                vm.notificationData.member_ids = response.data;

                ApiHelper.addItem("stateadmin/notification/email/add", vm.notificationData).then(function(response) {

                    ServerMessage.show(response.data, {
                        timeOut: 6000
                    });

                    vm.processing = false;


                });

            });


        };

        vm.triggerSMSNotification = function(type) {

            if(type == 'school'){

                if (vm.school_count == 0) {

                    Toast.error('Please select atleast one school from the filters');
                }
    
                vm.processing = true;
    
                ApiHelper.getAPIData('stateadmin/notification/get/school-admin?school_status=' + vm.search_filter + '&notification_type=sms').then(function(response) {
    
                    vm.notificationData.member_ids = response.data;
    
                    ApiHelper.addItem("stateadmin/notification/sms/add", vm.notificationData).then(function(response) {
                        
                        ServerMessage.show(response.data, {
                            timeOut: 6000
                        });
    
                        vm.processing = false;
                    });
                });

            }

            if(type == 'student'){

                if (vm.student_count == 0) {

                    Toast.error('Please select atleast one Student type from the filters');
                }
                
                vm.processing = true;

                ApiHelper.addItem('stateadmin/notification/notification/sms/add-for-student?student_status=' + vm.student_filter + '&notification_type=sms', vm.notificationData).then(function(response) {
    
                    ServerMessage.show(response.data, {

                        timeOut: 6000
                    });

                    vm.processing = false;
                });
            }


        };

        vm.triggerPushNotification = function() {


            if (vm.selected_users.length === 0) {
                return;
            }

            vm.notificationData.member_ids = __filterIds(vm.selected_users);

            ApiHelper.addItem("stateadmin/notification/push/add", vm.notificationData).then(function(response) {
                ServerMessage.show(response.data, {
                    timeOut: 6000
                });

            });
        };

        vm.triggerBrowserNotification = function() {


            if (vm.selected_users.length === 0) {
                return;
            }

            vm.notificationData.member_ids = __filterIds(vm.selected_users);

            ApiHelper.addItem("stateadmin/notification/browser/add", vm.notificationData).then(function(response) {
                ServerMessage.show(response.data, {
                    timeOut: 6000
                });

            });
        };

        function __filterIds(selected_users) {
            var IDs = [];

            angular.forEach(selected_users, function(member, key) {
                IDs.push(member.id);
            });

            return IDs;
        }

        vm.trixAttachmentAdd = function(e) {

            var attachment;
            attachment = e.attachment;

            if (!e.attachment.file) {
                return;
            }

            ApiHelper.addItem("member/journal/article/remote/image/add", {
                remote_image: e.attachment.file
            }).then(function(response) {

                if (response.data.data) {

                    return attachment.setAttributes({
                        url: response.data.data.image,
                        href: response.data.data.photo,
                        id: response.data.data.name,
                    });

                }

            });

        };

        vm.trixAttachmentRemove = function(e) {

            var attachment;
            attachment = e.attachment;

            var url = attachment.getAttribute("url");

            if (typeof url === 'undefined') {
                return;
            }

            var regex = /[\w-]+\.(jpg|png|txt)/g;

            var filename = url.match(regex);

            if (typeof filename[0] === 'undefined') {
                return;
            }

            ApiHelper.addItem("member/journal/article/remote/image/remove", {
                filename: filename[0]
            }).then(function(response) {});

        };

    }

})();