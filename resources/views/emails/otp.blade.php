<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Password</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0"
        style="background-color: #f4f6f9; padding: 40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="420" cellspacing="0" cellpadding="0"
                    style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); overflow: hidden;">

                    {{-- Header --}}
                    <tr>
                        <td style="background-color: #1E7A5C; padding: 28px 32px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 700; letter-spacing: 0.5px;">
                                🔒 Reset Password
                            </h1>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 32px;">
                            <p style="margin: 0 0 16px; color: #333333; font-size: 15px; line-height: 1.6;">
                                Halo,
                            </p>
                            <p style="margin: 0 0 24px; color: #333333; font-size: 15px; line-height: 1.6;">
                                Kami menerima permintaan untuk mereset password akun Anda. Gunakan kode OTP berikut:
                            </p>

                            {{-- OTP Code --}}
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" style="padding: 8px 0 24px;">
                                        <div style="display: inline-block; background-color: #f0faf6; border: 2px dashed #1E7A5C; border-radius: 10px; padding: 16px 40px;">
                                            <span style="font-size: 36px; font-weight: 800; color: #1E7A5C; letter-spacing: 12px; font-family: 'Courier New', monospace;">
                                                {{ $otp }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 8px; color: #666666; font-size: 13px; line-height: 1.6;">
                                ⏱️ Kode ini berlaku selama <strong>10 menit</strong>.
                            </p>
                            <p style="margin: 0 0 0; color: #666666; font-size: 13px; line-height: 1.6;">
                                Jika Anda tidak meminta reset password, abaikan email ini. Akun Anda tetap aman.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 20px 32px; text-align: center; border-top: 1px solid #e9ecef;">
                            <p style="margin: 0; color: #999999; font-size: 12px;">
                                &copy; {{ date('Y') }} Hotdie. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
