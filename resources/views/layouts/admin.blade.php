<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — {{ $title ?? 'IFS Nigeria' }}</title>
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body style="background-color:#F0F2F5; display:flex; min-height:100vh;">

<div x-data="{ sidebarOpen: true, mobileSidebar: false }" style="display:flex; width:100%; min-height:100vh;">

    {{-- Sidebar --}}
    <aside style="width:250px; background:#0F2E3A; display:flex; flex-direction:column; flex-shrink:0; position:fixed; top:0; left:0; height:100vh; z-index:50; overflow-y:auto; transition:transform 0.3s;">
        {{-- Logo --}}
        <div style="padding:1.25rem 1rem; border-bottom:1px solid rgba(255,255,255,0.08);">
            <a href="/" style="text-decoration:none; display:flex; align-items:center; gap:0.5rem;">
                <div style="width:34px; height:34px; background:#E07B2A; border-radius:7px; display:flex; align-items:center; justify-content:center;">
                    <span style="color:white; font-weight:900; font-size:1rem; font-family:Georgia,serif;">I</span>
                </div>
                <div>
                    <span style="color:white; font-size:1rem; font-weight:700; font-family:Georgia,serif; display:block;">IFS Nigeria</span>
                    <span style="color:rgba(255,255,255,0.45); font-size:0.7rem; text-transform:uppercase; letter-spacing:0.08em;">Admin Panel</span>
                </div>
            </a>
        </div>

        {{-- Nav --}}
        <nav style="padding:1rem 0.75rem; flex:1;">
            @php $path = request()->path(); @endphp

            <p style="color:rgba(255,255,255,0.3); font-size:0.7rem; text-transform:uppercase; letter-spacing:0.08em; padding:0 0.25rem; margin-bottom:0.5rem; margin-top:0;">Main</p>

            <a href="/admin" class="sidebar-link {{ $path === 'admin' ? 'active' : '' }}" style="margin-bottom:0.2rem;">
                <svg style="width:17px;height:17px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <p style="color:rgba(255,255,255,0.3); font-size:0.7rem; text-transform:uppercase; letter-spacing:0.08em; padding:0 0.25rem; margin:1rem 0 0.5rem;">Management</p>

            <a href="/admin/courses" class="sidebar-link {{ str_starts_with($path, 'admin/courses') ? 'active' : '' }}" style="margin-bottom:0.2rem;">
                <svg style="width:17px;height:17px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Courses
            </a>
            <a href="/admin/users" class="sidebar-link {{ str_starts_with($path, 'admin/users') ? 'active' : '' }}" style="margin-bottom:0.2rem;">
                <svg style="width:17px;height:17px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Users
            </a>
            <a href="/admin/enrolments" class="sidebar-link {{ str_starts_with($path, 'admin/enrolments') ? 'active' : '' }}" style="margin-bottom:0.2rem;">
                <svg style="width:17px;height:17px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Enrolments
            </a>
            <a href="/admin/payments" class="sidebar-link {{ str_starts_with($path, 'admin/payments') ? 'active' : '' }}" style="margin-bottom:0.2rem;">
                <svg style="width:17px;height:17px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Payments
            </a>
            <a href="/admin/reports" class="sidebar-link {{ str_starts_with($path, 'admin/reports') ? 'active' : '' }}" style="margin-bottom:0.2rem;">
                <svg style="width:17px;height:17px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Reports
            </a>

            <p style="color:rgba(255,255,255,0.3); font-size:0.7rem; text-transform:uppercase; letter-spacing:0.08em; padding:0 0.25rem; margin:1rem 0 0.5rem;">System</p>
            <a href="#" class="sidebar-link" style="margin-bottom:0.2rem;">
                <svg style="width:17px;height:17px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Settings
            </a>
        </nav>

        {{-- Logout --}}
        <div style="padding:1rem; border-top:1px solid rgba(255,255,255,0.08);">
            <a href="/" style="display:flex; align-items:center; gap:0.5rem; color:rgba(255,255,255,0.5); text-decoration:none; font-size:0.8rem; padding:0.5rem; margin-bottom:0.5rem;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">
                ← Back to Site
            </a>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" style="width:100%; display:flex; align-items:center; gap:0.5rem; padding:0.5rem; color:rgba(255,255,255,0.45); font-size:0.8rem; background:none; border:none; cursor:pointer; border-radius:0.375rem;" onmouseover="this.style.color='white'; this.style.background='rgba(255,255,255,0.06)'" onmouseout="this.style.color='rgba(255,255,255,0.45)'; this.style.background='none'">
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Sign Out ({{ Auth::user()->name }})
                </button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <div style="flex:1; margin-left:250px; display:flex; flex-direction:column; min-height:100vh;">

        {{-- Top Bar --}}
        <header style="background:white; border-bottom:1px solid #DDE3EA; padding:0 1.5rem; height:58px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:30;">
            <div>
                {{-- Breadcrumb --}}
                @isset($breadcrumb)
                    <nav style="font-size:0.8rem; color:#6B7C8D;">
                        @foreach($breadcrumb as $label => $url)
                            @if(!$loop->last)
                                <a href="{{ $url }}" style="color:#6B7C8D; text-decoration:none;" onmouseover="this.style.color='#1A4D5E'" onmouseout="this.style.color='#6B7C8D'">{{ $label }}</a>
                                <span style="margin:0 0.35rem; color:#DDE3EA;">/</span>
                            @else
                                <span style="color:#0F1F2B; font-weight:600;">{{ $label }}</span>
                            @endif
                        @endforeach
                    </nav>
                @else
                    <h1 style="font-size:1rem; font-weight:600; color:#0F1F2B; margin:0; font-family:Georgia,serif;">{{ $title ?? 'Admin' }}</h1>
                @endisset
            </div>
            <div style="display:flex; align-items:center; gap:0.75rem;">
                <span style="font-size:0.8rem; color:#6B7C8D;">{{ Auth::user()->name }}</span>
                <div style="width:32px; height:32px; background:#0F2E3A; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; color:white; font-size:0.8rem;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Flash --}}
        @if(session('success'))
            <div x-data="{show:true}" x-show="show" style="margin:1rem 1.5rem; background:#dcfce7; border-left:4px solid #1A7A4A; padding:0.75rem 1rem; border-radius:0.5rem; display:flex; justify-content:space-between; align-items:center;">
                <span style="color:#1A7A4A; font-size:0.875rem;">{{ session('success') }}</span>
                <button @click="show=false" style="background:none; border:none; cursor:pointer; color:#1A7A4A;">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div x-data="{show:true}" x-show="show" style="margin:1rem 1.5rem; background:#fee2e2; border-left:4px solid #C0392B; padding:0.75rem 1rem; border-radius:0.5rem; display:flex; justify-content:space-between; align-items:center;">
                <span style="color:#C0392B; font-size:0.875rem;">{{ session('error') }}</span>
                <button @click="show=false" style="background:none; border:none; cursor:pointer; color:#C0392B;">&times;</button>
            </div>
        @endif

        {{-- Content --}}
        <main style="flex:1; padding:1.5rem;">
            {{ $slot }}
        </main>
    </div>
</div>

@livewireScripts
</body>
</html>
