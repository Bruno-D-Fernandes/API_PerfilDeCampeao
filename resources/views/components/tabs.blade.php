<div class="w-full">
    <div class="border-b-[0.052vw] border-gray-200">
        <ul class="flex flex-wrap -mb-[0.052vw] text-[0.73vw] font-medium text-center">
            @foreach($options as $key => $label)
                <li class="me-[0.42vw]">
                    <button 
                        type="button"
                        id="tab-btn-{{ $key }}"
                        onclick="switchTab('{{ $key }}')"
                        class="tab-button cursor-pointer inline-flex items-center justify-center p-[0.83vw] border-b-[0.1vw] rounded-t-[0.42vw] transition-all duration-100 gap-[0.42vw] 
                        {{ $key === $default ? 'text-emerald-500 border-emerald-500 active' : 'text-gray-500 border-transparent hover:text-gray-600 hover:border-gray-300' }}"
                    >
                        @if(isset(${'icon_'.$key}))
                            <span id="tab-icon-{{ $key }}" class="{{ $key === $default ? 'text-emerald-500' : 'text-gray-400' }}">
                                {{ ${'icon_'.$key} }}
                            </span>
                        @endif

                        {{ $label }}
                    </button>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="mt-[1.25vw]">
        @foreach($options as $key => $label)
            <div id="tab-content-{{ $key }}" class="tab-content {{ $key === $default ? '' : 'hidden' }}">
                {{ $$key ?? '' }} 
            </div>
        @endforeach
    </div>

</div>

@once
<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(el => {
            el.classList.add('hidden');
        });

        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('text-emerald-500', 'border-emerald-500', 'active');
            btn.classList.add('text-gray-500', 'border-transparent');
            
            const icon = btn.querySelector('span');

            if (icon) {
                icon.classList.remove('text-emerald-500');
                icon.classList.add('text-gray-400');
            }
        });

        document.getElementById('tab-content-' + tabId).classList.remove('hidden');

        const activeBtn = document.getElementById('tab-btn-' + tabId);
        activeBtn.classList.remove('text-gray-500', 'border-transparent');
        activeBtn.classList.add('text-emerald-500', 'border-emerald-500', 'active');

        const activeIcon = document.getElementById('tab-icon-' + tabId);
        
        if (activeIcon) {
            activeIcon.classList.remove('text-gray-400');
            activeIcon.classList.add('text-emerald-500');
        }
    }
</script>
@endonce