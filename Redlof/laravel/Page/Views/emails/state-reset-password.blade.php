<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Reset Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet">
  <style type="text/css">
    td    {
      color: #888;
      line-height: 27px;
    }

  </style>
</head>
<body style="margin: 0; padding: 0;font-family: Lato, serif;position: relative;">
  <div style="background-image: linear-gradient(186deg, rgb(145, 28, 255) 1%, rgb(255, 176, 31) 101%);height: 3px;max-width:600px;margin: 0 auto;position: absolute;top: 41px;left: 0;right: 0;border-top-left-radius: 3px;border-top-right-radius: 3px;"></div>
  <table style="padding: 40px 0" border="0" bgcolor="#EFEFE9" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td>
        <table style="max-width:600px;border: 1px solid #cccccc;border-radius: 0px;border-radius: 3px;" align="center" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" bgcolor="#ffffff" style="padding: 20px 0;display: block;max-width: 100%;height: auto;border-bottom: 2px solid #ededed;">
              <!-- <a href="https://instasafe.com" target="_blank">
                <img src="https://instasafe.com/web/wp-content/themes/instasafe-wp-theme-development/public/img/Instasafe-logo.png" alt="Creating Email Magic" style="display: block;" />
              </a> -->
            </td>
          </tr>
          <tr>
            <td bgcolor="#ffffff" style="padding: 30px 30px 0px 30px;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td style="font-size: 16px;font-weight: 500;">
                    <h2>Hello!</h2>
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 16px;font-weight: 500;">
                    You are receiving this email because we received a password reset request for your account.
                  </td>
                </tr>

                <tr>
                  <td>
                    <table cellspacing="0" cellpadding="0" width="100%">
                      <tr>
                        <td align="center" style="padding: 10px 20px 10px" >
                          <a style="text-decoration: none;padding:11px 40px;font-family: Arial;font-size: 14px;color: #FFFFFF; background-color: #3c8dbc;border-color: #367fa9;border-radius: 4px; display: inline-block; margin: 15px 0;" class="btn" href="{!! $link !!}">
                            Reset Password
                          </a>

                          <p style="font-size: 14px;font-family: Arial;padding: 0px 15px;line-height: 22px;">
                            In case you face any issues, you can check our knowledge base <a href="https://support.rte.com/portal/kb">here</a> or open a ticket <a href="https://support.rte.com/portal/newticket">here</a>
                          </p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>


              </table>
            </td>
          </tr>

@include('admin::emails.inc-mail-footer')
