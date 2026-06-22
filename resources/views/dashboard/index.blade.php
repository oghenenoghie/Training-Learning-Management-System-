<x-dashboard-layout>
    <x-slot name="title">Dashboard</x-slot>

    {{-- Welcome Banner --}}
    <div style="background:linear-gradient(135deg,#1A4D5E,#2a7a8e);border-radius:1rem;padding:1.75rem;color:white;margin-bottom:1.5rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div>
            <h2 style="font-size:1.4rem;font-weight:800;margin:0;font-family:Georgia,serif;">Welcome back, {{ Auth::user()->name }}! 👋</h2>
            <p style="color:rgba(255,255,255,0.8);margin:0.25rem 0 0;font-size:0.9rem;">Here's an overview of your learning journey.</p>
        </div>
        <a href="/courses" class="btn-primary" style="padding:0.625rem 1.25rem;font-size:0.875rem;">Browse More Courses</a>
    </div>

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin-bottom:1.5rem;">
        <x-stat-card icon="📚" value="{{ $stats['enrolled'] }}" label="Enrolled Courses" color="#1A4D5E" />
        <x-stat-card icon="✅" value="{{ $stats['completed'] }}" label="Completed" color="#1A7A4A" />
        <x-stat-card icon="🏆" value="{{ $stats['certificates'] }}" label="Certificates Earned" color="#E07B2A" />
        <x-stat-card icon="📅" value="{{ $stats['upcoming'] }}" label="Upcoming Sessions" color="#B85C00" />
    </div>

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;flex-wrap:wrap;">
        {{-- Active Courses --}}
        <div class="card" style="padding:1.5rem;">
            <h3 style="font-size:1.1rem;font-weight:700;color:#0F1F2B;margin:0 0 1rem;font-family:Georgia,serif;">My Active Courses</h3>
            @forelse($activeEnrolments as $enrolment)
                <div style="border:1px solid #DDE3EA;border-radius:0.75rem;padding:1rem;margin-bottom:0.75rem;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.5rem;">
                        <h4 style="font-size:0.9rem;font-weight:700;color:#0F1F2B;margin:0;">{{ $enrolment->course->title }}</h4>
                        <x-status-badge :status="$enrolment->status" />
                    </div>
                    <div style="background:#DDE3EA;border-radius:999px;height:6px;margin-bottom:0.5rem;overflow:hidden;">
                        <div style="background:#1A4D5E;height:100%;border-radius:999px;width:{{ $enrolment->progress ?? 0 }}%;transition:width 0.3s;"></div>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:0.75rem;color:#6B7C8D;">
                        <span>{{ $enrolment->progress ?? 0 }}% complete</span>
                        <a href="/courses/{{ $enrolment->course->slug }}" style="color:#1A4D5E;text-decoration:none;font-weight:600;">Continue →</a>
                    </div>
                </div>
            @empty
                <div style="text-align:center;padding:2rem;color:#6B7C8D;">
                    <p>No active courses yet.</p>
                    <a href="/courses" class="btn-primary" style="padding:0.5rem 1rem;font-size:0.8rem;margin-top:0.5rem;display:inline-block;">Browse Courses</a>
                </div>
            @endforelse
        </div>

        {{-- Upcoming & Certificates --}}
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div class="card" style="padding:1.25rem;">
                <h3 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 0.75rem;font-family:Georgia,serif;">Upcoming Sessions</h3>
                @forelse($upcomingSchedules as $s)
                    <div style="padding:0.625rem 0;border-bottom:1px solid #F5F7F9;">
                        <p style="font-size:0.8rem;font-weight:600;color:#0F1F2B;margin:0;">{{ $s->course->title ?? 'Course' }}</p>
                        <p style="font-size:0.75rem;color:#6B7C8D;margin:0.15rem 0 0;">{{ $s->start_date ? $s->start_date->format('d M Y') : 'TBD' }}</p>
                    </div>
                @empty
                    <p style="font-size:0.8rem;color:#6B7C8D;">No upcoming sessions.</p>
                @endforelse
            </div>
            <div class="card" style="padding:1.25rem;">
                <h3 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 0.75rem;font-family:Georgia,serif;">Recent Certificates</h3>
                @forelse($recentCertificates as $cert)
                    <div style="padding:0.625rem 0;border-bottom:1px solid #F5F7F9;display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            <p style="font-size:0.8rem;font-weight:600;color:#0F1F2B;margin:0;">{{ $cert->course->title ?? 'Course' }}</p>
                            <p style="font-size:0.75rem;color:#6B7C8D;margin:0.15rem 0 0;">{{ $cert->issued_at ? $cert->issued_at->format('d M Y') : '' }}</p>
                        </div>
                        <a href="/api/v1/certificates/{{ $cert->id }}/download" style="font-size:0.75rem;color:#1A4D5E;font-weight:600;text-decoration:none;">Download</a>
                    </div>
                @empty
                    <p style="font-size:0.8rem;color:#6B7C8D;">No certificates yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-dashboard-layout>
