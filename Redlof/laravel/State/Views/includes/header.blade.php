<header class="header header-home">
    <div class="header-overlay"></div>
    <div class="container">
        <div class="rte-container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-10 pr-0">
                    <a class="logo" href="{{route('state', $state->slug)}}">
                        <img src="{{ asset('img/rte-logo.png') }}" class="" alt="logo-state" style="border-radius: 10px;">
                        <h2 class="logo-nm">
                            RTE - PARADARSHI
                        </h2>
                        <h4 class="state-nm">
                            {{$state->name}}
                        </h4>
                    </a>
                </div>
                <div class="col-md-9 col-sm-9">
                    <div class="header-action">
                        <ul class="list-inline list-unstyled">
                            <!-- <li>
                                <div class="form-group">
                                    <select class="form-control language-select" ng-model="formData.lang"
                                        ng-change="create('{{$state->slug}}/language/change', formData)">
                                        <option value="">
                                            Select language
                                        </option>
                                        <option value="en">
                                            English
                                        </option>
                                        <option value="default">
                                            Hindi
                                        </option>
                                    </select>
                                </div>
                            </li> -->
                            <li class="dropdown" style="padding-top: 5px;">
                                <a href="" class="dropdown-toggle btn-theme btn-login" data-toggle="dropdown">
                                    {{ googletrans('लॉगइन', $_COOKIE['lang']) }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li><a
                                            href="{{ route('state.school-admin.get', $state->slug) }}">{{ googletrans('विद्यालय लॉगइन', $_COOKIE['lang']) }}</a>
                                    </li>
                                    <li><a
                                            href="{{ route('state.nodal-admin.get', $state->slug) }}">{{ googletrans('नोडल लॉगइन', $_COOKIE['lang']) }}</a>
                                    </li>
                                    <li><a
                                            href="{{ route('state.district-admin.get', $state->slug) }}">{{ googletrans('जनपद लॉगइन', $_COOKIE['lang']) }}</a>
                                    </li>
                                    <li><a
                                            href="{{ route('state.state-admin.get', $state->slug) }}">{{ googletrans('राज्य लॉगइन', $_COOKIE['lang']) }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <nav class="main-nav">
                        <ul class="list-inline list-unstyled  clearfix">
                            <li>
                                <a href="{{route('state', $state->slug)}}" class="btn-theme-header f-l-u">
                                    {{ googletrans('होम', $_COOKIE['lang']) }}
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle btn-theme-header f-l-u" data-toggle="dropdown">
                                    {{ googletrans('निर्देश', $_COOKIE['lang']) }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li><a class="f-l-u"
                                            href="{{route('state.student-registration-instruction', $state->slug)}}">{{ googletrans('छात्रों हेतु निर्देश', $_COOKIE['lang']) }}</a>
                                    </li>
                                    <li><a class="f-l-u"
                                            href="{{route('state.school-registration-instruction', $state->slug)}}">{{ googletrans('स्कूल हेतु निर्देश', $_COOKIE['lang']) }}</a>
                                    </li>
                                    <li><a class="f-l-u"
                                            href="{{route('state.government-registration-instruction', $state->slug)}}">{{ googletrans('अधिकरियो हेतु निर्देश', $_COOKIE['lang']) }}</a>
                                    </li>
                                </ul>
                            </li>
                            @if($state->student_registration || $state->school_registration)
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle btn-theme-header f-l-u" data-toggle="dropdown">
                                    {{ googletrans('पंजीकरण', $_COOKIE['lang']) }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    @if($state->student_registration)
                                    <li><a class="f-l-u"
                                            href="{{route('state.registration', $state->slug)}}">{{ googletrans('छात्र पंजीकरण', $_COOKIE['lang']) }}</a>
                                    </li>
                                    @endif
                                    @if($state->school_registration)
                                    <li><a class="f-l-u"
                                            href="{{route('state.register-your-school', $state->slug)}}">{{ googletrans('विद्यालय पंजीकरण', $_COOKIE['lang']) }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif

                            <li class="dropdown">
                                <a href="" class="dropdown-toggle btn-theme-header f-l-u" data-toggle="dropdown">
                                    {{ googletrans('अक्सर पूछे जाने वाले प्रश्न', $_COOKIE['lang']) }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li><a class="f-l-u"
                                            href="{{route('state.school-faq', $state->slug)}}">{{ googletrans('विध्यालयो द्वारा अक्सर पूछे जाने वाले प्रश्न', $_COOKIE['lang']) }}</a>
                                    </li>
                                    <li><a class="f-l-u"
                                            href="{{route('state.student-faq', $state->slug)}}">{{ googletrans('छात्रों द्वारा अक्सर पूछे जाने वाले प्रश्न', $_COOKIE['lang']) }}</a>
                                    </li>
                                </ul>
                            </li>
                            @if(true)


                            <li class="dropdown">
                                <a href="" class="dropdown-toggle btn-theme-header f-l-u" data-toggle="dropdown">
                                    {{ googletrans('परिणाम', $_COOKIE['lang']) }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li><a class="f-l-u"
                                            href="{{route('state.student.results' , $state->slug)}}">{{ googletrans('छात्र पंजीकरण परिणाम', $_COOKIE['lang']) }}</a>
                                    </li>
                                    <li><a class="f-l-u"
                                            href="{{route('state.school.results', $state->slug)}}">{{ googletrans('विद्यालय पंजीकरण परिणाम', $_COOKIE['lang']) }}</a>
                                    </li>
                                </ul>
                            </li>

                            {{-- <li>
								<a href="{{route('state.student.results' , $state->slug)}}" class="btn-theme-header">
                            {{ googletrans('छात्र परिणाम', $_COOKIE['lang']) }}
                            </a>
                            </li> --}}
                            @endif
                            <li>
                                <a href="{{route('state.general.information', $state->slug)}}" class="btn-theme-header f-l-u"
                                    style="padding-right: 10px;">{{ googletrans('सामान्य सूचनाएं', $_COOKIE['lang']) }}
                                </a>
                            </li>

                            <li>
                                <a href="{{route('state.documents' , $state->slug)}}" class="btn-theme-header f-l-u"
                                    style="padding-right: 15px;">
                                    {{ googletrans('सरकार के निर्देश', $_COOKIE['lang']) }}
                                </a>
                            </li>

                            {{-- <li>
                                <a href="api/{{$state->slug}}/download/empty/registration-form" class="btn-theme-header f-l-u"
                                    style="padding-right: 15px;">
                                    {{ googletrans('डाउनलोड फार्म', $_COOKIE['lang']) }}
                                </a>
                            </li> --}}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="text-center" style="margin-top: 15px;">
    <span style="color: #0f27dd;">RTE के एडमिशन से संबन्धित जानकारी के लिये दिये गये नंबर पर मिस कॉल करें <a
            href="tel: 011 40845192"> 011 40845192</a></span>
</div>
<div class="container" style="margin-top: 10px;">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();"
                style="color: red;">
                {{ googletrans("RTE के 2023-24 सत्र के लिए छात्र पंजीकरण 23 मई तक खुले रहेंगे। ऑनलाइन पंजीकरण करने के बाद अभिभावक फॉर्म और दस्तावेजों की दो कोपी अपने उप शिक्षा अधिकारी कार्यालय में जमा कराएं।", $_COOKIE['lang']) }}
            </marquee>

             <!-- <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();"
                style="color: green;">
                {{ googletrans("RTE के 2023-24 सत्र के लिए विद्यालय पंजीकरण  7 मई तक खुले रहेंगे | जो नवीन पंजीकरण अथवा कुछ अपडेट करना चाहते हैं कर सकते हैं |", $_COOKIE['lang']) }}
            </marquee> -->
        </div>
    </div>
</div>
