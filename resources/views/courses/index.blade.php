<x-app-layout>
    <x-slot name="title">All Courses — IFS Nigeria</x-slot>

    <div style="max-width:1200px;margin:0 auto;padding:2rem 1.5rem;">
        <div style="margin-bottom:1.5rem;">
            <h1 style="font-size:2rem;font-weight:800;color:#0F1F2B;margin:0;font-family:Georgia,serif;">Course Catalogue</h1>
            <p style="color:#6B7C8D;margin:0.25rem 0 0;">{{ $courses->total() }} courses available</p>
        </div>

        {{-- Search --}}
        <form method="GET" style="margin-bottom:1.5rem;">
            <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search courses..." class="input" style="flex:1;min-width:200px;">
                <select name="mode" class="input" style="width:auto;">
                    <option value="">All Modes</option>
                    <option value="virtual" {{ request('mode')=='virtual'?'selected':'' }}>Virtual</option>
                    <option value="in_person" {{ request('mode')=='in_person'?'selected':'' }}>In-Person</option>
                    <option value="hybrid" {{ request('mode')=='hybrid'?'selected':'' }}>Hybrid</option>
                </select>
                <button type="submit" class="btn-secondary" style="padding:0.75rem 1.25rem;">Search</button>
                @if(request()->hasAny(['search','mode','category']))
                    <a href="/courses" style="padding:0.75rem 1rem;color:#6B7C8D;text-decoration:none;border:1px solid #DDE3EA;border-radius:0.5rem;display:inline-block;">Clear</a>
                @endif
            </div>
        </form>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;">
            @forelse($courses as $course)
                <x-course-card :course="$course" />
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:3rem;color:#6B7C8D;">
                    <p style="font-size:3rem;margin:0 0 1rem;">📚</p>
                    <h3 style="font-family:Georgia,serif;color:#0F1F2B;">No courses found</h3>
                    <p>Try a different search or <a href="/courses" style="color:#1A4D5E;">browse all courses</a>.</p>
                </div>
            @endforelse
        </div>

        @if($courses->hasPages())
            <div style="margin-top:2rem;display:flex;justify-content:center;">
                {{ $courses->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
