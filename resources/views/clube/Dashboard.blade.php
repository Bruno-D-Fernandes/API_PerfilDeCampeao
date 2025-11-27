<x-layouts.clube title="Dashboard" :breadcrumb="[
    'Dashboard' => null,
]">
    <div class="h-full w-full flex flex-col flex-1">
        <div class="h-[1.67vw] flex gap-x-[0.42vw] items-center w-full mb-[0.83vw]">
            <span class="text-[0.83vw] font-medium text-emerald-500">
                Esporte
            </span>

            <div>
                <x-form-group :label="null" name="fe" type="select" id="fe" labelColor="green" class="!h-[1.67vw] pr-[1.67vw] !bg-white leading-none !border-2">
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw] text-emerald-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                    </x-slot:icon>

                    <option class="text-[0.83vw] font-medium text-gray-800 leading-tight">
                        Futebol
                    </option>

                    <option class="text-[0.83vw] font-medium text-gray-800 leading-tight">
                        Basquete
                    </option>

                    <option class="text-[0.83vw] font-medium text-gray-800 leading-tight">
                        Vôlei
                    </option>
                </x-form-group>
            </div>
        </div>

        <div class="flex-grow grid grid-rows-[auto_1fr] gap-[0.83vw]">
            <div class="w-full grid grid-cols-4 gap-[0.83vw]">
                <x-dashboard-widget title="Inscrições pendentes" :value="90" :trend="70">
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw] text-emerald-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>

                <x-dashboard-widget title="Oportunidades ativas" :value="7" :trend="3">
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw] text-emerald-500/70"  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone-icon lucide-megaphone"><path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"/><path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"/><path d="M8 6v8"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>

                <x-dashboard-widget title="Próximo evento" value="Treino com os manos! (14/10)">
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw] text-emerald-500/70"  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>

                <x-dashboard-widget title="Perfis salvos" :value="27" :trend="4" >
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw] text-emerald-500/70"  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>
            </div>

            <div class="flex-1 h-full">
                <div class="h-full grid grid-cols-5 gap-[0.83vw]">
                    <div class="h-full col-span-3 flex flex-col gap-[0.83vw]">
                        <div class="grid grid-cols-2 gap-[0.83vw] flex-1">
                            <div class="bg-white p-[0.83vw] rounded-[0.42vw] border border-[0.15vw] border-gray-200 hover:border-emerald-500 transition-colors flex flex-col gap-[0.415vw]">
                                <span class="text-[0.83vw] font-medium text-gray-700">
                                    Distribuição por posições
                                </span>

                                <div class="relative flex-1 min-h-0">
                                    <div id="chart-posicoes" class="absolute inset-0"></div>
                                </div>

                                <script>
                                    const cores = ['#006045', '#007a55', '#00bc7d', '#00d492', '#5ee9b5'];

                                    google.charts.load('current', { packages: ['corechart'] });
                                    google.charts.setOnLoadCallback(drawChart);

                                    function drawChart() {

                                        const data = new google.visualization.DataTable();
                                        data.addColumn('string', 'Posição');
                                        data.addColumn('number', 'Quantidade');
                                        data.addColumn({ type: 'string', role: 'tooltip', p: { html: true } });

                                        const tooltip = (titulo, qtd, cor) => `
                                            <div role="tooltip"
                                                class="absolute z-10 flex flex-col gap-y-1 px-3 py-2 text-sm font-medium text-white 
                                                    bg-stone-950 rounded-md leading-none whitespace-nowrap">
                                                
                                                <div class="flex items-center gap-x-1">
                                                    <span class="w-2.5 h-2.5 rounded-full" style="background:${cor}"></span>
                                                    <span class="font-semibold">${titulo}</span>
                                                </div>

                                                <div class="font-medium">${qtd} jogadores</div>
                                            </div>
                                        `;

                                        data.addRows([
                                            ['Meio-campo', 15, tooltip('Meio-campo', 15, cores[0])],
                                            ['Zagueiro', 12, tooltip('Zagueiro', 12, cores[1])],
                                            ['Atacante', 9, tooltip('Atacante', 9, cores[2])],
                                            ['Lateral', 8, tooltip('Lateral', 8, cores[3])],
                                            ['Goleiro', 4, tooltip('Goleiro', 4, cores[4])],
                                        ]);

                                        const options = {
                                            chartArea: { width: '60%', height: '80%' },
                                            legend: {
                                                position: 'right',
                                                textStyle: { fontSize: 12, fontName: 'Poppins' }
                                            },
                                            animation: { startup: true, duration: 800, easing: 'out' },
                                            pieHole: 0,
                                            pieSliceBorderColor: 'transparent',
                                            tooltip: { isHtml: true },
                                            colors: [...cores],
                                        };

                                        const container = document.getElementById('chart-posicoes');

                                        function draw() {
                                            const chart = new google.visualization.PieChart(container);
                                            chart.draw(data, options);
                                        }

                                        draw();
                                        window.addEventListener('resize', draw);
                                    }
                                </script>
                            </div>

                            <div class="bg-white h-full p-[0.83vw] rounded-[0.42vw] border border-[0.15vw] border-gray-200 hover:border-emerald-500 transition-colors flex flex-col gap-[0.73vw]">
                                <span class="text-[0.83vw] font-medium text-gray-700">
                                    Origem das candidaturas
                                </span>

                                <div class="relative flex-1 min-h-0">
                                    <div id="chart-origem" class="absolute inset-0"></div>
                                </div>

                                <script>
                                    const cores3 = ['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#3B82F6'];

                                    google.charts.setOnLoadCallback(drawChart);

                                    function drawChart() {
                                        const data = new google.visualization.DataTable();
                                        data.addColumn('string', 'Origem');
                                        data.addColumn('number', 'Candidaturas');
                                        data.addColumn({ type: 'string', role: 'tooltip', p: { html: true } });

                                        const tooltip = (origem, qtd, cor) => `
                                            <div role="tooltip"
                                                class="absolute z-10 flex flex-col gap-y-1 px-3 py-2 text-sm font-medium text-white 
                                                    bg-stone-950 rounded-md leading-none whitespace-nowrap">

                                                <div class="flex items-center gap-x-1">
                                                    <span class="w-2.5 h-2.5 rounded-full" style="background: ${cor}"></span>
                                                    <span class="font-semibold">${origem}</span>
                                                </div>

                                                <div class="font-medium">${qtd} candidaturas</div>
                                            </div>
                                        `;

                                        const origens = ['SP', 'MG', 'RJ', 'BA', 'PR'];
                                        const valores = [120, 80, 65, 50, 30];

                                        data.addRows(
                                            origens.map((o, i) => [
                                                o,
                                                valores[i],
                                                tooltip(o, valores[i], cores3[1])
                                            ])
                                        );

                                        const options = {
                                            chartArea: { width: '85%', height: '70%' },
                                            legend: { position: 'none' },
                                            animation: { startup: true, duration: 800, easing: 'out' },

                                            tooltip: { isHtml: true },

                                            colors: [cores3[1]],

                                            bar: { groupWidth: '65%' },

                                            hAxis: {
                                                textStyle: { fontSize: 12, fontName: 'Poppins' },
                                                gridlines: { color: '#e5e7eb' }
                                            },

                                            vAxis: {
                                                textStyle: { fontSize: 12, fontName: 'Poppins' }
                                            }
                                        };

                                        const container = document.getElementById('chart-origem');

                                        function draw() {
                                            const chart = new google.visualization.ColumnChart(container);
                                            chart.draw(data, options);
                                        }

                                        draw();
                                        window.addEventListener('resize', draw);
                                    }
                                </script>
                            </div>
                        </div>

                        <div class="flex-1">
                            <div class="bg-white h-full p-[0.83vw] rounded-[0.42vw] border border-[0.15vw] border-gray-200 hover:border-emerald-500 transition-colors flex flex-col gap-[0.73vw]">
                                <span class="text-[0.83vw] font-medium text-gray-700">
                                    Evolução de candidaturas
                                </span>

                                <div class="relative flex-1 min-h-0">
                                    <div id="chart-evolucao" class="absolute inset-0"></div>
                                </div>

                                <script>
                                    const cor = '#10B981';

                                    google.charts.setOnLoadCallback(drawChart);

                                    function drawChart() {
                                        const data = new google.visualization.DataTable();
                                        data.addColumn('string', 'Mês');
                                        data.addColumn('number', 'Candidaturas');
                                        data.addColumn({ type: 'string', role: 'tooltip', p: { html: true } });

                                        const tooltip = (mes, qtd, cor) => `
                                            <div role="tooltip"
                                                class="absolute z-10 flex flex-col gap-y-1 px-3 py-2 text-sm font-medium text-white 
                                                    bg-stone-950 rounded-md leading-none whitespace-nowrap">

                                                <div class="flex items-center gap-x-1">
                                                    <span class="w-2.5 h-2.5 rounded-full" style="background: ${cor}"></span>
                                                    <span class="font-semibold">${mes}</span>
                                                </div>

                                                <div class="font-medium">${qtd} candidaturas</div>
                                            </div>
                                        `;

                                        const meses = ['Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov'];
                                        const valores = [12, 18, 23, 19, 27, 31];

                                        data.addRows(
                                            meses.map((m, i) => [
                                                m,
                                                valores[i],
                                                tooltip(m, valores[i], cor)
                                            ])
                                        );

                                        const options = {
                                            chartArea: { width: '95%', height: '70%' },
                                            legend: { position: 'none' },
                                            animation: { startup: true, duration: 800, easing: 'out' },
                                            tooltip: { isHtml: true },

                                            colors: [cor],
                                            lineWidth: 3,
                                            pointSize: 7,
                                            pointShape: 'circle',
                                            curveType: 'function',
                                            series: {
                                                0: {
                                                    areaOpacity: 0.2
                                                }
                                            },

                                            hAxis: {
                                                textStyle: { fontSize: 12, fontName: 'Poppins' },
                                                slantedText: false,
                                                showTextEvery: 1,
                                                gridlines: { color: '#e5e7eb' }
                                            },
                                            vAxis: {
                                                textStyle: { fontSize: 12, fontName: 'Poppins' },
                                                gridlines: { color: '#e5e7eb' }
                                            }
                                        };

                                        const container = document.getElementById('chart-evolucao');

                                        function draw() {
                                            const chart = new google.visualization.LineChart(container);
                                            chart.draw(data, options);
                                        }

                                        draw();
                                        window.addEventListener('resize', draw);
                                    }
                                </script>
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col">
                            <div class="bg-white h-full p-[0.83vw] rounded-[0.42vw] border border-[0.15vw] border-gray-200 hover:border-emerald-500 transition-colors">
                                <span class="text-[0.83vw] font-medium text-gray-700">
                                    Atividades recentes
                                </span>
                            </div>
                        </div>

                    </div>

                    <div class="h-full col-span-2 flex flex-col gap-[0.83vw]">
                        <div class="bg-white p-[0.83vw] rounded-[0.42vw] border border-[0.15vw] border-gray-200 hover:border-emerald-500 transition-colors flex flex-col gap-[0.63vw]">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-x-[0.42vw]">
                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days-icon lucide-calendar-days"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>

                                    <span class="text-[0.83vw] font-medium text-gray-700">
                                        Próximo evento
                                    </span>
                                </div>

                                <div class="relative cursor-pointer h-[1.04vw] w-[1.04vw] rounded-full bg-red-500">
                                
                                </div>
                            </div>

                            <div class="w-full border border-t-[0.052vw] border-gray-200"></div>

                            <div class="flex flex-col gap-[0.42vw]">
                                <div class="flex flex-col gap-[0.31vw]">
                                    <h2 class="text-[1.04vw] font-medium tracking-tight text-gray-800">
                                        A volta daqueles que não foram
                                    </h2>
                                    
                                    <h3 class="text-[0.83vw] font-normal text-gray-700">
                                        O evento que reúne metade da ETEC de Guaianazes para todos darem a vida!
                                    </h3>
                                </div> 
                                
                                <div class="flex items-center gap-x-[0.42vw]">
                                    <svg class="h-[0.83vw] w-[0.83vw] text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>

                                    <span class="text-[0.73vw] font-medium text-gray-500 truncate">
                                        11/11 - 14h até 12/11 - 18h
                                    </span>
                                </div>

                                <div class="flex items-center gap-x-[0.42vw]">
                                    <svg class="h-[0.83vw] w-[0.83vw] text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-icon lucide-map-pin"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>

                                    <span class="block text-[0.73vw] font-medium text-gray-500 truncate">
                                        R. Feliciano de Mendonça, 290 - Guaianases, São Paulo - SP, 08460-365
                                    </span>
                                </div>

                                <div>
                                    <x-progress 
                                        :percentage="70" 
                                        :showValue="true" 
                                        color="green" 
                                    />
                                </div>

                                <x-button color="clube" :full="true" class="mt-[0.21vw]">
                                    Ver agenda
                                </x-button>
                            </div>
                        </div>

                        <div class="bg-white flex-1 p-[0.83vw] rounded-[0.42vw] border border-[0.15vw] border-gray-200 hover:border-emerald-500 transition-colors flex flex-col gap-[0.63vw]">
                            <div class="flex items-center gap-x-[0.42vw]">
                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hourglass-icon lucide-hourglass"><path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"/><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"/></svg>

                                <span class="text-[0.83vw] font-medium text-gray-700">
                                    Inscrições pendentes
                                </span>
                            </div>

                            <div class="w-full border border-t-[0.052vw] border-gray-200"></div>

                            <div class="flex flex-col gap-[0.42vw] overflow-y-auto h-full">
                                @foreach([1, 2, 3, 4, 5] as $num)
                                    <div class="flex flex-1 items-center justify-between">
                                        <div class="flex items-center gap-x-[0.63vw]">
                                            <div class="h-[1.6vw] border border-l border-[0.16vw] border-gray-200 rounded-[0.31vw]"></div>

                                            <span class="text-[0.83vw] font-medium text-gray-700">
                                                João Pedro
                                            </span>

                                            <a href="" class="text-[0.73vw] font-semibold tracking-tight text-emerald-500 hover:text-emerald-600 underline transition-colors">
                                                Oportunidade
                                            </a>
                                        </div>

                                        <div class="flex items-center gap-x-[0.42vw]">
                                            <x-icon-button color="red">
                                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                            </x-icon-button>
                                        
                                            <div class="w-[0.052vw] h-[0.83vw] bg-gray-200"></div>

                                            <x-icon-button color="green">
                                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                                            </x-icon-button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.clube>