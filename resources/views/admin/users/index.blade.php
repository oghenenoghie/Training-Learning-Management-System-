<x-admin-layout>
    <x-slot name="title">Manage Users</x-slot>

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
        <h2 style="font-size:1.25rem;font-weight:700;color:#0F1F2B;margin:0;font-family:Georgia,serif;">Users ({{ $users->total() }})</h2>
    </div>

    <div class="card" style="overflow:hidden;">
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:0.875rem;">
                <thead>
                    <tr style="background:#F5F7F9;">
                        @foreach(['Name','Email','Role','Organisation','Joined','Actions'] as $h)
                            <th style="padding:0.875rem 1rem;text-align:left;font-weight:700;color:#6B7C8D;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.05em;border-bottom:1px solid #DDE3EA;">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="border-bottom:1px solid #F5F7F9;" onmouseover="this.style.background='#FAFBFC'" onmouseout="this.style.background=''">
                            <td style="padding:0.875rem 1rem;">
                                <div style="display:flex;align-items:center;gap:0.75rem;">
                                    <div style="width:32px;height:32px;background:#1A4D5E;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:white;font-size:0.8rem;flex-shrink:0;">{{ strtoupper(substr($user->name,0,1)) }}</div>
                                    <span style="font-weight:600;color:#0F1F2B;">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td style="padding:0.875rem 1rem;color:#6B7C8D;font-size:0.8rem;">{{ $user->email }}</td>
                            <td style="padding:0.875rem 1rem;"><x-status-badge :status="$user->role ?? 'delegate'" /></td>
                            <td style="padding:0.875rem 1rem;color:#6B7C8D;font-size:0.8rem;">{{ $user->organisation ?? '—' }}</td>
                            <td style="padding:0.875rem 1rem;color:#6B7C8D;font-size:0.8rem;">{{ $user->created_at->format('d M Y') }}</td>
                            <td style="padding:0.875rem 1rem;">
                                <a href="#" style="font-size:0.75rem;color:#1A4D5E;font-weight:600;text-decoration:none;padding:0.25rem 0.5rem;border:1px solid #DDE3EA;border-radius:0.375rem;">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="padding:2rem;text-align:center;color:#6B7C8D;">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div style="padding:1rem;border-top:1px solid #DDE3EA;">{{ $users->links() }}</div>
        @endif
    </div>
</x-admin-layout>
