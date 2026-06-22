<x-app-layout>
    <x-slot name="title">Set New Password — IFS Nigeria</x-slot>
    <div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:2rem 1.5rem;">
        <div style="width:100%;max-width:440px;">
            <div style="text-align:center;margin-bottom:2rem;">
                <h1 style="font-size:1.75rem;font-weight:800;color:#0F1F2B;margin:0;font-family:Georgia,serif;">Set New Password</h1>
            </div>
            <div class="card" style="padding:2rem;">
                @if($errors->any())
                    <x-alert type="error" message="{{ $errors->first() }}" />
                @endif
                <form method="POST" action="/reset-password">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div style="margin-bottom:1.25rem;">
                        <label class="label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $email ?? '') }}" class="input" required>
                    </div>
                    <div style="margin-bottom:1.25rem;">
                        <label class="label">New Password</label>
                        <input type="password" name="password" class="input" placeholder="Min 8 characters" required>
                    </div>
                    <div style="margin-bottom:1.5rem;">
                        <label class="label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="input" placeholder="Repeat password" required>
                    </div>
                    <button type="submit" class="btn-secondary" style="width:100%;text-align:center;">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
