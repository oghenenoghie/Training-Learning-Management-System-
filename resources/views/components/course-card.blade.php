@props(['course'])

@php
$gradients = [
    'default' => 'linear-gradient(135deg, #1A4D5E 0%, #2a7a8e 100%)',
    'finance' => 'linear-gradient(135deg, #1A4D5E 0%, #0d3347 100%)',
    'oil' => 'linear-gradient(135deg, #B85C00 0%, #E07B2A 100%)',
    'it' => 'linear-gradient(135deg, #1A4D5E 0%, #4a9fb5 100%)',
    'legal' => 'linear-gradient(135deg, #0F2E3A 0%, #1A4D5E 100%)',
];
$gradient = $gradients['default'];
@endphp

<div class="card" style="overflow:hidden; transition:transform 0.2s, box-shadow 0.2s; display:flex; flex-direction:column;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.1)'" onmouseout="this.style.transform=''; this.style.boxShadow=''">

    {{-- Gradient Header --}}
    <div style="background:{{ $gradient }}; height:140px; position:relative; display:flex; align-items:flex-end; padding:1rem; overflow:hidden;">
        {{-- Decorative circles --}}
        <div style="position:absolute; top:-20px; right:-20px; width:100px; height:100px; border-radius:50%; background:rgba(255,255,255,0.06);"></div>
        <div style="position:absolute; top:20px; right:40px; width:60px; height:60px; border-radius:50%; background:rgba(255,255,255,0.04);"></div>

        {{-- Mode badge --}}
        <span style="position:absolute; top:0.75rem; right:0.75rem; background:rgba(0,0,0,0.3); color:white; font-size:0.7rem; font-weight:600; padding:0.2rem 0.6rem; border-radius:999px; text-transform:uppercase; letter-spacing:0.04em;">
            {{ ucfirst($course->mode ?? 'virtual') }}
        </span>

        {{-- Category badge --}}
        @if($course->category)
            <span style="background:#E07B2A; color:white; font-size:0.7rem; font-weight:700; padding:0.25rem 0.65rem; border-radius:999px; text-transform:uppercase; letter-spacing:0.05em;">
                {{ $course->category->name }}
            </span>
        @endif
    </div>

    {{-- Content --}}
    <div style="padding:1.25rem; flex:1; display:flex; flex-direction:column;">
        <h3 style="font-size:1rem; font-weight:700; color:#0F1F2B; margin:0 0 0.5rem; font-family:Georgia,serif; line-height:1.4;">
            {{ $course->title }}
        </h3>

        @if($course->short_description)
            <p style="font-size:0.8rem; color:#6B7C8D; line-height:1.5; margin:0 0 1rem; flex:1;">
                {{ Str::limit($course->short_description, 90) }}
            </p>
        @else
            <div style="flex:1;"></div>
        @endif

        {{-- Meta --}}
        <div style="display:flex; align-items:center; gap:1rem; margin-bottom:1rem; border-top:1px solid #DDE3EA; padding-top:0.75rem;">
            <span style="font-size:0.75rem; color:#6B7C8D; display:flex; align-items:center; gap:0.3rem;">
                <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $course->duration_days ?? '–' }} {{ ($course->duration_days == 1) ? 'day' : 'days' }}
            </span>
            @if($course->level)
                <span style="font-size:0.75rem; color:#6B7C8D; display:flex; align-items:center; gap:0.3rem;">
                    <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    {{ ucfirst($course->level) }}
                </span>
            @endif
        </div>

        {{-- Price + CTA --}}
        <div style="display:flex; align-items:center; justify-content:space-between;">
            <div>
                <span style="font-size:1.1rem; font-weight:800; color:#1A4D5E; font-family:Georgia,serif;">
                    ₦{{ number_format($course->price ?? 0) }}
                </span>
            </div>
            <a href="/courses/{{ $course->slug }}" class="btn-primary" style="padding:0.5rem 1rem; font-size:0.8rem;">
                Enrol Now
            </a>
        </div>
    </div>
</div>
