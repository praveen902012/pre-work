(function() {

    "use strict";

    angular
        .module('app.role-stateadmin')
        .controller('DashboardController', DashboardController);

    DashboardController.$inject = ['Helper', 'AppTableListService', '$scope', 'ApiHelper', 'ServerMessage', '$rootScope', 'NgMap', 'Toast', '$sce'];

    function DashboardController(Helper, AppTableListService, $scope, ApiHelper, ServerMessage, $rootScope, NgMap, Toast, $sce) {

        var vm = this;
        vm.admissionCycle = {};
        vm.selectedImages = [];
        vm.show_school_information = false;
        vm.show_overview_metrics = false;
        vm.show_student_details = false;
        vm.previousSelectedImages = [];
        vm.districts = {};
        vm.nodals = {};
        vm.schoolInfo = {};
        vm.imageData = {};
        vm.schools = {};
        vm.all_class = {};
        vm.studentFilteredData = {};
        vm.overviewFilterData = {};
        vm.selectionChanged = 'never';

        function showPieChart(chartData, divId, svgId) {

            d3.select('#' + svgId).remove();
            var height = 400;
            var width = 400;

            var chart = nv.models.pieChart()
                .x(function(d) {
                    return d.label;
                })
                .y(function(d) {
                    return d.value;
                })
                .labelSunbeamLayout(true)
                // .pieLabelsOutside(true)
                .valueFormat(d3.format(".0f"))
                .width(width)
                .height(height)
                .noData('No Data')
                .showLabels(false);

            d3.select('#' + divId).append("svg")
                .attr("id", svgId);

            d3.select('#' + svgId)
                .datum(chartData)
                .transition().duration(500)
                .attr('width', width)
                .attr('height', height)
                .call(chart);

            return chart;

        }

        function showBarChart(chartData, divId, svgId) {
            d3.select('#' + svgId).remove();
            var historicalBarChart = [{
                key: "Cumulative Return",
                values: chartData
            }];
            var width = 400;
            var height = 400;

            var chart = nv.models.discreteBarChart()
                .x(function(d) {
                    return d.label;
                })
                .y(function(d) {
                    return d.value;
                })
                // .valueFormat(d3.format(".1f"))
                // .showValues(true)
                // .staggerLabels(false)
                .width(width)
                .height(height)
                .noData('No Data')
                .duration(250);
            chart.yAxis
                .axisLabel("Enrollment/Application percentage")

            d3.select('#' + divId).append("svg")
                .attr("id", svgId);

            d3.select('#' + svgId)
                .datum(historicalBarChart)
                .attr('width', width)
                .attr('height', height)
                .call(chart);

            nv.utils.windowResize(chart.update);
            return chart;

        }

        vm.initAdmissionCycle = function() {


            ApiHelper.getData('stateadmin/get/applicationcycle').then(function(response) {

                vm.admissionCycle = response.data;

            });

        };

        vm.initDistricts = function() {


            ApiHelper.getData('stateadmin/get/district/list').then(function(response) {

                vm.districts = response.data;

            });
        };

        vm.initNodals = function(district_id) {

            ApiHelper.getData('stateadmin/get/nodal/' + district_id + '/list').then(function(response) {

                vm.nodals = response.data;

            });
        };

        vm.getSchoolInfo = function(application_cycle_year, district_id, nodal_id, refresh) {

            vm.show_school_information = false;

            ApiHelper.getData('stateadmin/get/schoolinfo/application_cycle_year/' + application_cycle_year + '/district_id/' + district_id + '/nodal_id/' + nodal_id + '/' + refresh).then(function(response) {

                vm.show_school_information = true;

                vm.schoolInfo = response.data;

                showPieChart(response.data.data.rejection_graph, 'rejectionGraph', 'rejectionGraphSvg');

            });
        };

        vm.initSchools = function(district_id) {

            ApiHelper.getData('stateadmin/get/schools/' + district_id + '/list').then(function(response) {

                vm.schools = response.data;

            });
        };

        vm.initClass = function() {

            ApiHelper.getData('stateadmin/get/class/list').then(function(response) {

                vm.all_class = response.data;

            });
        };


        vm.applyFilterStudentDetails = function(API, formData) {

            vm.show_student_details = false;

            ApiHelper.postData(API, formData).then(function(response) {

                vm.show_student_details = true;

                vm.studentFilteredData = response.data;

                showPieChart(response.data.data.ews_vs_dg, 'ewsDg', 'ewsDgSvg');

                showPieChart(response.data.data.boys_vs_girls, 'boyGirl', 'boyGirlSvg');

            });
        };

        vm.applyFilterOverviewMetrics = function(API, formData) {

            vm.show_overview_metrics = false;

            ApiHelper.postData(API, formData).then(function(response) {

                vm.show_overview_metrics = true;

                vm.overviewFilterData = response.data;

                showPieChart(response.data.data.school_registration, 'schoolRegistration', 'schoolRegistrationSvg');

                showPieChart(response.data.data.school_participation, 'schoolParticipation', 'schoolParticipationSvg');

                showBarChart(response.data.data.top_districts, 'topDistricts', 'topDistrictsSvg');

                showBarChart(response.data.data.top_nodals, 'topNodals', 'topNodalsSvg');

            });


        };


        vm.changeImageSelection = function(pic) {

            var pic = pic;
            vm.selectionChanged = 'show';

            if (pic.selection) {

                pic.class1 = 'btn-default';
                pic.class2 = 'gallery-img';
                pic.selection = false;

                var index = vm.selectedImages.indexOf(pic.id);
                if (index !== -1) vm.selectedImages.splice(index, 1);


            } else {

                if (vm.selectedImages.length < 4) {



                    pic.class1 = 'btn-primary';
                    pic.class2 = 'gallery-img-selected';
                    pic.selection = true;
                    vm.selectedImages.push(pic.id);
                } else {

                    vm.selectionChanged = 'never';

                    Toast.success('Featured image cannot have more then 4 images.');
                }



            }

            return pic;



        };

        vm.addSelectedImages = function(pic_id) {


            vm.previousSelectedImages.push(pic_id);

            vm.selectedImages.push(pic_id);

        };

        vm.saveImageSelection = function() {

            vm.selectionChanged = 'wait';

            vm.imageData.selected_images = vm.selectedImages;
            vm.imageData.previous_images = vm.previousSelectedImages;

            ApiHelper.postData('stateadmin/save/featured/images', vm.imageData).then(function(response) {
                vm.selectionChanged = 'never';
                Toast.success('Saved successfully');

            });



        }



    }

})();