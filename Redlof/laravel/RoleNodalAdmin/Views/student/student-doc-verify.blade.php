@extends('nodaladmin::includes.layout')
@section('content')
<section class="nodaladmin_dash cm-content" ng-controller="AppController" ng-cloak>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="heading-strip"></div>
            </div>
            <div class="col-sm-12 col-xs-12">

                <div class="all-admin-link">
                    <a href="#">
                        <button class="btn btn-primary">कुल छात्र</button>
                    </a>
                    <a href="{{ route('nodaladmin.students.verifed') }}">
                        <button class="btn btn-default">सत्यापि छात्र</button>
                    </a>
                    <a href="{{ route('nodaladmin.students.rejected') }}">
                        <button class="btn btn-default">अस्वीकार किए गये छात्र</button>
                    </a>
                </div>
            </div>
            <div ng-controller="ListController as List"
                ng-init="List.init('student-list', {'getall': 'nodaladmin/students/all','search1': 'nodaladmin/allotedschools/search','search': 'nodaladmin/verify-student/searchByName'})"
                ng-cloak>
                <div>
                    <div class="col-sm-5 col-xs-12">
                        <div class="search-action clearfix">
                            <form class="">
                                <div class="form-group">
                                    <input ng-model="keyword" search-icon type="text"
                                        class="form-control theme-blur-focus clearable"
                                        placeholder="Search by Name or ID" table-list-search="[[List.ListName]]">
                                </div>
                                <button ng-disabled="List.appTableService.inProcess" class="btn-theme btn-blue"
                                    ng-click="List.search(keyword)" type="button">
                                    <span ng-if="!List.appTableService.inProcess">खोज</span>
                                    <span ng-if="List.appTableService.inProcess">Please Wait.. <i
                                            class="fa fa-spinner fa-spin"></i></span>
                                </a>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-12" ng-controller="ToBeVerifiedStudent as DocVerify"
                        ng-init="getAPIData('nodaladmin/get/allschool/list', 'allschools')">
                        {{-- <div class="search-action clearfix">
								<form class="">
									<div class="form-group">
										<ui-select class="" style="width:200px" ng-model="DocVerify.searchschool" ng-change="List.search1(DocVerify.searchschool.school.id)" theme="select2">
											<ui-select-match placeholder="Select School">
												[[$select.selected.school.name]]
											</ui-select-match>
											<ui-select-choices repeat="item in allschools | filter:$select.search">
												[[item.school.name]]
											</ui-select-choices>
										</ui-select>
									</div>
								</form>
							</div> --}}
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <div class="rt-action  pull-right" ng-controller="DownloadReportController as Download">
                            <button ng-if="List.ListService.results.length > 0" type="button"
                                class="btn btn-warning pull-right"
                                ng-click="Download.triggerDownload('nodaladmin/alldocstudents/download')"><i
                                    class="fa fa-download"></i> एक्षेल (Excel) को डाउनलोड करे</button>
                        </div>
                    </div>
                    <div ng-if="List.ListService.results.length > 0">
                        <table class="table table-responsive custom-table table-bordered">
                            <thead class="thead-cls">
                                <tr>
                                    <th>आई.डी</th>
                                    <th>छात्र का नाम</th>
                                    <th>स्थिति</th>
                                    <th>जन्म तिथि</th>
                                    <th>कक्षा</th>
                                    {{-- <th>विद्यालय</th> --}}
                                    <th>एक्शन</th>
                                </tr>
                            </thead>
                            <tr ng-repeat="student in List.ListService.results">
                                <td>[[student.basic_details.registration_no]]</td>
                                <td><a target="_blank"
                                        href="../student-details/[[student.basic_details.id]]">[[student.basic_details.first_name]]</a>
                                </td>
                                <td>[[student.basic_details.status]]</td>
                                <td>[[student.basic_details.dob | date:'mediumDate']]</td>
                                <td>[[student.basic_details.level.level]]</td>
                                {{-- <td>[[student.school.name]]</td> --}}
                                <td>
                                    <div>
                                        <div ng-controller="ToBeVerifiedStudent as DocVerify">
                                            {{-- <div ng-if="student.doc_verification_status==NULL"
                                                class="btn-docverify[[student.basic_details.id]]">
                                                <button style="width:42%;" class="btn btn-success"
                                                    ng-click="DocVerify.documentVerifyStudent(student.basic_details.id,'verifed')">Verify</button>
                                                <button style="margin-left: 10px;width:42%"
                                                    ng-click="helper.registration_id=student.basic_details.id;openPopup('nodaladmin', 'student', 'reject-student-reason', 'create-popup-style')"
                                                    class="btn btn-danger">Reject</button>
                                            </div> --}}
                                            <div ng-if="student.doc_verification_status=='Verified'">
                                                Verified
                                            </div>
                                            <div ng-if="student.doc_verification_status=='Rejected'">
                                                Rejected
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="t-footer">
                            <div class="row">
                                <div class="col-sm-6 col-xs-6">
                                    <p>
                                        Showing [[List.ListService.currentPage]] of [[List.ListService.totalPage]]
                                        pages.
                                    </p>
                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="prev-next pagination-custom tb-pagination pull-right">
                                        <table class="table">
                                            <td class="no-border">
                                                <ul class="list-unstyled list-inline text-left"
                                                    ng-class="{ 'hide-pagination': !List.ListService.pagination }">
                                                    <li>
                                                        <a href="" ng-click="List.prevPageSearch()"
                                                            class="next-prev-link">
                                                            <i class="fa ion-ios-arrow-left" aria-hidden="true"></i>
                                                            <span>
                                                                Prev [[List.ListService.pagesize]]
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="" ng-click="List.nextPageSearch()"
                                                            class="next-prev-link">
                                                            <span>
                                                                Next [[List.ListService.pagesize]]
                                                            </span>
                                                            <i class="fa ion-ios-arrow-right" aria-hidden="true"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div align="center" class="col-sm-12 col-xs-12">
                        <p ng-if="List.ListService.results.length == 0">No Students to display</p>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection