<x-layouts.admin title="Dashboard" :breadcrumb="[
    'Dashboard' => null,
]">
    <div class="h-full w-full flex flex-col">
        <div class="flex-grow grid grid-rows-[auto_1fr] gap-[0.83vw]">
            <div class="w-full grid grid-cols-4 gap-[0.83vw]">
                @php
                    $dict = [
                        'atletas_mes' => 'Atletas totais', 
                        'clubes_ativos' => 'Clubes ativos', 
                        'oportunidades_ativas' => 'Oportunidades ativas', 
                        'inscricoes_totais' => 'Inscrições totais'
                    ];

                    $icons = [
                        'atletas_mes' => '<svg class="h-[0.83vw] w-[0.83vw] text-sky-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>',
                        'clubes_ativos' => '<svg class="h-[0.83vw] w-[0.83vw] text-sky-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-icon lucide-building"><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M12 6h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/><path d="M8 6h.01"/><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect x="4" y="2" width="16" height="20" rx="2"/></svg>',
                        'oportunidades_ativas' => '<svg class="h-[0.83vw] w-[0.83vw] text-sky-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone-icon lucide-megaphone"><path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"/><path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"/><path d="M8 6v8"/></svg>',
                        'inscricoes_totais' => '<svg class="h-[0.83vw] w-[0.83vw] text-sky-500/70" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-icon lucide-file"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/></svg>',
                    ];
                @endphp

                @foreach($resumo as $key => $item)
                    @php
                        $value = $item['total'];
                        $trend = $item['diferenca'];
                    @endphp

                    <x-dashboard-widget 
                        :title="$dict[$key]" 
                        :value="$value" 
                        :trend="$trend"
                        iconColor="text-sky-500/70"
                    >
                        <x-slot:icon>
                            {!! $icons[$key] !!}
                        </x-slot:icon>
                    </x-dashboard-widget>
                @endforeach
            </div>

            <div class="flex-1 h-full">
                <div class="h-full grid grid-cols-20 gap-[0.83vw]">
                    <div class="h-full col-span-8 flex flex-col gap-[0.83vw]">
                        <div class="bg-white p-[0.83vw] rounded-lg border border-[0.15vw] border-gray-200 hover:border-sky-500 transition-colors flex-[6] flex flex-col gap-[0.415vw]">
                            <span class="text-[0.83vw] font-medium text-gray-700">
                                Crescimento de usuários
                            </span>

                            <div class="relative flex-1 min-h-0">
                                <div id="chart-evolucao" class="absolute inset-0"></div>
                            </div>

                            <script>
                                const dadosUsuarios = @json($graficoUsuarios);

                                console.log(dadosUsuarios.length);

                                const cor = '#00a6f4';

                                google.charts.load('current', { packages: ['corechart'] });
                                google.charts.setOnLoadCallback(drawChart);

                                function drawChart() {
                                    const data = new google.visualization.DataTable();
                                    data.addColumn('string', 'Mês');
                                    data.addColumn('number', 'Usuários');
                                    data.addColumn({ type: 'string', role: 'tooltip', p: { html: true } });

                                    const tooltip = (mes, qtd, cor) => `
                                        <div role="tooltip"
                                            class="absolute z-10 flex flex-col gap-y-[0.21vw] px-[0.63vw] py-[0.42vw] text-[0.73vw] font-medium text-white 
                                                bg-stone-950 rounded-md leading-none whitespace-nowrap">

                                            <div class="flex items-center gap-x-[0.21vw]">
                                                <span class="w-[0.52vw] h-[0.52vw] rounded-full" style="background: ${cor}"></span>
                                                <span class="font-semibold">${mes}</span>
                                            </div>

                                            <div class="font-medium">${qtd} candidaturas</div>
                                        </div>
                                    `;

                                    data.addRows(
                                        dadosUsuarios.map((item, i) => [
                                            item.rotulo,
                                            item.total,
                                            tooltip(item.rotulo, item.total, cor)
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

                        <div class="bg-white p-[0.83vw] rounded-lg border border-[0.15vw] border-gray-200 hover:border-sky-500 transition-colors flex-[6] flex flex-col gap-[0.415vw]">
                            <span class="text-[0.83vw] font-medium text-gray-700">
                                Evolução de candidaturas
                            </span>

                            <div class="relative flex-1 min-h-0">
                                <div id="chart-candidaturas" class="absolute inset-0"></div>
                            </div>

                            <script>
                                const dadosInscricoes = @json($graficoInscricoes);

                                const cor2 = '#00a6f4';

                                google.charts.setOnLoadCallback(drawChart);

                                function drawChart() {
                                    const data = new google.visualization.DataTable();

                                    data.addColumn('string', 'Mês'); 
                                    data.addColumn('number', 'Candidaturas');
                                    data.addColumn({ type: 'string', role: 'tooltip', p: { html: true } });

                                    const tooltip = (mes, qtd, cor) => `
                                        <div role="tooltip"
                                            class="absolute z-10 flex flex-col gap-y-[0.21vw] px-[0.63vw] py-[0.42vw] text-[0.73vw] font-medium text-white 
                                                bg-stone-950 rounded-md leading-none whitespace-nowrap">

                                            <div class="flex items-center gap-x-[0.21vw]">
                                                <span class="w-[0.52vw] h-[0.52vw] rounded-full" style="background: ${cor}"></span>
                                                <span class="font-semibold">${mes}</span>
                                            </div>

                                            <div class="font-medium">${qtd} candidaturas</div>
                                        </div>
                                    `;

                                    data.addRows(
                                        dadosInscricoes.map((item, i) => [
                                            item.rotulo,
                                            item.total,
                                            tooltip(item.rotulo, item.total, cor2)
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

                        <div class="w-full bg-white p-[0.83vw] rounded-lg border border-[0.15vw] border-gray-200 hover:border-sky-500 transition-colors flex flex-col gap-[0.415vw] flex-[4]">
                            <span class="text-[0.83vw] font-medium text-gray-700">
                                Novos usuários
                            </span>

                            @php
                                $userIcon = '<svg class="h-[0.83vw] w-[0.83vw] text-sky-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>';
                            @endphp

                            <div class="w-full flex flex-col gap-[0.42vw] overflow-y-auto h-full">
                                @forelse($listaUsuarios as $usuario)
                                    <div class="flex items-center gap-x-[0.63vw] p-[0.42vw] border-b border-gray-100 last:border-b-0 group">
                                        
                                        <div class="flex-shrink-0 bg-sky-50 p-[0.42vw] rounded-full group-hover:bg-sky-100 transition-colors">
                                            {!! $userIcon !!}
                                        </div>

                                        <div class="w-full flex-1 min-w-0 flex flex-col">
                                            <p class="text-[0.73vw] font-medium text-gray-700 truncate" title="{{ $usuario->nomeCompletoUsuario }}">
                                                {{ $usuario->nomeCompletoUsuario }}
                                            </p>

                                            <p class="text-[0.63vw] text-gray-500 truncate" title="{{ $usuario->emailUsuario }}">
                                                {{ $usuario->emailUsuario }}
                                            </p>
                                        </div>

                                        <div class="flex-shrink-0">
                                            <span class="text-[0.63vw] text-gray-400 whitespace-nowrap">
                                                {{ $usuario->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-[0.42vw] flex items-center justify-center h-full">
                                        <x-empty-state text="Nenhum cadastro recente.">
                                            <x-slot:icon>
                                                <svg class="h-[1.67vw] w-[1.67vw] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-x-icon lucide-user-x"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="17" x2="22" y1="8" y2="13"/><line x1="22" x2="17" y1="8" y2="13"/></svg>
                                            </x-slot:icon>
                                            <p class="text-gray-400 font-normal text-[0.83vw]">
                                                Não houveram novos registros na plataforma recentemente.
                                            </p>
                                        </x-empty-state>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6 flex flex-col gap-[0.83vw] flex-1 h-full">
                        <div class="bg-white p-[0.83vw] rounded-[0.42vw] border border-[0.15vw] border-gray-200 hover:border-sky-500 transition-colors flex flex-col gap-[0.415vw] flex-1">
                            <span class="text-[0.83vw] font-medium text-gray-700">
                                Distribuição de oportunidades
                            </span>

                            <div class="relative flex-1 min-h-0">
                                <div id="chart-oportunidades" class="absolute inset-0"></div>
                            </div>

                            <script>
                                function hexToRgb(hex) {
                                    hex = hex.replace(/^#/, '');

                                    if (hex.length === 3) {
                                        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
                                    }

                                    const bigint = parseInt(hex, 16);
                                    return {
                                        r: (bigint >> 16) & 255,
                                        g: (bigint >> 8) & 255,
                                        b: bigint & 255
                                    };
                                }

                                function rgbToHex(r, g, b) {
                                    r = Math.max(0, Math.min(255, Math.round(r)));
                                    g = Math.max(0, Math.min(255, Math.round(g)));
                                    b = Math.max(0, Math.min(255, Math.round(b)));

                                    return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
                                }

                                function generateColorGradient(startHex, endHex, steps) {
                                    if (steps === 0) return [];
                                    if (steps === 1) return [startHex];

                                    const startRGB = hexToRgb(startHex);
                                    const endRGB = hexToRgb(endHex);
                                    const gradientColors = [];

                                    const stepR = (endRGB.r - startRGB.r) / (steps - 1);
                                    const stepG = (endRGB.g - startRGB.g) / (steps - 1);
                                    const stepB = (endRGB.b - startRGB.b) / (steps - 1);

                                    for (let i = 0; i < steps; i++) {
                                        const newR = startRGB.r + (stepR * i);
                                        const newG = startRGB.g + (stepG * i);
                                        const newB = startRGB.b + (stepB * i);
                                        gradientColors.push(rgbToHex(newR, newG, newB));
                                    }

                                    return gradientColors;
                                }

                                const dadosEsportes = @json($graficoEsportes);

                                const corInicialAzul = '#00598a';
                                const corFinalAzul   = '#00bcff';

                                const quantidadeElementos = dadosEsportes.length || 0;

                                let cores = [];

                                if (quantidadeElementos > 0) {
                                    cores = generateColorGradient(corInicialAzul, corFinalAzul, quantidadeElementos);
                                } else {
                                    cores = ['#cccccc']; 
                                }

                                google.charts.setOnLoadCallback(drawChart);

                                function drawChart() {

                                    const data = new google.visualization.DataTable();
                                    data.addColumn('string', 'Esporte'); 
                                    data.addColumn('number', 'Quantidade');
                                    data.addColumn({ type: 'string', role: 'tooltip', p: { html: true } });

                                    const tooltip = (titulo, qtd, cor) => `
                                        <div role="tooltip"
                                            class="absolute z-10 flex flex-col gap-y-[0.21vw] px-[0.63vw] py-[0.42vw] text-[0.73vw] font-medium text-white 
                                                bg-stone-950 rounded-md leading-none whitespace-nowrap">
                                            
                                            <div class="flex items-center gap-x-[0.21vw]">
                                                <span class="w-[0.52vw] h-[0.52vw] rounded-full" style="background:${cor}"></span>
                                                <span class="font-semibold">${titulo}</span>
                                            </div>

                                            <div class="font-medium">${qtd} oportunidades</div>
                                        </div>
                                    `;

                                    const linhasComTooltip = dadosEsportes.map((item, index) => [
                                        item.esporte_nome, 
                                        item.total, 
                                        tooltip(item.esporte_nome, item.total, cores[index % cores.length])
                                    ]);

                                    data.addRows(linhasComTooltip);

                                    const options = {
                                        chartArea: { width: '70%', height: '80%' },
                                        legend: {
                                            position: 'right',
                                            textStyle: { fontSize: 12, fontName: 'Poppins' },
                                            maxLines: 5,
                                        },
                                        animation: { startup: true, duration: 800, easing: 'out' },
                                        pieHole: 0.7,
                                        pieSliceBorderColor: 'transparent',
                                        tooltip: { isHtml: true },
                                        colors: [...cores], 
                                        scrollArrows: {
                                            activeColor: '#00bcff',
                                            inactiveColor: '#cccccc'
                                        },
                                        pieSliceText: 'none',
                                        pagingTextStyle: {
                                            color: '#666666',
                                            fontSize: 12,
                                            bold: true
                                        }
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

                        <div class="bg-white p-[0.83vw] rounded-lg border border-[0.15vw] border-gray-200 hover:border-sky-500 transition-colors flex-1 flex flex-col gap-[0.415vw]">
                            <span class="text-[0.83vw] font-medium text-gray-700">
                                Clubes Pendentes
                            </span>

                            <div class="w-full border border-t border-gray-200"></div>

                            <div class="flex flex-col gap-[0.42vw] overflow-y-auto h-full">
                                @forelse($clubesPendentes as $clube)
                                    <div class="flex items-center gap-x-[0.63vw] p-[0.42vw] border-b border-gray-100 last:border-b-0 group"  x-data="{ openModal: false }">
                                        
                                        {{-- FOTO DO CLUBE --}}
                                        <img src="{{ asset('storage/' . ($clube->fotoPerfilClube ?? 'imagens_seeder/building_perfil.png')) }}"
                                        class="h-[2.2vw] w-[2.2vw] rounded-full object-cover">
                                        
                                        {{-- NOME E DATA --}}
                                        <div class="flex-1 min-w-0 flex flex-col">
                                            <p class="text-[0.73vw] font-medium text-gray-700 truncate">
                                                {{ $clube->nomeClube }}
                                            </p>
                                            <p class="text-[0.63vw] text-gray-500 truncate">
                                                Criado em: {{ $clube->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>

                                        <x-icon-button
                                            color="red"
                                        >
                                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                        </x-icon-button>

                                        {{-- BOTÃO APROVAR --}}
                                        <form action="{{ route('admin.clube.aprovar') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="clube_id" value="{{ $clube->id }}">
                                            <x-icon-button
                                                color="green"
                                                onclick="this.closest('form').submit();"
                                            >
                                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                                            </x-icon-button>
                                        </form>
                                    </div>
                                @empty
                                    <div class="p-[0.83vw] flex items-center justify-center flex-1">
                                        <x-empty-state text="Nenhum clube pendente.">
                                            <x-slot:icon>
                                                <svg class="h-[1.67vw] w-[1.67vw] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-icon lucide-building"><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M12 6h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/><path d="M8 6h.01"/><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect x="4" y="2" width="16" height="20" rx="2"/></svg>
                                            </x-slot:icon>
                                            <p class="text-gray-400 font-normal text-[0.83vw]">
                                                Não há clubes aguardando aprovação no momento.
                                            </p>
                                        </x-empty-state>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6 flex flex-col gap-[0.83vw]">
                        <div class="bg-white p-[0.83vw] rounded-lg border border-[0.15vw] border-gray-200 hover:border-sky-500 transition-colors flex-1 flex flex-col gap-[0.415vw]">
                            <span class="text-[0.83vw] font-medium text-gray-700">
                                Atividades recentes
                            </span>

                            @php
                                $userIcon = '<svg class="h-[0.83vw] w-[0.83vw] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>';
                                $clubIcon = '<svg class="h-[0.83vw] w-[0.83vw] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-icon lucide-building"><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M12 6h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/><path d="M8 6h.01"/><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect x="4" y="2" width="16" height="20" rx="2"/></svg>';

                                $statusIcons = [
                                    'pending' => '<svg class="h-[0.83vw] w-[0.83vw] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>',
                                    'approved' => '<svg class="h-[0.83vw] w-[0.83vw] text-green-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-icon lucide-circle-check"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>',
                                    'rejected' => '<svg class="h-[0.83vw] w-[0.83vw] text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x-icon lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>',
                                ];
                            @endphp

                            <div class="flex flex-col gap-[0.42vw] overflow-y-auto h-full">
                                @forelse($atividadesRecentes as $atividade)
                                    @php
                                        $mensagem = '';
                                        $mainIcon = '';
                                        $statusIcon = '';
                                        $data = $atividade->created_at instanceof \Carbon\Carbon ? $atividade->created_at->diffForHumans() : '';
                                    @endphp

                                    @if ($atividade instanceof App\Models\Oportunidade)
                                        @php
                                            $clubeNome = optional($atividade->clube)->nomeClube ?? 'Clube';
                                            $esporteNome = optional($atividade->esporte)->nomeEsporte ?? 'Esporte';
                                            $mainIcon = $clubIcon;
                                            $statusIcon = $statusIcons[$atividade->status] ?? $statusIcons['pending'];

                                            switch ($atividade->status) {
                                                case 'pending':
                                                    $mensagem = "O clube {$clubeNome} criou a oportunidade para {$esporteNome} (Pendente).";
                                                    break;
                                                case 'approved':
                                                    $mensagem = "A oportunidade para {$esporteNome} do clube {$clubeNome} foi aprovada.";
                                                    break;
                                                case 'rejected':
                                                    $mensagem = "A oportunidade para {$esporteNome} do clube {$clubeNome} foi recusada.";
                                                    break;
                                                default:
                                                    $mensagem = "Nova oportunidade criada pelo clube {$clubeNome}.";
                                            }
                                        @endphp

                                    @elseif ($atividade instanceof App\Models\Inscricao)
                                        @php
                                            $usuarioNome = optional($atividade->usuario)->nomeCompletoUsuario ?? 'Usuário';
                                            $oportunidadeTitulo = optional($atividade->oportunidade)->tituloOportunidades ?? 'Oportunidade';
                                            $mainIcon = $userIcon;
                                            $statusIcon = $statusIcons[$atividade->status] ?? $statusIcons['pending'];

                                            switch ($atividade->status) {
                                                case 'pending':
                                                    $mensagem = "O usuário {$usuarioNome} se inscreveu em '{$oportunidadeTitulo}'.";
                                                    break;
                                                case 'approved':
                                                    $mensagem = "O clube aprovou a inscrição de {$usuarioNome} em '{$oportunidadeTitulo}'.";
                                                    break;
                                                case 'rejected':
                                                    $mensagem = "O clube recusou a inscrição de {$usuarioNome} em '{$oportunidadeTitulo}'.";
                                                    break;
                                                default:
                                                    $mensagem = "Atualização na inscrição de {$usuarioNome}.";
                                            }
                                        @endphp
                                    @endif

                                    @if (!empty($mensagem))
                                        <div class="flex-1 flex items-center gap-x-[0.63vw] p-[0.42vw] border-b border-gray-100 last:border-b-0 h-full">
                                            <div class="flex-shrink-0">
                                                {!! $statusIcon !!}
                                            </div>

                                            <div class="flex-1 min-w-0 flex items-center gap-x-[0.42vw]">
                                                <div class="flex-shrink-0">
                                                    {!! $mainIcon !!}
                                                </div>
                                                <p class="text-[0.73vw] text-gray-700 truncate" title="{{ strip_tags($mensagem) }}">
                                                    {!! $mensagem !!}
                                                </p>
                                            </div>

                                            <div class="flex-shrink-0">
                                                <span class="text-[0.63vw] text-gray-400 whitespace-nowrap">
                                                    {{ $data }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                @empty
                                    <div class="p-[0.83vw] flex items-center justify-center h-full">
                                        <x-empty-state text="Sem atividades recentes.">
                                            <x-slot:icon>
                                                <svg class="h-[1.67vw] w-[1.67vw] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-newspaper-icon lucide-newspaper"><path d="M15 18h-5"/><path d="M18 14h-8"/><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="10" y="6" rx="1"/></svg>
                                            </x-slot:icon>
                                            <p class="text-gray-400 font-normal text-[0.83vw]">
                                                O sistema não identificou nenhuma atividade recente até o momento.
                                            </p>
                                        </x-empty-state>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="bg-white h-max p-[0.83vw] rounded-lg border border-[0.15vw] border-gray-200 hover:border-sky-500 transition-colors flex flex-col gap-[0.63vw] flex-1">
                            <div class="flex items-center gap-x-[0.42vw]">
                                <span class="text-[0.83vw] font-medium text-gray-700">
                                    Oportunidades pendentes
                                </span>
                            </div>

                            <div class="w-full border border-t border-gray-200"></div>

                            <div class="flex flex-col gap-[0.42vw] h-full">
                                @forelse($oportunidadesPendentes->take(5) as $oportunidade)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-x-[0.63vw] truncate">
                                            <div class="h-[1.6vw] border border-l border-[0.225vw] border-gray-200 hover:border-sky-500 transition-colors rounded-md"></div>

                                            <span class="text-[0.83vw] font-medium text-gray-700 truncate">
                                                {{ optional($oportunidade->clube)->nomeClube ?? 'Clube' }}
                                            </span>

                                            <a
                                                href="{{ route('admin.oportunidades') }}"
                                                class="text-[0.73vw] font-semibold tracking-tight text-sky-500 hover:text-sky-600 underline transition-colors truncate"
                                            >
                                                {{ $oportunidade->tituloOportunidades }}
                                            </a>
                                        </div>

                                        <div class="flex items-center gap-x-[0.42vw]">
                                            {{-- Recusar --}}
                                            <x-icon-button
                                                color="red"
                                                onclick="openRejectOpportunityModal(
                                                    {{ $oportunidade->id }},
                                                    {{ \Illuminate\Support\Js::from(optional($oportunidade->clube)->nomeClube ?? 'Clube') }},
                                                    {{ \Illuminate\Support\Js::from($oportunidade->tituloOportunidades) }}
                                                )"
                                            >
                                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                            </x-icon-button>
                                    
                                            <div class="w-px h-[0.83vw] bg-gray-200"></div>

                                            {{-- Aprovar --}}
                                            <x-icon-button
                                                color="green"
                                                onclick="openApproveOpportunityModal(
                                                    {{ $oportunidade->id }},
                                                    {{ \Illuminate\Support\Js::from(optional($oportunidade->clube)->nomeClube ?? 'Clube') }},
                                                    {{ \Illuminate\Support\Js::from($oportunidade->tituloOportunidades) }}
                                                )"
                                            >
                                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                                            </x-icon-button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-[0.83vw] flex items-center justify-center flex-1">
                                        <x-empty-state text="Nenhuma oportunidade pendente.">
                                            <x-slot:icon>
                                                <svg class="h-[1.67vw] w-[1.67vw] text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone-icon lucide-megaphone"><path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"/><path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"/><path d="M8 6v8"/></svg>
                                            </x-slot:icon>
                                            <p class="text-gray-400 font-normal text-[0.83vw]">
                                                Não há oportunidades aguardando aprovação no momento.
                                            </p>
                                        </x-empty-state>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        {{-- Modal Aprovar Oportunidade --}}
    <x-modal 
        maxWidth="xl" 
        name="approve-opportunity" 
        title="Aprovar oportunidade" 
        titleSize="[0.94vw]" 
        titleColor="green"
    >
        <x-form 
            id="approveOpportunityForm" 
            method="POST" 
            action="{{ route('admin.oportunidades.aprovar') }}"
        >
            @csrf
            <input type="hidden" name="oportunidade_id" id="approve_oportunidade_id">

            <div class="flex flex-col gap-[0.52vw]">
                <p class="text-[0.83vw] text-gray-600 leading-snug">
                    Você está prestes a aprovar a oportunidade:
                </p>

                <div class="bg-sky-50 border border-sky-100 rounded-md px-[0.73vw] py-[0.52vw] flex flex-col gap-[0.31vw]">
                    <p class="text-[0.83vw] font-semibold text-sky-900" id="approve_opportunity_title">
                        <!-- preenchido via JS -->
                    </p>
                    <p class="text-[0.73vw] text-sky-800/80">
                        Clube: <span class="font-medium" id="approve_opportunity_club"></span>
                    </p>
                </div>

                <p class="text-[0.73vw] text-gray-500">
                    Após a aprovação, a oportunidade ficará visível para os atletas na plataforma.
                </p>
            </div>
        </x-form>

        <x-slot:footer>
            <div class="w-full flex gap-x-[0.42vw] justify-end">
                <x-button 
                    color="gray" 
                    size="md" 
                    onclick="closeModal('approve-opportunity')"
                >
                    Cancelar
                </x-button>

                <x-button 
                    color="clube" 
                    size="md" 
                    type="submit" 
                    form="approveOpportunityForm"
                >
                    <span class="ml-[0.21vw]">Aprovar</span>
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>

    {{-- Modal Recusar Oportunidade --}}
    <x-modal 
        maxWidth="xl" 
        name="reject-opportunity" 
        title="Recusar oportunidade" 
        titleSize="[0.94vw]" 
        titleColor="red"
    >
        <x-form 
            id="rejectOpportunityForm" 
            method="POST" 
            action="{{ route('admin.oportunidades.recusar') }}"
        >
            @csrf
            <input type="hidden" name="oportunidade_id" id="reject_oportunidade_id">

            <div class="flex flex-col gap-[0.52vw]">
                <p class="text-[0.83vw] text-gray-600 leading-snug">
                    Você está prestes a <span class="font-semibold text-red-500">recusar</span> a oportunidade:
                </p>

                <div class="bg-red-50 border border-red-100 rounded-md px-[0.73vw] py-[0.52vw] flex flex-col gap-[0.31vw]">
                    <p class="text-[0.83vw] font-semibold text-red-900" id="reject_opportunity_title">
                        <!-- preenchido via JS -->
                    </p>
                    <p class="text-[0.73vw] text-red-800/80">
                        Clube: <span class="font-medium" id="reject_opportunity_club"></span>
                    </p>
                </div>

                <p class="text-[0.78vw] text-gray-600">
                    Informe o motivo da recusa. Esse texto poderá ser enviado ao clube como feedback.
                </p>

                <textarea
                    name="motivo_recusa"
                    id="motivo_recusa"
                    rows="3"
                    class="w-full rounded-md border border-gray-300 focus:border-red-400 focus:ring-1 focus:ring-red-400 text-[0.78vw] text-gray-700 px-[0.63vw] py-[0.52vw] resize-none"
                    placeholder="Descreva brevemente o motivo da recusa..."
                    required
                ></textarea>
            </div>
        </x-form>

        <x-slot:footer>
            <div class="w-full flex gap-x-[0.42vw] justify-end">
                <x-button 
                    color="gray" 
                    size="md" 
                    onclick="closeModal('reject-opportunity')"
                >
                    Cancelar
                </x-button>

                <x-button 
                    color="red" 
                    size="md" 
                    type="submit" 
                    form="rejectOpportunityForm"
                >
                    <span class="ml-[0.21vw]">Recusar</span>
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>

    <script>
        function openApproveOpportunityModal(id, clubName, oppTitle) {
            document.getElementById('approve_oportunidade_id').value = id;
            document.getElementById('approve_opportunity_club').textContent = clubName ?? 'Clube';
            document.getElementById('approve_opportunity_title').textContent = oppTitle ?? 'Oportunidade';

            openModal('approve-opportunity');
        }

        function closeApproveOpportunityModal() {
            closeModal('approve-opportunity');
        }

        function openRejectOpportunityModal(id, clubName, oppTitle) {
            document.getElementById('reject_oportunidade_id').value = id;
            document.getElementById('reject_opportunity_club').textContent = clubName ?? 'Clube';
            document.getElementById('reject_opportunity_title').textContent = oppTitle ?? 'Oportunidade';

            const motivo = document.getElementById('motivo_recusa');
            if (motivo) motivo.value = '';

            openModal('reject-opportunity');
        }

        function closeRejectOpportunityModal() {
            closeModal('reject-opportunity');
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeApproveOpportunityModal();
                closeRejectOpportunityModal();
            }
        });
    </script>

</x-layouts.admin>