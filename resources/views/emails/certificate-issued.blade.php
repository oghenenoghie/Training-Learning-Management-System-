<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Certificate is Ready</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:30px 0;">
  <tr>
    <td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
        <!-- Header -->
        <tr>
          <td style="background:#1A4D5E;padding:32px 40px;text-align:center;">
            <h1 style="color:#ffffff;font-size:24px;margin:0;letter-spacing:1px;">IFS Nigeria</h1>
            <p style="color:#E07B2A;font-size:12px;margin:6px 0 0;letter-spacing:2px;text-transform:uppercase;">International Finance &amp; Strategy</p>
          </td>
        </tr>
        <tr><td style="background:#E07B2A;height:4px;"></td></tr>
        <!-- Body -->
        <tr>
          <td style="padding:40px;">
            <h2 style="color:#1A4D5E;font-size:20px;margin:0 0 16px;">Congratulations!</h2>
            <p style="color:#444;font-size:15px;line-height:1.6;margin:0 0 12px;">
              Dear <strong>{{ $certificate->user->name ?? 'Delegate' }}</strong>,
            </p>
            <p style="color:#444;font-size:15px;line-height:1.6;margin:0 0 24px;">
              We are delighted to inform you that your certificate of completion is now ready for the following programme:
            </p>
            <!-- Certificate details box -->
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f7fa;border-left:4px solid #1A4D5E;border-radius:4px;margin-bottom:24px;">
              <tr>
                <td style="padding:20px;">
                  <p style="margin:0 0 8px;color:#1A4D5E;font-size:17px;font-weight:bold;">{{ $certificate->course->title ?? 'Course' }}</p>
                  <p style="margin:0 0 8px;color:#666;font-size:14px;"><strong style="color:#1A4D5E;">Certificate Number:</strong> {{ $certificate->certificate_number }}</p>
                  <p style="margin:0 0 8px;color:#666;font-size:14px;"><strong style="color:#1A4D5E;">Issue Date:</strong> {{ $certificate->issued_at ? $certificate->issued_at->format('d F Y') : now()->format('d F Y') }}</p>
                  <p style="margin:0;color:#666;font-size:14px;"><strong style="color:#1A4D5E;">Verification Code:</strong> {{ $certificate->verification_code }}</p>
                </td>
              </tr>
            </table>
            <p style="color:#444;font-size:14px;line-height:1.6;margin:0 0 16px;">
              You can download your certificate and verify its authenticity using the link below:
            </p>
            <table cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
              <tr>
                <td style="background:#E07B2A;border-radius:4px;padding:12px 28px;">
                  <a href="{{ config('app.url') }}/api/v1/certificates/{{ $certificate->id }}/download" style="color:#ffffff;text-decoration:none;font-size:14px;font-weight:bold;">Download Certificate</a>
                </td>
              </tr>
            </table>
            <p style="color:#666;font-size:13px;line-height:1.6;margin:0;">
              You can also verify this certificate at: <a href="{{ config('app.url') }}/api/v1/certificates/verify/{{ $certificate->verification_code }}" style="color:#E07B2A;">{{ config('app.url') }}/api/v1/certificates/verify/{{ $certificate->verification_code }}</a>
            </p>
          </td>
        </tr>
        <!-- Footer -->
        <tr>
          <td style="background:#1A4D5E;padding:20px 40px;text-align:center;">
            <p style="color:#aaa;font-size:12px;margin:0;">IFS Nigeria | &copy; {{ date('Y') }} All rights reserved.</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
