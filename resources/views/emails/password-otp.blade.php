<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset OTP</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f6fa;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6fa; padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">
                    
                    <tr>
                        <td align="center" style="background:#3f51b5; padding:20px;">
                            <h1 style="color:#ffffff; margin:0; font-size:20px; font-weight:600;">
                                AIRWAY CONNECT
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:30px 20px 10px;">
                            <img src="https://img.icons8.com/ios-filled/100/3f51b5/lock.png" alt="Lock Icon" width="80" height="80">
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:0 20px;">
                            <h2 style="color:#3f51b5; margin:20px 0 10px; font-size:24px;">Forgot Your Password?</h2>
                            <p style="color:#555; font-size:14px; margin:0 0 20px;">
                                No worries! Use the OTP below to reset your password.  
                                This OTP is valid for <strong>10 minutes</strong>.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:20px;">
                            <div style="background:#f4f6fa; border:2px dashed #3f51b5; display:inline-block; padding:15px 30px; border-radius:6px; font-size:22px; font-weight:bold; letter-spacing:5px; color:#3f51b5;">
                                {{ $otp }}
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:30px 20px;">
                            <p style="color:#777; font-size:13px; line-height:1.6; margin:0;">
                                If you didn’t request a password reset, you can safely ignore this email.  
                                For extra security, consider enabling two-factor authentication.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="background:#3f51b5; padding:15px;">
                            <p style="color:#ffffff; font-size:12px; margin:0;">
                                © {{ date('Y') }} AIRWAY CONNECT · All rights reserved
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
