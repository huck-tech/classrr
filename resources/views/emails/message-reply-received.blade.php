<html>
<head>
    <meta content='text/html; charset=utf-8' http-equiv='Content-Type'>
    <meta content='width=device-width, initial-scale=1.0' name='viewport'>
</head>
<body>
    <div style="width:100%!important;background:#f2f2f2;margin:0;padding:0" bgcolor="#f2f2f2">
        <table width="100%" bgcolor="#f2f2f2" cellpadding="0" cellspacing="0" border="0" style="width:100%!important;line-height:100%!important;border-collapse:collapse;margin:0;padding:0">
            <tbody>
            <tr>
                <td style="border-collapse:collapse">
                    <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" style="display:block;border-collapse:collapse">
                        <tbody style="display:table;width:100%">
                        <tr>
                            <td style="border-collapse:collapse">

                                <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="border-collapse:collapse">
                                    <tbody>
                                    <tr>
                                        <td valign="middle" width="100%" align="center" style="border-collapse:collapse;padding:40px 0" >

                                            <a href="https://www.classrr.com/" style="text-emphasis:none" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=en&amp;q=https://www.classrr.com/&amp;source=gmail&amp;ust=1499063696634000&amp;usg=AFQjCNH2G7fSfaKvPm7wz87MM8B8dMs8NA">
                                                <img src="https://www.classrr.com/img/logo-teachinclass-black.png" alt="Classrr" width="108" height="30" border="0" style="display:block;outline:none;text-decoration:none;border:none">
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
    <table width="100%" bgcolor="#f2f2f2" cellpadding="0" cellspacing="0" border="0" id="m_264488515043371869backgroundTable" style="width:100%!important;line-height:100%!important;border-collapse:collapse;margin:0;padding:0">
        <tbody>
        <tr>
            <td style="border-collapse:collapse">
                <table bgcolor="#ffffff" width="600" align="center" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                    <tbody>
                    <tr>
                        <td>
                            <table width="540" align="center" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                <tbody style="border-collapse:collapse">

                                <tr>
                                    <td width="100%" height="30" style="border-collapse:collapse"></td>
                                </tr>


                                <tr>
                                    <td style="font-family:Helvetica,arial,sans-serif;font-size:14.5px;color:#666666;text-align:left;line-height:20px;border-collapse:collapse">
                                        <table width="100%" align="center" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                            <tbody>
                                            <tr>
                                                <td valign="top" style="vertical-align:top;font-family:Helvetica,arial,sans-serif;font-size:16px;color:#767676;text-align:left;line-height:20px;border-collapse:collapse">
                                                    You have unread messages about
                                                    <a href="{{ route('user_message', [$newMessage->id]) }}" style="color:#37a000;font-weight:bold;text-decoration:none" target="_blank">
                                                        {{  $newMessage->title }}
                                                    </a>
                                                </td>
                                            </tr><tr>
                                                <td width="100%" height="30" style="border-collapse:collapse;border-bottom-color:#e0e0e0;border-bottom-style:solid;border-bottom-width:1px"></td>
                                            </tr>

                                            <tr>
                                                <td style="border-collapse:collapse;padding-top:30px">
                                                    <table width="100%" align="center" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                                        <tbody>
                                                        <tr>
                                                            <td valign="top" width="60" style="padding-right:20px">
                                                                <img src="{{ $sender->getAvatarPath() }}" width="60" height="60" alt="{{ $sender->pretty_name() }}">
                                                            </td>
                                                            <td valign="top" width="100%" style="vertical-align:top;font-family:Helvetica,arial,sans-serif;font-size:16px;color:#222222;text-align:left;line-height:20px;border-collapse:collapse" align="left">
                                                                <div style="font-family:'Gotham SSm',Helvetica,arial,sans-serif;font-size:16px;color:#222222">
                                                                    <strong>{{ $sender->pretty_name() }}</strong>
                                                                </div>
                                                                <div style="font-size:12px;color:#7d7d7d;margin:0 0;padding-bottom:15px">
                                                                    {{ $messageReply->created_at }}
                                                                </div>
                                                                <div style="line-height:24px">
                                                                    {{ $messageReply->text }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>


                                        <table width="120px" align="left" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse">
                                            <tbody>
                                            <tr>
                                                <td style="font-size:14px;text-align:center;color:#ededed;padding:10px 20px 10px 20px;background:#32a000" bgcolor="#32A000" align="center" valign="middle">
                                                    <span style="color:#ededed">
                                                        <a style="color:#ededed;text-align:center;text-decoration:none" href="{{ route('user_message', [$newMessage->id]) }}" target="_blank">
                                                            Reply
                                                        </a>
                                                    </span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px 20px 10px 20px;">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

    <table cellspacing="0" cellpadding="0" width="100%" border="0" align="center" bgcolor="#f2f2f2">
        <tbody>
        <tr>
            <td valign="top" align="center" width="100%" style="padding-bottom:15px">
                <table width="540" border="0" cellspacing="0" cellpadding="0" align="center">

                    <tbody>
                    <tr>
                        <td align="center" style="padding:10px 10px 0px 10px">
                            <p style='font-family: helvetica, sans-serif; line-height: 24px; font-size: 16px; color: #888;; font-size: 12px; margin-top: 32px; padding-top: 16px; border-top: 1px solid #eee; color: #888'>
                                Classrr, 8 on Claymore &middot; Singapore 229572
                                &middot;
                                <a href="http://[unsubscribe]/" style="color: #666">Unsubscribe</a>
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

</body>
</html>
