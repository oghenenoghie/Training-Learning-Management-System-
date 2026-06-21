<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Enrolment Confirmed</title>
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
        <!-- Accent bar -->
        <tr><td style="background:#E07B2A;height:4px;"></td></tr>
        <!-- Body -->
        <tr>
          <td style="padding:40px;">
            <h2 style="color:#1A4D5E;font-size:20px;margin:0 0 16px;">Enrolment Confirmed!</h2>
            <p style="color:#444;font-size:15px;line-height:1.6;margin:0 0 12px;">
              Dear <strong>{{ $enrolment->user->name ?? 'Delegate' }}</strong>,
            </p>
            <p style="color:#444;font-size:15px;line-height:1.6;margin:0 0 24px;">
              We are pleased to confirm your enrolment in the following programme:
            </p>
            <!-- Course box -->
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f7fa;border-left:4px solid #1A4D5E;border-radius:4px;margin-bottom:24px;">
              <tr>
                <td style="padding:20px;">
                  <p style="margin:0 0 8px;color:#1A4D5E;font-size:17px;font-weight:bold;">{{ $enrolment->course->title ?? 'Course' }}</p>
                  @if($enrolment->schedule)
                  <p style="margin:0 0 4px;color:#666;font-size:14px;">
                    <strong>Start Date:</strong> {{ $enrolment->schedule->start_date ? \Carbon\Carbon::parse($enrolment->schedule->start_date)->format('d F Y') : 'TBC' }}
                  </p>
                  <p style="margin:0 0 4px;color:#666;font-size:14px;">
                    <strong>Mode:</strong> {{ ucfirst($enrolment->schedule->mode ?? 'TBC') }}
                  </p>
                  @if($enrolment->schedule->venue)
                  <p style="margin:0;color:#666;font-size:14px;">
                    <strong>Venue:</strong> {{ $enrolment->schedule->venue }}
                  </p>
                  @endif
                  @endif
                </td>
              </tr>
            </table>
            <p style="color:#444;font-size:14px;line-height:1.6;margin:0 0 12px;">
              Please ensure payment is completed to secure your seat. Our team will be in touch with further details.
            </p>
            <p style="color:#444;font-size:14px;line-height:1.6;margin:0;">
              If you have any questions, please contact us at <a href="mailto:training@ifsnigeria.com" style="color:#E07B2A;">training@ifsnigeria.com</a>.
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
