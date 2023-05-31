(function() {

    "use strict";

    angular
        .module('app.role-nodaladmin')
        .controller('DashboardController', DashboardController);

    DashboardController.$inject = ['Helper', 'AppTableListService', '$scope', 'ApiHelper', 'ServerMessage', '$rootScope', 'NgMap', 'Toast', '$sce'];

    function DashboardController(Helper, AppTableListService, $scope, ApiHelper, ServerMessage, $rootScope, NgMap, Toast, $sce) {

        var vm = this;
        vm.admissionCycle = {};
        vm.districts = {};
        vm.nodals = {};
        vm.schoolInfo = {};
        vm.schools = {};
        vm.all_class = {};
        vm.studentFilteredData = {};
        vm.overviewFilterData = {};
        vm.show_school_information = false;
        vm.show_overview_metrics = false;
        vm.show_student_details = false;

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
                .valueFormat(d3.format(".1f"))
                .showValues(false)
                .staggerLabels(true)
                // .showLabels(false)
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


            ApiHelper.getData('nodaladmin/get/applicationcycle').then(function(response) {

                vm.admissionCycle = response.data;

            });

        };

        vm.initDistricts = function() {


            ApiHelper.getData('nodaladmin/get/district/list').then(function(response) {

                vm.districts = response.data;

            });
        };

        vm.initNodals = function(district_id) {

            ApiHelper.getData('nodaladmin/get/nodal/' + district_id + '/list').then(function(response) {

                vm.nodals = response.data;

            });
        };

        vm.getSchoolInfo = function(application_cycle_year, district_id, nodal_id, refresh) {


            vm.show_school_information = false;

            ApiHelper.getData('nodaladmin/get/schoolinfo/application_cycle_year/' + application_cycle_year + '/district_id/' + district_id + '/nodal_id/' + nodal_id + '/' + refresh).then(function(response) {

                vm.show_school_information = true;

                vm.schoolInfo = response.data;

                showPieChart(response.data.data.rejection_graph, 'rejectionGraph', 'rejectionGraphSvg');

            });
        };

        vm.initSchools = function(district_id) {

            ApiHelper.getData('nodaladmin/get/schools/' + district_id + '/list').then(function(response) {

                vm.schools = response.data;

            });
        };

        vm.initClass = function() {

            ApiHelper.getData('nodaladmin/get/class/list').then(function(response) {

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

                showBarChart(response.data.data.top_schools, 'topSchools', 'topSchoolsSvg');

            });


        };



    }

})();