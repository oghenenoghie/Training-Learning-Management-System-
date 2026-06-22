<x-dashboard-layout>
    <x-slot name="title">Payment History</x-slot>

    <div class="card" style="overflow:hidden;">
        @if($payments->isEmpty())
            <div style="padding:3rem;text-align:center;color:#6B7C8D;">
                <p style="font-size:2rem;margin:0 0 1rem;">💳</p>
                <p>No payments yet.</p>
                <a href="/courses" class="btn-primary" style="display:inline-block;margin-top:0.5rem;">Browse Courses</a>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:0.875rem;">
                    <thead>
                        <tr style="background:#F5F7F9;">
                            <th style="padding:0.875rem 1rem;text-align:left;font-weight:700;color:#6B7C8D;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;border-bottom:1px solid #DDE3EA;">Invoice</th>
                            <th style="padding:0.875rem 1rem;text-align:left;font-weight:700;color:#6B7C8D;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;border-bottom:1px solid #DDE3EA;">Course</th>
                            <th style="padding:0.875rem 1rem;text-align:right;font-weight:700;color:#6B7C8D;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;border-bottom:1px solid #DDE3EA;">Amount</th>
                            <th style="padding:0.875rem 1rem;text-align:left;font-weight:700;color:#6B7C8D;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;border-bottom:1px solid #DDE3EA;">Date</th>
                            <th style="padding:0.875rem 1rem;text-align:center;font-weight:700;color:#6B7C8D;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;border-bottom:1px solid #DDE3EA;">Status</th>
                            <th style="padding:0.875rem 1rem;text-align:center;font-weight:700;color:#6B7C8D;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.05em;border-bottom:1px solid #DDE3EA;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr style="border-bottom:1px solid #F5F7F9;" onmouseover="this.style.background='#FAFBFC'" onmouseout="this.style.background=''">
                                <td style="padding:0.875rem 1rem;color:#0F1F2B;font-weight:600;font-size:0.8rem;">{{ $payment->invoice_number ?? '—' }}</td>
                                <td style="padding:0.875rem 1rem;color:#0F1F2B;">{{ $payment->enrolment?->course?->title ?? '—' }}</td>
                                <td style="padding:0.875rem 1rem;text-align:right;font-weight:700;color:#1A4D5E;">₦{{ number_format($payment->amount) }}</td>
                                <td style="padding:0.875rem 1rem;color:#6B7C8D;">{{ $payment->paid_at ? $payment->paid_at->format('d M Y') : ($payment->created_at ? $payment->created_at->format('d M Y') : '—') }}</td>
                                <td style="padding:0.875rem 1rem;text-align:center;"><x-status-badge :status="$payment->status" /></td>
                                <td style="padding:0.875rem 1rem;text-align:center;"><a href="/api/v1/payments/{{ $payment->id }}/invoice" style="font-size:0.75rem;color:#1A4D5E;font-weight:600;text-decoration:none;">Invoice</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-dashboard-layout>
