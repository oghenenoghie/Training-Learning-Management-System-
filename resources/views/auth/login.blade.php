<x-app-layout>
    <x-slot name="title">Login — IFS Nigeria</x-slot>
    <div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:2rem 1.5rem;">
        <div style="width:100%;max-width:440px;">
            <div style="text-align:center;margin-bottom:2rem;">
                <div style="width:48px;height:48px;background:#1A4D5E;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;"><span style="color:white;font-weight:900;font-size:1.25rem;font-family:Georgia,serif;">I</span></div>
                <h1 style="font-size:1.75rem;font-weight:800;color:#0F1F2B;margin:0;font-family:Georgia,serif;">Welcome Back</h1>
                <p style="color:#6B7C8D;margin:0.5rem 0 0;font-size:0.9rem;">Sign in to your IFS Nigeria account</p>
            </div>

            <div class="card" style="padding:2rem;">
                @if($errors->any())
                    <x-alert type="error" message="{{ $errors->first() }}" />
                @endif

                <form method="POST" action="/login">
                    @csrf
                    <div style="margin-bottom:1.25rem;">
                        <label class="label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="input" placeholder="you@example.com" required>
                    </div>
                    <div style="margin-bottom:1.25rem;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.5rem;">
                            <label class="label" style="margin:0;">Password</label>
                            <a href="/forgot-password" style="font-size:0.8rem;color:#1A4D5E;text-decoration:none;">Forgot password?</a>
                        </div>
                        <input type="password" name="password" class="input" placeholder="••••••••" required>
                    </div>
                    <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1.5rem;">
                        <input type="checkbox" name="remember" id="remember" style="width:16px;height:16px;accent-color:#1A4D5E;">
                        <label for="remember" style="font-size:0.875rem;color:#6B7C8D;">Remember me for 30 days</label>
                    </div>
                    <button type="submit" class="btn-secondary" style="width:100%;text-align:center;">Sign In</button>
                </form>
            </div>
            <p style="text-align:center;margin-top:1.25rem;font-size:0.875rem;color:#6B7C8D;">
                Don't have an account? <a href="/register" style="color:#1A4D5E;font-weight:600;text-decoration:none;">Register here</a>
            </p>
        </div>
    </div>
</x-app-layout>
