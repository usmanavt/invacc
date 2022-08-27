<div class="px-4 py-2">
    <form action="{{ $slot }}" method="get">
        <x-input id="search" class="block mt-1 w-full" type="search" name="search" :value="old('search')" autofocus placeholder="search database" />
    </form>
</div>

