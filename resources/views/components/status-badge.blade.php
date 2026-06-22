@props(['status'])

@php
$styles = [
    'enrolled'    => 'background:#dbeafe; color:#1e40af;',
    'active'      => 'background:#dbeafe; color:#1e40af;',
    'completed'   => 'background:#dcfce7; color:#1A7A4A;',
    'pending'     => 'background:#fef3c7; color:#B85C00;',
    'cancelled'   => 'background:#fee2e2; color:#C0392B;',
    'waitlisted'  => 'background:#fed7aa; color:#9a3412;',
    'approved'    => 'background:#dcfce7; color:#1A7A4A;',
    'rejected'    => 'background:#fee2e2; color:#C0392B;',
    'paid'        => 'background:#dcfce7; color:#1A7A4A;',
    'failed'      => 'background:#fee2e2; color:#C0392B;',
    'refunded'    => 'background:#f3e8ff; color:#6b21a8;',
    'published'   => 'background:#dcfce7; color:#1A7A4A;',
    'draft'       => 'background:#f3f4f6; color:#4b5563;',
    'super_admin' => 'background:#fce7f3; color:#9d174d;',
    'admin'       => 'background:#ede9fe; color:#5b21b6;',
    'trainer'     => 'background:#dbeafe; color:#1e40af;',
    'delegate'    => 'background:#f0fdf4; color:#1A7A4A;',
];
$style = $styles[strtolower($status)] ?? 'background:#f3f4f6; color:#4b5563;';
@endphp

<span style="{{ $style }} font-size:0.72rem; font-weight:700; padding:0.2rem 0.6rem; border-radius:999px; text-transform:uppercase; letter-spacing:0.04em; white-space:nowrap;">
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
