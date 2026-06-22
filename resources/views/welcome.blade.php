<x-app-layout>
    <x-slot name="title">IFS Nigeria — Professional Training & Capacity Development</x-slot>

    {{-- Hero --}}
    <section style="background:linear-gradient(135deg, #0F2E3A 0%, #1A4D5E 50%, #2a6b80 100%); padding:5rem 1.5rem 4rem; position:relative; overflow:hidden;">
        <div style="position:absolute;top:-60px;right:-60px;width:400px;height:400px;border-radius:50%;background:rgba(255,255,255,0.03);"></div>
        <div style="position:absolute;bottom:-80px;left:10%;width:300px;height:300px;border-radius:50%;background:rgba(224,123,42,0.08);"></div>
        <div style="max-width:800px;margin:0 auto;text-align:center;position:relative;">
            <div style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(224,123,42,0.2);border:1px solid rgba(224,123,42,0.3);border-radius:999px;padding:0.375rem 1rem;margin-bottom:1.5rem;">
                <span style="width:6px;height:6px;background:#E07B2A;border-radius:50%;display:inline-block;"></span>
                <span style="color:#E07B2A;font-size:0.8rem;font-weight:600;letter-spacing:0.05em;">NIGERIA'S PREMIER TRAINING PLATFORM</span>
            </div>
            <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:800;color:white;line-height:1.15;margin:0 0 1.25rem;font-family:Georgia,serif;">
                Professional Training &<br><span style="color:#E07B2A;">Capacity Development</span>
            </h1>
            <p style="font-size:1.1rem;color:rgba(255,255,255,0.8);line-height:1.7;margin:0 0 2.5rem;max-width:600px;margin-left:auto;margin-right:auto;">
                Empowering Nigeria's professionals with world-class training programmes, internationally recognised certifications, and transformative learning experiences.
            </p>
            <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                <a href="/courses" class="btn-primary" style="padding:0.875rem 2rem;font-size:1rem;">Browse Courses</a>
                <a href="/register" style="border:2px solid rgba(255,255,255,0.4);color:white;font-weight:600;padding:0.875rem 2rem;border-radius:0.5rem;text-decoration:none;font-size:1rem;display:inline-block;">Create Account</a>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section style="background:white;border-bottom:1px solid #DDE3EA;padding:1.5rem;">
        <div style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;text-align:center;">
            @foreach([['37+','Courses Available'],['10K+','Professionals Trained'],['5','User Roles'],['100%','Online Access']] as $stat)
                <div style="padding:0.5rem;">
                    <p style="font-size:1.75rem;font-weight:800;color:#1A4D5E;margin:0;font-family:Georgia,serif;">{{ $stat[0] }}</p>
                    <p style="font-size:0.8rem;color:#6B7C8D;margin:0.25rem 0 0;font-weight:500;">{{ $stat[1] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Featured Courses --}}
    <section style="padding:4rem 1.5rem;max-width:1200px;margin:0 auto;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
            <div>
                <h2 style="font-size:1.75rem;font-weight:800;color:#0F1F2B;margin:0;font-family:Georgia,serif;">Featured Courses</h2>
                <p style="color:#6B7C8D;margin:0.25rem 0 0;font-size:0.9rem;">Handpicked programmes for your professional growth</p>
            </div>
            <a href="/courses" class="btn-outline" style="padding:0.6rem 1.25rem;font-size:0.875rem;">View All Courses</a>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;">
            @forelse($courses as $course)
                <x-course-card :course="$course" />
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:3rem;color:#6B7C8D;">
                    <p style="font-size:1rem;">No courses available yet. <a href="/admin/courses/create" style="color:#1A4D5E;">Add the first course.</a></p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Categories --}}
    <section style="background:white;padding:4rem 1.5rem;">
        <div style="max-width:1200px;margin:0 auto;">
            <div style="text-align:center;margin-bottom:2.5rem;">
                <h2 style="font-size:1.75rem;font-weight:800;color:#0F1F2B;margin:0;font-family:Georgia,serif;">Course Categories</h2>
                <p style="color:#6B7C8D;margin:0.5rem 0 0;">Explore training across key professional domains</p>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:1rem;">
                @foreach([['🏦','Finance & Banking','#1A4D5E'],['⚡','Oil & Gas','#B85C00'],['💻','IT & Technology','#1e40af'],['⚖️','Legal & Compliance','#0F2E3A'],['📊','Project Management','#1A7A4A'],['🔧','Engineering','#6b21a8']] as $cat)
                    <a href="/courses" style="text-decoration:none;">
                        <div style="background:#F5F7F9;border:1px solid #DDE3EA;border-radius:0.75rem;padding:1.5rem 1rem;text-align:center;transition:all 0.2s;" onmouseover="this.style.background='{{ $cat[2] }}';this.style.borderColor='{{ $cat[2] }}';this.querySelector('.cat-label').style.color='white'" onmouseout="this.style.background='#F5F7F9';this.style.borderColor='#DDE3EA';this.querySelector('.cat-label').style.color='#6B7C8D'">
                            <p style="font-size:1.75rem;margin:0 0 0.5rem;">{{ $cat[0] }}</p>
                            <p class="cat-label" style="font-size:0.8rem;font-weight:600;color:#6B7C8D;margin:0;line-height:1.3;transition:color 0.2s;">{{ $cat[1] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Why IFS --}}
    <section style="padding:4rem 1.5rem;max-width:1200px;margin:0 auto;">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <h2 style="font-size:1.75rem;font-weight:800;color:#0F1F2B;margin:0;font-family:Georgia,serif;">Why Choose IFS Nigeria?</h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1.5rem;">
            @foreach([['🎓','Expert-Led Training','Learn from industry practitioners with decades of real-world experience across Nigeria\'s key sectors.'],['🌍','Globally Recognised','Our certifications are aligned with international standards and recognised by leading organisations worldwide.'],['📱','Flexible Learning','Choose from virtual, in-person, or hybrid delivery modes to fit your schedule and location.']] as $f)
                <div class="card" style="padding:1.75rem;text-align:center;">
                    <div style="font-size:2.25rem;margin-bottom:1rem;">{{ $f[0] }}</div>
                    <h3 style="font-size:1.1rem;font-weight:700;color:#0F1F2B;margin:0 0 0.75rem;font-family:Georgia,serif;">{{ $f[1] }}</h3>
                    <p style="font-size:0.875rem;color:#6B7C8D;line-height:1.6;margin:0;">{{ $f[2] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- CTA --}}
    <section style="background:linear-gradient(135deg,#E07B2A,#c96b1e);padding:4rem 1.5rem;text-align:center;">
        <div style="max-width:600px;margin:0 auto;">
            <h2 style="font-size:1.75rem;font-weight:800;color:white;margin:0 0 0.75rem;font-family:Georgia,serif;">Ready to Advance Your Career?</h2>
            <p style="color:rgba(255,255,255,0.85);margin:0 0 2rem;font-size:1rem;line-height:1.6;">Join thousands of Nigerian professionals already transforming their careers with IFS training programmes.</p>
            <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                <a href="/register" style="background:white;color:#E07B2A;font-weight:700;padding:0.875rem 2rem;border-radius:0.5rem;text-decoration:none;font-size:1rem;">Get Started Today</a>
                <a href="/courses" style="border:2px solid rgba(255,255,255,0.5);color:white;font-weight:600;padding:0.875rem 2rem;border-radius:0.5rem;text-decoration:none;font-size:1rem;">Browse Courses</a>
            </div>
        </div>
    </section>
</x-app-layout>
