<x-admin-layout>
    <x-slot name="title">Manage Courses</x-slot>

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
        <h2 style="font-size:1.25rem;font-weight:700;color:#0F1F2B;margin:0;font-family:Georgia,serif;">Courses ({{ $courses->total() }})</h2>
        <a href="/admin/courses/create" class="btn-primary" style="padding:0.6rem 1.25rem;font-size:0.875rem;">+ Add Course</a>
    </div>

    <div class="card" style="overflow:hidden;">
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:0.875rem;">
                <thead>
                    <tr style="background:#F5F7F9;">
                        @foreach(['Title','Category','Price','Delegates','Status','Actions'] as $h)
                            <th style="padding:0.875rem 1rem;text-align:left;font-weight:700;color:#6B7C8D;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.05em;border-bottom:1px solid #DDE3EA;white-space:nowrap;">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr style="border-bottom:1px solid #F5F7F9;" onmouseover="this.style.background='#FAFBFC'" onmouseout="this.style.background=''">
                            <td style="padding:0.875rem 1rem;">
                                <p style="font-weight:600;color:#0F1F2B;margin:0;font-size:0.875rem;">{{ $course->title }}</p>
                                <p style="color:#6B7C8D;margin:0.15rem 0 0;font-size:0.75rem;">{{ $course->mode }} · {{ $course->duration_days }}d</p>
                            </td>
                            <td style="padding:0.875rem 1rem;color:#6B7C8D;font-size:0.8rem;">{{ $course->category?->name ?? '—' }}</td>
                            <td style="padding:0.875rem 1rem;font-weight:700;color:#1A4D5E;">₦{{ number_format($course->price) }}</td>
                            <td style="padding:0.875rem 1rem;color:#6B7C8D;text-align:center;">{{ $course->enrolments_count ?? 0 }}</td>
                            <td style="padding:0.875rem 1rem;">
                                <x-status-badge :status="$course->is_published ? 'published' : 'draft'" />
                            </td>
                            <td style="padding:0.875rem 1rem;">
                                <div style="display:flex;gap:0.5rem;align-items:center;">
                                    <a href="/admin/courses/{{ $course->id }}/edit" style="font-size:0.75rem;color:#1A4D5E;font-weight:600;text-decoration:none;padding:0.25rem 0.5rem;border:1px solid #DDE3EA;border-radius:0.375rem;">Edit</a>
                                    <form method="POST" action="/admin/courses/{{ $course->id }}" style="display:inline;" onsubmit="return confirm('Delete this course?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="font-size:0.75rem;color:#C0392B;font-weight:600;background:none;border:1px solid #C0392B;border-radius:0.375rem;padding:0.25rem 0.5rem;cursor:pointer;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="padding:2rem;text-align:center;color:#6B7C8D;">No courses yet. <a href="/admin/courses/create" style="color:#1A4D5E;">Add one.</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($courses->hasPages())
            <div style="padding:1rem;border-top:1px solid #DDE3EA;">{{ $courses->links() }}</div>
        @endif
    </div>
</x-admin-layout>
