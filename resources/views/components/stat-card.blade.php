@props(['icon', 'value', 'label', 'sub' => null, 'color' => '#1A4D5E'])

<div class="card" style="padding:1.5rem; display:flex; align-items:flex-start; gap:1rem;">
    <div style="width:48px; height:48px; background:{{ $color }}1a; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
        <span style="font-size:1.5rem;">{{ $icon }}</span>
    </div>
    <div>
        <p style="font-size:1.75rem; font-weight:800; color:#0F1F2B; margin:0; font-family:Georgia,serif; line-height:1;">{{ $value }}</p>
        <p style="font-size:0.85rem; font-weight:600; color:#6B7C8D; margin:0.25rem 0 0;">{{ $label }}</p>
        @if($sub)
            <p style="font-size:0.75rem; color:#9ca3af; margin:0.2rem 0 0;">{{ $sub }}</p>
        @endif
    </div>
</div>
