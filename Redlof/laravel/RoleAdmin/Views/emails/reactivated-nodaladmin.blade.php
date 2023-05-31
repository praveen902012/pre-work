@include('admin::emails.inc-mail-header')
<tr>
 <td>
  <table cellspacing="0" cellpadding="0" width="100%">

   <tr>
    <td style="text-decoration:none;padding: 10px 20px 10px;font-family: Arial;" >
     <h4 style="padding: 10px 15px;">
      Hello {{$first_name}}!
    </h4>
    <p style="font-size: 14px;font-family: Arial;padding: 0px 15px;line-height: 22px;">
      Your account has been activated.
    </p>


  </td>
</tr>
</table>
</td>
</tr>

@if(isset($password))
<tr>
 <td>
  <table cellspacing="0" cellpadding="0" width="100%">
   <tr>
    <td align="center" style="padding: 10px 20px 10px">
     <p style="font-size: 14px;font-family: Lato;padding: 0px 15px;line-height: 22px;color: #6f7784;">
       Use the following credentials to login to your account.
     </p>
     <p style="font-size: 14px;font-family: Lato;padding: 0px 15px;line-height: 22px;color: #6f7784;">
       Email : <a href="{!! url('/') !!}">{!!$email!!}</a><br>
       Password : {!!$password!!}<br>
     </p>
   </td>


 </tr>
</table>
</td>
</tr>
@endif

<tr>
  <td>
    <table cellspacing="0" cellpadding="0" width="100%">
      <tr>
        <td style="padding: 10px 0px 10px 20px">
          <p style="font-size: 14px;font-family: Lato;padding: 0px 15px;line-height: 22px;color: #6f7784;">
            Thanks &amp; Regards, <br>
            Team RTE <br>
          </p>
        </td>
      </tr>
    </table>
  </td>
</tr>


@include('admin::emails.inc-mail-footer')