<!DOCTYPE html>
<html lang="ar" dir="rtl" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>تحديث بشأن طلب تسجيل الفريق — Handball Hub</title>
    
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; background-color: #070c14; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        @media screen and (max-width: 600px) {
            .email-container { width: 100% !important; padding: 10px !important; }
            .content-padding { padding: 24px 18px !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #070c14; color: #f8fafc;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #070c14; table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 40px 10px;">
                
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="email-container" style="max-width: 580px; background-color: #0e1626; border: 1px solid #1e293b; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);">
                    
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #070c14 0%, #162238 100%); padding: 32px 24px; border-bottom: 2px solid #ef4444;">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <div style="display: inline-block; width: 56px; height: 56px; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-radius: 14px; line-height: 56px; text-align: center; color: #ffffff; font-size: 24px; font-weight: 900; box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);">
                                            ✕
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-top: 14px;">
                                        <span style="font-size: 22px; font-weight: 800; color: #ffffff; letter-spacing: 1px;">
                                            HANDBALL <span style="color: #ef4444;">HUB</span>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td class="content-padding" style="padding: 36px 32px; text-align: right;">
                            
                            <div style="display: inline-block; background-color: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 30px; padding: 6px 18px; margin-bottom: 20px;">
                                <span style="color: #ef4444; font-size: 13px; font-weight: 700; text-transform: uppercase;">
                                    ⚠️ تحديث حالة الطلب
                                </span>
                            </div>

                            <h1 style="margin: 0 0 16px 0; color: #ffffff; font-size: 24px; font-weight: 800; line-height: 1.4;">
                                اعتذار بشأن طلب تسجيل الفريق
                            </h1>
                            
                            <p style="margin: 0 0 24px 0; color: #94a3b8; font-size: 15px; line-height: 1.8;">
                                عزيزي الكابتن / مدير الفريق <strong>{{ $team->manager_name ?? 'الراعي' }}</strong>، نأسف لإبلاغك بأنه قد تم مراجعة طلب تسجيل فريق <strong>({{ $team->name }})</strong> وتواذر عدم استيفاء الشروط المطلوبة للتسجيل في الوقت الحالي.
                            </p>

                            <!-- Rejection Reason Card -->
                            @if(!empty($reason))
                            <div style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.08) 0%, rgba(220, 38, 38, 0.05) 100%); border-right: 4px solid #ef4444; border-radius: 8px; padding: 18px; margin-bottom: 28px;">
                                <h4 style="margin: 0 0 8px 0; color: #f87171; font-size: 14px; font-weight: 700;">
                                    سبب عدم القبول:
                                </h4>
                                <p style="margin: 0; color: #fca5a5; font-size: 14px; line-height: 1.6;">
                                    {{ $reason }}
                                </p>
                            </div>
                            @endif

                            <!-- Team Details Card -->
                            <div style="background: linear-gradient(135deg, #070c14 0%, #0e172a 100%); border: 1px solid #334155; border-radius: 14px; padding: 20px; margin-bottom: 28px;">
                                <h3 style="margin: 0 0 14px 0; color: #ef4444; font-size: 16px; font-weight: 700; border-bottom: 1px dashed #334155; padding-bottom: 8px;">
                                    بيانات الطلب المقدم:
                                </h3>

                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 14px; color: #cbd5e1;">
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b;">اسم الفريق:</td>
                                        <td style="padding: 6px 0; font-weight: 700; color: #ffffff; text-align: left;">{{ $team->name }} ({{ $team->short_name }})</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b;">المدينة / الدولة:</td>
                                        <td style="padding: 6px 0; font-weight: 700; color: #ffffff; text-align: left;">{{ $team->city }}، {{ $team->country }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; color: #64748b;">الحالة الحالية:</td>
                                        <td style="padding: 6px 0; text-align: left;">
                                            <span style="background-color: #ef4444; color: #ffffff; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: 700;">مرفوض (Rejected)</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <p style="margin: 0 0 28px 0; color: #94a3b8; font-size: 14px; line-height: 1.7;">
                                يمكنك استيفاء البيانات المطلوبة وإعادة تقديم الطلب، أو التواصل مع الدعم الفني للبطولة لمزيد من الاستفسارات.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #070c14; padding: 24px 32px; text-align: center; border-top: 1px solid #1e293b;">
                            <p style="margin: 0 0 8px 0; color: #64748b; font-size: 12px; line-height: 1.5;">
                                وصلتك هذه الرسالة بناءً على تقديم طلب تسجيل فريق في Handball Hub System.
                            </p>
                            <p style="margin: 0; color: #475569; font-size: 12px;">
                                &copy; {{ date('Y') }} Handball Hub. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
