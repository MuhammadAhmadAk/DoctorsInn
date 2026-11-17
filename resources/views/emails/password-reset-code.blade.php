<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>DoctorsInn — Password Reset Code</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f1fb;-webkit-text-size-adjust:100%;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f1fb;padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;background-color:#ffffff;border:1px solid #ece7f8;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td style="padding:28px 32px 0 32px;" align="left">
                            <img src="{{ $message->embed(public_path('frontend/img/logo/logo-email.png')) }}" alt="DoctorsInn" height="38" style="display:block;height:38px;width:auto;border:0;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:22px 32px 0 32px;">
                            <h1 style="margin:0 0 10px 0;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:20px;line-height:1.35;color:#1d1b26;font-weight:700;">Password Reset Code</h1>
                            <p style="margin:0 0 18px 0;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:14px;line-height:1.65;color:#55516a;">
                                Hi {{ $user->name }},<br>
                                we received a request to reset the password for your DoctorsInn account. Use the code below to continue:
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 32px;">
                            <div style="background-color:#f4f1fb;border:1px solid #e2daf6;border-radius:8px;padding:16px 18px;text-align:center;">
                                <span style="font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:28px;line-height:1;letter-spacing:7px;font-weight:700;color:#5C32FF;">{{ $code }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:14px 32px 0 32px;">
                            <p style="margin:0 0 18px 0;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:12px;line-height:1.6;color:#8a8598;">
                                This code expires in 15 minutes. If you did not request a password reset, you can safely ignore this email — your password will stay unchanged.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 32px;">
                            <div style="border-top:1px solid #f0ecfa;font-size:0;line-height:0;">&nbsp;</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 32px 26px 32px;">
                            <p style="margin:0;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:12px;line-height:1.6;color:#9a95a8;">
                                Sent by <strong style="color:#55516a;">DoctorsInn</strong> — Your companion to Success<br>
                                <a href="https://dev.doctorsinnelite.com" style="color:#5C32FF;text-decoration:none;">dev.doctorsinnelite.com</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
