<x-dashboard-layout>
    <x-slot name="title">My Certificates</x-slot>

    @if($certificates->isEmpty())
        <div class="card" style="padding:3rem;text-align:center;">
            <p style="font-size:3rem;margin:0 0 1rem;">🏆</p>
            <h3 style="font-family:Georgia,serif;color:#0F1F2B;">No Certificates Yet</h3>
            <p style="color:#6B7C8D;">Complete a course to earn your certificate.</p>
            <a href="/courses" class="btn-primary" style="display:inline-block;margin-top:1rem;">Browse Courses</a>
        </div>
    @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;">
            @foreach($certificates as $cert)
                <div class="card" style="overflow:hidden;">
                    <div style="background:linear-gradient(135deg,#1A4D5E,#0F2E3A);padding:1.5rem;text-align:center;position:relative;">
                        <div style="position:absolute;top:0.5rem;right:0.5rem;background:rgba(224,123,42,0.9);border-radius:999px;padding:0.2rem 0.6rem;font-size:0.7rem;font-weight:700;color:white;">CERTIFIED</div>
                        <p style="font-size:2rem;margin:0 0 0.5rem;">🏆</p>
                        <p style="color:rgba(255,255,255,0.8);font-size:0.7rem;font-weight:600;letter-spacing:0.05em;margin:0;text-transform:uppercase;">Certificate of Completion</p>
                    </div>
                    <div style="padding:1.25rem;">
                        <h3 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 0.5rem;font-family:Georgia,serif;">{{ $cert->course->title ?? 'Course' }}</h3>
                        <div style="font-size:0.75rem;color:#6B7C8D;margin-bottom:1rem;">
                            <p style="margin:0.2rem 0;">Cert #: {{ $cert->certificate_number }}</p>
                            <p style="margin:0.2rem 0;">Issued: {{ $cert->issued_at ? $cert->issued_at->format('d M Y') : 'N/A' }}</p>
                        </div>
                        <div style="display:flex;gap:0.5rem;">
                            <a href="/api/v1/certificates/{{ $cert->id }}/download" class="btn-primary" style="flex:1;text-align:center;padding:0.5rem;font-size:0.8rem;">Download PDF</a>
                            <a href="/verify/{{ $cert->verification_code }}" style="border:1px solid #DDE3EA;color:#6B7C8D;padding:0.5rem 0.75rem;border-radius:0.5rem;font-size:0.8rem;text-decoration:none;display:inline-block;">Verify</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-dashboard-layout>
