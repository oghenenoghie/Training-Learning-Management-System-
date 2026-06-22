<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tax Invoice – {{ $enrolment->booking_reference }}</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #1a1a1a; background: white; }
  .page { padding: 40px 48px; max-width: 794px; margin: 0 auto; }
  .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; padding-bottom: 20px; border-bottom: 3px solid #1A4D5E; }
  .logo-box { }
  .company-name { font-size: 22px; font-weight: 800; color: #1A4D5E; letter-spacing: -0.5px; }
  .company-tagline { font-size: 10px; color: #6B7C8D; margin-top: 2px; text-transform: uppercase; letter-spacing: 0.08em; }
  .invoice-label { text-align: right; }
  .invoice-title { font-size: 28px; font-weight: 800; color: #E07B2A; letter-spacing: 1px; }
  .invoice-meta { font-size: 11px; color: #6B7C8D; margin-top: 4px; line-height: 1.8; }
  .invoice-meta strong { color: #1a1a1a; }
  .two-col { display: flex; gap: 32px; margin-bottom: 28px; }
  .two-col > div { flex: 1; }
  .section-label { font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; color: #6B7C8D; margin-bottom: 6px; }
  .address-block { font-size: 12px; line-height: 1.7; color: #1a1a1a; }
  .address-block strong { font-weight: 700; color: #1A4D5E; }
  table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
  table thead tr { background: #1A4D5E; color: white; }
  table thead th { padding: 10px 12px; text-align: left; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
  table thead th:last-child { text-align: right; }
  table tbody tr { border-bottom: 1px solid #DDE3EA; }
  table tbody tr:nth-child(even) { background: #F8FAFC; }
  table tbody td { padding: 10px 12px; font-size: 12px; color: #1a1a1a; }
  table tbody td:last-child { text-align: right; font-weight: 600; }
  .totals { margin-left: auto; width: 280px; border: 1px solid #DDE3EA; border-radius: 4px; overflow: hidden; margin-bottom: 28px; }
  .totals-row { display: flex; justify-content: space-between; padding: 8px 12px; border-bottom: 1px solid #DDE3EA; font-size: 12px; }
  .totals-row:last-child { border-bottom: none; background: #1A4D5E; color: white; font-weight: 700; font-size: 14px; }
  .totals-label { color: #6B7C8D; }
  .totals-row:last-child .totals-label { color: rgba(255,255,255,0.8); }
  .totals-value { font-weight: 600; color: #1a1a1a; }
  .bank-box { background: #F5F7F9; border: 1px solid #DDE3EA; border-left: 4px solid #E07B2A; border-radius: 4px; padding: 14px 16px; margin-bottom: 20px; }
  .bank-title { font-size: 11px; font-weight: 700; color: #E07B2A; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 8px; }
  .bank-details { font-size: 11px; line-height: 2; color: #1a1a1a; }
  .footer { border-top: 2px solid #1A4D5E; padding-top: 16px; display: flex; justify-content: space-between; align-items: center; }
  .footer-left { font-size: 10px; color: #6B7C8D; line-height: 1.6; }
  .footer-right { font-size: 11px; color: #1A4D5E; font-weight: 700; text-align: right; }
  .terms-box { background: #FFFBEB; border: 1px solid #FDE68A; border-radius: 4px; padding: 10px 14px; margin-bottom: 20px; font-size: 11px; color: #92400E; line-height: 1.6; }
</style>
</head>
<body>
<div class="page">

  {{-- Header --}}
  <div class="header">
    <div class="logo-box">
      <div class="company-name">IFS Nigeria</div>
      <div class="company-tagline">Institute For Skills & Professional Development</div>
      <div style="margin-top:6px;font-size:11px;color:#6B7C8D;line-height:1.6;">
        Lagos, Nigeria<br>
        info@ifsnigeria.com · +234 800 IFS TRAIN
      </div>
    </div>
    <div class="invoice-label">
      <div class="invoice-title">TAX INVOICE</div>
      <div class="invoice-meta">
        <strong>Invoice No:</strong> {{ $enrolment->payment?->invoice_number ?? 'INV-' . str_pad($enrolment->id, 6, '0', STR_PAD_LEFT) }}<br>
        <strong>Booking Ref:</strong> {{ $enrolment->booking_reference }}<br>
        <strong>Date:</strong> {{ now()->format('d M Y') }}<br>
        <strong>Due Date:</strong> {{ now()->addDays(14)->format('d M Y') }}
      </div>
    </div>
  </div>

  {{-- Bill To --}}
  <div class="two-col">
    <div>
      <div class="section-label">Bill To</div>
      <div class="address-block">
        <strong>{{ $enrolment->company_name ?? $enrolment->contact_person }}</strong><br>
        {{ $enrolment->contact_person }}<br>
        {{ $enrolment->contact_email }}<br>
        {{ $enrolment->contact_phone }}<br>
        @if($enrolment->company_address){{ $enrolment->company_address }}@endif
        @if($enrolment->po_number)<br>PO: {{ $enrolment->po_number }}@endif
      </div>
    </div>
    <div>
      <div class="section-label">Training Details</div>
      <div class="address-block">
        @if($enrolment->schedule)
          <strong>Start:</strong> {{ $enrolment->schedule->start_date->format('d M Y') }}<br>
          <strong>End:</strong> {{ $enrolment->schedule->end_date->format('d M Y') }}<br>
          @if($enrolment->schedule->venue)
          <strong>Venue:</strong> {{ $enrolment->schedule->venue }}<br>
          @endif
          <strong>Mode:</strong> {{ ucfirst($enrolment->schedule->mode ?? 'Virtual') }}<br>
        @endif
        <strong>Status:</strong> {{ ucfirst($enrolment->status) }}
      </div>
    </div>
  </div>

  {{-- Items Table --}}
  <table>
    <thead>
      <tr>
        <th style="width:50%;">Description</th>
        <th style="text-align:center;width:12%;">Qty</th>
        <th style="text-align:right;width:19%;">Unit Price</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <strong>{{ $enrolment->course->title }}</strong><br>
          <span style="font-size:11px;color:#6B7C8D;">Professional Training Programme</span>
        </td>
        <td style="text-align:center;">{{ $enrolment->number_of_delegates }}</td>
        <td style="text-align:right;">₦{{ number_format($enrolment->course->price ?? 0, 2) }}</td>
        <td>₦{{ number_format($enrolment->subtotal, 2) }}</td>
      </tr>
    </tbody>
  </table>

  {{-- Totals --}}
  <div style="display:flex;justify-content:flex-end;margin-bottom:28px;">
    <div class="totals">
      <div class="totals-row">
        <span class="totals-label">Subtotal</span>
        <span class="totals-value">₦{{ number_format($enrolment->subtotal, 2) }}</span>
      </div>
      <div class="totals-row">
        <span class="totals-label">VAT (7.5%)</span>
        <span class="totals-value">₦{{ number_format($enrolment->vat_amount, 2) }}</span>
      </div>
      <div class="totals-row">
        <span class="totals-label">TOTAL DUE</span>
        <span style="color:white;">₦{{ number_format($enrolment->total_amount, 2) }}</span>
      </div>
    </div>
  </div>

  {{-- Payment Terms --}}
  <div class="terms-box">
    <strong>Payment Terms:</strong> Payment is due within 14 business days of the invoice date.
    Please reference <strong>{{ $enrolment->booking_reference }}</strong> in your bank transfer.
  </div>

  {{-- Bank Details --}}
  <div class="bank-box">
    <div class="bank-title">Bank Transfer Details</div>
    <div class="bank-details">
      <strong>Bank:</strong> First Bank of Nigeria &nbsp;&nbsp;
      <strong>Account Name:</strong> IFS Nigeria Ltd &nbsp;&nbsp;
      <strong>Account Number:</strong> 0000000000<br>
      <strong>Sort Code:</strong> 011 &nbsp;&nbsp;
      <strong>Reference:</strong> {{ $enrolment->booking_reference }}
    </div>
  </div>

  {{-- Footer --}}
  <div class="footer">
    <div class="footer-left">
      IFS Nigeria — Institute For Skills &amp; Professional Development<br>
      RC Number: 0000000 · Tax ID: 00000000-0001<br>
      This invoice was computer-generated and is valid without a signature.
    </div>
    <div class="footer-right">
      Thank you for choosing<br>IFS Nigeria!
    </div>
  </div>

</div>
</body>
</html>
