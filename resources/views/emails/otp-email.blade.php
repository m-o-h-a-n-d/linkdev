<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Handball Hub — OTP Verification Code</title>
    
    <style>
        /* Reset Styles for Email Clients */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; background-color: #070c14; font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, Helvetica, Arial, sans-serif; }

        /* Responsive Mobile Layout */
        @media screen and (max-width: 600px) {
            .email-container { width: 100% !important; padding: 10px !important; }
            .otp-digit { width: 38px !important; height: 48px !important; font-size: 24px !important; line-height: 48px !important; margin: 0 2px !important; }
            .content-padding { padding: 24px 18px !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #070c14; color: #f8fafc;">

    <!-- Wrapper Table -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #070c14; table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 40px 10px 40px 10px;">
                
                <!-- Main Email Card -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="email-container" style="max-width: 540px; background-color: #0e1626; border: 1px solid #1e293b; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);">
                    
                    <!-- Header Banner -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #070c14 0%, #162238 100%); padding: 32px 24px; border-bottom: 2px solid #ea580c;">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <div style="display: inline-block; width: 50px; height: 50px; background-color: #ea580c; border-radius: 12px; line-height: 50px; text-align: center; color: #ffffff; font-size: 24px; font-weight: 900; font-family: sans-serif; box-shadow: 0 6px 16px rgba(234, 88, 12, 0.4);">
                                            ⚡
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-top: 14px;">
                                        <span style="font-family: 'Oswald', 'Segoe UI', sans-serif; font-size: 22px; font-weight: 800; color: #ffffff; letter-spacing: 2px; text-transform: uppercase;">
                                            HANDBALL <span style="color: #ea580c;">HUB</span>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td class="content-padding" style="padding: 36px 32px; text-align: center;">
                            
                            <!-- Lock Icon Pill -->
                            <div style="display: inline-block; background-color: rgba(234, 88, 12, 0.12); border: 1px solid rgba(234, 88, 12, 0.3); border-radius: 30px; padding: 6px 18px; margin-bottom: 20px;">
                                <span style="color: #ea580c; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                                    🔒 Security Verification
                                </span>
                            </div>

                            <h1 style="margin: 0 0 12px 0; color: #ffffff; font-size: 24px; font-weight: 800; letter-spacing: 0.5px;">
                                One-Time Passcode
                            </h1>
                            
                            <p style="margin: 0 0 28px 0; color: #94a3b8; font-size: 15px; line-height: 1.6;">
                                Use the verification code below to authorize your password reset request. This code is private and single-use.
                            </p>

                            <!-- OTP Digits Container -->
                            <div style="background: linear-gradient(135deg, #070c14 0%, #0e172a 100%); border: 2px dashed #ea580c; border-radius: 14px; padding: 24px 16px; margin-bottom: 28px;">
                                <div style="margin-bottom: 8px; color: #64748b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px;">
                                    Your 6-Digit Passcode
                                </div>

                                <!-- Digit Boxes Layout -->
                                <table border="0" cellpadding="0" cellspacing="0" align="center" style="margin: 0 auto;">
                                    <tr>
                                        @foreach(str_split((string)$otp) as $digit)
                                            <td style="padding: 0 4px;">
                                                <div class="otp-digit" style="width: 44px; height: 56px; background-color: #1e293b; border: 1px solid #334155; border-radius: 8px; color: #ea580c; font-family: 'Courier New', Courier, monospace; font-size: 28px; font-weight: 800; line-height: 56px; text-align: center; box-shadow: inset 0 2px 4px rgba(0,0,0,0.5);">
                                                    {{ $digit }}
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                </table>
                            </div>

                            <!-- Expiration Badge -->
                            <table border="0" cellpadding="0" cellspacing="0" align="center" style="margin: 0 auto 28px auto;">
                                <tr>
                                    <td style="background-color: #1e293b; border: 1px solid #334155; border-radius: 20px; padding: 8px 18px; color: #94a3b8; font-size: 13px;">
                                        ⏱️ Valid for <strong style="color: #f8fafc;">{{ $expiresInMinutes }} minutes</strong>
                                    </td>
                                </tr>
                            </table>

                            <!-- Security Warning Notice -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: rgba(239, 68, 68, 0.08); border-left: 4px solid #ef4444; border-radius: 4px;">
                                <tr>
                                    <td style="padding: 14px 16px; text-align: left;">
                                        <p style="margin: 0; color: #f87171; font-size: 13px; line-height: 1.5;">
                                            <strong>Security Notice:</strong> Never share this OTP code with anyone. Our support team will never ask for your verification passcode.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #070c14; padding: 24px 32px; text-align: center; border-top: 1px solid #1e293b;">
                            <p style="margin: 0 0 8px 0; color: #64748b; font-size: 12px; line-height: 1.5;">
                                You received this email because a password reset request was submitted for your account.
                            </p>
                            <p style="margin: 0; color: #475569; font-size: 12px;">
                                &copy; {{ date('Y') }} Handball Hub. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
                <!-- End Email Card -->

            </td>
        </tr>
    </table>

</body>
</html>
