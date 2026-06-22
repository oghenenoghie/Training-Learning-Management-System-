<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'IFS Nigeria — Training & LMS' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body style="background-color:#F5F7F9; color:#0F1F2B;">

{{-- Sticky Navigation --}}
<nav x-data="{ open: false }" style="background:#1A4D5E; position:sticky; top:0; z-index:50; box-shadow:0 2px 8px rgba(0,0,0,0.15);">
    <div style="max-width:1200px; margin:0 auto; padding:0 1.5rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; height:64px;">

            {{-- Logo --}}
            <a href="/" style="text-decoration:none; display:flex; align-items:center; gap:0.5rem;">
                <div style="width:36px; height:36px; background:#E07B2A; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                    <span style="color:white; font-weight:900; font-size:1rem; font-family:Georgia,serif;">I</span>
                </div>
                <span style="color:white; font-size:1.25rem; font-weight:700; font-family:Georgia,serif; letter-spacing:-0.02em;">IFS Nigeria</span>
            </a>

            {{-- Desktop Nav Links --}}
            <div style="display:flex; align-items:center; gap:2rem;" class="desktop-nav">
                <a href="/courses" style="color:rgba(255,255,255,0.85); text-decoration:none; font-weight:500; font-size:0.9rem; transition:color 0.15s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.85)'">Courses</a>
                <a href="#about" style="color:rgba(255,255,255,0.85); text-decoration:none; font-weight:500; font-size:0.9rem;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.85)'">About</a>
                <a href="#contact" style="color:rgba(255,255,255,0.85); text-decoration:none; font-weight:500; font-size:0.9rem;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.85)'">Contact</a>
            </div>

            {{-- Auth Buttons / User Dropdown --}}
            <div style="display:flex; align-items:center; gap:0.75rem;">
                @auth
                    <div x-data="{ userOpen: false }" style="position:relative;">
                        <button @click="userOpen = !userOpen" style="display:flex; align-items:center; gap:0.5rem; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); border-radius:0.5rem; padding:0.4rem 0.75rem; cursor:pointer; color:white; font-size:0.875rem;">
                            <div style="width:28px; height:28px; background:#E07B2A; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:700;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            {{ Auth::user()->name }}
                            <svg style="width:14px; height:14px; transition:transform 0.15s;" :style="userOpen ? 'transform:rotate(180deg)' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="userOpen" @click.outside="userOpen=false" x-transition style="position:absolute; right:0; top:100%; margin-top:0.5rem; background:white; border:1px solid #DDE3EA; border-radius:0.75rem; box-shadow:0 8px 24px rgba(0,0,0,0.12); min-width:180px; z-index:100; overflow:hidden;">
                            <a href="/dashboard" style="display:block; padding:0.75rem 1rem; color:#0F1F2B; text-decoration:none; font-size:0.875rem; border-bottom:1px solid #DDE3EA;" onmouseover="this.style.background='#F5F7F9'" onmouseout="this.style.background='white'">Dashboard</a>
                            <a href="/dashboard/profile" style="display:block; padding:0.75rem 1rem; color:#0F1F2B; text-decoration:none; font-size:0.875rem; border-bottom:1px solid #DDE3EA;" onmouseover="this.style.background='#F5F7F9'" onmouseout="this.style.background='white'">Profile</a>
                            @if(Auth::user()->hasRole('super_admin') || Auth::user()->hasRole('admin'))
                                <a href="/admin" style="display:block; padding:0.75rem 1rem; color:#0F1F2B; text-decoration:none; font-size:0.875rem; border-bottom:1px solid #DDE3EA;" onmouseover="this.style.background='#F5F7F9'" onmouseout="this.style.background='white'">Admin Panel</a>
                            @endif
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" style="width:100%; text-align:left; padding:0.75rem 1rem; color:#C0392B; font-size:0.875rem; background:none; border:none; cursor:pointer;" onmouseover="this.style.background='#F5F7F9'" onmouseout="this.style.background='none'">Sign Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/login" style="color:rgba(255,255,255,0.85); text-decoration:none; font-weight:500; font-size:0.875rem; padding:0.4rem 0.75rem;">Login</a>
                    <a href="/register" class="btn-primary" style="padding:0.5rem 1.25rem; font-size:0.875rem;">Register</a>
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
            <a href="/courses" style="display:block; padding:0.625rem 0; color:rgba(255,255,255,0.85); text-decoration:none;">Courses</a>
            <a href="#about" style="display:block; padding:0.625rem 0; color:rgba(255,255,255,0.85); text-decoration:none;">About</a>
            <a href="#contact" style="display:block; padding:0.625rem 0; color:rgba(255,255,255,0.85); text-decoration:none;">Contact</a>
        </div>
    </div>
