@props(['type' => 'success', 'message'])

@php
$styles = [
    'success' => ['bg'=>'#dcfce7','border'=>'#1A7A4A','text'=>'#1A7A4A'],
    'error'   => ['bg'=>'#fee2e2','border'=>'#C0392B','text'=>'#C0392B'],
    'warning' => ['bg'=>'#fef3c7','border'=>'#B85C00','text'=>'#B85C00'],
    'info'    => ['bg'=>'#dbeafe','border'=>'#1e40af','text'=>'#1e40af'],
];
$s = $styles[$type] ?? $styles['info'];
@endphp

<div x-data="{ show: true }" x-show="show" x-transition
    style="background:{{ $s['bg'] }}; border-left:4px solid {{ $s['border'] }}; padding:0.875rem 1rem; border-radius:0.5rem; display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
    <span style="color:{{ $s['text'] }}; font-size:0.875rem; font-weight:500;">{{ $message }}</span>
    <button @click="show=false" style="background:none; border:none; cursor:pointer; color:{{ $s['text'] }}; font-size:1.125rem; line-height:1;">&times;</button>
</div>
