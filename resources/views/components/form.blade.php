<form {{ $attributes }}>
    <div class="w-full flex flex-col gap-4">
        {{ $slot }}
    </div>

    @if(isset($actions))
        <div class="flex items-start justify-end gap-x-4">
            {{ $actions }}
        </div>
    @endif

    @if(isset($link))
        {{ $link }}
    @endif
</form>