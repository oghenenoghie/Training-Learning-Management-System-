<x-app-layout>
    <x-slot name="title">Register — IFS Nigeria</x-slot>
    <div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:2rem 1.5rem;">
        <div style="width:100%;max-width:680px;">
            <div style="text-align:center;margin-bottom:2rem;">
                <div style="width:48px;height:48px;background:#1A4D5E;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;"><span style="color:white;font-weight:900;font-size:1.25rem;font-family:Georgia,serif;">I</span></div>
                <h1 style="font-size:1.75rem;font-weight:800;color:#0F1F2B;margin:0;font-family:Georgia,serif;">Create Your Account</h1>
                <p style="color:#6B7C8D;margin:0.5rem 0 0;font-size:0.9rem;">Join thousands of professionals on IFS Nigeria</p>
            </div>

            <div class="card" style="padding:2rem;">
                @if($errors->any())
                    <x-alert type="error" message="{{ $errors->first() }}" />
                @endif

                <form method="POST" action="/register">
                    @csrf
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.25rem;">
                        <div>
                            <label class="label">Full Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="input" placeholder="John Doe" required>
                        </div>
                        <div>
                            <label class="label">Email Address *</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="input" placeholder="you@example.com" required>
                        </div>
                        <div>
                            <label class="label">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="input" placeholder="+234 800 000 0000">
                        </div>
                        <div>
                            <label class="label">Organisation</label>
                            <input type="text" name="organisation" value="{{ old('organisation') }}" class="input" placeholder="Company name">
                        </div>
                        <div>
                            <label class="label">Job Title</label>
                            <input type="text" name="job_title" value="{{ old('job_title') }}" class="input" placeholder="e.g. Senior Manager">
                        </div>
                        <div></div>
                        <div>
                            <label class="label">Password *</label>
                            <input type="password" name="password" class="input" placeholder="Min 8 characters" required>
                        </div>
                        <div>
                            <label class="label">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="input" placeholder="Repeat password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-secondary" style="width:100%;text-align:center;">Create Account</button>
                </form>
            </div>
            <p style="text-align:center;margin-top:1.25rem;font-size:0.875rem;color:#6B7C8D;">
                Already have an account? <a href="/login" style="color:#1A4D5E;font-weight:600;text-decoration:none;">Sign in</a>
            </p>
        </div>
    </div>
</x-app-layout>
