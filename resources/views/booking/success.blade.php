<x-app-layout>
    <x-slot name="title">Booking Confirmed — {{ $enrolment->booking_reference }} | IFS Nigeria</x-slot>

    <div style="max-width:720px;margin:0 auto;padding:3rem 1.5rem;">

        {{-- Success Card --}}
        <div style="background:white;border:1px solid #DDE3EA;border-radius:1rem;overflow:hidden;text-align:center;">

            {{-- Header --}}
            <div style="background:linear-gradient(135deg,#0F2E3A,#1A4D5E);padding:2.5rem 2rem;">
                <div style="width:72px;height:72px;background:#10B981;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:36px;height:36px;">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <h1 style="color:white;font-size:1.75rem;font-weight:800;margin:0 0 0.5rem;font-family:Georgia,serif;">Booking Confirmed!</h1>
                <p style="color:rgba(255,255,255,0.75);font-size:0.9rem;margin:0;">Thank you for booking with IFS Nigeria</p>
            </div>

            <div style="padding:2rem;">

                {{-- Reference --}}
                <div style="background:#F0F7FA;border:2px dashed #1A4D5E;border-radius:0.5rem;padding:1rem 1.5rem;margin-bottom:1.5rem;display:inline-block;min-width:280px;">
                    <p style="font-size:0.75rem;font-weight:600;color:#6B7C8D;margin:0 0 0.25rem;text-transform:uppercase;letter-spacing:0.08em;">Booking Reference</p>
                    <p style="font-family:monospace;font-size:1.5rem;font-weight:800;color:#1A4D5E;margin:0;letter-spacing:0.1em;">{{ $enrolment->booking_reference }}</p>
                </div>

                {{-- Payment Status Badge --}}
                @if($enrolment->payment?->status === 'paid')
                    <div style="display:inline-flex;align-items:center;gap:0.4rem;background:#D1FAE5;border:1px solid #6EE7B7;border-radius:999px;padding:0.35rem 1rem;margin:0 0 1.5rem;font-size:0.8rem;font-weight:700;color:#065F46;">
                        <span style="width:8px;height:8px;background:#10B981;border-radius:50%;display:inline-block;"></span>
                        Payment Received
                    </div>
                @elseif($enrolment->payment_method === 'invoice')
                    <div style="display:inline-flex;align-items:center;gap:0.4rem;background:#FFFBEB;border:1px solid #FDE68A;border-radius:999px;padding:0.35rem 1rem;margin:0 0 1.5rem;font-size:0.8rem;font-weight:700;color:#92400E;">
                        <span style="width:8px;height:8px;background:#F59E0B;border-radius:50%;display:inline-block;"></span>
                        Invoice Pending
                    </div>
                @else
                    <div style="display:inline-flex;align-items:center;gap:0.4rem;background:#EFF6FF;border:1px solid #BFDBFE;border-radius:999px;padding:0.35rem 1rem;margin:0 0 1.5rem;font-size:0.8rem;font-weight:700;color:#1E40AF;">
                        <span style="width:8px;height:8px;background:#3B82F6;border-radius:50%;display:inline-block;"></span>
                        Awaiting Payment
                    </div>
                @endif

                {{-- Course Details --}}
                <div style="background:#F5F7F9;border-radius:0.5rem;padding:1.25rem;margin-bottom:1.5rem;text-align:left;">
                    <h3 style="font-size:0.85rem;font-weight:700;color:#0F1F2B;margin:0 0 0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Course Details</h3>
                    <table style="width:100%;border-collapse:collapse;font-size:0.85rem;">
                        <tr>
                            <td style="color:#6B7C8D;padding:0.35rem 0;width:40%;">Course</td>
                            <td style="color:#0F1F2B;font-weight:600;">{{ $enrolment->course->title }}</td>
                        </tr>
                        @if($enrolment->schedule)
                        <tr>
                            <td style="color:#6B7C8D;padding:0.35rem 0;">Dates</td>
                            <td style="color:#0F1F2B;font-weight:600;">{{ $enrolment->schedule->start_date->format('d M Y') }} – {{ $enrolment->schedule->end_date->format('d M Y') }}</td>
                        </tr>
                        @if($enrolment->schedule->venue)
                        <tr>
                            <td style="color:#6B7C8D;padding:0.35rem 0;">Venue</td>
                            <td style="color:#0F1F2B;font-weight:600;">{{ $enrolment->schedule->venue }}</td>
                        </tr>
                        @endif
                        @endif
                        <tr>
                            <td style="color:#6B7C8D;padding:0.35rem 0;">Delegates</td>
                            <td style="color:#0F1F2B;font-weight:600;">{{ $enrolment->number_of_delegates }}</td>
                        </tr>
                        <tr>
                            <td style="color:#6B7C8D;padding:0.35rem 0;">Contact</td>
                            <td style="color:#0F1F2B;font-weight:600;">{{ $enrolment->contact_person }} &lt;{{ $enrolment->contact_email }}&gt;</td>
                        </tr>
                        @if($enrolment->company_name)
                        <tr>
                            <td style="color:#6B7C8D;padding:0.35rem 0;">Company</td>
                            <td style="color:#0F1F2B;font-weight:600;">{{ $enrolment->company_name }}</td>
                        </tr>
                        @endif
                        <tr style="border-top:1px solid #DDE3EA;">
                            <td style="color:#6B7C8D;padding:0.5rem 0 0.35rem;">Subtotal</td>
                            <td style="color:#0F1F2B;font-weight:600;">₦{{ number_format($enrolment->subtotal, 0) }}</td>
                        </tr>
                        <tr>
                            <td style="color:#6B7C8D;padding:0.35rem 0;">VAT (7.5%)</td>
                            <td style="color:#0F1F2B;font-weight:600;">₦{{ number_format($enrolment->vat_amount, 0) }}</td>
                        </tr>
                        <tr>
                            <td style="color:#6B7C8D;padding:0.35rem 0;font-weight:700;">Total</td>
                            <td style="color:#1A4D5E;font-weight:800;font-size:1rem;">₦{{ number_format($enrolment->total_amount, 0) }}</td>
                        </tr>
                    </table>
                </div>

                {{-- Delegate List --}}
                @if(!empty($enrolment->delegate_names) && count($enrolment->delegate_names) > 0)
                <div style="background:#F5F7F9;border-radius:0.5rem;padding:1.25rem;margin-bottom:1.5rem;text-align:left;">
                    <h3 style="font-size:0.85rem;font-weight:700;color:#0F1F2B;margin:0 0 0.75rem;text-transform:uppercase;letter-spacing:0.05em;">Registered Delegates</h3>
                    @foreach($enrolment->delegate_names as $i => $d)
                        <div style="display:flex;justify-content:space-between;font-size:0.8rem;padding:0.35rem 0;{{ !$loop->last ? 'border-bottom:1px solid #DDE3EA;' : '' }}">
                            <span style="color:#0F1F2B;font-weight:600;">{{ $i+1 }}. {{ $d['name'] ?? '—' }}</span>
                            <span style="color:#6B7C8D;">{{ $d['email'] ?? '' }}</span>
                        </div>
                    @endforeach
                </div>
                @endif

                {{-- Email note --}}
                <div style="background:#EFF6FF;border:1px solid #BFDBFE;border-radius:0.4rem;padding:0.75rem 1rem;margin-bottom:1.5rem;font-size:0.8rem;color:#1E40AF;text-align:left;">
                    📧 A confirmation email has been sent to <strong>{{ $enrolment->contact_email }}</strong>. Please check your inbox (and spam folder).
                </div>

                {{-- Invoice payment details --}}
                @if($enrolment->payment_method === 'invoice')
                <div style="background:#FFFBEB;border:1px solid #FDE68A;border-radius:0.5rem;padding:1.25rem;margin-bottom:1.5rem;text-align:left;">
                    <h3 style="font-size:0.85rem;font-weight:700;color:#92400E;margin:0 0 0.75rem;">Bank Transfer Details</h3>
                    <div style="font-size:0.8rem;color:#78350F;line-height:2;">
                        <p style="margin:0;"><strong>Bank:</strong> First Bank of Nigeria</p>
                        <p style="margin:0;"><strong>Account Name:</strong> IFS Nigeria Ltd</p>
                        <p style="margin:0;"><strong>Account Number:</strong> 0000000000</p>
                        <p style="margin:0;"><strong>Sort Code:</strong> 011</p>
                        <p style="margin:0.5rem 0 0;font-weight:700;">Reference: {{ $enrolment->booking_reference }}</p>
                    </div>
                </div>
                @endif

                {{-- Actions --}}
                <div style="display:flex;gap:0.75rem;justify-content:center;flex-wrap:wrap;">
                    @if($enrolment->payment_method === 'invoice')
                        <a href="{{ route('booking.invoice', $enrolment->booking_reference) }}"
                            style="background:#1A4D5E;color:white;font-weight:700;padding:0.75rem 1.5rem;border-radius:0.5rem;text-decoration:none;font-size:0.875rem;display:inline-flex;align-items:center;gap:0.4rem;">
                            🧾 Download Invoice (PDF)
                        </a>
                    @endif
                    @if($enrolment->payment?->status === 'paid')
                        <a href="{{ route('booking.invoice', $enrolment->booking_reference) }}"
                            style="background:#F5F7F9;color:#1A4D5E;font-weight:700;padding:0.75rem 1.5rem;border-radius:0.5rem;text-decoration:none;font-size:0.875rem;border:1px solid #DDE3EA;display:inline-flex;align-items:center;gap:0.4rem;">
                            🧾 Download Receipt
                        </a>
                    @endif
                    <a href="/courses"
                        style="background:#F5F7F9;color:#6B7C8D;font-weight:600;padding:0.75rem 1.5rem;border-radius:0.5rem;text-decoration:none;font-size:0.875rem;border:1px solid #DDE3EA;">
                        Browse More Courses
                    </a>
                </div>

            </div>{{-- /padding --}}
        </div>{{-- /card --}}

    </div>
</x-app-layout>
