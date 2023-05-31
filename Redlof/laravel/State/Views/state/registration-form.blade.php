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
                <b>
                    SCHOOL REGISTRATION FORM FOR THE SESSION {{$year}}-{{$year+1}}
                    <br>STATE ADMINISTRATION, UTTARAKHAND
                </b>
            </div>
        </div>

        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="color:#1E88E5;">Primary Details</th>
                    </tr>
                </thead>
            </table>
        </div>
        
        <div class="row mb-2">
            <table class="table table-bordered">
                <tr>
                    <th><b>School Name</b></th>
                    <td>{{$school_details['name']}}</td>
                </tr>
                <tr>
                    <th><b>UDISE Code</b></th>
                    <td>{{$school_details['udise']}}</td>
                </tr>
                <tr>
                    <th><b>Medium of Instruction</b></th>
                    <td>{{$school_details['language']['name']}}</td>
                </tr>
                <tr>
                    <th><b>Class Upto</b></th>
                    <td>{{$school_details['type']}}</td>
                </tr>
                <tr>
                    <th><b>Type</b></th>
                    <td>{{$school_details['school_type']}}</td>
                </tr>
                <tr>
                    <th><b>Admin Mobile No.</b></th>
                    <td>{{$school_details['schooladmin']['user']['phone']}}</td>
                </tr>
                <tr>
                    <th><b>Contact Number</b></th>
                    <td>{{$school_details['phone']}}</td>
                </tr>
                <tr>
                    <th><b>Entry Classes</b></th>
                    <td>
                        @if($school_details['entry_class'])
                            {{$school_details['entry_class']}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th><b>RTE Certificate No.</b></th>
                    <td>{{$school_details['rte_certificate_no']}}</td>
                </tr>
                <tr>
                    <th><b>Email ID</b></th>
                    <td>
                        {{$school_details['schooladmin']['user']['email']}}
                    </td>
                </tr>
                <tr>
                    <th><b>Website Link</b></th>
                    <td>
                        @if($school_details['website'])
                            {{$school_details['website']}}
                        @endif    
                    </td>
                </tr>

                @if($school_details['fmt_logo'])
                    <tr>
                        <th><b>School Image</b></th>
                        <td class="text-center">
                            <img style="max-height:500px" width="300"
                                ng-src="{{$school_details['fmt_logo']}}" alt="{{$school_details['name']}}">
                        </td>
                    </tr>
                @endif    

                <tr>
                    <th><b>School Description</b></th>
                    <td>
                        @if($school_details['description'])
                            {{$school_details['description']}}
                        @endif     
                    </td>
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
                    <th><b>District</b></th>
                    <td>{{$school_address['district_name']}}</td>
                </tr>
                <tr>
                    <th><b>Block</b></th>
                    <td>{{$school_address['block_name']}}</td>
                </tr>
                <tr>
                    <th><b>Rural/Urban</b></th>
                    <td>{{$school_address['state_type']}}</td>
                </tr>
                <tr>
                    <th><b>Block/Nagar Nigam/Nagar Palika Parishad/Nagar Panchayat</b></th>
                    <td>{{$school_address['sub_block_name']}}</td>
                </tr>
                <tr>
                    <th><b>Ward or Village</b></th>
                    <td>{{$school_address['locality_name']}}</td>
                </tr>
                <tr>
                    <th><b>Pincode</b></th>
                    <td>{{$school_address['pincode']}}</td>

                </tr>
                <tr>
                    <th><b>Postal Address</b></th>
                    <td>{{$school_address['address']}}</td>
                </tr>
            </table>
        </div>

        <div class="row">
            <table class="table table-bordered mt-5">
                <thead>
                    <tr>
                        <th style="color:#1E88E5;">Region Selection Details</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="row mb-2">
            <h4>Selected neighbourhood wards (In Block):</h4><br>
            <table class="table table-bordered">
                <tr>
                    <th><b>S No.</b></th>
                    <th><b>Name</b></th>
                </tr>
                @foreach($school_region['selected'] as $key => $s_region)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$s_region['name']}}</td>
                    </tr>
                @endforeach
            </table>
            <br>
            <h4>Selected neighbourhood wards (In District):</h4><br>
            <table class="table table-bordered">
                <tr>
                    <th><b>S No.</b></th>
                    <th><b>Name</b></th>
                </tr>
                @foreach($school_region['selectedDist'] as $key => $region)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$region['name']}}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="row">
            <table class="table table-bordered mt-5">
                <thead>
                    <tr>
                        <th style="color:#1E88E5;">Fee Details</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="row">
            <table class="table table-bordered">
                <tr>
                    <th><b>S No.</b></th>
                    <th><b>Class</b></th>
                    <th><b>Monthly Tution Fee (in Rs)</b></th>
                    <th><b>Total Annual Fees (in Rs)</b></th>
                </tr>

                @foreach($school_fee_structure as $key => $fee)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$fee['level_info']['level']}}</td>
                        <td>{{$fee['tution_fee']}}</td>
                        <td>{{ ($fee['tution_fee']*12) + $fee['other_fee'] }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="color:#1E88E5;">Total RTE seats allotted</th>
                    </tr>
                </thead>
            </table>
        </div>
        
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Class</th>
                        <th class="text-center">{{$year - 3 }} - {{ $year - 2 }}
                        </th>
                        <th class="text-center">{{ $year - 2 }} - {{ $year - 1 }}
                        </th>
                        <th class="text-center">{{ $year - 1 }} - {{ $year}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1.</td>
                        <td>
                            {{$school_past_seat_info['level']}}
                        </td>
                        <td>
                            {{$school_past_seat_info['third_year']}}
                        </td>
                        <td>
                            {{$school_past_seat_info['second_year']}}
                        </td>
                        <td>
                            {{$school_past_seat_info['first_year']}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="color:#1E88E5;">Seat Details</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="row">
            <table class="table table-bordered">
                <tr>
                    <th><b>S No.</b></th>
                    <th><b>Class</b></th>
                    <th><b>Available Seats</b></th>
                    <th><b>Total Seats</b></th>
                </tr>
                @foreach($school_seat_info as $key => $single_seat)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$single_seat['level']}}</td>
                        <td>{{$single_seat['available_seats']}}</td>
                        <td>{{$single_seat['total_seats']}}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="color:#1E88E5;">Bank Details</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="row">
            <table class="table table-bordered">
                <tr>
                    <th><b>Account Holder Name</b></th>
                    <td>{{$school_bank_details['account_holder_name']}}</td>
                </tr>
                <tr>
                    <th><b>Account Number</b></th>
                    <td>{{$school_bank_details['account_number']}}</td>
                </tr>
                <tr>
                    <th><b>Bank Name</b></th>
                    <td>{{$school_bank_details['bank_name']}}</td>
                </tr>
                <tr>
                    <th><b>IFSC Code</b></th>
                    <td>{{$school_bank_details['ifsc_code']}}</td>
                </tr>
                <tr>
                    <th><b>Branch Name</b></th>
                    <td>{{$school_bank_details['branch']}}</td>
                </tr>
            </table>
        </div>

    </div>

</body>

</html>

