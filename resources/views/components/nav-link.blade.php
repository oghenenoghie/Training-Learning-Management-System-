@props(['href', 'active' => false])

<a href="{{ $href }}"
    style="display:inline-flex; align-items:center; padding:0.5rem 0.75rem; border-radius:0.375rem; font-size:0.875rem; font-weight:500; text-decoration:none; transition:all 0.15s;
    {{ $active ? 'background:#1A4D5E1a; color:#1A4D5E;' : 'color:#6B7C8D;' }}"
    onmouseover="if(!{{ $active ? 'true' : 'false' }}) { this.style.background='#F5F7F9'; this.style.color='#0F1F2B'; }"
    onmouseout="if(!{{ $active ? 'true' : 'false' }}) { this.style.background=''; this.style.color='#6B7C8D'; }">
    {{ $slot }}
</a>
