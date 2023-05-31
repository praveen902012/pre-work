<section class="footer" style="padding: 1.5% 0;">
    <!-- <div class="container">
        <div class="rte-container">
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="hm-card footer-stat">
                                <div class="heading-header landing-header-card bg-hm-theme ">
                                    <h4 class="text-center">
                                        Statistics for {{$state->name}}
                                    </h4>
                                </div>

                                <div class="bg-wht">
                                    <div class="globl-st">

                                        <div class="row">
                                            <div class="col-md-offset-1 col-md-2">
                                                <h2>
                                                    {{$current_year_registered_students}}
                                                </h2>
                                                <p class="text-capitalize">
                                                    {{ googletrans("पंजीकृत छात्र", $_COOKIE['lang']) }}
                                                </p>
                                            </div>
                                            <div class="col-md-2">
                                                <h2>
                                                    {{$current_year_verified_students}}
                                                </h2>
                                                <p class="text-capitalize">
                                                    {{ googletrans("सत्यापित छात्र", $_COOKIE['lang']) }}
                                                </p>
                                            </div>
                                            <div class="col-md-2">
                                                <h2>
                                                    {{$current_year_rejected_students}}
                                                </h2>
                                                <p class="text-capitalize">
                                                    {{ googletrans("खारिज छात्र", $_COOKIE['lang']) }}
                                                </p>
                                            </div>
                                            <div class="col-md-2">
                                                <h2>
                                                    {{$students_selected_in_lottery}}
                                                </h2>
                                                <p class="text-capitalize">
                                                    {{ googletrans("लॉटरी में चयनित छात्र", $_COOKIE['lang']) }}
                                                </p>
                                            </div>
                                            <div class="col-md-2">
                                                <h2>
                                                    {{$school_enrolled_students}}
                                                </h2>
                                                <p class="text-capitalize">
                                                    {{ googletrans("विद्यालय द्वारा दाखिल किए गए छात्र", $_COOKIE['lang']) }}
                                                </p>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-md-offset-3 col-sm-2">
                                                <h2>
                                                    {{$current_year_registered_schools}}
                                                </h2>
                                                <p class="text-capitalize">
                                                    {{ googletrans("पंजीकृत विद्यालय", $_COOKIE['lang']) }}
                                                </p>
                                            </div>
                                            <div class="col-sm-2">
                                                <h2>
                                                    {{$current_year_verified_schools}}
                                                </h2>
                                                <p class="text-capitalize">
                                                    {{ googletrans("सत्यापित विद्यालय", $_COOKIE['lang']) }}
                                                </p>
                                            </div>
                                            <div class="col-sm-2">
                                                <h2>
                                                    {{$current_year_rejected_schools}}
                                                </h2>
                                                <p class="text-capitalize">
                                                    {{ googletrans("खारिज विद्यालय", $_COOKIE['lang']) }}
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</section>

<section class="contact-us">
    <div class="container">
        <div class="rte-container">
            <div class="row">
                <div class="col-sm-12 col-xs-12 mt-50 mb-30">
                    <h2 class="footer-heading">
                        Contact us
                    </h2>
                    <address>
                        <div class="row">
                            <div class="col-md-4">
                                <p class="contact-info">
                                    <span>
                                        <i class="fa fa-map-signs" aria-hidden="true"></i>
                                    </span>
                                    State Project Office,<br>
                                    Nannoor Khera, Tapovan Road,<br>
                                    Raipur,<br>
                                    ​​​​​​​Dehradun - 248001.
                                </p>
                            </div>
                            <div class="col-md-4">
                                <a href="mailto:spd-ssa-uk@nic.in" class="contact-info font-mid-dark">
                                    <span>
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                    </span>
                                    spd-ssa-uk@nic.in
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="" class="contact-info font-mid-dark">
                                    <span>
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                    </span>
                                    0135-2781941

                                </a>
                            </div>
                        </div>
                    </address>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="lower-footer">
    <div class="container">
        <div class="rte-container">
            <div class="row">
                <div class="col-sm-8 col-xs-12">
                    <p class="footer-copyright">
                        Copyright &copy; <?php echo date('Y'); ?> School Education Department, Government of
                        Uttarakhand, {{$state_details->name}}. All rights reserved.
                    </p>
                </div>
                <div class="col-sm-4 col-xs-12">
                    <p class="footer-copyright text-right">
                        Powered by <a href="http://www.indusaction.org/" target="_blank">Indus Action</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>