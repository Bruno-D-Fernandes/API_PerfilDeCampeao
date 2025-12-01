<div 
    id="mc-root"
    class="{{ $attributes->get('class') }}"
    data-current-month="{{ $date->month }}" 
    data-current-year="{{ $date->year }}"
    data-selected="{{ $highlight ? $highlight->format('Y-m-d') : '' }}"
    data-route="{{ route('clube.ajax.calendar') }}"
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
    
    <div id="mc-grid" class="grid grid-cols-7 gap-y-[0.42vw] text-[0.75vw] font-medium text-gray-600">

    </div>
</div>

<script>
    const mcState = {
        month: 0,
        year: 0,
        selectedDate: null,
        events: @json($events) || {},
        route: null,    
        isLoading: false
    };

    document.addEventListener('DOMContentLoaded', () => {
        const root = document.getElementById('mc-root');

        if (root) {
            mcState.month = parseInt(root.dataset.currentMonth) - 1;
            mcState.year = parseInt(root.dataset.currentYear);
            mcState.selectedDate = root.dataset.selected; 
            mcState.route = root.dataset.route; 
        }
        
        mcRender();
    });

    window.updateMiniCalendarData = function(newEvents) {
        mcState.events = newEvents || {};
        mcRender(); 
    }

    window.updateMiniCalendar = function(dateStr, shouldSelect = true) {
        const [y, m, d] = dateStr.split('-').map(Number);
        
        if (mcState.year !== y || mcState.month !== (m - 1)) {
            mcState.year = y;
            mcState.month = m - 1;
        }

        if (shouldSelect) {
            mcState.selectedDate = dateStr;
        }
        
        mcRender();
    }

    async function mcChangeMonth(direction) {
        if (mcState.isLoading) return;

        mcState.month += direction;

        if (mcState.month > 11) {
            mcState.month = 0;
            mcState.year++;
        } else if (mcState.month < 0) {
            mcState.month = 11;
            mcState.year--;
        }

        mcRender();
        await mcFetchEvents();
    }

    async function mcFetchEvents() {
        if (!mcState.route) return;

        mcState.isLoading = true;

        const grid = document.getElementById('mc-grid');

        if (grid) grid.style.opacity = '0.5'; 

        try {
            const currentMonthStr = String(mcState.month + 1).padStart(2, '0');
            const paramDate = `${mcState.year}-${currentMonthStr}`;

            const url = `${mcState.route}?month=${paramDate}`;
            
            const response = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (response.ok) {
                const data = await response.json();
                
                if (data.calendarData) {
                    mcState.events = data.calendarData;
                    mcRender();
                }
            }
        } catch (error) {
            console.error("Erro ao buscar eventos do mini calendário:", error);
        } finally {
            mcState.isLoading = false;
            if(grid) grid.style.opacity = '1';
        }
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
        
        if (!grid) return;

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
            
            const currentMonthStr = String(mcState.month + 1).padStart(2, '0');
            const currentDayStr = String(d).padStart(2, '0');
            const loopDate = `${mcState.year}-${currentMonthStr}-${currentDayStr}`;
            
            btn.innerText = d;
            btn.type = 'button';
            
            let classes = "relative justify-self-center text-[0.6vw] cursor-pointer w-[1.5vw] h-[1.5vw] flex items-center justify-center rounded-[0.31vw] transition-colors ";
            
            const isSelected = (loopDate === mcState.selectedDate);

            if (isSelected) {
                classes += "bg-emerald-500 text-white font-bold";
            } else {
                classes += "hover:bg-gray-100 text-gray-600 font-medium";
            }
            
            btn.className = classes;
            btn.onclick = () => mcSelectDate(loopDate);

            if (mcState.events && mcState.events[loopDate] && mcState.events[loopDate].length > 0) {
                const indicatorsContainer = document.createElement('div');
                indicatorsContainer.className = "absolute bottom-[0.15vw] right-[0.15vw] flex gap-[0.05vw] pointer-events-none z-10";
                
                const dayEvents = mcState.events[loopDate].slice(0, 1);
                
                const dotColorClass = isSelected ? 'bg-white' : 'bg-emerald-500';

                dayEvents.forEach(evt => {
                    const dot = document.createElement('span');
                    dot.className = `w-[0.25vw] h-[0.25vw] rounded-full ${dotColorClass}`;
                    indicatorsContainer.appendChild(dot);
                });

                btn.appendChild(indicatorsContainer);
            }
            
            grid.appendChild(btn);
        }
    }
</script>