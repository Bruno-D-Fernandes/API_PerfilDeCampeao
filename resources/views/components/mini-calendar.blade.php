<div 
    id="mc-root"
    class="{{ $attributes->get('class') }}"
    data-current-month="{{ $date->month }}" 
    data-current-year="{{ $date->year }}"
    data-selected="{{ $highlight ? $highlight->format('Y-m-d') : '' }}"
>
    <div class="flex items-center justify-between mb-[0.42vw]">
        <span id="mc-label" class="text-[0.75vw] font-bold text-gray-800 uppercase tracking-wide">
            {{ $date->translatedFormat('F Y') }}
        </span>
        
        <div class="flex gap-[0.1vw]">
            <button type="button" onclick="mcChangeMonth(-1)" class="cursor-pointer p-[0.31vw] hover:bg-gray-100 rounded-[0.21vw] text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-[0.75vw] h-[0.75vw] stroke-[0.1vw]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>

            <button type="button" onclick="mcChangeMonth(1)" class="cursor-pointer p-[0.31vw] hover:bg-gray-100 rounded-[0.21vw] text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-[0.75vw] h-[0.75vw] stroke-[0.1vw]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>
    
    <div class="grid grid-cols-7 text-center gap-y-[0.42vw] text-[0.55vw] font-bold text-gray-400 mb-[0.21vw]">
        @foreach(['D', 'S', 'T', 'Q', 'Q', 'S', 'S'] as $dia)
            <span>{{ $dia }}</span>
        @endforeach
    </div>
    
    <div id="mc-grid" class="grid grid-cols-7 text-center gap-y-[0.42vw] text-[0.75vw] font-medium text-gray-600">
        @for($i = 0; $i < $startDayOfWeek; $i++)
            <span class="p-[0.1vw]"></span>
        @endfor
        
        @for($day = 1; $day <= $daysInMonth; $day++)
            @php
                $fullDate = $date->copy()->day($day)->format('Y-m-d');
                $isSel = $isSelected($day);
            @endphp

            <button 
                type="button"
                onclick="mcSelectDate('{{ $fullDate }}')"
                class="text-[0.6vw] cursor-pointer w-[1.5vw] h-[1.5vw] mx-auto flex items-center justify-center rounded-[0.31vw] transition-colors {{ $isSel ? 'bg-emerald-500 text-white' : 'hover:bg-gray-100' }}"
            >
                {{ $day }}
            </button>
        @endfor

    </div>
</div>

@push('scripts')
    @once
    <script>
        const mcState = {
            month: 0,
            year: 0,
            selectedDate: null
        };

        document.addEventListener('DOMContentLoaded', () => {
            const root = document.getElementById('mc-root');

            if(root) {
                mcState.month = parseInt(root.dataset.currentMonth) - 1;
                mcState.year = parseInt(root.dataset.currentYear);
                mcState.selectedDate = root.dataset.selected; 
            }
        });

        function mcChangeMonth(direction) {
            mcState.month += direction;

            if (mcState.month > 11) {
                mcState.month = 0;
                mcState.year++;
            } else if (mcState.month < 0) {
                mcState.month = 11;
                mcState.year--;
            }

            mcRender();
        }

        function mcSelectDate(dateString) {
            mcState.selectedDate = dateString;
            
            mcRender();

            window.dispatchEvent(new CustomEvent('mini-calendar-change', { 
                detail: { date: dateString } 
            }));

            if (typeof window.selectDate === 'function') {
                window.selectDate(dateString);
            }
        }

        function mcRender() {
            const grid = document.getElementById('mc-grid');
            const label = document.getElementById('mc-label');
            
            grid.innerHTML = '';

            const firstDay = new Date(mcState.year, mcState.month, 1);
            const daysInMonth = new Date(mcState.year, mcState.month + 1, 0).getDate();
            const startDayOfWeek = firstDay.getDay();

            const monthName = new Intl.DateTimeFormat('pt-BR', { month: 'long' }).format(firstDay);
            const monthNameCap = monthName.charAt(0).toUpperCase() + monthName.slice(1);
            label.innerText = `${monthNameCap} ${mcState.year}`;

            for (let i = 0; i < startDayOfWeek; i++) {
                const span = document.createElement('span');
                span.className = 'p-[0.21vw]';
                grid.appendChild(span);
            }

            for (let d = 1; d <= daysInMonth; d++) {
                const btn = document.createElement('button');
                const loopDate = `${mcState.year}-${String(mcState.month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
                
                btn.innerText = d;
                btn.type = 'button';
                
                let classes = "text-[0.6vw] cursor-pointer w-[1.5vw] h-[1.5vw] mx-auto flex items-center justify-center rounded-[0.31vw] transition-colors ";
                
                if (loopDate === mcState.selectedDate) {
                    classes += "bg-emerald-500 text-white";
                } else {
                    classes += "hover:bg-gray-100 text-gray-600";
                }
                
                btn.className = classes;

                btn.onclick = () => mcSelectDate(loopDate);
                
                grid.appendChild(btn);
            }
        }
    </script>
    @endonce
@endpush