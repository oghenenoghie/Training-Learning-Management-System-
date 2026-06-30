<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'IFS Nigeria — Training & LMS' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        *{box-sizing:border-box;}
        body{margin:0;}
        .btn-primary-nav{background:#F08C3A;color:white;font-weight:700;padding:0.5rem 1.25rem;border-radius:9999px;text-decoration:none;display:inline-block;border:none;cursor:pointer;transition:background 0.15s,box-shadow 0.15s;font-family:'Plus Jakarta Sans',sans-serif;font-size:0.875rem;box-shadow:0 2px 6px rgba(240,140,58,0.3);}
        .btn-primary-nav:hover{background:#d97a28;box-shadow:0 4px 12px rgba(240,140,58,0.4);}
        .card{background:white;border:1px solid #E2E8EF;border-radius:1rem;box-shadow:0 2px 8px rgba(13,59,79,0.06),0 1px 2px rgba(0,0,0,0.03);transition:box-shadow 0.2s,transform 0.2s;}
        .card:hover{box-shadow:0 8px 24px rgba(13,59,79,0.12);transform:translateY(-2px);}
        .desktop-nav{display:flex;}
        .mobile-menu-btn{display:none!important;}
        @media(max-width:768px){
            .desktop-nav{display:none!important;}
            .mobile-menu-btn{display:block!important;}
            .stats-grid{grid-template-columns:repeat(2,1fr)!important;}
            .hero-btns{flex-direction:column;align-items:center;}
            .hero-btns a{width:100%;max-width:280px;text-align:center;}
        }
        @media(max-width:480px){
            .stats-grid{grid-template-columns:repeat(2,1fr)!important;}
        }
    </style>
</head>
<body style="background-color:#F8FAFB; color:#0A1628; font-family:'Plus Jakarta Sans',sans-serif;">

{{-- Sticky Navigation --}}
<nav x-data="{ open: false }" style="background:linear-gradient(135deg,#0A2E3E 0%,#0D3B4F 100%); position:sticky; top:0; z-index:50; box-shadow:0 2px 12px rgba(0,0,0,0.18);">
    <div style="max-width:1200px; margin:0 auto; padding:0 1.5rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; height:66px;">

            {{-- Logo --}}
            <a href="/" style="text-decoration:none; display:flex; align-items:center; gap:0.625rem;">
                <div style="width:38px; height:38px; background:#F08C3A; border-radius:9px; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(240,140,58,0.4);">
                    <span style="color:white; font-weight:900; font-size:1.1rem; font-family:'Lora',Georgia,serif;">I</span>
                </div>
                <div>
                    <span style="color:white; font-size:1.2rem; font-weight:700; font-family:'Lora',Georgia,serif; letter-spacing:-0.02em; display:block; line-height:1.1;">IFS Nigeria</span>
                    <span style="color:rgba(255,255,255,0.45); font-size:0.65rem; text-transform:uppercase; letter-spacing:0.08em; font-family:'Plus Jakarta Sans',sans-serif;">Training & LMS</span>
                </div>
            </a>

            {{-- Desktop Nav Links --}}
            <div style="display:flex; align-items:center; gap:2rem;" class="desktop-nav">
                <a href="/courses" style="color:rgba(255,255,255,0.8); text-decoration:none; font-weight:500; font-size:0.9rem; transition:color 0.15s; font-family:'Plus Jakarta Sans',sans-serif;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Courses</a>
                <a href="#about" style="color:rgba(255,255,255,0.8); text-decoration:none; font-weight:500; font-size:0.9rem; font-family:'Plus Jakarta Sans',sans-serif;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">About</a>
                <a href="#contact" style="color:rgba(255,255,255,0.8); text-decoration:none; font-weight:500; font-size:0.9rem; font-family:'Plus Jakarta Sans',sans-serif;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Contact</a>
            </div>

            {{-- Auth Buttons / User Dropdown --}}
            <div style="display:flex; align-items:center; gap:0.75rem;">
                @auth
                    <div x-data="{ userOpen: false }" style="position:relative;">
                        <button @click="userOpen = !userOpen" style="display:flex; align-items:center; gap:0.5rem; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); border-radius:9999px; padding:0.375rem 0.875rem 0.375rem 0.5rem; cursor:pointer; color:white; font-size:0.875rem; font-family:'Plus Jakarta Sans',sans-serif; transition:background 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                            <div style="width:28px; height:28px; background:#F08C3A; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:700;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span style="font-weight:600;">{{ Auth::user()->name }}</span>
                            <svg style="width:14px; height:14px; opacity:0.7; transition:transform 0.15s;" :style="userOpen ? 'transform:rotate(180deg)' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="userOpen" @click.outside="userOpen=false" x-transition style="position:absolute; right:0; top:calc(100% + 8px); background:white; border:1px solid #E2E8EF; border-radius:0.875rem; box-shadow:0 12px 32px rgba(13,59,79,0.15); min-width:190px; z-index:100; overflow:hidden;">
                            <a href="/dashboard" style="display:block; padding:0.75rem 1rem; color:#0A1628; text-decoration:none; font-size:0.875rem; border-bottom:1px solid #F0F4F8; font-family:'Plus Jakarta Sans',sans-serif;" onmouseover="this.style.background='#F8FAFB'" onmouseout="this.style.background='white'">Dashboard</a>
                            <a href="/dashboard/profile" style="display:block; padding:0.75rem 1rem; color:#0A1628; text-decoration:none; font-size:0.875rem; border-bottom:1px solid #F0F4F8; font-family:'Plus Jakarta Sans',sans-serif;" onmouseover="this.style.background='#F8FAFB'" onmouseout="this.style.background='white'">Profile</a>
                            @if(Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('admin'))
                                <a href="/admin" style="display:block; padding:0.75rem 1rem; color:#0A1628; text-decoration:none; font-size:0.875rem; border-bottom:1px solid #F0F4F8; font-family:'Plus Jakarta Sans',sans-serif;" onmouseover="this.style.background='#F8FAFB'" onmouseout="this.style.background='white'">Admin Panel</a>
                            @endif
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" style="width:100%; text-align:left; padding:0.75rem 1rem; color:#C0392B; font-size:0.875rem; background:none; border:none; cursor:pointer; font-family:'Plus Jakarta Sans',sans-serif; font-weight:500;" onmouseover="this.style.background='#FFF5F5'" onmouseout="this.style.background='none'">Sign Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/login" style="color:rgba(255,255,255,0.8); text-decoration:none; font-weight:500; font-size:0.875rem; padding:0.4rem 0.75rem; font-family:'Plus Jakarta Sans',sans-serif;">Login</a>
                    <a href="/register" class="btn-primary-nav">Register</a>
                @endauth

                {{-- Mobile menu button --}}
                <button @click="open = !open" style="display:none; background:none; border:none; cursor:pointer; color:white; padding:0.25rem;" class="mobile-menu-btn">
                    <svg style="width:24px; height:24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="open" x-transition style="border-top:1px solid rgba(255,255,255,0.1); padding:1rem 0;">
            <a href="/courses" style="display:block; padding:0.625rem 0; color:rgba(255,255,255,0.85); text-decoration:none; font-family:'Plus Jakarta Sans',sans-serif;">Courses</a>
            <a href="#about" style="display:block; padding:0.625rem 0; color:rgba(255,255,255,0.85); text-decoration:none; font-family:'Plus Jakarta Sans',sans-serif;">About</a>
            <a href="#contact" style="display:block; padding:0.625rem 0; color:rgba(255,255,255,0.85); text-decoration:none; font-family:'Plus Jakarta Sans',sans-serif;">Contact</a>
        </div>
    </div>
</nav>

{{-- Flash Messages --}}
@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition style="background:#ecfdf5; border-left:4px solid #1A7A4A; padding:1rem 1.5rem; margin:1rem auto; max-width:1200px; border-radius:0.75rem; display:flex; justify-content:space-between; align-items:center; box-shadow:0 2px 8px rgba(26,122,74,0.1);">
        <span style="color:#1A7A4A; font-weight:600; font-size:0.9rem; font-family:'Plus Jakarta Sans',sans-serif;">{{ session('success') }}</span>
        <button @click="show=false" style="background:none; border:none; cursor:pointer; color:#1A7A4A; font-size:1.25rem;">&times;</button>
    </div>
@endif
@if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-transition style="background:#fff1f0; border-left:4px solid #C0392B; padding:1rem 1.5rem; margin:1rem auto; max-width:1200px; border-radius:0.75rem; display:flex; justify-content:space-between; align-items:center;">
        <span style="color:#C0392B; font-weight:600; font-size:0.9rem; font-family:'Plus Jakarta Sans',sans-serif;">{{ session('error') }}</span>
        <button @click="show=false" style="background:none; border:none; cursor:pointer; color:#C0392B; font-size:1.25rem;">&times;</button>
    </div>
@endif

{{-- Main Content --}}
<main>
    {{ $slot }}
</main>

{{-- Footer --}}
<footer style="background:linear-gradient(180deg,#0A2E3E 0%,#071E2A 100%); color:rgba(255,255,255,0.7); margin-top:4rem;">
    <div style="max-width:1200px; margin:0 auto; padding:3.5rem 1.5rem 2rem;">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:2.5rem; margin-bottom:2.5rem;">
            <div>
                <div style="display:flex; align-items:center; gap:0.625rem; margin-bottom:1.25rem;">
                    <div style="width:36px; height:36px; background:#F08C3A; border-radius:8px; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(240,140,58,0.3);">
                        <span style="color:white; font-weight:900; font-size:1rem; font-family:'Lora',Georgia,serif;">I</span>
                    </div>
                    <div>
                        <span style="color:white; font-size:1.1rem; font-weight:700; font-family:'Lora',Georgia,serif; display:block; line-height:1.1;">IFS Nigeria</span>
                        <span style="color:rgba(255,255,255,0.4); font-size:0.65rem; text-transform:uppercase; letter-spacing:0.08em;">Training & LMS</span>
                    </div>
                </div>
                <p style="font-size:0.875rem; line-height:1.7; color:rgba(255,255,255,0.6); margin:0;">Empowering Nigeria's professionals with world-class training programmes and capacity development.</p>
                <div style="margin-top:1rem; display:inline-flex; align-items:center; gap:0.375rem; background:rgba(201,168,76,0.12); border:1px solid rgba(201,168,76,0.3); border-radius:9999px; padding:0.25rem 0.75rem;">
                    <span style="width:5px; height:5px; background:#C9A84C; border-radius:50%; display:inline-block;"></span>
                    <span style="color:#C9A84C; font-size:0.72rem; font-weight:600; letter-spacing:0.05em; text-transform:uppercase;">Internationally Recognised</span>
                </div>
            </div>
            <div>
                <h4 style="color:white; font-weight:700; margin-bottom:1.25rem; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; font-family:'Plus Jakarta Sans',sans-serif;">Quick Links</h4>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.625rem;">
                    <li><a href="/courses" style="color:rgba(255,255,255,0.6); text-decoration:none; font-size:0.875rem; font-family:'Plus Jakarta Sans',sans-serif; transition:color 0.15s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">All Courses</a></li>
                    <li><a href="/register" style="color:rgba(255,255,255,0.6); text-decoration:none; font-size:0.875rem; font-family:'Plus Jakarta Sans',sans-serif;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">Register</a></li>
                    <li><a href="/login" style="color:rgba(255,255,255,0.6); text-decoration:none; font-size:0.875rem; font-family:'Plus Jakarta Sans',sans-serif;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">Login</a></li>
                </ul>
            </div>
            <div>
                <h4 style="color:white; font-weight:700; margin-bottom:1.25rem; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.08em; font-family:'Plus Jakarta Sans',sans-serif;">Contact</h4>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.625rem;">
                    <li style="font-size:0.875rem; color:rgba(255,255,255,0.6);">Lagos, Nigeria</li>
                    <li><a href="mailto:info@dhnconsulting.org" style="color:rgba(255,255,255,0.6); text-decoration:none; font-size:0.875rem; font-family:'Plus Jakarta Sans',sans-serif;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">info@dhnconsulting.org</a></li>
                    <li style="font-size:0.875rem; color:rgba(255,255,255,0.6);">+234 (0) 800 000 0000</li>
                </ul>
            </div>
        </div>
        <div style="border-top:1px solid rgba(255,255,255,0.08); padding-top:1.5rem; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
            <p style="font-size:0.8rem; margin:0; color:rgba(255,255,255,0.4); font-family:'Plus Jakarta Sans',sans-serif;">&copy; {{ date('Y') }} IFS Nigeria / DH Consulting. All rights reserved.</p>
            <div style="display:flex; gap:1.5rem;">
                <a href="#" style="color:rgba(255,255,255,0.35); text-decoration:none; font-size:0.8rem; font-family:'Plus Jakarta Sans',sans-serif;" onmouseover="this.style.color='rgba(255,255,255,0.7)'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">Privacy Policy</a>
                <a href="#" style="color:rgba(255,255,255,0.35); text-decoration:none; font-size:0.8rem; font-family:'Plus Jakarta Sans',sans-serif;" onmouseover="this.style.color='rgba(255,255,255,0.7)'" onmouseout="this.style.color='rgba(255,255,255,0.35)'">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

@livewireScripts
</body>
</html>