</nav>

{{-- Flash Messages --}}
@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition style="background:#dcfce7; border-left:4px solid #1A7A4A; padding:1rem 1.5rem; margin:1rem auto; max-width:1200px; border-radius:0.5rem; display:flex; justify-content:space-between; align-items:center;">
        <span style="color:#1A7A4A; font-weight:500;">{{ session('success') }}</span>
        <button @click="show=false" style="background:none; border:none; cursor:pointer; color:#1A7A4A; font-size:1.25rem;">&times;</button>
    </div>
@endif
@if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-transition style="background:#fee2e2; border-left:4px solid #C0392B; padding:1rem 1.5rem; margin:1rem auto; max-width:1200px; border-radius:0.5rem; display:flex; justify-content:space-between; align-items:center;">
        <span style="color:#C0392B; font-weight:500;">{{ session('error') }}</span>
        <button @click="show=false" style="background:none; border:none; cursor:pointer; color:#C0392B; font-size:1.25rem;">&times;</button>
    </div>
@endif

{{-- Main Content --}}
<main>
    {{ $slot }}
</main>

{{-- Footer --}}
<footer style="background:#0F2E3A; color:rgba(255,255,255,0.75); margin-top:4rem;">
    <div style="max-width:1200px; margin:0 auto; padding:3rem 1.5rem 2rem;">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:2rem; margin-bottom:2rem;">
            <div>
                <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:1rem;">
                    <div style="width:32px; height:32px; background:#E07B2A; border-radius:6px; display:flex; align-items:center; justify-content:center;">
                        <span style="color:white; font-weight:900; font-size:0.9rem; font-family:Georgia,serif;">I</span>
                    </div>
                    <span style="color:white; font-size:1.1rem; font-weight:700; font-family:Georgia,serif;">IFS Nigeria</span>
                </div>
                <p style="font-size:0.875rem; line-height:1.6;">Empowering Nigeria's professionals with world-class training programmes and capacity development.</p>
            </div>
            <div>
                <h4 style="color:white; font-weight:600; margin-bottom:1rem; font-size:0.9rem; text-transform:uppercase; letter-spacing:0.05em;">Quick Links</h4>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.5rem;">
                    <li><a href="/courses" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:0.875rem;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">All Courses</a></li>
                    <li><a href="/register" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:0.875rem;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">Register</a></li>
                    <li><a href="/login" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:0.875rem;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">Login</a></li>
                </ul>
            </div>
            <div>
                <h4 style="color:white; font-weight:600; margin-bottom:1rem; font-size:0.9rem; text-transform:uppercase; letter-spacing:0.05em;">Contact</h4>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:0.5rem;">
                    <li style="font-size:0.875rem;">Lagos, Nigeria</li>
                    <li><a href="mailto:info@ifsnigeria.org" style="color:rgba(255,255,255,0.7); text-decoration:none; font-size:0.875rem;">info@ifsnigeria.org</a></li>
                    <li style="font-size:0.875rem;">+234 (0) 800 000 0000</li>
                </ul>
            </div>
        </div>
        <div style="border-top:1px solid rgba(255,255,255,0.1); padding-top:1.5rem; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
            <p style="font-size:0.8rem; margin:0;">&copy; {{ date('Y') }} IFS Nigeria. All rights reserved.</p>
            <div style="display:flex; gap:1rem;">
                <a href="#" style="color:rgba(255,255,255,0.5); text-decoration:none; font-size:0.8rem;">Privacy Policy</a>
                <a href="#" style="color:rgba(255,255,255,0.5); text-decoration:none; font-size:0.8rem;">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

@livewireScripts
</body>
</html>
