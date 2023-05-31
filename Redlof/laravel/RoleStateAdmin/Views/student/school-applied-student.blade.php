@extends('stateadmin::includes.layout')
@section('content')
<section class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
    <div class="container-fluid">

        <div class="form-group" ng-controller="DownloadReportController as Download">
            <button type="button" class="btn btn-warning pull-right"
                ng-click="Download.triggerDownload('stateadmin/download/applied-student/{{$udise}}')"><i
                    class="fa fa-download"></i> एक्षेल (Excel) को डाउनलोड करे</button>
        </div>
        <br>

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
                                        <th>DOB</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applied_student as $student)
                                    <tr>
                                        <td>{{$student->basic_details->registration_no}}</td>
                                        <td>{{$student->basic_details->first_name}}</td>
                                        <td>{{$student->basic_details->dob}}</td>
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
