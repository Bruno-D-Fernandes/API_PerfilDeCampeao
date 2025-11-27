<x-layouts.admin title="Dashboard" :breadcrumb="[
    'Dashboard' => null,
]">
    <div class="h-full w-full flex flex-col">
        <div class="flex-grow grid grid-rows-[auto_1fr] gap-4">
            <div class="w-full grid grid-cols-4 gap-4">
                <x-dashboard-widget title="Atletas cadastrados" :value="90" :trend="70" iconColor="text-sky-500/70">
                    <x-slot:icon>
                        <svg class="h-4 w-4 text-sky-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>

                <x-dashboard-widget title="Clubes ativos" :value="7" :trend="3" iconColor="text-sky-500/70">
                    <x-slot:icon>
                        <svg class="h-4 w-4 text-sky-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-icon lucide-building"><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M12 6h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/><path d="M8 6h.01"/><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect x="4" y="2" width="16" height="20" rx="2"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>

                <x-dashboard-widget title="Oportunidades ativas" :value="21" :trend="2" iconColor="text-sky-500/70">
                    <x-slot:icon>
                        <svg class="h-4 w-4 text-sky-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone-icon lucide-megaphone"><path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"/><path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"/><path d="M8 6v8"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>

                <x-dashboard-widget title="Inscrições realizadas" :value="12" :trend="2" iconColor="text-sky-500/70">
                    <x-slot:icon>
                        <svg class="h-4 w-4 text-sky-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-icon lucide-file"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/></svg>
                    </x-slot:icon>
                </x-dashboard-widget>
            </div>

            <div class="flex-1 h-full">
                <div class="h-full grid grid-cols-20 gap-4">
                    <div class="h-full col-span-6 flex flex-col gap-4">
                        <div class="bg-white p-4 rounded-lg border border-2 border-gray-200 hover:border-sky-500 transition-colors flex-1 flex flex-col gap-[0.415vw]">
                            <span class="text-[0.83vw] font-medium text-gray-700">
                                Crescimento de usuários
                            </span>

                            <div class="relative flex-1 min-h-0">
                                <div id="chart-evolucao" class="absolute inset-0"></div>
                            </div>

                            <script>
                                const cor = '#00a6f4';

                                google.charts.load('current', { packages: ['corechart'] });
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
                                        chartArea: { width: '85%', height: '80%' },
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

                        <div class="bg-white p-4 rounded-lg border border-2 border-gray-200 hover:border-sky-500 transition-colors flex-1 flex flex-col gap-[0.415vw]">
                            <span class="text-[0.83vw] font-medium text-gray-700">
                                Evolução de candidaturas
                            </span>

                            <div class="relative flex-1 min-h-0">
                                <div id="chart-candidaturas" class="absolute inset-0"></div>
                            </div>

                            <script>
                                const cor2 = '#00a6f4';

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
                                    const valores = [45, 60, 75, 70, 85, 95]; 

                                    data.addRows(
                                        meses.map((m, i) => [
                                            m,
                                            valores[i],
                                            tooltip(m, valores[i], cor2)
                                        ])
                                    );

                                    const options = {
                                        chartArea: { width: '85%', height: '70%' },
                                        legend: { position: 'none' },
                                        animation: { startup: true, duration: 800, easing: 'out' },

                                        tooltip: { isHtml: true },

                                        colors: [cor2],

                                        bar: { groupWidth: '65%' },

                                        hAxis: {
                                            textStyle: { fontSize: 12, fontName: 'Poppins' },
                                            gridlines: { color: '#e5e7eb' }
                                        },

                                        vAxis: {
                                            textStyle: { fontSize: 12, fontName: 'Poppins' }
                                        }
                                    };

                                    const container = document.getElementById('chart-candidaturas');

                                    function draw() {
                                        const chart = new google.visualization.ColumnChart(container);
                                        chart.draw(data, options);
                                    }

                                    draw();
                                    window.addEventListener('resize', draw);
                                }
                            </script>
                        </div>

                        <div>
                            <div class="bg-white p-4 rounded-lg border border-2 border-gray-200 hover:border-sky-500 transition-colors flex-1">
                                <span class="text-md font-medium text-gray-700">
                                    Novos cadastros
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6 flex flex-col gap-4 flex-1 h-full">
                        <div class="bg-white p-[0.83vw] rounded-[0.42vw] border border-[0.15vw] border-gray-200 hover:border-sky-500 transition-colors flex flex-col gap-[0.415vw] flex-1">
                            <span class="text-[0.83vw] font-medium text-gray-700">
                                Distribuição de oportunidades
                            </span>

                            <div class="relative flex-1 min-h-0">
                                <div id="chart-oportunidades" class="absolute inset-0"></div>
                            </div>

                            <script>
                                const cores = ['#00598a', '#0069a8', '#0084d1', '#00a6f4', '#00bcff'];

                                let dadosEsportes = [
                                    ['Futebol', 30],
                                    ['Basquete', 25],
                                    ['Vôlei', 18],
                                    ['Natação', 10],
                                    ['Tênis', 5],
                                ];

                                dadosEsportes.sort((a, b) => b[1] - a[1]); 

                                google.charts.load('current', { packages: ['corechart'] });
                                google.charts.setOnLoadCallback(drawChart);

                                function drawChart() {

                                    const data = new google.visualization.DataTable();
                                    data.addColumn('string', 'Esporte'); 
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

                                            <div class="font-medium">${qtd} oportunidades</div>
                                        </div>
                                    `;

                                    const linhasComTooltip = dadosEsportes.map((item, index) => [
                                        item[0], 
                                        item[1], 
                                        tooltip(item[0], item[1], cores[index % cores.length])
                                    ]);

                                    data.addRows(linhasComTooltip);

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

                                    const container = document.getElementById('chart-oportunidades');

                                    function draw() {
                                        const chart = new google.visualization.PieChart(container);
                                        chart.draw(data, options);
                                    }

                                    draw();
                                    window.addEventListener('resize', draw);
                                }
                            </script>
                        </div>

                        <div class="bg-white p-4 rounded-lg border border-2 border-gray-200 hover:border-sky-500 transition-colors flex-1">
                            <span class="text-md font-medium text-gray-700">
                                Oportunidades populares
                            </span>
                        </div>

                        <div class="bg-white p-4 rounded-lg border border-2 border-gray-200 hover:border-sky-500 transition-colors flex-1">
                            <span class="text-md font-medium text-gray-700">
                                Clubes mais ativos
                            </span>
                        </div>
                    </div>

                    <div class="col-span-8 flex flex-col gap-4">
                        <div class="bg-white p-4 rounded-lg border border-2 border-gray-200 hover:border-sky-500 transition-colors flex-1">
                            <span class="text-md font-medium text-gray-700">
                                Atividades recentes
                            </span>
                        </div>

                        <div class="bg-white h-max p-4 rounded-lg border border-2 border-gray-200 hover:border-sky-500 transition-colors flex flex-col gap-3 flex-1">
                            <div class="flex items-center gap-x-2">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hourglass-icon lucide-hourglass"><path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"/><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"/></svg>

                                <span class="text-md font-medium text-gray-700">
                                    Oportunidades pendentes
                                </span>
                            </div>

                            <div class="w-full border border-t border-gray-200"></div>

                            <div class="flex flex-col gap-2 overflow-y-auto h-full">
                                @foreach([1, 2, 3, 4, 5] as $num)
                                    <div class="flex flex-1 items-center justify-between">
                                        <div class="flex items-center gap-x-3">
                                            <div class="h-[1.6vw] border border-l border-3 border-gray-200 hover:border-sky-500 transition-colors rounded-md"></div>

                                            <span class="text-md font-medium text-gray-700">
                                                Vasco da Gama
                                            </span>

                                            <a href="" class="text-sm font-semibold tracking-tight text-sky-500 hover:text-sky-600 underline transition-colors">
                                                Oportunidade
                                            </a>
                                        </div>

                                        <div class="flex items-center gap-x-2">
                                            <x-icon-button color="red">
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                            </x-icon-button>
                                    
                                            <div class="w-px h-4 bg-gray-200"></div>

                                            <x-icon-button color="green">
                                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
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
</x-layouts.admin>