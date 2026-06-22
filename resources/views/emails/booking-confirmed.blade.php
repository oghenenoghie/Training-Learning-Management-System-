<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booking Confirmed | IFS Nigeria</title>
</head>
<body style="margin:0;padding:0;background:#F3F4F6;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#F3F4F6;padding:32px 16px;">
  <tr>
    <td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:white;border-radius:8px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);">

        {{-- Header --}}
        <tr>
          <td style="background:linear-gradient(135deg,#0F2E3A,#1A4D5E);padding:32px 40px;text-align:center;">
            <h1 style="color:white;font-size:24px;font-weight:800;margin:0 0 4px;font-family:Georgia,serif;">IFS Nigeria</h1>
            <p style="color:rgba(255,255,255,0.6);font-size:11px;margin:0;text-transform:uppercase;letter-spacing:0.1em;">Institute for Skills & Professional Development</p>
          </td>
        </tr>

        {{-- Green Banner --}}
        <tr>
          <td style="background:#10B981;padding:16px 40px;text-align:center;">
            <h2 style="color:white;font-size:18px;font-weight:700;margin:0;">Booking Confirmed!</h2>
          </td>
        </tr>

        {{-- Body --}}
        <tr>
          <td style="padding:32px 40px;">

            <p style="font-size:14px;color:#374151;margin:0 0 20px;">Dear <strong>{{ $enrolment->contact_person }}</strong>,</p>
            <p style="font-size:14px;color:#374151;margin:0 0 24px;line-height:1.6;">
              Your booking for <strong>{{ $enrolment->course->title }}</strong> has been received and confirmed. Please find the details below.
            </p>

            {{-- Reference Box --}}
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
              <tr>
                <td style="background:#F0F7FA;border:2px dashed #1A4D5E;border-radius:6px;padding:16px 20px;text-align:center;">
                  <p style="font-size:11px;font-weight:700;color:#6B7C8D;margin:0 0 6px;text-transform:uppercase;letter-spacing:0.08em;">Booking Reference</p>
                  <p style="font-family:Courier New,monospace;font-size:22px;font-weight:800;color:#1A4D5E;margin:0;letter-spacing:0.1em;">{{ $enrolment->booking_reference }}</p>
                </td>
              </tr>
            </table>

            {{-- Course Details --}}
            <h3 style="font-size:13px;font-weight:700;color:#1A4D5E;text-transform:uppercase;letter-spacing:0.06em;margin:0 0 10px;border-bottom:2px solid #1A4D5E;padding-bottom:6px;">Course Details</h3>
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;font-size:13px;">
              <tr>
                <td style="color:#6B7C8D;padding:6px 0;width:40%;vertical-align:top;">Course</td>
                <td style="color:#0F1F2B;font-weight:600;padding:6px 0;">{{ $enrolment->course->title }}</td>
              </tr>
              @if($enrolment->schedule)
              <tr>
                <td style="color:#6B7C8D;padding:6px 0;border-top:1px solid #F3F4F6;">Dates</td>
                <td style="color:#0F1F2B;font-weight:600;padding:6px 0;border-top:1px solid #F3F4F6;">{{ $enrolment->schedule->start_date->format('d M Y') }} – {{ $enrolment->schedule->end_date->format('d M Y') }}</td>
              </tr>
              @if($enrolment->schedule->venue)
              <tr>
                <td style="color:#6B7C8D;padding:6px 0;border-top:1px solid #F3F4F6;">Venue</td>
                <td style="color:#0F1F2B;font-weight:600;padding:6px 0;border-top:1px solid #F3F4F6;">{{ $enrolment->schedule->venue }}</td>
              </tr>
              @endif
              @endif
              <tr>
                <td style="color:#6B7C8D;padding:6px 0;border-top:1px solid #F3F4F6;">Delegates</td>
                <td style="color:#0F1F2B;font-weight:600;padding:6px 0;border-top:1px solid #F3F4F6;">{{ $enrolment->number_of_delegates }}</td>
              </tr>
              @if($enrolment->company_name)
              <tr>
                <td style="color:#6B7C8D;padding:6px 0;border-top:1px solid #F3F4F6;">Company</td>
                <td style="color:#0F1F2B;font-weight:600;padding:6px 0;border-top:1px solid #F3F4F6;">{{ $enrolment->company_name }}</td>
              </tr>
              @endif
              <tr>
                <td style="color:#6B7C8D;padding:6px 0;border-top:1px solid #F3F4F6;">Payment</td>
                <td style="padding:6px 0;border-top:1px solid #F3F4F6;">
                  @if($payment->status === 'paid')
                    <span style="background:#D1FAE5;color:#065F46;font-size:11px;font-weight:700;padding:3px 8px;border-radius:999px;">Paid ✓</span>
                  @elseif($enrolment->payment_method === 'invoice')
                    <span style="background:#FFFBEB;color:#92400E;font-size:11px;font-weight:700;padding:3px 8px;border-radius:999px;">Invoice Pending</span>
                  @else
                    <span style="background:#EFF6FF;color:#1E40AF;font-size:11px;font-weight:700;padding:3px 8px;border-radius:999px;">Awaiting Payment</span>
                  @endif
                </td>
              </tr>
              <tr>
                <td style="color:#6B7C8D;padding:6px 0;border-top:1px solid #F3F4F6;font-weight:700;">Total Amount</td>
                <td style="color:#1A4D5E;font-weight:800;font-size:15px;padding:6px 0;border-top:1px solid #F3F4F6;">₦{{ number_format($enrolment->total_amount, 0) }}</td>
              </tr>
            </table>

            @if($enrolment->payment_method === 'invoice')
            {{-- Bank details for invoice --}}
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
              <tr>
                <td style="background:#FFFBEB;border-left:4px solid #E07B2A;border-radius:4px;padding:14px 16px;">
                  <p style="font-size:12px;font-weight:700;color:#E07B2A;margin:0 0 8px;text-transform:uppercase;">Payment Instructions</p>
                  <p style="font-size:12px;color:#78350F;margin:0;line-height:1.8;">
                    <strong>Bank:</strong> First Bank of Nigeria<br>
                    <strong>Account Name:</strong> IFS Nigeria Ltd<br>
                    <strong>Account Number:</strong> 0000000000<br>
                    <strong>Reference:</strong> {{ $enrolment->booking_reference }}<br>
                    <strong>Due Date:</strong> {{ now()->addDays(14)->format('d M Y') }}
                  </p>
                </td>
              </tr>
            </table>
            @endif

            <p style="font-size:13px;color:#374151;margin:0 0 8px;line-height:1.6;">
              If you have any questions, please contact us at <a href="mailto:info@ifsnigeria.com" style="color:#1A4D5E;font-weight:600;">info@ifsnigeria.com</a> or call <strong>+234 800 IFS TRAIN</strong>, quoting your booking reference.
            </p>
            <p style="font-size:13px;color:#374151;margin:0;">We look forward to welcoming you!</p>

          </td>
        </tr>

        {{-- Footer --}}
        <tr>
          <td style="background:#F5F7F9;border-top:1px solid #DDE3EA;padding:20px 40px;text-align:center;">
            <p style="font-size:11px;color:#9CA3AF;margin:0;line-height:1.6;">
              IFS Nigeria — Institute for Skills &amp; Professional Development<br>
              Lagos, Nigeria &nbsp;·&nbsp; <a href="mailto:info@ifsnigeria.com" style="color:#1A4D5E;">info@ifsnigeria.com</a><br>
              This is an automated email. Please do not reply directly to this message.
            </p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>
