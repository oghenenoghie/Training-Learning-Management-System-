<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} — IFS Nigeria</title>
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body style="background-color:#F5F7F9; display:flex; min-height:100vh;">

<div x-data="{ sidebarOpen: false }" style="display:flex; width:100%; min-height:100vh;">

    {{-- Sidebar Overlay (mobile) --}}
    <div x-show="sidebarOpen" @click="sidebarOpen=false" style="position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:40; display:none;" class="mobile-overlay"></div>

    {{-- Sidebar --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : ''" style="width:240px; background:#1A4D5E; display:flex; flex-direction:column; flex-shrink:0; position:fixed; top:0; left:0; height:100vh; z-index:50; overflow-y:auto;">
        {{-- Logo --}}
        <div style="padding:1.25rem 1rem; border-bottom:1px solid rgba(255,255,255,0.1);">
            <a href="/" style="text-decoration:none; display:flex; align-items:center; gap:0.5rem;">
                <div style="width:32px; height:32px; background:#E07B2A; border-radius:7px; display:flex; align-items:center; justify-content:center;">
                    <span style="color:white; font-weight:900; font-size:0.9rem; font-family:Georgia,serif;">I</span>
                </div>
                <span style="color:white; font-size:1.1rem; font-weight:700; font-family:Georgia,serif;">IFS Nigeria</span>
            </a>
        </div>

        {{-- User Info --}}
        <div style="padding:1rem; border-bottom:1px solid rgba(255,255,255,0.1);">
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <div style="width:38px; height:38px; background:#E07B2A; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; font-weight:700; color:white; font-size:1rem;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p style="color:white; font-size:0.875rem; font-weight:600; margin:0; line-height:1.3;">{{ Auth::user()->name }}</p>
                    <p style="color:rgba(255,255,255,0.6); font-size:0.75rem; margin:0;">Delegate</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav style="padding:1rem; flex:1;">
            @php $currentPath = request()->path(); @endphp

            <a href="/dashboard" class="sidebar-link {{ $currentPath === 'dashboard' ? 'active' : '' }}" style="margin-bottom:0.25rem;">
                <svg style="width:18px; height:18px; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="/dashboard/courses" class="sidebar-link {{ str_starts_with($currentPath, 'dashboard/courses') ? 'active' : '' }}" style="margin-bottom:0.25rem;">
                <svg style="width:18px; height:18px; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                My Courses
            </a>
            <a href="/dashboard/certificates" class="sidebar-link {{ str_starts_with($currentPath, 'dashboard/certificates') ? 'active' : '' }}" style="margin-bottom:0.25rem;">
                <svg style="width:18px; height:18px; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                Certificates
            </a>
            <a href="/dashboard/payments" class="sidebar-link {{ str_starts_with($currentPath, 'dashboard/payments') ? 'active' : '' }}" style="margin-bottom:0.25rem;">
                <svg style="width:18px; height:18px; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Payments
            </a>
            <a href="/dashboard/profile" class="sidebar-link {{ str_starts_with($currentPath, 'dashboard/profile') ? 'active' : '' }}" style="margin-bottom:0.25rem;">
                <svg style="width:18px; height:18px; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profile
            </a>
        </nav>

        {{-- Logout --}}
        <div style="padding:1rem; border-top:1px solid rgba(255,255,255,0.1);">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" style="width:100%; display:flex; align-items:center; gap:0.75rem; padding:0.625rem 1rem; border-radius:0.5rem; color:rgba(255,255,255,0.6); font-size:0.875rem; background:none; border:none; cursor:pointer;" onmouseover="this.style.color='white'; this.style.background='rgba(255,255,255,0.07)'" onmouseout="this.style.color='rgba(255,255,255,0.6)'; this.style.background='none'">
                    <svg style="width:18px; height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    {{-- Main area --}}
    <div style="flex:1; margin-left:240px; display:flex; flex-direction:column; min-height:100vh;">

        {{-- Top Bar --}}
        <header style="background:white; border-bottom:1px solid #DDE3EA; padding:0 1.5rem; height:60px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:30;">
            <div style="display:flex; align-items:center; gap:1rem;">
                <button @click="sidebarOpen = !sidebarOpen" style="display:none; background:none; border:none; cursor:pointer; color:#6B7C8D;" class="sidebar-toggle">
                    <svg style="width:22px; height:22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 style="font-size:1.125rem; font-weight:600; color:#0F1F2B; margin:0; font-family:Georgia,serif;">{{ $title ?? 'Dashboard' }}</h1>
            </div>
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <a href="/courses" style="font-size:0.875rem; color:#6B7C8D; text-decoration:none; padding:0.375rem 0.75rem; border:1px solid #DDE3EA; border-radius:0.5rem;" onmouseover="this.style.background='#F5F7F9'" onmouseout="this.style.background='transparent'">Browse Courses</a>
                <div style="width:34px; height:34px; background:#1A4D5E; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; color:white; font-size:0.875rem;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div x-data="{ show:true }" x-show="show" style="margin:1rem 1.5rem; background:#dcfce7; border-left:4px solid #1A7A4A; padding:0.875rem 1rem; border-radius:0.5rem; display:flex; justify-content:space-between; align-items:center;">
                <span style="color:#1A7A4A; font-size:0.875rem; font-weight:500;">{{ session('success') }}</span>
                <button @click="show=false" style="background:none; border:none; cursor:pointer; color:#1A7A4A;">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div x-data="{ show:true }" x-show="show" style="margin:1rem 1.5rem; background:#fee2e2; border-left:4px solid #C0392B; padding:0.875rem 1rem; border-radius:0.5rem; display:flex; justify-content:space-between; align-items:center;">
                <span style="color:#C0392B; font-size:0.875rem; font-weight:500;">{{ session('error') }}</span>
                <button @click="show=false" style="background:none; border:none; cursor:pointer; color:#C0392B;">&times;</button>
            </div>
        @endif

        {{-- Page Content --}}
        <main style="flex:1; padding:2rem 1.5rem;">
            {{ $slot }}
        </main>
    </div>
</div>

<style>
@media (max-width: 768px) {
    aside { transform: translateX(-100%); transition: transform 0.3s; }
    aside.translate-x-0 { transform: translateX(0); }
    .mobile-overlay { display:block !important; }
    .sidebar-toggle { display:block !important; }
    div[style*="margin-left:240px"] { margin-left: 0 !important; }
}
</style>

@livewireScripts
</body>
</html>
