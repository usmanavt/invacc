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
    type="number"
    id="{{ $name }}"
    name="{{ $name }}"
    pattern="\d{1}|\d{8,3}"
    title="must be 1 or 8 digit"
    onkeypress="return isNumberKey(event)"
    step=".001"
    value="0"
    >


@push('scripts')
<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode != 46 && charCode > 31
        && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>
@endpush
