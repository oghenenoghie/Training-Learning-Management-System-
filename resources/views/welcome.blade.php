<x-app-layout>
    <x-slot name="title">IFS Nigeria — Professional Training & Capacity Development</x-slot>

    {{-- Hero --}}
    <section style="background:linear-gradient(135deg, #071E2A 0%, #0D3B4F 50%, #1A5570 100%); padding:5.5rem 1.5rem 4.5rem; position:relative; overflow:hidden;">
        <div style="position:absolute;top:-80px;right:-60px;width:450px;height:450px;border-radius:50%;background:rgba(255,255,255,0.025);pointer-events:none;"></div>
        <div style="position:absolute;bottom:-100px;left:5%;width:350px;height:350px;border-radius:50%;background:rgba(240,140,58,0.07);pointer-events:none;"></div>
        <div style="position:absolute;top:30%;right:15%;width:200px;height:200px;border-radius:50%;background:rgba(201,168,76,0.05);pointer-events:none;"></div>
        <div style="max-width:820px;margin:0 auto;text-align:center;position:relative;">
            <div style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(201,168,76,0.12);border:1px solid rgba(201,168,76,0.3);border-radius:9999px;padding:0.375rem 1.125rem;margin-bottom:1.75rem;">
                <span style="width:6px;height:6px;background:#C9A84C;border-radius:50%;display:inline-block;"></span>
                <span style="color:#C9A84C;font-size:0.75rem;font-weight:700;letter-spacing:0.06em;font-family:'Plus Jakarta Sans',sans-serif;">NIGERIA'S PREMIER TRAINING PLATFORM</span>
            </div>
            <h1 style="font-size:clamp(2.1rem,5vw,3.75rem);font-weight:700;color:white;line-height:1.12;margin:0 0 1.375rem;font-family:'Lora',Georgia,serif;">
                Professional Training &amp;<br><span style="color:#F08C3A;">Capacity Development</span>
            </h1>
            <p style="font-size:1.1rem;color:rgba(255,255,255,0.75);line-height:1.75;margin:0 0 2.75rem;max-width:600px;margin-left:auto;margin-right:auto;font-family:'Plus Jakarta Sans',sans-serif;">
                Empowering Nigeria's professionals with world-class training programmes, internationally recognised certifications, and transformative learning experiences.
            </p>
            <div class="hero-btns" style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                <a href="/courses" style="background:#F08C3A;color:white;font-weight:700;padding:0.9rem 2.25rem;border-radius:9999px;text-decoration:none;font-size:1rem;display:inline-block;box-shadow:0 4px 16px rgba(240,140,58,0.4);font-family:'Plus Jakarta Sans',sans-serif;transition:all 0.15s;" onmouseover="this.style.background='#d97a28';this.style.transform='translateY(-1px)'" onmouseout="this.style.background='#F08C3A';this.style.transform='translateY(0)'">Browse Courses</a>
                <a href="/register" style="border:2px solid rgba(255,255,255,0.4);color:white;font-weight:600;padding:0.9rem 2.25rem;border-radius:9999px;text-decoration:none;font-size:1rem;display:inline-block;font-family:'Plus Jakarta Sans',sans-serif;transition:all 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.borderColor='rgba(255,255,255,0.7)'" onmouseout="this.style.background='transparent';this.style.borderColor='rgba(255,255,255,0.4)'">Create Account</a>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section style="background:white;border-bottom:1px solid #E2E8EF;padding:1.75rem;box-shadow:0 2px 8px rgba(13,59,79,0.04);">
        <div class="stats-grid" style="max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;text-align:center;">
            @foreach([['37+','Courses Available'],['10K+','Professionals Trained'],['5','User Roles'],['100%','Online Access']] as $stat)
                <div style="padding:0.75rem;">
                    <p style="font-size:1.875rem;font-weight:700;color:#0D3B4F;margin:0;font-family:'Lora',Georgia,serif;">{{ $stat[0] }}</p>
                    <p style="font-size:0.8rem;color:#6B7C8D;margin:0.3rem 0 0;font-weight:600;letter-spacing:0.02em;font-family:'Plus Jakarta Sans',sans-serif;">{{ $stat[1] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Featured Courses --}}
    <section style="padding:4.5rem 1.5rem;max-width:1200px;margin:0 auto;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2.25rem;flex-wrap:wrap;gap:1rem;">
            <div>
                <h2 style="font-size:1.875rem;font-weight:700;color:#0A1628;margin:0;font-family:'Lora',Georgia,serif;">Featured Courses</h2>
                <p style="color:#6B7C8D;margin:0.375rem 0 0;font-size:0.9rem;font-family:'Plus Jakarta Sans',sans-serif;">Handpicked programmes for your professional growth</p>
            </div>
            <a href="/courses" style="border:2px solid #0D3B4F;color:#0D3B4F;font-weight:700;padding:0.6rem 1.5rem;border-radius:9999px;text-decoration:none;font-size:0.875rem;display:inline-block;font-family:'Plus Jakarta Sans',sans-serif;transition:all 0.15s;" onmouseover="this.style.background='#0D3B4F';this.style.color='white'" onmouseout="this.style.background='transparent';this.style.color='#0D3B4F'">View All Courses</a>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;">
            @forelse($courses as $course)
                <x-course-card :course="$course" />
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:3rem;color:#6B7C8D;">
                    <p style="font-size:1rem;font-family:'Plus Jakarta Sans',sans-serif;">No courses available yet. <a href="/admin/courses/create" style="color:#0D3B4F;font-weight:600;">Add the first course.</a></p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Categories --}}
    <section style="background:white;padding:4.5rem 1.5rem;border-top:1px solid #E2E8EF;">
        <div style="max-width:1200px;margin:0 auto;">
            <div style="text-align:center;margin-bottom:2.75rem;">
                <h2 style="font-size:1.875rem;font-weight:700;color:#0A1628;margin:0;font-family:'Lora',Georgia,serif;">Course Categories</h2>
                <p style="color:#6B7C8D;margin:0.5rem 0 0;font-family:'Plus Jakarta Sans',sans-serif;">Explore training across key professional domains</p>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(165px,1fr));gap:1rem;">
                @foreach([
                    ['🏦','Finance & Banking','#0D3B4F','#E8F0F4'],
                    ['⚡','Oil & Gas','#7A3A00','#FFF0E0'],
                    ['💻','IT & Technology','#1e3a8a','#EEF2FF'],
                    ['⚖️','Legal & Compliance','#2D1B69','#F0EBFF'],
                    ['📊','Project Management','#1A7A4A','#ECFDF5'],
                    ['🔧','Engineering','#5B21B6','#F3EEFF']
                ] as $cat)
                    <a href="/courses" style="text-decoration:none;">
                        <div style="background:{{ $cat[3] }};border:1.5px solid transparent;border-radius:1rem;padding:1.75rem 1rem;text-align:center;transition:all 0.2s;cursor:pointer;" onmouseover="this.style.background='{{ $cat[2] }}';this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)';this.querySelector('p').style.color='white'" onmouseout="this.style.background='{{ $cat[3] }}';this.style.transform='translateY(0)';this.style.boxShadow='none';this.querySelector('p').style.color='{{ $cat[2] }}'">
                            <p style="font-size:1.875rem;margin:0 0 0.625rem;">{{ $cat[0] }}</p>
                            <p style="font-size:0.8rem;font-weight:700;color:{{ $cat[2] }};margin:0;line-height:1.3;transition:color 0.2s;font-family:'Plus Jakarta Sans',sans-serif;">{{ $cat[1] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Why IFS --}}
    <section style="padding:4.5rem 1.5rem;max-width:1200px;margin:0 auto;">
        <div style="text-align:center;margin-bottom:2.75rem;">
            <h2 style="font-size:1.875rem;font-weight:700;color:#0A1628;margin:0;font-family:'Lora',Georgia,serif;">Why Choose IFS Nigeria?</h2>
            <p style="color:#6B7C8D;margin:0.5rem 0 0;font-family:'Plus Jakarta Sans',sans-serif;">Built for Nigeria's ambitious professionals</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1.5rem;">
            @foreach([
                ['🎓','Expert-Led Training','Learn from industry practitioners with decades of real-world experience across Nigeria\'s key sectors.','#0D3B4F'],
                ['🌍','Globally Recognised','Our certifications are aligned with international standards and recognised by leading organisations worldwide.','#C9A84C'],
                ['📱','Flexible Learning','Choose from virtual, in-person, or hybrid delivery modes to fit your schedule and location.','#F08C3A']
            ] as $f)
                <div style="background:white;border-radius:1rem;border:1px solid #E2E8EF;box-shadow:0 2px 8px rgba(13,59,79,0.06);padding:2rem 1.75rem;text-align:center;">
                    <div style="width:56px;height:56px;background:{{ $f[3] }}15;border-radius:1rem;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;font-size:1.75rem;">{{ $f[0] }}</div>
                    <h3 style="font-size:1.1rem;font-weight:700;color:#0A1628;margin:0 0 0.75rem;font-family:'Lora',Georgia,serif;">{{ $f[1] }}</h3>
                    <p style="font-size:0.875rem;color:#6B7C8D;line-height:1.7;margin:0;font-family:'Plus Jakarta Sans',sans-serif;">{{ $f[2] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Gold Prestige Banner --}}
    <section style="background:linear-gradient(135deg,#0A1628,#0D3B4F);padding:3rem 1.5rem;margin:0;">
        <div style="max-width:1200px;margin:0 auto;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:2rem;">
            <div style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;">
                @foreach(['ISO Aligned','CPD Accredited','Industry Endorsed'] as $badge)
                    <div style="display:inline-flex;align-items:center;gap:0.5rem;">
                        <div style="width:8px;height:8px;background:#C9A84C;border-radius:50%;"></div>
                        <span style="color:rgba(255,255,255,0.75);font-size:0.85rem;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;letter-spacing:0.02em;">{{ $badge }}</span>
                    </div>
                @endforeach
            </div>
            <a href="/register" style="background:linear-gradient(135deg,#C9A84C,#A8873A);color:#0A1628;font-weight:800;padding:0.75rem 2rem;border-radius:9999px;text-decoration:none;font-size:0.9rem;font-family:'Plus Jakarta Sans',sans-serif;box-shadow:0 4px 16px rgba(201,168,76,0.3);white-space:nowrap;">Enrol Today</a>
        </div>
    </section>

    {{-- CTA --}}
    <section style="background:linear-gradient(135deg,#F08C3A,#d97a28);padding:4.5rem 1.5rem;text-align:center;">
        <div style="max-width:640px;margin:0 auto;">
            <h2 style="font-size:1.875rem;font-weight:700;color:white;margin:0 0 0.875rem;font-family:'Lora',Georgia,serif;">Ready to Advance Your Career?</h2>
            <p style="color:rgba(255,255,255,0.88);margin:0 0 2.25rem;font-size:1rem;line-height:1.75;font-family:'Plus Jakarta Sans',sans-serif;">Join thousands of Nigerian professionals already transforming their careers with IFS training programmes.</p>
            <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                <a href="/register" style="background:white;color:#E07B2A;font-weight:800;padding:0.9rem 2.25rem;border-radius:9999px;text-decoration:none;font-size:1rem;font-family:'Plus Jakarta Sans',sans-serif;box-shadow:0 4px 16px rgba(0,0,0,0.15);transition:all 0.15s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">Get Started Today</a>
                <a href="/courses" style="border:2px solid rgba(255,255,255,0.5);color:white;font-weight:600;padding:0.9rem 2.25rem;border-radius:9999px;text-decoration:none;font-size:1rem;font-family:'Plus Jakarta Sans',sans-serif;transition:all 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='transparent'">Browse Courses</a>
            </div>
        </div>
    </section>
</x-app-layout>
