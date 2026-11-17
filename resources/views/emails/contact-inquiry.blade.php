<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>New contact message</title>
</head>
<body style="margin:0;padding:0;background-color:#f6f6f8;-webkit-text-size-adjust:100%;">
    <div style="display:none;max-height:0;overflow:hidden;mso-hide:all;">New message from {{ $senderName }} via the DoctorsInn contact form.</div>
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f6f6f8;">
        <tr>
            <td align="center" style="padding:40px 16px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;background-color:#ffffff;border:1px solid #ececf1;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td style="height:3px;background-color:#5c32ff;font-size:0;line-height:0;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:32px 40px 0 40px;">
                            <img src="{{ $message->embed(public_path('frontend/img/logo/logo-email.png')) }}" alt="DoctorsInn" width="104" style="display:block;width:104px;height:auto;border:0;">
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:22px 40px 0 40px;">
                            <h1 style="margin:0;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:20px;line-height:1.35;color:#15151c;font-weight:700;">New contact message</h1>
                            <p style="margin:8px 0 0 0;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:13.5px;line-height:1.6;color:#5c616b;">
                                Someone submitted the contact form on your website.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:22px 40px 0 40px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ededf2;border-radius:8px;">
                                <tr>
                                    <td style="padding:12px 16px;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:12px;line-height:1.5;color:#8b909a;width:88px;">Name</td>
                                    <td style="padding:12px 16px;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:14px;line-height:1.5;color:#15151c;font-weight:600;">{{ $senderName }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 16px;border-top:1px solid #f1f1f4;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:12px;line-height:1.5;color:#8b909a;">Email</td>
                                    <td style="padding:12px 16px;border-top:1px solid #f1f1f4;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:14px;line-height:1.5;color:#15151c;font-weight:600;">
                                        <a href="mailto:{{ $senderEmail }}" style="color:#5c32ff;text-decoration:none;">{{ $senderEmail }}</a>
                                    </td>
                                </tr>
                                @if ($senderPhone)
                                    <tr>
                                        <td style="padding:12px 16px;border-top:1px solid #f1f1f4;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:12px;line-height:1.5;color:#8b909a;">Phone</td>
                                        <td style="padding:12px 16px;border-top:1px solid #f1f1f4;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:14px;line-height:1.5;color:#15151c;font-weight:600;">{{ $senderPhone }}</td>
                                    </tr>
                                @endif
                                @if ($topic)
                                    <tr>
                                        <td style="padding:12px 16px;border-top:1px solid #f1f1f4;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:12px;line-height:1.5;color:#8b909a;">Topic</td>
                                        <td style="padding:12px 16px;border-top:1px solid #f1f1f4;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:14px;line-height:1.5;color:#15151c;font-weight:600;">{{ $topic }}</td>
                                    </tr>
                                @endif
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 40px 0 40px;">
                            <p style="margin:0 0 8px 0;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:12px;letter-spacing:0.05em;text-transform:uppercase;color:#8b909a;">Message</p>
                            <div style="background-color:#f7f7fa;border:1px solid #ededf2;border-radius:8px;padding:16px;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:14px;line-height:1.7;color:#15151c;">{!! nl2br(e($inquiry)) !!}</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 40px 0 40px;">
                            <p style="margin:0;font-family:'Segoe UI',Arial,Helvetica,sans-serif;font-size:12.5px;line-height:1.6;color:#8b909a;">
                                Reply to this email to answer {{ $senderName }} directly.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:22px 40px 0 40px;">
                            <div style="border-top:1px solid #f1f1f4;font-size:0;line-height:0;">&nbsp;</div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:16px 40px 26px 40px;">
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
