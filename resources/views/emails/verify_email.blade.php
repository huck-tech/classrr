<html>
<head>
<meta content='text/html; charset=utf-8' http-equiv='Content-Type'>
<meta content='width=device-width, initial-scale=1.0' name='viewport'>

<style>
  html, body, td {
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px;
  }
  
  @media screen and (max-width: 520px) {
    body {
      width: 100%!important;
    }
    img {
      max-width: 100%!important;
      height:auto !important;
    }
    a {
      word-break: break-word;
    }
  }
</style>

<style>
    /* Fixing width issues in Apple Mail */
    @media only screen and (min-device-width: 601px) {
      .container {width: 600px !important;}
    }
</style>
<!--[if (gte mso 9)|(IE)]>
<style>
  li {
    text-indent: -1em; /* Normalise space between bullets and text */
  }
</style>
<![endif]-->
</head>
<body>
<!--[if (gte mso 9)|(IE)]>
<table width="600" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td>
<![endif]-->
<table border='0' cellpadding='0' cellspacing='0' class='container' style='max-width: 520px; width: 100%;'>
<tr>
<td>
<p style='font-family: helvetica, sans-serif; line-height: 24px; font-size: 16px;'>
Hi {{ $current_user->pretty_name() }},
</p>
<p style='font-family: helvetica, sans-serif; line-height: 24px; font-size: 16px;'>
Thank you for joining Classrr.
</p>
<p style='font-family: helvetica, sans-serif; line-height: 24px; font-size: 16px;'>
Please verify your email to complete your registration on Classrr.
</p>
<p style='font-family: helvetica, sans-serif; line-height: 24px; font-size: 16px;'>
<table cellpadding='0' cellspacing='0'>
<tr>
<td align='center' bgcolor='#3379CD' height='40' style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; text-align: center; padding: 2px; -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px; border-bottom: 1px solid #2E6496; background-color: #3379CD;padding: 0;" width='300'>
<a href="{{ url('/') }}/verification/email/{{ $verification_code }}" style="color: #ffffff; font-size: 16px; font-family: helvetica, sans-serif; text-decoration: none; width: 100%; display: inline-block; line-height: 40px; height: 40px;">Verify Email</a>
</td>
</tr>
</table>

</p>
<p style='font-family: helvetica, sans-serif; line-height: 24px; font-size: 16px; color: #888;; font-size: 12px; margin-top: 32px; padding-top: 16px; border-top: 1px solid #eee; color: #888'>
Classrr, 8 on Claymore &middot; Singapore 229572
&middot;
<a href="http://[unsubscribe]/" style="color: #666">Unsubscribe</a>
</p>

</td>
</tr>
</table>
<!--[if (gte mso 9)|(IE)]>
    </td>
  </tr>
</table>
<![endif]-->

<!--
Tracker
<img src="#" alt="" width="1" height="1" border="0" style="height:1px !important;width:1px !important;border-width:0 !important;margin-top:0 !important;margin-bottom:0 !important;margin-right:0 !important;margin-left:0 !important;padding-top:0 !important;padding-bottom:0 !important;padding-right:0 !important;padding-left:0 !important;"/>
-->
</body>
</html>