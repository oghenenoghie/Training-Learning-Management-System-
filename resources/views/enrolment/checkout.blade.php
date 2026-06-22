<x-app-layout>
    <x-slot name="title">Checkout — {{ $course->title }}</x-slot>

    <div style="max-width:900px;margin:0 auto;padding:2rem 1.5rem;display:grid;grid-template-columns:1fr 340px;gap:2rem;">
        <div>
            <h1 style="font-size:1.75rem;font-weight:800;color:#0F1F2B;margin:0 0 0.25rem;font-family:Georgia,serif;">Complete Enrolment</h1>
            <p style="color:#6B7C8D;margin:0 0 1.5rem;">{{ $course->title }}</p>

            @if($errors->any())
                <x-alert type="error" message="{{ $errors->first() }}" />
            @endif

            <form method="POST" action="/enrolment/initiate">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">

                {{-- Schedule Selection --}}
                @if($schedules->count())
                    <div class="card" style="padding:1.5rem;margin-bottom:1.25rem;">
                        <h3 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 1rem;font-family:Georgia,serif;">Select Schedule</h3>
                        @foreach($schedules as $schedule)
                            <label style="display:flex;align-items:center;gap:0.75rem;padding:0.875rem;border:2px solid #DDE3EA;border-radius:0.5rem;cursor:pointer;margin-bottom:0.5rem;transition:border-color 0.15s;" onmouseover="this.style.borderColor='#1A4D5E'" onmouseout="this.style.borderColor='#DDE3EA'">
                                <input type="radio" name="schedule_id" value="{{ $schedule->id }}" {{ request('schedule') == $schedule->id ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#1A4D5E;">
                                <div>
                                    <p style="font-weight:600;color:#0F1F2B;margin:0;font-size:0.9rem;">{{ $schedule->start_date->format('d M Y') }} — {{ $schedule->end_date->format('d M Y') }}</p>
                                    <p style="color:#6B7C8D;margin:0.15rem 0 0;font-size:0.8rem;">{{ $schedule->venue ?? ucfirst($schedule->mode) }}</p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @endif

                {{-- Payment Method --}}
                <div class="card" style="padding:1.5rem;margin-bottom:1.25rem;">
                    <h3 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 1rem;font-family:Georgia,serif;">Payment Method</h3>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <label x-data style="display:flex;align-items:center;gap:0.75rem;padding:1rem;border:2px solid #DDE3EA;border-radius:0.5rem;cursor:pointer;" onmouseover="this.style.borderColor='#00C3F7'" onmouseout="this.style.borderColor='#DDE3EA'">
                            <input type="radio" name="gateway" value="paystack" checked style="width:18px;height:18px;accent-color:#00C3F7;">
                            <div>
                                <p style="font-weight:700;color:#0F1F2B;margin:0;font-size:0.9rem;">Paystack</p>
                                <p style="color:#6B7C8D;margin:0;font-size:0.75rem;">Cards, Bank Transfer</p>
                            </div>
                        </label>
                        <label style="display:flex;align-items:center;gap:0.75rem;padding:1rem;border:2px solid #DDE3EA;border-radius:0.5rem;cursor:pointer;" onmouseover="this.style.borderColor='#FF5733'" onmouseout="this.style.borderColor='#DDE3EA'">
                            <input type="radio" name="gateway" value="flutterwave" style="width:18px;height:18px;accent-color:#FF5733;">
                            <div>
                                <p style="font-weight:700;color:#0F1F2B;margin:0;font-size:0.9rem;">Flutterwave</p>
                                <p style="color:#6B7C8D;margin:0;font-size:0.75rem;">Cards, USSD, Bank</p>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="width:100%;text-align:center;padding:1rem;font-size:1rem;">
                    Proceed to Payment →
                </button>
            </form>
        </div>

        {{-- Order Summary --}}
        <div style="position:sticky;top:80px;align-self:start;">
            <div class="card" style="padding:1.5rem;">
                <h3 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 1rem;font-family:Georgia,serif;">Order Summary</h3>
                <div style="border:1px solid #DDE3EA;border-radius:0.5rem;padding:1rem;margin-bottom:1rem;background:#F5F7F9;">
                    <p style="font-weight:700;color:#0F1F2B;margin:0 0 0.25rem;font-size:0.9rem;">{{ $course->title }}</p>
                    <p style="color:#6B7C8D;font-size:0.8rem;margin:0;">{{ $course->duration_days }} day(s) · {{ ucfirst($course->mode) }}</p>
                </div>
                @php
                    $subtotal = $course->price ?? 0;
                    $vat = $subtotal * 0.075;
                    $total = $subtotal + $vat;
                @endphp
                <div style="display:flex;flex-direction:column;gap:0.5rem;margin-bottom:1rem;">
                    <div style="display:flex;justify-content:space-between;font-size:0.875rem;"><span style="color:#6B7C8D;">Subtotal</span><span style="color:#0F1F2B;">₦{{ number_format($subtotal) }}</span></div>
                    <div style="display:flex;justify-content:space-between;font-size:0.875rem;"><span style="color:#6B7C8D;">VAT (7.5%)</span><span style="color:#0F1F2B;">₦{{ number_format($vat) }}</span></div>
                    <div style="display:flex;justify-content:space-between;font-size:1rem;font-weight:800;border-top:1px solid #DDE3EA;padding-top:0.5rem;"><span style="color:#0F1F2B;">Total</span><span style="color:#1A4D5E;font-family:Georgia,serif;">₦{{ number_format($total) }}</span></div>
                </div>
                <p style="font-size:0.75rem;color:#6B7C8D;text-align:center;">🔒 Secure payment. Enrolment confirmed upon payment.</p>
            </div>
        </div>
    </div>
</x-app-layout>
