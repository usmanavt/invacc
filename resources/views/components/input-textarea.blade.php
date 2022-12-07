@props(['disabled' => false ,'req' => false, 'name' => $name , 'title' => $title])

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
<textarea
    id="{{ $name }}"
    name="{{ $name }}"
    rows="5"
    columns="5"
    >
</textarea>
