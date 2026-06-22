<x-dashboard-layout>
    <x-slot name="title">My Courses</x-slot>

    <div x-data="{ tab: 'active' }">
        <div style="display:flex;gap:0;border-bottom:2px solid #DDE3EA;margin-bottom:1.5rem;">
            @foreach(['active'=>'In Progress','completed'=>'Completed','upcoming'=>'Upcoming'] as $key=>$label)
                <button @click="tab='{{ $key }}'" :style="tab==='{{ $key }}' ? 'border-bottom:2px solid #1A4D5E;color:#1A4D5E;margin-bottom:-2px;' : 'color:#6B7C8D;'"
                    style="padding:0.75rem 1.25rem;background:none;border:none;font-weight:600;font-size:0.875rem;cursor:pointer;transition:all 0.15s;">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        @foreach(['active'=>$active,'completed'=>$completed,'upcoming'=>$upcoming] as $key=>$enrolments)
            <div x-show="tab==='{{ $key }}'">
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1rem;">
                    @forelse($enrolments as $enrolment)
                        <div class="card" style="padding:1.25rem;">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.75rem;">
                                <h3 style="font-size:0.95rem;font-weight:700;color:#0F1F2B;margin:0;line-height:1.4;flex:1;margin-right:0.5rem;">{{ $enrolment->course->title }}</h3>
                                <x-status-badge :status="$enrolment->status" />
                            </div>
                            @if($enrolment->course->category)
                                <span style="background:#1A4D5E1a;color:#1A4D5E;font-size:0.7rem;font-weight:600;padding:0.2rem 0.5rem;border-radius:999px;">{{ $enrolment->course->category->name }}</span>
                            @endif
                            @if($key === 'active')
                                <div style="margin:0.75rem 0 0.5rem;">
                                    <div style="background:#DDE3EA;border-radius:999px;height:6px;overflow:hidden;">
                                        <div style="background:#1A4D5E;height:100%;border-radius:999px;width:{{ $enrolment->progress ?? 0 }}%;"></div>
                                    </div>
                                    <span style="font-size:0.7rem;color:#6B7C8D;">{{ $enrolment->progress ?? 0 }}% complete</span>
                                </div>
                                <a href="/courses/{{ $enrolment->course->slug }}" class="btn-secondary" style="display:block;text-align:center;padding:0.5rem;font-size:0.8rem;margin-top:0.5rem;">Continue Learning</a>
                            @elseif($key === 'completed')
                                @if($enrolment->certificate)
                                    <a href="/api/v1/certificates/{{ $enrolment->certificate->id }}/download" class="btn-primary" style="display:block;text-align:center;padding:0.5rem;font-size:0.8rem;margin-top:0.75rem;">View Certificate</a>
                                @endif
                            @endif
                        </div>
                    @empty
                        <div style="grid-column:1/-1;text-align:center;padding:3rem;color:#6B7C8D;">
                            <p>No {{ $key }} courses.</p>
                            <a href="/courses" class="btn-primary" style="display:inline-block;padding:0.5rem 1rem;font-size:0.8rem;margin-top:0.5rem;">Browse Courses</a>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</x-dashboard-layout>
