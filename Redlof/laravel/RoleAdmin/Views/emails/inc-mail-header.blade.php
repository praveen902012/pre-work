<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <title>{!! config('redlof.name')!!}</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
   <style type="text/css">
      @media only screen and (max-width: 480px) and (min-width: 320px) {
         body,table,td,a {
            -webkit-text-size-adjust:none !important;
         }
         table {width: 100% !important;}
         .responsive-image img {
            height: auto !important;
            max-width: 100% !important;
            width: 100% !important;
         }
      }
      .btn {
         color: #FFFFFF;
         background-color: #3c8dbc;
         border-color: #367fa9;
         border-radius: 4px;
      }
      .bg-img {
         height: 240px;
         background: #3c8dbc url('');
         background-size: cover;
         background-position: bottom;
         background-repeat: no-repeat;
         position: relative;
      }
   </style>
</head>

<body style="margin: 0;padding: 0; font-family: 'Lato', sans-serif;
    background-color: #f9f9f9;
    ">
   <table align="center" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;border: 1px solid #e0e0e0;">

      <tr>
         <td width="100%" style="padding: 10px;">
            <a href="{!! url('/') !!}">
               <img width="auto" height="45px" src="{!! asset('img/rte-logo.png') !!}" alt="RTE" class="responsive-image"/>
            </a>
         </td>
      </tr>