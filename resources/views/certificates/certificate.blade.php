<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Certificate of Completion</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        width: 297mm;
        height: 210mm;
        font-family: Georgia, 'Times New Roman', serif;
        background: #ffffff;
        color: #1A4D5E;
    }
    .page {
        width: 297mm;
        height: 210mm;
        position: relative;
        overflow: hidden;
        background: #ffffff;
    }
    /* Border frame */
    .outer-border {
        position: absolute;
        top: 8mm;
        left: 8mm;
        right: 8mm;
        bottom: 8mm;
        border: 4px solid #1A4D5E;
    }
    .inner-border {
        position: absolute;
        top: 10mm;
        left: 10mm;
        right: 10mm;
        bottom: 10mm;
        border: 1.5px solid #E07B2A;
    }
    /* Header band */
    .header-band {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 38mm;
        background-color: #1A4D5E;
        display: block;
    }
    .header-content {
        position: absolute;
        top: 5mm;
        left: 0;
        right: 0;
        text-align: center;
    }
    .org-name {
        font-size: 22pt;
        font-weight: bold;
        color: #ffffff;
        letter-spacing: 3px;
        text-transform: uppercase;
    }
    .org-tagline {
        font-size: 9pt;
        color: #E07B2A;
        letter-spacing: 2px;
        margin-top: 2mm;
        text-transform: uppercase;
    }
    /* Decorative accent line */
    .accent-line {
        position: absolute;
        top: 38mm;
        left: 0;
        right: 0;
        height: 5px;
        background-color: #E07B2A;
    }
    /* Body content */
    .body-content {
        position: absolute;
        top: 44mm;
        left: 20mm;
        right: 20mm;
        text-align: center;
    }
    .cert-title {
        font-size: 11pt;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: #E07B2A;
        margin-bottom: 5mm;
    }
    .certify-text {
        font-size: 10pt;
        color: #555555;
        margin-bottom: 4mm;
    }
    .delegate-name {
        font-size: 28pt;
        color: #1A4D5E;
        font-style: italic;
        margin: 3mm 0;
        border-bottom: 1.5px solid #E07B2A;
        padding-bottom: 2mm;
        display: inline-block;
        min-width: 180mm;
    }
    .completion-text {
        font-size: 10pt;
        color: #555555;
        margin: 4mm 0 2mm;
    }
    .course-title {
        font-size: 16pt;
        font-weight: bold;
        color: #1A4D5E;
        margin: 2mm 0 4mm;
    }
    .duration-text {
        font-size: 9pt;
        color: #777777;
        margin-bottom: 5mm;
    }
    /* Footer section */
    .footer-section {
        position: absolute;
        bottom: 16mm;
        left: 16mm;
        right: 16mm;
    }
    .footer-columns {
        width: 100%;
    }
    .footer-left {
        display: inline-block;
        width: 30%;
        text-align: center;
        vertical-align: top;
    }
    .footer-center {
        display: inline-block;
        width: 36%;
        text-align: center;
        vertical-align: top;
    }
    .footer-right {
        display: inline-block;
        width: 30%;
        text-align: right;
        vertical-align: top;
    }
    .signature-line {
        border-top: 1.5px solid #1A4D5E;
        margin-bottom: 2mm;
        width: 100%;
    }
    .sig-label {
        font-size: 8pt;
        color: #777777;
    }
    .sig-name {
        font-size: 9pt;
        font-weight: bold;
        color: #1A4D5E;
        margin-bottom: 1mm;
    }
    .cert-meta {
        font-size: 7pt;
        color: #999999;
        margin-top: 1mm;
    }
    /* QR placeholder */
    .qr-placeholder {
        width: 22mm;
        height: 22mm;
        border: 1px solid #cccccc;
        display: inline-block;
        text-align: center;
        line-height: 22mm;
        font-size: 7pt;
        color: #aaaaaa;
        vertical-align: middle;
    }
    .verify-url {
        font-size: 7pt;
        color: #777777;
        margin-top: 1mm;
    }
    /* Bottom accent */
    .bottom-accent {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 5px;
        background-color: #1A4D5E;
    }
    .amber-bottom {
        position: absolute;
        bottom: 5px;
        left: 0;
        right: 0;
        height: 3px;
        background-color: #E07B2A;
    }
</style>
</head>
<body>
<div class="page">
    <div class="outer-border"></div>
    <div class="inner-border"></div>
    <div class="header-band"></div>
    <div class="header-content">
        <div class="org-name">IFS Nigeria</div>
        <div class="org-tagline">International Finance &amp; Strategy Training Institute</div>
    </div>
    <div class="accent-line"></div>

    <div class="body-content">
        <div class="cert-title">Certificate of Completion</div>
        <div class="certify-text">This is to certify that</div>
        <div class="delegate-name">{{ $certificate->user->name ?? 'Delegate Name' }}</div>
        <div class="completion-text">has successfully completed the professional training programme</div>
        <div class="course-title">{{ $certificate->course->title ?? 'Course Title' }}</div>
        @if($certificate->course && $certificate->course->duration_days)
        <div class="duration-text">Duration: {{ $certificate->course->duration_days }} Day{{ $certificate->course->duration_days > 1 ? 's' : '' }} | Level: {{ ucfirst($certificate->course->level ?? 'Intermediate') }}</div>
        @endif
    </div>

    <div class="footer-section">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="32%" align="center" valign="bottom">
                    <div class="signature-line"></div>
                    <div class="sig-name">Director of Training</div>
                    <div class="sig-label">IFS Nigeria</div>
                </td>
                <td width="36%" align="center" valign="top">
                    <div class="qr-placeholder">QR</div>
                    <div class="cert-meta">Certificate No: {{ $certificate->certificate_number }}</div>
                    <div class="cert-meta">Issued: {{ $certificate->issued_at ? $certificate->issued_at->format('d F Y') : now()->format('d F Y') }}</div>
                    <div class="verify-url">Verify at: {{ config('app.url') }}/verify/{{ $certificate->verification_code }}</div>
                </td>
                <td width="32%" align="center" valign="bottom">
                    <div class="signature-line"></div>
                    <div class="sig-name">Head of Certification</div>
                    <div class="sig-label">IFS Nigeria</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="bottom-accent"></div>
    <div class="amber-bottom"></div>
</div>
</body>
</html>
