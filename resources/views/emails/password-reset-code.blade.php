<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>Reset your password</title>
</head>
<body style="margin:0;padding:0;background-color:#f6f6f8;-webkit-text-size-adjust:100%;">
    <div style="display:none;max-height:0;overflow:hidden;mso-hide:all;">Your DoctorsInn password reset code is inside — it expires in 15 minutes.</div>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f6f6f8;">
        <tr>
            <td align="center" style="padding:40px 16px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;background-color:#ffffff;border:1px solid #ececf1;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td style="height:3px;background-color:#5c32ff;font-size:0;line-height:0;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:36px 40px 0 40px;">
                            <img src="{{ $message->embed(public_path('frontend/img/logo/logo-email.png')) }}" alt="DoctorsInn" width="112" style="display:block;width:112px;height:auto;border:0;">
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:26px 40px 0 40px;">
                            <h1 style="margin:0;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:21px;line-height:1.35;color:#15151c;font-weight:700;">Reset your password</h1>
                            <p style="margin:10px 0 0 0;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:14px;line-height:1.65;color:#5c616b;">
                                Hi {{ $user->name }}, we received a request to reset your DoctorsInn password. Enter the code below to continue.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 40px 0 40px;">
                            <div style="background-color:#f7f7fa;border:1px solid #ededf2;border-radius:8px;padding:18px 12px;text-align:center;">
                                <span style="font-family:Consolas,'Courier New',monospace;font-size:30px;line-height:1;letter-spacing:8px;font-weight:700;color:#5c32ff;">{{ $code }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:14px 40px 0 40px;">
                            <p style="margin:0;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:12.5px;line-height:1.6;color:#8b909a;">
                                This code expires in 15 minutes. If you didn't request a password reset, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:26px 40px 0 40px;">
                            <div style="border-top:1px solid #f1f1f4;font-size:0;line-height:0;">&nbsp;</div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:18px 40px 30px 40px;">
                            <p style="margin:0;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:12px;line-height:1.7;color:#9aa0aa;">
                                <strong style="color:#5c616b;">DoctorsInn</strong> — Your companion to Success<br>
                                <a href="{{ config('app.url') }}" style="color:#5c32ff;text-decoration:none;">{{ preg_replace('#^https?://#', '', config('app.url')) }}</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
