<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Confirmed</title>
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
            <h2 style="color:#1A4D5E;font-size:20px;margin:0 0 16px;">Payment Confirmed</h2>
            <p style="color:#444;font-size:15px;line-height:1.6;margin:0 0 12px;">
              Dear <strong>{{ $payment->user->name ?? 'Delegate' }}</strong>,
            </p>
            <p style="color:#444;font-size:15px;line-height:1.6;margin:0 0 24px;">
              Thank you! We have received your payment. Here are your payment details:
            </p>
            <!-- Payment details box -->
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0f7fa;border-left:4px solid #E07B2A;border-radius:4px;margin-bottom:24px;">
              <tr>
                <td style="padding:20px;">
                  <p style="margin:0 0 8px;color:#666;font-size:14px;"><strong style="color:#1A4D5E;">Invoice Number:</strong> {{ $payment->invoice_number }}</p>
                  <p style="margin:0 0 8px;color:#666;font-size:14px;"><strong style="color:#1A4D5E;">Course:</strong> {{ $payment->enrolment->course->title ?? 'N/A' }}</p>
                  <p style="margin:0 0 8px;color:#666;font-size:14px;"><strong style="color:#1A4D5E;">Amount Paid:</strong> ₦{{ number_format($payment->amount, 2) }}</p>
                  @if($payment->vat_amount)
                  <p style="margin:0 0 8px;color:#666;font-size:14px;"><strong style="color:#1A4D5E;">VAT (7.5%):</strong> ₦{{ number_format($payment->vat_amount, 2) }}</p>
                  @endif
                  <p style="margin:0 0 8px;color:#666;font-size:14px;"><strong style="color:#1A4D5E;">Payment Reference:</strong> {{ $payment->reference }}</p>
                  <p style="margin:0;color:#666;font-size:14px;"><strong style="color:#1A4D5E;">Date:</strong> {{ $payment->paid_at ? $payment->paid_at->format('d F Y, H:i') : now()->format('d F Y, H:i') }}</p>
                </td>
              </tr>
            </table>
            <p style="color:#444;font-size:14px;line-height:1.6;margin:0 0 12px;">
              Your enrolment is now confirmed. You will receive further details about your programme shortly.
            </p>
            <p style="color:#444;font-size:14px;line-height:1.6;margin:0;">
              For queries, contact <a href="mailto:training@ifsnigeria.com" style="color:#E07B2A;">training@ifsnigeria.com</a>.
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
