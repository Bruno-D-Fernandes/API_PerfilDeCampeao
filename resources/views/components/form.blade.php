<form {{ $attributes }}>
    <div class="w-full flex flex-col gap-[0.83vw]">
        {{ $slot }}
    </div>

    @if(isset($actions))
        <div class="flex items-start justify-end gap-x-[0.83vw]">
            {{ $actions }}
        </div>
    @endif

    @if(isset($link))
        {{ $link }}
    @endif
</form>