<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{$title}}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link href="https://fonts.googleapis.com/css?family=Hind:400,700&amp;subset=devanagari,latin-ext" rel="stylesheet">

    <!-- Latest compiled and minified CSS -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
        integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css"
        integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">


</head>

<body style="font-family: Hind">
    <div class="container-fluid">
        <div class="text-center row">
            <img src="{!! asset('img/rte-logo.png') !!}" width="70" alt="RTE - PARADARSHI">
        </div>
        <br>
        <div class="row mt-3">
            <div class="text-center alert alert-info">
                <b>REGISTRATION FORM FOR ADMISSION UNDER EWS/DG CATEGORY FOR THE SESSION {{date('Y')}}-{{ date('Y') + 1 }}<br>DISTRICT
                    ADMINISTRATION, UTTARAKHAND</b>
            </div>
        </div>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="color:#1E88E5;">
                            General Details of the Child
                            <span style="float: right; position: absolute; top: -1px;">Date: {{ date("F j, Y") }}</span>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="row mb-2">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th><b>Registration ID</b></th>
                        <td>{{$candidate['registration_no']}}</td>
                    </tr>
                    <tr>
                        <th><b>First Name</b></th>
                        <td>{{$candidate['first_name']}}</td>
                    </tr>
                    <tr>
                        <th><b>Middle Name</b></th>
                        <td>
                            @if($candidate['middle_name']!='Null')
                            {{$candidate['middle_name']}}
                            @else
                            NA
                            @endif
                        </td>

                    </tr>
                    <tr>
                        <th><b>Last Name</b></th>
                        <td>
                            @if($candidate['last_name']!='Null')
                            {{$candidate['last_name']}}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><b>Student Photo</b></th>
                        <td>
                            @if($candidate['photo']!='Null')
                            <img src="{{$candidate['fmt_photo']}}" height="80px" width="80px">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th><b>Gender</b></th>
                        <td>{{$candidate['gender']}}</td>
                    </tr>
                    <tr>
                        <th><b>Date of Birth</b></th>
                        <td>{{$candidate['fmt_dob_form']}}</td>
                    </tr>
                    <tr>
                        <th><b>Mobile No.</b></th>
                        <td>{{$candidate['mobile']}}</td>
                    </tr>
                    <tr>
                        <th><b>Email Address</b></th>
                        <td>{{$candidate['email']}}</td>
                    </tr>
                    <tr>
                        <th><b>Aadhar No. of the Child</b></th>
                        <td>{{$candidate['aadhar_no']}}</td>
                    </tr>
                    <tr>
                        <th><b>Aadhar Enrollment No. of the Child</b></th>
                        <td>{{$candidate['aadhar_enrollment_no']}}</td>
                    </tr>
                    <tr>
                        <th><b>Class</b></th>
                        <td>{{$candidate->level['level']}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <table class="table table-bordered mt-5">
                <thead>
                    <tr>
                        <th style="color:#1E88E5;">Details of Parents/Guardian</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="row mb-2">
            <table class="table table-bordered">

                <tr>
                    @if($candidate->parent_details['parent_type'] == 'father')
                    <td><b>Father's Name</b></td>
                    @endif
                    @if($candidate->parent_details['parent_type'] == 'mother')
                    <td><b>Mother's Name</b></td>
                    @endif
                    @if($candidate->parent_details['parent_type'] == 'guardian')
                    <td><b>Guardian's Name</b></td>
                    @endif

                    <td>{{$candidate->parent_details['parent_name']}}</td>
                </tr>
                <tr>
                    @if($candidate->parent_details['parent_type'] == 'father')
                    <td><b>Father's Mobile No.</b></td>
                    @endif
                    @if($candidate->parent_details['parent_type'] == 'mother')
                    <td><b>Mother's Mobile No.</b></td>
                    @endif
                    @if($candidate->parent_details['parent_type'] == 'guardian')
                    <td><b>Guardian's Mobile No.</b></td>
                    @endif
                    <td>
                        {{$candidate->parent_details['parent_mobile_no']}}
                    </td>
                </tr>
                <tr>
                    @if($candidate->parent_details['parent_type'] == 'father')
                    <td><b>Father's Profession</b></td>
                    @endif
                    @if($candidate->parent_details['parent_type'] == 'mother')
                    <td><b>Mother's Profession</b></td>
                    @endif
                    @if($candidate->parent_details['parent_type'] == 'guardian')
                    <td><b>Guardian's Profession</b></td>
                    @endif
                    <td>
                        @if($candidate->parent_details['parent_profession'] == 'government')
                        Government Services
                        @elseif($candidate->parent_details['parent_profession'] == 'business')
                        Self employed / Business
                        @elseif($candidate->parent_details['parent_profession'] == 'private')
                        Private Job
                        @elseif($candidate->parent_details['parent_profession'] == 'other')
                        Other
                        @elseif($candidate->parent_details['parent_profession'] == 'home-maker')
                        Home maker
                        @endif
                    </td>
                </tr>

                @if($candidate->personal_details->category=='dg')

                <tr>
                    <td><b>Applied Category</b></td>
                    <td> DG (Disadvantaged Group)</td>
                </tr>

                <tr>
                    <td><b>Type of DG</b></td>
                    <td>
                        @if($candidate->personal_details->certificate_details['dg_type'] == 'sc')
                        SC
                        @elseif($candidate->personal_details->certificate_details['dg_type'] == 'st')
                        ST
                        @elseif($candidate->personal_details->certificate_details['dg_type'] == 'obc')
                        OBC (NC)
                        @elseif($candidate->personal_details->certificate_details['dg_type'] == 'orphan')
                        Orphan
                        @elseif($candidate->personal_details->certificate_details['dg_type'] == 'with_hiv')
                        Child or Parent is HIV +ve
                        @elseif($candidate->personal_details->certificate_details['dg_type'] == 'disable')
                        Child or Parent is Differently Abled
                        @elseif($candidate->personal_details->certificate_details['dg_type'] == 'widow_women')
                        Widow women with income less than INR 80,000
                        @elseif($candidate->personal_details->certificate_details['dg_type'] == 'divorced_women')
                        Divorced women with income less than INR 80,000
                        @elseif($candidate->personal_details->certificate_details['dg_type'] == 'disable_parents')
                        Parent is Differently Abled
                        @endif
                    </td>
                </tr>

                @if($candidate->personal_details->certificate_details['dg_type'] == 'obc')
                <tr>
                    <td><b>Name of Tahsil issuing Income Certificate</b></td>
                    <td>
                        {{$candidate->personal_details->certificate_details['dg_income_tahsil_name']}}
                    </td>

                </tr>
                <tr>
                    <td><b>Issued Income Certificate No.</b></td>
                    <td>
                        {{$candidate->personal_details->certificate_details['dg_income_cerificate']}}
                    </td>

                </tr>

                <tr>
                    <td>
                        <b>Income Certificate Issued Date</b>
                    </td>
                    <td>
                        {{$candidate->personal_details->certificate_details['dg_cerificate_date']}}/{{$candidate->personal_details->certificate_details['dg_cerificate_month']}}/{{$candidate->personal_details->certificate_details['dg_cerificate_year']}}
                    </td>
                </tr>
                @endif

                @if($candidate->personal_details->certificate_details['dg_type'] == 'sc' ||
                $candidate->personal_details->certificate_details['dg_type'] == 'st' ||
                $candidate->personal_details->certificate_details['dg_type'] == 'obc')
                <tr>
                    <td><b>Name of Tahsil issuing Caste Certificate</b></td>
                    <td>
                        {{$candidate->personal_details->certificate_details['dg_tahsil_name']}}
                    </td>
                </tr>
                @endif
                <tr>
                    <td><b>Issued Certificate No.</b></td>
                    <td>
                        {{$candidate->personal_details->certificate_details['dg_cerificate']}}
                    </td>
                </tr>

                @elseif($candidate->personal_details->category=='ews')

                <tr>
                    <td><b>Applied Category</b></td>
                    <td> EWS (Economically Weaker Section) </td>
                </tr>

                <tr>
                    <td><b>Name of Tahsil issuing income certificate</b></td>

                    <td>
                        {{$candidate->personal_details->certificate_details['ews_tahsil_name']}}
                    </td>
                </tr>

                <tr>
                    <td><b>Issued Certificate No.</b></td>
                    <td>
                        {{$candidate->personal_details->certificate_details['ews_cerificate_no']}}
                    </td>
                </tr>

                @if($candidate->personal_details->certificate_details['ews_type'] == 'income_certificate')
                <tr>
                    <td><b>Family annual income (in INR)</b></td>
                    <td>
                        {{$candidate->personal_details->certificate_details['ews_income']}}
                    </td>
                </tr>

                <tr>
                    <td>
                        <b>Certificate Issued Date</b>
                    </td>
                    <td>
                        {{$candidate->personal_details->certificate_details['bpl_cerificate_date']}}/{{$candidate->personal_details->certificate_details['bpl_cerificate_month']}}/{{$candidate->personal_details->certificate_details['bpl_cerificate_year']}}
                    </td>
                </tr>

                @endif

                @endif


            </table>
        </div>

        <div class="row">
            <table class="table table-bordered mt-5">
                <thead>
                    <tr>
                        <th style="color:#1E88E5;">Address Details</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="row mb-2">
            <table class="table table-bordered">

                <tr>
                    <td><b>District</b></td>
                    <td>{{$candidate->personal_details->district['name']}}</td>
                </tr>
                <tr>
                    <td><b>Block</b></td>
                    <td>{{$candidate->personal_details->block['name']}}</td>
                </tr>
                <tr>
                    <td><b>Nagar Nigam/Nagar Palika Parishad/Nagar Panchayat</b></td>
                    <td>{{$candidate->personal_details->sub_block_name}}</td>
                </tr>
                <tr>
                    <td><b>Ward Name</b></td>
                    <td>{{$candidate->personal_details->locality['name']}}</td>
                </tr>
                <tr>
                    <td><b>Pincode</b></td>
                    <td>{{$candidate->personal_details->pincode}}</td>
                </tr>
                <tr>
                    <td><b>Residential address</b></td>
                    <td>{{$candidate->personal_details->residential_address}}</td>
                </tr>

            </table>
        </div>

        <div class="row">
            <table class="table table-bordered mt-5">
                <thead>
                    <tr>
                        <th style="color:#1E88E5;">Documents Details</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="row">
            <table class="table table-bordered mt-5">
                <tr>
                    <td><b>Proof of birth</b></td>
                    <td>
                        @if(isset($candidate->documents->proof_of_birth->self_declaration) &&
                        $candidate->documents->proof_of_birth->self_declaration == 'true')

                        Self Declaration Certificate,
                        @endif
                        @if(isset($candidate->documents->proof_of_birth->birth_certificate) &&
                        $candidate->documents->proof_of_birth->birth_certificate == 'true')

                        Birth Certificate,
                        @endif
                        @if(isset($candidate->documents->proof_of_birth->aadhaar_card) &&
                        $candidate->documents->proof_of_birth->aadhaar_card == 'true')
                        Aadhaar Card,
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><b>Parent ID</b></td>
                    <td>
                        @if(isset($candidate->documents->proof_of_parent->voter_card) &&
                        $candidate->documents->proof_of_parent->voter_card == 'true')
                        Voter ID,
                        @endif
                        @if(isset($candidate->documents->proof_of_parent->aadhaar_card) &&
                        $candidate->documents->proof_of_parent->aadhaar_card == 'true')
                        Aadhaar Card,
                        @endif
                        @if(isset($candidate->documents->proof_of_parent->driving_license) &&
                        $candidate->documents->proof_of_parent->driving_license == 'true')
                        Driving license,
                        @endif
                        @if(isset($candidate->documents->proof_of_parent->pan_card) &&
                        $candidate->documents->proof_of_parent->pan_card == 'true')
                        PAN card,
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><b>Address proof</b></td>
                    <td>
                        @if(isset($candidate->documents->proof_of_address->ration_card) &&
                        $candidate->documents->proof_of_address->ration_card == 'true')
                        Ration Card,
                        @endif
                        @if(isset($candidate->documents->proof_of_address->voter_card) &&
                        $candidate->documents->proof_of_address->voter_card == 'true')
                        Voter ID,
                        @endif
                        @if(isset($candidate->documents->proof_of_address->aadhaar_card) &&
                        $candidate->documents->proof_of_address->aadhaar_card == 'true')
                        Aadhaar Card,
                        @endif
                        @if(isset($candidate->documents->proof_of_address->driving_license) &&
                        $candidate->documents->proof_of_address->driving_license == 'true')
                        Driving license,
                        @endif
                        @if(isset($candidate->documents->proof_of_address->electricity_bill) &&
                        $candidate->documents->proof_of_address->electricity_bill == 'true')
                        Electricity Bill,
                        @endif
                        @if(isset($candidate->documents->proof_of_address->residential_certificate) &&
                        $candidate->documents->proof_of_address->residential_certificate == 'true')
                        Residential Certificate,
                        @endif
                        @if(isset($candidate->documents->proof_of_address->bank_passbook) &&
                        $candidate->documents->proof_of_address->bank_passbook == 'true')
                        Bank Passbook,
                        @endif
                    </td>
                </tr>
                @if($candidate->personal_details->category=='ews')
                <tr>
                    <td><b>EWS certificate</b></td>
                    <td>
                        @if(isset($candidate->documents->ews_documents->income_certificate) &&
                        $candidate->documents->ews_documents->income_certificate == 'true')
                        Income Certificate,
                        @endif
                        @if(isset($candidate->documents->ews_documents->ration_card) &&
                        $candidate->documents->ews_documents->ration_card)
                        Ration Card,
                        @endif
                    </td>
                </tr>
                @elseif($candidate->personal_details->category=='dg')
                <tr>
                    <td><b>DG certificate</b></td>
                    <td>
                        @if(isset($candidate->documents->dg_documents->income_certificate) &&
                        $candidate->documents->dg_documents->income_certificate)
                        Income Certificate,
                        @endif
                        @if(isset($candidate->documents->dg_documents->cast_certificate) &&
                        $candidate->documents->dg_documents->cast_certificate)
                        Caste Certificate,
                        @endif
                        @if(isset($candidate->documents->dg_documents->orphan_certificate) &&
                        $candidate->documents->dg_documents->orphan_certificate)
                        Orphan certificate,
                        @endif
                        @if(isset($candidate->documents->dg_documents->disability_certificate) &&
                        $candidate->documents->dg_documents->disability_certificate)
                        Disability certificate,
                        @endif
                        @if(isset($candidate->documents->dg_documents->health_certificate) &&
                        $candidate->documents->dg_documents->health_certificate)
                        Health Certificate,
                        @endif
                        @if(isset($candidate->documents->dg_documents->father_death_certificate) &&
                        $candidate->documents->dg_documents->father_death_certificate)
                        Death certificate of father,
                        @endif
                        @if(isset($candidate->documents->dg_documents->divorce_certificate) &&
                        $candidate->documents->dg_documents->divorce_certificate)
                        Divorce Certificate,
                        @endif

                    </td>

                </tr>

                @endif

            </table>
        </div>

        </table>
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="color:#1E88E5;">Selected Schools</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="row">
            <table class="table table-bordered">
                <tbody>
                    <thead>
                        <tr>
                            <th class="text-center">Range</th>
                            <th class="text-center">Priority No.</th>
                            <th class="text-center">School ID</th>
                            <th class="text-center">School Name</th>
                        </tr>
                    </thead>
                    @if($candidate->registration_cycle->preferences)
                    @foreach($candidate->registration_cycle->preferences as $key => $value)
                    @foreach($schoolData as $school)
                    @if(!empty($school))
                    @if($school['id'] == $value)
                    @php $schoolname = $school['name']; $schooludise = $school['udise']; @endphp
                    <tr>
                        <td>Your Ward</td>
                        <td>{{$key+1}}</td>
                        <td>{{$schooludise}}</td>
                        <td>{{$schoolname}}</td>
                    </tr>
                    @endif
                    @endif
                    @endforeach
                    @endforeach
                    @endif
                    @if($candidate->registration_cycle->nearby_preferences)
                    @foreach($candidate->registration_cycle->nearby_preferences as $key => $value)
                    @foreach($schoolNearbyData as $school)
                        @if(!empty($school))
                            @if($school['id'] == $value)
                                @php
                                    $schoolname = $school['name'];
                                    $schooludise = $school['udise'];
                                @endphp

                                <tr>
                                    <td>Neighboring Ward</td>
                                    <td>{{$key+1}}</td>
                                    <td>{{$schooludise}}</td>
                                    <td>{{$schoolname}}</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        @if($candidate->registration_cycle->status !='applied')
            <div class="row">
                <table class="table table-bordered">
                    <thead>

                        <tr>
                            <th style="color:#f44336;">Allotted School</th>

                            @if(isset($alloted_school))
                                <td>{{$alloted_school['udise']}}</td>
                                <td>{{$alloted_school['name']}}</td>
                            @endif
                        </tr>
                    </thead>
                </table>
            </div>
        @endif

        <div class="container">
            <div class="row">
                <div class="rte-container">
                    <div class="heading-strip all-pg-heading ">

                        <h2 class="instruction-heading" style="font-family: Hind !important;">
                            Instructions for parents (अभिभावकों के लिए निर्देष)
                        </h2>
                    </div>
                    <div class="instruction-list">
                        <ul class="">
                            <li>
                                फार्म भरने के बाद एक बार कंप्यूटर पर दी गई जानकारी को अच्छे से जांच लें। जानकारी में कोई भी गलती पाते ही तुरंत उसे ठीक करें।
                            </li>
                            <li>
                                फार्म भरने के बाद अपने दस्तावेजों की 2—2 कॉपी बनाके अपने खंड शिक्षा अधिकारी के दफ्तर में जमा करें। फार्म भरने की आखरी तारीक 23 मई है।
                            </li>
                            <li>
                                25 मई दस्तावेज जमा करने की आखिरी तिथि है| इसलिए अपने दस्तावेज समय से जमा करवाएं |
                            </li>
                            <li>
                                दाखिले से पहले देहरादून स्थित उत्तराखंड राज्य परियोजना कार्यालय में सभी खंड शिक्षा अधिकारियों द्वारा कंप्यूटर द्वारा लॉटरी करवाई जायेगी जो की ऑनलाइन होगी। लॉटरी की तिथि 1 जून है।
                            </li>
                            <li>
                                विद्यालय में उन्ही बच्चो का दाखिला होगा जिनका नाम लॉटरी में आयेगा। लॉटरी के परिणाम आते ही बच्चे के माता पिता द्वारा फार्म में भरे गए नंबर पर मैसेज आयेगा। लॉटरी में निकले नामो की सूची यानी के वो बच्चे जिनको एडमिशन मिलेगा उनकी सूची खंड शिक्षा अधिकारी के ऑफिस में भी होगी तथा ऑनलाइन पोर्टल पर भी जाके आप अपने फार्म की स्तिथि देख सकते हैं।
                            </li>
                            <li>
                                अधिक जानकारी के लिए इस नंबर पर मिस्ड कॉल दें— 01140845192
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="row">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>
                                <!-- <p><input type="checkbox" checked>&nbsp;&nbsp;&nbsp;I {{$candidate->parent_details['parent_name']}}, {{$candidate->parent_details['parent_type']}} of {{$candidate['first_name']}} {{$candidate['middle_name']}} {{$candidate['last_name']}} मेरे (माता/ पिता) द्वारा RTE के सभी मानकों एवं अर्हताओं को भली भांति पढ लिया गया है। मेरे द्वारा दी गयी समस्त जानकारी सत्य है, उक्त जानकारी/ दस्तावेज भ्रामक/ त्रुटिपूर्ण पाये जाने पर मेरे पाल्य का अभ्यर्थन निरस्त कर दिया जाने पर मुझे कोई आपत्ति नहीं होगी तथा संबंधित विभाग मेरे विरूद्ध कर्यवाही हेतु भी सक्षम होगा। </p> -->
                                &nbsp;I {{$candidate->parent_details['parent_name']}},
                                {{$candidate->parent_details['parent_type']}} of {{$candidate['first_name']}}
                                @if($candidate['middle_name']!='Null')
                                {{$candidate['middle_name']}}
                                @endif
                                @if($candidate['last_name']!='Null')
                                {{$candidate['last_name']}}
                                @endif
                                All the standards and qualifications of RTE have been read correctly by my (parent). All
                                information given by me is true, I will not have any objection if the said information /
                                document is misleading / inaccurate, and if the decision of my boycott is canceled then
                                the concerned department will also be able to act against me.

                            </td>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <p>Guardian's name:{{$candidate->parent_details['parent_name']}}</p>
                    <p>Guardian's signature: <&nbsp>
                            <&nbsp>
                                <&nbsp>
                    </p>
                    <p>{{$candidate->personal_details->residential_address}},
                        {{$candidate->personal_details->block['name']}},
                        {{$candidate->personal_details->locality['name']}}, -{{$candidate->personal_details->pincode}}
                    </p>
                </div>

            </div>
        </div>

        <!-- अभिभावक का नाम -->
        <!-- </div>
				<div class="col-sm-12 col-xs-12">
				<p class="text-right">Guardian's signature: <&nbsp> <&nbsp> <&nbsp> </p> -->
        <!-- अभिभावक के हस्ताक्षर -->
        <!-- </div>
				<div class="col-sm-12 col-xs-12">
				<p class="text-right">Guardian's address:{{$candidate->personal_details->residential_address}}{{$candidate->personal_details->block['name']}}{{$candidate->personal_details->locality['name']}}{{$candidate->personal_details->pincode}}</p>
				</div> -->
        <!-- अभिभावक का पता -->
    </div>

</body>

</html>
