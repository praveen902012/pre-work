<section class="state-hero-sec cm-content hm-sec-space" ng-controller="StudentRegistrationController as Registration">
    <div class="container">
        <div class="rte-container">
            <div class="row">
                <div class="col-sm-8 col-xs-12">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <div class="hm-card bg-hm-theme ">
                                <div class="heading-header" style="min-height: 60px;">
                                    <h4 class="text-center">
                                        छात्र पंजीकरण के लिए वीडियो
                                    </h4>
                                </div>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <video controls="" name="media">
                                        <source
                                            src="https://rte-static.s3.ap-south-1.amazonaws.com/videos/student+registration+video_1.mp4"
                                            type="video/mp4">
                                    </video>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="hm-card bg-hm-theme ">
                                <div class="heading-header" style="min-height: 60px;">
                                    <h4 class="text-center">
                                        विध्यालय पंजीकरण के लिए वीडियो
                                    </h4>
                                </div>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <video controls="" name="media">
                                        <source src="{{asset('video/rte_uk_student_enrollment_video.mp4')}}" type="video/mp4">
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 22px">
                        <div class="col-sm-12 col-xs-12">
                            <div class="hm-card bg-hm-theme">
                                <div class="heading-header">
                                    <h4 class="text-center">
                                        विध्यालयों के लिए निर्देश
                                    </h4>
                                </div>
                                <div class="card-content notification-content" style="height: 250px;">
                                    <ul class="list-unstyled">
                                        <li>
                                            <span>
                                                <a style="color:red;" href="#">
                                                   विध्यालय पंजीकरण की प्रक्रिया में सहायता के लिए portal पर school registration की video उपलब्ध है, विध्यालयों से अनुरोध है कि वे school registration करने से पहले वीडियो देख लें।
                                                </a>
                                            </span>
                                        </li>

                                        <li>
                                            <span>
                                                <a style="color:red;" href="#">
                                                    जो विध्यालय पहली बार पंजीकरण करेंगे वे RTE portal पर हरे बटन पर क्लिक करें और जानकारी भरने के पश्चात submit करें। विद्यालयो से अनुरोध है की फोन नंबर उन्ही का डाले जो विद्यालय मे परमानेंट नौकरी पर हों।
                                                </a>
                                            </span>
                                        </li>

                                        <li>
                                            <span>
                                                <a style="color:red;" href="#">
                                                    जो विध्यालय पहले से पंजीकरत है उन्हे दोबारा से रेजिस्ट्रेशं करने की ज़रूरत नही हैं। यदि अगर वे कुछ जानकारी edit करना चाहते हैं तो login में जाकर edit करें और अपने विध्यालय का User Id डालकर जानकारी भरने के पश्चात  submit करें।
                                                </a>
                                            </span>
                                        </li>

                                        <li>
                                            <span>
                                                <a style="color:red;" href="#">
                                                    पहले से पंजिकरत् विद्यालयो को अगर फोन नंबर बदलना हैं तोह अपने उप शिक्षा अधिकारी दफ्तर मे संपर्क करे।
                                                </a>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div ng-init="Registration.checkRegistrationStatus('{{$state->slug}}')" class="col-sm-4 col-xs-12"
                    ng-cloak>

                    @if($state->school_registration || $state->student_registration)
                        <div class="hm-card bg-hm-theme" style="margin-bottom: 16px;">
                            <div class="heading-header">
                                <h4 class="text-center">
                                    {{ googletrans('यहां आवेदन करें', $_COOKIE['lang']) }}
                                </h4>

                            </div>
                            <div class="card-content text-center">
                                @if($state->school_registration)
                                    <a class="btn-theme w-100" style="margin-bottom: 10px" href="{{route('state.register-your-school', $state->slug)}}">{{ googletrans('विद्यालय पंजीकरण', $_COOKIE['lang']) }}</a>
                                @endif
                                @if($state->student_registration)
                                <a class="btn-theme w-100" href="{{route('state.registration', $state->slug)}}">{{ googletrans('छात्र पंजीकरण', $_COOKIE['lang']) }}</a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="hm-card bg-hm-theme">
                        <div class="heading-header">
                            <h4 class="text-center">
                                {{ googletrans('राज्य परियोजना कार्यालय की ओर से निर्देश', $_COOKIE['lang']) }}
                            </h4>
                        </div>
                        <div class="card-content notification-content" style="height: 250px;">
                            <ul class="list-unstyled">

                                <li>
                                    <span>
                                        <a style="color:green;" href="#">
                                           <b> {{ googletrans('छात्रों के लिए निर्देश', $_COOKIE['lang']) }} </b>
                                        </a>
                                    </span>
                                </li>

                                <!-- <li>
                                    <span>
                                        <a style="color:red;" href="#">
                                            {{ googletrans('जो अभिभावक अपने पंजीकरण में कुछ भी बदलाव करना चाहते हैं वो 21 अक्टूबर से 31 अक्टूबर तक रिज्यूम रजिस्ट्रेशन करके बदलाव कर सकते हैं। जरूरी बदलाव करने के बाद फॉर्म को ऑनलाइन सबमिट अवश्य करें।', $_COOKIE['lang']) }}
                                        </a>
                                    </span>
                                </li>

                                <li>
                                    <span>
                                        <a style="color:red;" href="#">
                                            {{ googletrans('जिन छात्रों के फॉर्म निरस्त हो गए थे वे वो पुनः फॉर्म खोलकर सबमिट करें और उसके बाद दो कॉपी खंड शिक्षा अधिकारी के दफ्तर में जमा करवाएं।', $_COOKIE['lang']) }}
                                        </a>
                                    </span>
                                </li>

                                <li>
                                    <span>
                                        <a style="color:red;" href="#">
                                            {{ googletrans('फॉर्म में कोई भी बदलाव करने के लिए रिज्यूम रजिस्ट्रेशन के बटन पर जाएं और अपने रजिस्टर्ड मोबाइल नंबर पर OTP मंगवा कर फॉर्म की प्रतिलिपि खोलें।', $_COOKIE['lang']) }}
                                        </a>
                                    </span>
                                </li>

                                <li>
                                    <span>
                                        <a style="color:red;" href="#">
                                            {{ googletrans('खंड शिक्षा अधिकारी के दफ्तर में दस्तावेज जमा कराने की तिथि 22 अक्टूबर से 6 नवंबर तक है।', $_COOKIE['lang']) }}
                                        </a>
                                    </span>
                                </li> -->

                                <li>
                                    <span>
                                        <a style="color:green;" href="#">
                                            {{ googletrans('आयु मानदंड: तिथि 1 अप्रैल 2023 के अनुसार बच्चे की कक्षा और जन्म तिथि इस हिसाब से होनी चाहिए:', $_COOKIE['lang']) }}
                                        </a>
                                    </span>
                                </li>

                                <li>
                                    <span>
                                        <a style="color:green;" href="#">
                                            {{ googletrans('प्री प्राइमरी: 1 अप्रैल 2018 से 31 मार्च 2020 तक |', $_COOKIE['lang']) }}
                                        </a>
                                    </span>

                                    <span>
                                        <a style="color:green;" href="#">
                                            {{ googletrans('पहली कक्षा: 1 अप्रैल 2017 से 31 मार्च 2018 तक |', $_COOKIE['lang']) }}
                                        </a>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
