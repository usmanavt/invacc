@props(['disabled' => false , 'req' => false , 'name' => $name , 'title' => $title])

@php
$classes = ($disabled ?? true)
            ? 'text-white':''
@endphp

<label
    for="{{ $name }}">
    {{ $title }}
    {!! $req ?
     '<span class="text-red-500 font-semibold">(*)</span>'
    :'' !!}
</label>
<input
    {{ $disabled ? 'disabled':''}}
    {{ $attributes->merge(['class' => $classes])}}
    type="date"
    value="{{ date('Y-m-d') }}"
    id="{{ $name }}"
    name="{{ $name }}"
    >
