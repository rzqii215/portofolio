<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password E-Portfolio</title>
</head>
<body style="margin: 0; padding: 0; background: #f1f5f9; font-family: Arial, Helvetica, sans-serif; color: #0f172a;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background: #f1f5f9; padding: 32px 16px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 560px; background: #ffffff; border-radius: 18px; overflow: hidden; border: 1px solid #e2e8f0;">
                    <tr>
                        <td style="background: #0f172a; padding: 28px 32px; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 24px; font-weight: 900;">
                                Reset Password
                            </h1>

                            <p style="margin: 8px 0 0; color: #cbd5e1; font-size: 14px;">
                                E-Portfolio Prestasi Mahasiswa
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 32px;">
                            <p style="margin: 0 0 14px; font-size: 15px; line-height: 1.7;">
                                Halo <strong>{{ $user->name }}</strong>,
                            </p>

                            <p style="margin: 0 0 18px; font-size: 15px; line-height: 1.7; color: #475569;">
                                Kami menerima permintaan untuk mereset password akun E-Portfolio kamu.
                                Klik tombol di bawah ini untuk membuat password baru.
                            </p>

                            <p style="margin: 28px 0; text-align: center;">
                                <a
                                    href="{{ $resetLink }}"
                                    style="display: inline-block; background: #2563eb; color: #ffffff; text-decoration: none; padding: 14px 22px; border-radius: 12px; font-size: 15px; font-weight: 900;"
                                >
                                    Reset Password
                                </a>
                            </p>

                            <p style="margin: 0 0 14px; font-size: 14px; line-height: 1.7; color: #475569;">
                                Link reset password ini berlaku selama 60 menit.
                            </p>

                            <p style="margin: 0 0 14px; font-size: 14px; line-height: 1.7; color: #475569;">
                                Jika tombol tidak bisa dibuka, salin link berikut ke browser:
                            </p>

                            <p style="margin: 0; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; font-size: 13px; line-height: 1.6; word-break: break-all;">
                                <a href="{{ $resetLink }}" style="color: #2563eb; font-weight: 700;">
                                    {{ $resetLink }}
                                </a>
                            </p>

                            <p style="margin: 22px 0 0; font-size: 14px; line-height: 1.7; color: #64748b;">
                                Jika kamu tidak meminta reset password, abaikan email ini.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 18px 32px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0; color: #64748b; font-size: 13px;">
                                Email otomatis dari Sistem E-Portfolio Prestasi Mahasiswa.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>