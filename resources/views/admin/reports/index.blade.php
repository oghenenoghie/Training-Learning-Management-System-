<x-admin-layout>
    <x-slot name="title">Reports</x-slot>

    {{-- Summary Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin-bottom:1.5rem;">
        <x-stat-card icon="📋" value="{{ $stats['total_enrolments'] }}" label="Total Enrolments" />
        <x-stat-card icon="✅" value="{{ $stats['completed'] }}" label="Completed" color="#1A7A4A" />
        <x-stat-card icon="💰" value="₦{{ number_format($stats['total_revenue']) }}" label="Total Revenue" color="#E07B2A" />
        <x-stat-card icon="📈" value="{{ $stats['completion_rate'] }}%" label="Completion Rate" color="#6b21a8" />
    </div>

    {{-- Export Buttons --}}
    <div style="display:flex;gap:0.75rem;margin-bottom:1.5rem;">
        <a href="/admin/reports/export?type=enrolments" class="btn-outline" style="padding:0.6rem 1.25rem;font-size:0.875rem;">Export Enrolments CSV</a>
        <a href="/admin/reports/export?type=revenue" class="btn-outline" style="padding:0.6rem 1.25rem;font-size:0.875rem;">Export Revenue CSV</a>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
        {{-- Revenue Chart --}}
        <div class="card" style="padding:1.5rem;">
            <h3 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 1.25rem;font-family:Georgia,serif;">Revenue by Month</h3>
            <div style="display:flex;align-items:flex-end;gap:0.5rem;height:120px;border-bottom:1px solid #DDE3EA;padding-bottom:0.5rem;">
                @foreach($revenueByMonth as $month => $amount)
                    @php $maxVal = max(array_values($revenueByMonth) ?: [1]); $pct = $maxVal > 0 ? ($amount/$maxVal*100) : 4; @endphp
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:0.25rem;">
                        <span style="font-size:0.6rem;color:#6B7C8D;">₦{{ number_format($amount/1000) }}k</span>
                        <div style="width:100%;background:#E07B2A;border-radius:3px 3px 0 0;height:{{ max($pct,4) }}%;"></div>
                    </div>
                @endforeach
            </div>
            <div style="display:flex;gap:0.5rem;margin-top:0.5rem;">
                @foreach(array_keys($revenueByMonth) as $m)
                    <div style="flex:1;text-align:center;font-size:0.6rem;color:#6B7C8D;">{{ $m }}</div>
                @endforeach
            </div>
        </div>

        {{-- Completion Rates --}}
        <div class="card" style="padding:1.5rem;">
            <h3 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 1rem;font-family:Georgia,serif;">Completion by Course</h3>
            <div style="overflow-x:auto;">
                <table style="width:100%;font-size:0.8rem;border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="text-align:left;color:#6B7C8D;font-size:0.7rem;padding:0.5rem 0.5rem;border-bottom:1px solid #DDE3EA;">Course</th>
                            <th style="text-align:right;color:#6B7C8D;font-size:0.7rem;padding:0.5rem 0.5rem;border-bottom:1px solid #DDE3EA;">Enrolled</th>
                            <th style="text-align:right;color:#6B7C8D;font-size:0.7rem;padding:0.5rem 0.5rem;border-bottom:1px solid #DDE3EA;">Completed</th>
                            <th style="text-align:right;color:#6B7C8D;font-size:0.7rem;padding:0.5rem 0.5rem;border-bottom:1px solid #DDE3EA;">Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completionRates as $row)
                            <tr style="border-bottom:1px solid #F5F7F9;">
                                <td style="padding:0.5rem;color:#0F1F2B;font-weight:600;max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $row['title'] }}</td>
                                <td style="padding:0.5rem;text-align:right;color:#6B7C8D;">{{ $row['enrolled'] }}</td>
                                <td style="padding:0.5rem;text-align:right;color:#1A7A4A;">{{ $row['completed'] }}</td>
                                <td style="padding:0.5rem;text-align:right;font-weight:700;color:#1A4D5E;">{{ $row['rate'] }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
