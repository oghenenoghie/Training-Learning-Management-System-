<x-admin-layout>
    <x-slot name="title">Admin Dashboard</x-slot>

    {{-- KPI Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:1.5rem;">
        <x-stat-card icon="💰" value="₦{{ number_format($stats['revenue']) }}" label="Revenue This Month" color="#1A7A4A" />
        <x-stat-card icon="📋" value="{{ $stats['enrolments'] }}" label="New Enrolments" color="#1A4D5E" />
        <x-stat-card icon="👥" value="{{ $stats['delegates'] }}" label="Active Delegates" color="#E07B2A" />
        <x-stat-card icon="📚" value="{{ $stats['courses'] }}" label="Published Courses" color="#6b21a8" />
    </div>

    {{-- Quick Actions --}}
    <div style="display:flex;gap:0.75rem;margin-bottom:1.5rem;flex-wrap:wrap;">
        <a href="/admin/courses/create" class="btn-primary" style="padding:0.6rem 1.25rem;font-size:0.875rem;">+ Add Course</a>
        <a href="/admin/reports" class="btn-outline" style="padding:0.6rem 1.25rem;font-size:0.875rem;">Export Reports</a>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
        {{-- Revenue Chart --}}
        <div class="card" style="padding:1.5rem;">
            <h3 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 1.25rem;font-family:Georgia,serif;">Revenue (Last 6 Months)</h3>
            <div style="display:flex;align-items:flex-end;gap:0.5rem;height:120px;border-bottom:1px solid #DDE3EA;padding-bottom:0.5rem;">
                @foreach($revenueChart as $month => $amount)
                    @php $maxVal = max(array_values($revenueChart)) ?: 1; $pct = ($amount / $maxVal) * 100; @endphp
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:0.25rem;">
                        <span style="font-size:0.6rem;color:#6B7C8D;">₦{{ number_format($amount/1000) }}k</span>
                        <div style="width:100%;background:#1A4D5E;border-radius:4px 4px 0 0;height:{{ max($pct, 4) }}%;min-height:4px;transition:height 0.3s;"></div>
                    </div>
                @endforeach
            </div>
            <div style="display:flex;gap:0.5rem;margin-top:0.5rem;">
                @foreach(array_keys($revenueChart) as $m)
                    <div style="flex:1;text-align:center;font-size:0.65rem;color:#6B7C8D;">{{ $m }}</div>
                @endforeach
            </div>
        </div>

        {{-- Recent Enrolments --}}
        <div class="card" style="padding:1.5rem;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
                <h3 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0;font-family:Georgia,serif;">Recent Enrolments</h3>
                <a href="/admin/enrolments" style="font-size:0.8rem;color:#1A4D5E;text-decoration:none;">View all →</a>
            </div>
            @forelse($recentEnrolments as $e)
                <div style="padding:0.625rem 0;border-bottom:1px solid #F5F7F9;display:flex;justify-content:space-between;align-items:center;">
                    <div>
                        <p style="font-size:0.8rem;font-weight:600;color:#0F1F2B;margin:0;">{{ $e->user?->name ?? 'Unknown' }}</p>
                        <p style="font-size:0.72rem;color:#6B7C8D;margin:0.1rem 0 0;">{{ $e->course?->title ?? '—' }}</p>
                    </div>
                    <x-status-badge :status="$e->status" />
                </div>
            @empty
                <p style="font-size:0.8rem;color:#6B7C8D;">No enrolments yet.</p>
            @endforelse
        </div>
    </div>
</x-admin-layout>
