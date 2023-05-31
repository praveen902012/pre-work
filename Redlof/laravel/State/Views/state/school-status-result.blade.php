@include('state::includes.head')
@include('state::includes.header')
<section class="header-secondary" ng-controller="AppController">
    <div class="container">
        <div class="rte-container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <ul class="list-unstyled list-inline">
                        <li>
                            <a href="{{route('state', $state->slug)}}">
                                <i class="fa fa-home home" aria-hidden="true"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <span class="ion-ios-arrow-right">
                            </span>
                        </li>
                        <li>
                            <a href="{{route('state.school.results', $state->slug)}}">
                                School Status
                            </a>
                        </li>
                        <li>
                            <span class="ion-ios-arrow-right">
                            </span>
                        </li>
                        <li>
                            <a href="{{route('state.school.general.information.status', $state->slug)}}">
                                {{$title}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="page-height section-spacing cm-content bg-grey" ng-init="School={{$school}}">
    <div class="container">
        <div class="rte-container">
            <div class="row">
                <div class="col-sm-7 col-xs-12">
                    <div class="heading-strip">
                        <h2>
                            Registered School Status
                            <span class="info-icon">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                            </span>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row" ng-cloak>
                <div class="col-sm-10 col-xs-12">
                    <div class="hm-card bg-wht lottery-result">
                        <div class="result-row-heading">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h4>
                                        School Name
                                    </h4>
                                </div>
                                <div class="col-sm-9">
                                    <h4 ng-bind="School.name"></h4>
                                </div>
                            </div>
                        </div>
                        <div class="result-row">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h4>Udise</h4>
                                </div>
                                <div class="col-sm-9">
                                    <h4 ng-bind="School.udise"></h4>
                                </div>
                            </div>
                        </div>
                        <div class="result-row  no-border">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h4>Application Status</h4>
                                </div>
                                <div class="col-sm-9">
                                    <h4 ng-if="School.status == 'active' && School.application_status == 'applied'">
                                        पंजीकरण अधूरा. <br><br>(School registration incomplete).</h4>
                                    <h4 ng-if="School.status == 'active' && School.application_status == 'registered'">
                                        पंजीकृत विद्यालय, खंड शिक्षा अधिकारी द्वारा सत्यापित नहीं. <br><br>(School under
                                        review).</h4>
                                    <h4 ng-if="School.status == 'active' && School.application_status == 'verified'">खंड
                                        शिक्षा अधिकारी द्वारा सत्यापित विद्यालय. पंजीकरण संपूर्ण. <br><br>(School
                                        verified).</h4>
                                    <h4 ng-if="School.status == 'active' && School.application_status == 'rejected'">
                                        School rejected.</h4>
                                    <h4 ng-if="School.status == 'active' && School.application_status == 'recheck'">
                                        School requested for recheck.</h4>
                                    <h4 ng-if="School.status == 'ban' && School.application_status == 'verified'">School
                                        banned.</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('state::includes.footer')
@include('state::includes.foot')