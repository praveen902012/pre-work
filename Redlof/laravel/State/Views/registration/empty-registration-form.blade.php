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
                <b>REGISTRATION FORM FOR ADMISSION UNDER EWS/DG CATEGORY FOR THE SESSION 2022 - 2023<br>DISTRICT
                    ADMINISTRATION, UTTARAKHAND</b>
            </div>
        </div>

        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="color:#1E88E5;">General Details of the Child</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="row mb-2">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td style="width: 40%"><b>Registration ID</b></td>
                        <td style="width: 60%"></td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><b>First Name</b></td>
                        <td style="width: 60%"></td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><b>Middle Name</b></td>
                        <td style="width: 60%"></td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><b>Last Name</b></td>
                        <td style="width: 60%"></td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><b>Student Photo</b></td>
                        <td style="width: 60%"></td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><b>Gender</b></td>
                        <td style="width: 60%"></td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><b>Date of Birth</b></td>
                        <td style="width: 60%"></td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><b>Mobile No.</b></td>
                        <td style="width: 60%"></td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><b>Email Address</b></td>
                        <td style="width: 60%"></td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><b>Aadhar No. of the Child</b></td>
                        <td style="width: 60%"></td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><b>Aadhar Enrollment No. of the Child</b></td>
                        <td style="width: 60%"></td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><b>Class</b></td>
                        <td style="width: 60%"></td>
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
                    <td><b>Father's Name</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Mother's Name</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Guardian's Name</b></td>
                    <td></td>
                </tr>

                <tr>
                    <td><b>Father's Mobile No.</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Mother's Mobile No.</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Guardian's Mobile No.</b></td>
                    <td></td>
                </tr>

                <tr>
                    <td><b>Father's Profession.</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Mother's Profession.</b></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Guardian's Profession.</b></td>
                    <td></td>
                </tr>

                <tr>
                    <td><b>Applied Category</b></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="dg" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">DG (Disadvantaged Group)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="ews" id="defaultCheck2">
                            <label class="form-check-label" for="defaultCheck2">EWS</label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><b>Type of DG</b></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="SC" id="defaultCheck3">
                            <label class="form-check-label" for="defaultCheck3">SC</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="ST" id="defaultCheck4">
                            <label class="form-check-label" for="defaultCheck4">ST</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="OBC (NC)" id="defaultCheck5">
                            <label class="form-check-label" for="defaultCheck5">OBC (NC)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Orphan" id="defaultCheck6">
                            <label class="form-check-label" for="defaultCheck6">Orphan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Child or Parent is HIV +ve" id="defaultCheck7">
                            <label class="form-check-label" for="defaultCheck7">Child or Parent is HIV +ve</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Child or Parent is Differently Abled" id="defaultCheck8">
                            <label class="form-check-label" for="defaultCheck8">Child or Parent is Differently Abled</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Widow women with income less than INR 80,000" id="defaultCheck9">
                            <label class="form-check-label" for="defaultCheck9">Widow women with income less than INR 80,000</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Divorced women with income less than INR 80,0000" id="defaultCheck10">
                            <label class="form-check-label" for="defaultCheck10">Divorced women with income less than INR 80,0000</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Parent is Differently Abled" id="defaultCheck11">
                            <label class="form-check-label" for="defaultCheck11">Parent is Differently Abled</label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><b>Name of Tahsil issuing Income Certificate</b></td>
                    <td></td>
                </tr>

                <tr>
                    <td><b>Issued Income Certificate No.</b></td>
                    <td></td>
                </tr>

                <tr>
                    <td><b>Income Certificate Issued Date.</b></td>
                    <td></td>
                </tr>

                <tr>
                    <td><b>Name of Tahsil issuing Caste Certificate.</b></td>
                    <td></td>
                </tr>

                <tr>
                    <td><b>Issued Caste Certificate No.</b></td>
                    <td></td>
                </tr>

                <tr>
                    <td><b>Family annual income (in INR)</b></td>
                    <td></td>
                </tr>

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
                    <td style="width: 40%"><b>District</b></td>
                    <td style="width: 60%"></td>
                </tr>
                <tr>
                    <td style="width: 40%"><b>Block</b></td>
                    <td style="width: 60%"></td>
                </tr>
                <tr>
                    <td style="width: 40%"><b>Nagar Nigam/Nagar Palika Parishad/Nagar Panchayat</b></td>
                    <td style="width: 60%"></td>
                </tr>
                <tr>
                    <td style="width: 40%"><b>Ward Name</b></td>
                    <td style="width: 60%"></td>
                </tr>
                <tr>
                    <td style="width: 40%"><b>Pincode</b></td>
                    <td style="width: 60%"></td>
                </tr>
                <tr>
                    <td style="width: 40%"><b>Residential address</b></td>
                    <td style="width: 60%"></td>
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
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Self Declaration Certificate" id="defaultCheck12">
                            <label class="form-check-label" for="defaultCheck12">Self Declaration Certificate</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Birth Certificate" id="defaultCheck13">
                            <label class="form-check-label" for="defaultCheck13">Birth Certificate</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Aadhaar Card" id="defaultCheck14">
                            <label class="form-check-label" for="defaultCheck14">Aadhaar Card</label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><b>Parent ID</b></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Aadhaar Card" id="defaultCheck15">
                            <label class="form-check-label" for="defaultCheck15">Aadhaar Card</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Voter ID" id="defaultCheck16">
                            <label class="form-check-label" for="defaultCheck16">Voter ID</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Driving license" id="defaultCheck17">
                            <label class="form-check-label" for="defaultCheck17">Driving license</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="PAN card" id="defaultCheck18">
                            <label class="form-check-label" for="defaultCheck18">PAN card</label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><b>Address proof</b></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Ration Card" id="defaultCheck19">
                            <label class="form-check-label" for="defaultCheck19">Ration Card</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Voter ID" id="defaultCheck20">
                            <label class="form-check-label" for="defaultCheck20">Voter ID</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Aadhaar Card" id="defaultCheck21">
                            <label class="form-check-label" for="defaultCheck21">Aadhaar Card</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Driving license" id="defaultCheck22">
                            <label class="form-check-label" for="defaultCheck22">Driving license</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Electricity Bill" id="defaultCheck23">
                            <label class="form-check-label" for="defaultCheck23">Electricity Bill</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Residential Certificate" id="defaultCheck24">
                            <label class="form-check-label" for="defaultCheck24">Residential Certificate</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Bank Passbook" id="defaultCheck25">
                            <label class="form-check-label" for="defaultCheck25">Bank Passbook</label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><b>EWS certificate</b></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Income Certificate" id="defaultCheck26">
                            <label class="form-check-label" for="defaultCheck26">Income Certificate</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Ration Card" id="defaultCheck27">
                            <label class="form-check-label" for="defaultCheck27">Ration Card</label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><b>DG certificate</b></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Income Certificate" id="defaultCheck28">
                            <label class="form-check-label" for="defaultCheck28">Income Certificate</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Caste Certificate" id="defaultCheck29">
                            <label class="form-check-label" for="defaultCheck29">Caste Certificate</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Orphan certificate" id="defaultCheck30">
                            <label class="form-check-label" for="defaultCheck30">Orphan certificate</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Disability certificate" id="defaultCheck31">
                            <label class="form-check-label" for="defaultCheck31">Disability certificate</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Health Certificate" id="defaultCheck32">
                            <label class="form-check-label" for="defaultCheck32">Health Certificate</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Death certificate of father" id="defaultCheck33">
                            <label class="form-check-label" for="defaultCheck33">Death certificate of father</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="Divorce Certificate" id="defaultCheck34">
                            <label class="form-check-label" for="defaultCheck34">Divorce Certificate</label>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

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

                    <tr>
                        <td>Your Ward</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Neighboring Ward</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

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
                                फॉर्म भरने के बाद कंप्यूटर पर सारी जानकारी एक बार फिर से परख ले। कोई भी गलती पाते ही
                                तुरंत कंप्यूटर पर ठीक कर लीजिए।

                            </li>
                            <li>
                                फॉर्म सही से भरने के बाद फ़ॉर्म और अपने दस्तावेज़ों की 2-2 कॉपी बनाकर अपने खंड शिक्षा
                                अधिकारी दफ्तर में जमा करें। फ़ॉर्म भरने की आखरी तारीख 23 मई हैं।
                            </li>
                            <li>
                                25 मई दस्तावेज जमा करने की आखिरी तिथि है| इसलिए अपने दस्तावेज समय से जमा करवाएं |
                            </li>
                            <li>
                                दाखिले से पहले देहरादून स्थित उत्तराखंड के राज्य परियोजना कार्यालय में कंप्यूटर पर सभी
                                खंड शिक्षा अधिकारी द्वारा सत्यपित छात्रों की ऑनलाइन लॉटरी होगी। यह लॉटरी 1 जून को
                                होगी।
                            </li>
                            <li>
                                विद्यालय में उन्ही छात्रो का दाखिला होगा जिनका नाम लॉटरी में आएगा। लॉटरी होते ही
                                अभिभावकों के मोबाइल पर मैसेज आ जायेगा। पारित बच्चों की सूची आप खंड शिक्षा अधिकारी दफ्तर
                                पर भी होगी और RTE पोर्टल पर रेजिस्ट्रेशन नंबर डालकर अपने फॉर्म के बारे में जानकारी ले
                                सकते है ।
                            </li>
                            <li>
                                अधिक जानकारी के लिए इस नंबर पर मिस्ड कॉल करे- 01140845192
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
                                &nbsp;I
                                _________(parent name), ___________(parent type) of ______________(candidate name)
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
                    <p>Guardian's name:</p>
                    <p>Guardian's signature:
                        <&nbsp>
                        <&nbsp>
                        <&nbsp>
                    </p>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
