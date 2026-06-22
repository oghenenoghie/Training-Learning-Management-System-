<x-admin-layout>
    <x-slot name="title">Enrolments</x-slot>

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
        <h2 style="font-size:1.25rem;font-weight:700;color:#0F1F2B;margin:0;font-family:Georgia,serif;">Enrolments ({{ $enrolments->total() }})</h2>
    </div>

    <div class="card" style="overflow:hidden;">
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:0.875rem;">
                <thead>
                    <tr style="background:#F5F7F9;">
                        @foreach(['Delegate','Course','Schedule','Status','Payment','Actions'] as $h)
                            <th style="padding:0.875rem 1rem;text-align:left;font-weight:700;color:#6B7C8D;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.05em;border-bottom:1px solid #DDE3EA;">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrolments as $e)
                        <tr style="border-bottom:1px solid #F5F7F9;" onmouseover="this.style.background='#FAFBFC'" onmouseout="this.style.background=''">
                            <td style="padding:0.875rem 1rem;">
                                <p style="font-weight:600;color:#0F1F2B;margin:0;font-size:0.875rem;">{{ $e->user?->name ?? '—' }}</p>
                                <p style="color:#6B7C8D;margin:0.1rem 0 0;font-size:0.75rem;">{{ $e->user?->email }}</p>
                            </td>
                            <td style="padding:0.875rem 1rem;color:#0F1F2B;font-size:0.8rem;max-width:200px;">{{ $e->course?->title ?? '—' }}</td>
                            <td style="padding:0.875rem 1rem;color:#6B7C8D;font-size:0.8rem;">{{ $e->schedule?->start_date?->format('d M Y') ?? '—' }}</td>
                            <td style="padding:0.875rem 1rem;"><x-status-badge :status="$e->status" /></td>
                            <td style="padding:0.875rem 1rem;"><x-status-badge :status="$e->payment?->status ?? 'pending'" /></td>
                            <td style="padding:0.875rem 1rem;">
                                <div style="display:flex;gap:0.35rem;">
                                    @if($e->status === 'pending')
                                        <form method="POST" action="/admin/enrolments/{{ $e->id }}/approve">
                                            @csrf
                                            <button type="submit" style="font-size:0.72rem;color:#1A7A4A;font-weight:600;background:none;border:1px solid #1A7A4A;border-radius:0.375rem;padding:0.2rem 0.5rem;cursor:pointer;">Approve</button>
                                        </form>
                                    @endif
                                    @if(in_array($e->status, ['pending','enrolled']))
                                        <form method="POST" action="/admin/enrolments/{{ $e->id }}/cancel">
                                            @csrf
                                            <button type="submit" style="font-size:0.72rem;color:#C0392B;font-weight:600;background:none;border:1px solid #C0392B;border-radius:0.375rem;padding:0.2rem 0.5rem;cursor:pointer;">Cancel</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="padding:2rem;text-align:center;color:#6B7C8D;">No enrolments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($enrolments->hasPages())
            <div style="padding:1rem;border-top:1px solid #DDE3EA;">{{ $enrolments->links() }}</div>
        @endif
    </div>
</x-admin-layout>
