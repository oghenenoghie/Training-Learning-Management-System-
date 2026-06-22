<x-app-layout>
    <x-slot name="title">Forgot Password — IFS Nigeria</x-slot>
    <div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:2rem 1.5rem;">
        <div style="width:100%;max-width:440px;">
            <div style="text-align:center;margin-bottom:2rem;">
                <h1 style="font-size:1.75rem;font-weight:800;color:#0F1F2B;margin:0;font-family:Georgia,serif;">Reset Password</h1>
                <p style="color:#6B7C8D;margin:0.5rem 0 0;font-size:0.9rem;">Enter your email and we'll send you a reset link.</p>
            </div>
            <div class="card" style="padding:2rem;">
                @if(session('status'))
                    <x-alert type="success" message="{{ session('status') }}" />
                @endif
                @if($errors->any())
                    <x-alert type="error" message="{{ $errors->first() }}" />
                @endif
                <form method="POST" action="/forgot-password">
                    @csrf
                    <div style="margin-bottom:1.5rem;">
                        <label class="label">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="input" placeholder="you@example.com" required>
                    </div>
                    <button type="submit" class="btn-secondary" style="width:100%;text-align:center;">Send Reset Link</button>
                </form>
            </div>
            <p style="text-align:center;margin-top:1rem;font-size:0.875rem;color:#6B7C8D;"><a href="/login" style="color:#1A4D5E;text-decoration:none;">Back to login</a></p>
        </div>
    </div>
</x-app-layout>
