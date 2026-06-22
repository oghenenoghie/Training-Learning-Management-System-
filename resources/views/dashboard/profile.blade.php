<x-dashboard-layout>
    <x-slot name="title">Edit Profile</x-slot>

    <div style="max-width:640px;">
        <div class="card" style="padding:2rem;">
            @if(session('success'))
                <x-alert type="success" message="{{ session('success') }}" />
            @endif
            @if($errors->any())
                <x-alert type="error" message="{{ $errors->first() }}" />
            @endif

            <div style="display:flex;align-items:center;gap:1.5rem;margin-bottom:2rem;">
                <div style="width:72px;height:72px;background:#1A4D5E;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.75rem;font-weight:700;color:white;flex-shrink:0;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <h2 style="font-size:1.25rem;font-weight:700;color:#0F1F2B;margin:0;font-family:Georgia,serif;">{{ Auth::user()->name }}</h2>
                    <p style="color:#6B7C8D;margin:0.2rem 0 0;font-size:0.875rem;">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <form method="POST" action="/dashboard/profile">
                @csrf
                @method('PUT')
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">
                    <div>
                        <label class="label">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="input" required>
                    </div>
                    <div>
                        <label class="label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="input" required>
                    </div>
                    <div>
                        <label class="label">Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone', Auth::user()->phone) }}" class="input">
                    </div>
                    <div>
                        <label class="label">Organisation</label>
                        <input type="text" name="organisation" value="{{ old('organisation', Auth::user()->organisation) }}" class="input">
                    </div>
                    <div style="grid-column:1/-1;">
                        <label class="label">Job Title</label>
                        <input type="text" name="job_title" value="{{ old('job_title', Auth::user()->job_title) }}" class="input">
                    </div>
                </div>

                <div style="border-top:1px solid #DDE3EA;padding-top:1.5rem;margin-top:0.5rem;">
                    <h3 style="font-size:1rem;font-weight:700;color:#0F1F2B;margin:0 0 1rem;">Change Password</h3>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                        <div>
                            <label class="label">New Password</label>
                            <input type="password" name="password" class="input" placeholder="Leave blank to keep current">
                        </div>
                        <div>
                            <label class="label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="input">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-secondary" style="margin-top:1.5rem;">Save Changes</button>
            </form>
        </div>
    </div>
</x-dashboard-layout>
