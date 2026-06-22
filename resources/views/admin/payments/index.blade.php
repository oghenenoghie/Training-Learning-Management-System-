<x-admin-layout>
    <x-slot name="title">Payments</x-slot>

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
        <h2 style="font-size:1.25rem;font-weight:700;color:#0F1F2B;margin:0;font-family:Georgia,serif;">Payments ({{ $payments->total() }})</h2>
    </div>

    <div class="card" style="overflow:hidden;">
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:0.875rem;">
                <thead>
                    <tr style="background:#F5F7F9;">
                        @foreach(['Invoice','Delegate','Course','Amount','Gateway','Status','Date','Action'] as $h)
                            <th style="padding:0.75rem 1rem;text-align:left;font-weight:700;color:#6B7C8D;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.05em;border-bottom:1px solid #DDE3EA;white-space:nowrap;">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                        <tr style="border-bottom:1px solid #F5F7F9;" onmouseover="this.style.background='#FAFBFC'" onmouseout="this.style.background=''">
                            <td style="padding:0.75rem 1rem;font-weight:600;color:#0F1F2B;font-size:0.8rem;">{{ $p->invoice_number ?? '—' }}</td>
                            <td style="padding:0.75rem 1rem;color:#0F1F2B;font-size:0.8rem;">{{ $p->user?->name ?? '—' }}</td>
                            <td style="padding:0.75rem 1rem;color:#6B7C8D;font-size:0.8rem;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $p->enrolment?->course?->title ?? '—' }}</td>
                            <td style="padding:0.75rem 1rem;font-weight:700;color:#1A4D5E;">₦{{ number_format($p->amount) }}</td>
                            <td style="padding:0.75rem 1rem;">
                                @if($p->gateway)
                                    <span style="background:{{ $p->gateway === 'paystack' ? '#00C3F7' : '#FF5733' }}20;color:{{ $p->gateway === 'paystack' ? '#007A99' : '#c0392b' }};font-size:0.7rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:4px;text-transform:uppercase;">{{ $p->gateway }}</span>
                                @else
                                    <span style="color:#6B7C8D;font-size:0.8rem;">—</span>
                                @endif
                            </td>
                            <td style="padding:0.75rem 1rem;"><x-status-badge :status="$p->status" /></td>
                            <td style="padding:0.75rem 1rem;color:#6B7C8D;font-size:0.8rem;white-space:nowrap;">{{ $p->paid_at?->format('d M Y') ?? ($p->created_at?->format('d M Y') ?? '—') }}</td>
                            <td style="padding:0.75rem 1rem;"><a href="#" style="font-size:0.75rem;color:#1A4D5E;font-weight:600;text-decoration:none;">Invoice</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="8" style="padding:2rem;text-align:center;color:#6B7C8D;">No payments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())
            <div style="padding:1rem;border-top:1px solid #DDE3EA;">{{ $payments->links() }}</div>
        @endif
    </div>
</x-admin-layout>
