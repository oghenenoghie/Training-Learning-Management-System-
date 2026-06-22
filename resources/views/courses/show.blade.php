<x-app-layout>
    <x-slot name="title">{{ $course->title }} — IFS Nigeria</x-slot>

    {{-- Hero --}}
    <section style="background:linear-gradient(135deg,#1A4D5E,#0F2E3A);padding:3rem 1.5rem;color:white;">
        <div style="max-width:1200px;margin:0 auto;">
            @if($course->category)
                <span style="background:#E07B2A;color:white;font-size:0.75rem;font-weight:700;padding:0.25rem 0.75rem;border-radius:999px;margin-bottom:1rem;display:inline-block;">{{ $course->category->name }}</span>
            @endif
            <h1 style="font-size:clamp(1.5rem,3vw,2.5rem);font-weight:800;margin:0.75rem 0 1rem;font-family:Georgia,serif;">{{ $course->title }}</h1>
            <div style="display:flex;gap:1.5rem;flex-wrap:wrap;font-size:0.9rem;color:rgba(255,255,255,0.8);">
                <span>⏱ {{ $course->duration_days }} day(s)</span>
                <span>📍 {{ ucfirst($course->mode ?? 'virtual') }}</span>
                @if($course->level)<span>📊 {{ ucfirst($course->level) }}</span>@endif
            </div>
        </div>
    </section>

    <div style="max-width:1200px;margin:0 auto;padding:2rem 1.5rem;display:grid;grid-template-columns:1fr 320px;gap:2rem;" x-data="{ tab: 'overview' }">
        {{-- Main Content --}}
        <div>
            {{-- Tabs --}}
            <div style="display:flex;gap:0;border-bottom:2px solid #DDE3EA;margin-bottom:1.5rem;">
                @foreach(['overview'=>'Overview','curriculum'=>'Curriculum','schedules'=>'Schedules','reviews'=>'Reviews'] as $key=>$label)
                    <button @click="tab='{{ $key }}'" :style="tab==='{{ $key }}' ? 'border-bottom:2px solid #1A4D5E;color:#1A4D5E;margin-bottom:-2px;' : 'color:#6B7C8D;'"
                        style="padding:0.75rem 1.25rem;background:none;border:none;font-weight:600;font-size:0.9rem;cursor:pointer;transition:all 0.15s;">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            {{-- Overview --}}
            <div x-show="tab==='overview'">
                <div class="card" style="padding:1.5rem;">
                    <h2 style="font-size:1.25rem;font-weight:700;color:#0F1F2B;margin:0 0 1rem;font-family:Georgia,serif;">About This Course</h2>
                    <div style="color:#6B7C8D;line-height:1.7;font-size:0.9rem;">
                        {!! nl2br(e($course->description ?? 'No description available.')) !!}
                    </div>
                </div>
            </div>

            {{-- Curriculum --}}
            <div x-show="tab==='curriculum'">
                <div class="card" style="padding:1.5rem;">
                    <h2 style="font-size:1.25rem;font-weight:700;color:#0F1F2B;margin:0 0 1rem;font-family:Georgia,serif;">Course Curriculum</h2>
                    @forelse($course->materials as $m)
                        <div style="padding:0.75rem;border:1px solid #DDE3EA;border-radius:0.5rem;margin-bottom:0.5rem;display:flex;align-items:center;gap:0.75rem;">
                            <span style="color:#1A4D5E;">📄</span>
                            <span style="font-size:0.875rem;color:#0F1F2B;">{{ $m->title }}</span>
                        </div>
                    @empty
                        <p style="color:#6B7C8D;font-size:0.875rem;">Curriculum details will be available upon enrolment.</p>
                    @endforelse
                </div>
            </div>

            {{-- Schedules --}}
            <div x-show="tab==='schedules'">
                <div class="card" style="padding:1.5rem;">
                    <h2 style="font-size:1.25rem;font-weight:700;color:#0F1F2B;margin:0 0 1rem;font-family:Georgia,serif;">Available Schedules</h2>
                    @forelse($course->schedules->where('status','open')->where('start_date','>=',now()->toDateString()) as $schedule)
                        <div style="padding:1rem;border:1px solid #DDE3EA;border-radius:0.5rem;margin-bottom:0.75rem;display:flex;justify-content:space-between;align-items:center;transition:border-color 0.15s;" onmouseover="this.style.borderColor='#1A4D5E'" onmouseout="this.style.borderColor='#DDE3EA'">
                            <div>
                                <p style="font-weight:700;color:#0F1F2B;margin:0;">{{ $schedule->start_date->format('d M Y') }} — {{ $schedule->end_date->format('d M Y') }}</p>
                                <p style="font-size:0.8rem;color:#6B7C8D;margin:0.25rem 0 0;">
                                    📍 {{ $schedule->venue ?? ucfirst($schedule->mode ?? 'Virtual') }}
                                    &nbsp;·&nbsp; {{ $schedule->start_date->diffInDays($schedule->end_date) + 1 }} day(s)
                                </p>
                            </div>
                            <a href="{{ route('booking.checkout', $course->slug) }}?schedule_id={{ $schedule->id }}"
                                style="background:#1A4D5E;color:white;font-weight:700;padding:0.5rem 1rem;border-radius:0.4rem;text-decoration:none;font-size:0.8rem;white-space:nowrap;">
                                Book Now
                            </a>
                        </div>
                    @empty
                        <p style="color:#6B7C8D;font-size:0.875rem;">No upcoming open schedules. <a href="mailto:info@ifsnigeria.com" style="color:#1A4D5E;">Contact us</a> to arrange a cohort.</p>
                    @endforelse
                </div>
            </div>

            {{-- Reviews --}}
            <div x-show="tab==='reviews'">
                <div class="card" style="padding:1.5rem;">
                    <h2 style="font-size:1.25rem;font-weight:700;color:#0F1F2B;margin:0 0 1rem;font-family:Georgia,serif;">Delegate Reviews</h2>
                    <p style="color:#6B7C8D;font-size:0.875rem;">Reviews coming soon.</p>
                </div>
            </div>
        </div>

        {{-- Sticky Sidebar --}}
        <div style="position:sticky;top:80px;align-self:start;">
            <div class="card" style="padding:1.5rem;">
                <p style="font-size:2rem;font-weight:800;color:#1A4D5E;margin:0 0 0.5rem;font-family:Georgia,serif;">₦{{ number_format($course->price ?? 0) }}</p>
                <p style="font-size:0.75rem;color:#6B7C8D;margin:0 0 1.5rem;">+7.5% VAT</p>

                <a href="{{ route('booking.checkout', $course->slug) }}" class="btn-primary" style="display:block;text-align:center;margin-bottom:0.75rem;">Book Now — No Login Required</a>
                <a href="/login" style="display:block;text-align:center;padding:0.75rem;border:1px solid #DDE3EA;border-radius:0.5rem;color:#6B7C8D;text-decoration:none;font-size:0.875rem;">Login to Enrol</a>

                <div style="border-top:1px solid #DDE3EA;margin-top:1.25rem;padding-top:1.25rem;">
                    <h4 style="font-size:0.85rem;font-weight:700;color:#0F1F2B;margin:0 0 0.75rem;">Course Details</h4>
                    @foreach([['Duration', $course->duration_days . ' day(s)'],['Mode', ucfirst($course->mode ?? 'virtual')],['Level', ucfirst($course->level ?? 'all')],['Max Delegates', $course->max_delegates ?? 'Open']] as $d)
                        <div style="display:flex;justify-content:space-between;padding:0.4rem 0;border-bottom:1px solid #F5F7F9;font-size:0.8rem;">
                            <span style="color:#6B7C8D;">{{ $d[0] }}</span>
                            <span style="color:#0F1F2B;font-weight:600;">{{ $d[1] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Related --}}
    @if($related->count())
        <section style="background:white;padding:3rem 1.5rem;">
            <div style="max-width:1200px;margin:0 auto;">
                <h2 style="font-size:1.5rem;font-weight:800;color:#0F1F2B;margin:0 0 1.5rem;font-family:Georgia,serif;">Related Courses</h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;">
                    @foreach($related as $r)
                        <x-course-card :course="$r" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-app-layout>
