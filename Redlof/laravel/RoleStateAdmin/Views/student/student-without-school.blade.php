@extends('stateadmin::includes.layout')
@section('content')
<section class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-10 col-xs-10">
                <h2>Registered Student Without Selecting School</h2>
            </div>
            <div class="col-sm-2 col-xs-12">
                <div class="rt-action  pull-left" ng-controller="DownloadReportController as Download">
                    <button type="button" class="btn btn-warning pull-right"
                        ng-click="Download.triggerDownload('stateadmin/download/students/without/school')">
                        <i class="fa fa-download"></i> Download Excel
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div class="tb-container">
                    <div class="table-responsive ">
                        <div class="rte-table bg-wht">

                            <table class="table">
                                <thead>
                                  <tr>
                                    <th>Registration Table</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applied_student as $student)
                                        <tr>
                                            <td>{{$student->basic_details->registration_no}}</td>
                                            <td>{{$student->basic_details->first_name}}</td>
                                            <td>{{$student->basic_details->mobile}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection