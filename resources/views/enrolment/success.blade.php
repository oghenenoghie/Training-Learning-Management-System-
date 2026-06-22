<x-app-layout>
    <x-slot name="title">Enrolment Confirmed — IFS Nigeria</x-slot>
    <div style="max-width:600px;margin:4rem auto;padding:0 1.5rem;text-align:center;">
        <div class="card" style="padding:3rem;">
            <div style="width:72px;height:72px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;font-size:2rem;">✅</div>
            <h1 style="font-size:1.75rem;font-weight:800;color:#0F1F2B;margin:0 0 0.75rem;font-family:Georgia,serif;">Enrolment Confirmed!</h1>
            <p style="color:#6B7C8D;margin:0 0 1.5rem;line-height:1.6;">Your payment was successful and your enrolment is confirmed. Check your email for details.</p>

            @if(isset($enrolment))
                <div style="background:#F5F7F9;border-radius:0.75rem;padding:1.25rem;margin-bottom:1.5rem;text-align:left;">
                    <h3 style="font-size:0.9rem;font-weight:700;color:#0F1F2B;margin:0 0 0.75rem;">Enrolment Details</h3>
                    <div style="display:flex;flex-direction:column;gap:0.5rem;font-size:0.875rem;">
                        <div style="display:flex;justify-content:space-between;"><span style="color:#6B7C8D;">Course</span><span style="font-weight:600;color:#0F1F2B;">{{ $enrolment->course?->title }}</span></div>
                        <div style="display:flex;justify-content:space-between;"><span style="color:#6B7C8D;">Status</span><x-status-badge :status="$enrolment->status" /></div>
                        <div style="display:flex;justify-content:space-between;"><span style="color:#6B7C8D;">Reference</span><span style="font-weight:600;color:#0F1F2B;">{{ $enrolment->payment?->reference ?? '—' }}</span></div>
                    </div>
                </div>
            @endif

            <div style="display:flex;gap:1rem;justify-content:center;">
                <a href="/dashboard" class="btn-secondary">Go to Dashboard</a>
                <a href="/courses" class="btn-outline">Browse More Courses</a>
            </div>
        </div>
    </div>
</x-app-layout>
