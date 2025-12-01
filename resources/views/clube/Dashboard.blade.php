<x-layouts.clube title="Dashboard" :breadcrumb="[
    'Dashboard' => null,
]">
    <div class="h-full w-full flex flex-col flex-1">
        <div class="h-[1.67vw] flex gap-x-[0.42vw] items-center w-full mb-[0.83vw]">
            <span class="text-[0.83vw] font-medium text-emerald-500">
                Esporte
            </span>

            <div>
                <x-form-group :label="null" name="fe" type="select" id="esporte-selector" labelColor="green" class="!h-[1.67vw] pr-[1.67vw] !bg-white leading-none !text-[0.63vw] !border-[0.15vw] !py-0">
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw] text-emerald-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                    </x-slot:icon>

                    @foreach($esportes as $esporte)
                        <option value="{{ $esporte->id }}" {{ isset($esporteAtual) && $esporteAtual->id == $esporte->id ? 'selected' : '' }}>
                            {{ $esporte->nomeEsporte ?? $esporte->nome }}
                        </option>
                    @endforeach
                </x-form-group>
            </div>
        </div>

        <div id="dashboard-content" class="flex-grow grid grid-rows-[auto_1fr] gap-[0.83vw] relative min-h-0">
            <div id="dashboard-loading" class="absolute inset-0 bg-white/50 backdrop-blur-sm z-[999] flex items-center justify-center hidden rounded-[0.42vw]">
                <svg class="animate-spin h-[1.67vw] w-[1.67vw] text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        
            @if($dados)
                @include('clube.partials.dashboard-content', ['dados' => $dados])
            @else
                <div class="flex items-center justify-center h-full text-gray-400">Sem dados para exibir.</div>
            @endif
        </div>
    </div>
</x-layouts.clube>

<script>
    google.charts.load('current', { packages: ['corechart'] });

    const styles = {
        fontName: 'Poppins',
        fontSize: 12,
        colors: {
            gradientStart: '#006045', 
            gradientEnd: '#5ee9b5',
            origem: ['#10B981'],
            evolucao: ['#10B981']
        },
        textStyle: {
            fontSize: 12,
            fontName: 'Poppins'
        },
        gridlines: {
            color: '#e5e7eb'
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        const selector = document.getElementById('esporte-selector');
        const container = document.getElementById('dashboard-content');
        const loader = document.getElementById('dashboard-loading');

        google.charts.setOnLoadCallback(renderDashboardCharts);

        if (selector && container) {
            selector.addEventListener('change', function() {
                const esporteId = this.value;
                
                loader.classList.remove('hidden');
                
                container.style.pointerEvents = 'none'

                fetch(`/clube/dashboard/content/${esporteId}`) 
                    .then(response => {
                        if (!response.ok) throw new Error('Erro ao buscar dados');
                        return response.json();
                    })
                    .then(data => {
                        container.innerHTML = data.html;
                        
                        container.appendChild(loader); 
                        
                        setTimeout(() => {
                            renderDashboardCharts();
                        }, 100);
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                    })
                    .finally(() => {
                        loader.classList.add('hidden');
                        container.style.pointerEvents = 'auto';
                    });
            });
        }
    });

    function renderDashboardCharts() {
        drawPosicoesChart();
        drawOrigemChart();
        drawEvolucaoChart();
    }

    function drawPosicoesChart() {
        const container = document.getElementById('chart-posicoes');
        const rawData = JSON.parse(container.dataset.json);

        const dynamicColors = generateGreenGradient(rawData.length);

        const data = new google.visualization.DataTable();
        data.addColumn('string', 'Posição');
        data.addColumn('number', 'Quantidade');
        data.addColumn({ type: 'string', role: 'tooltip', p: { html: true } });

        const rows = rawData.map((item, index) => {
            const cor = dynamicColors[index];

            return [
                item.posicao_nome,
                parseInt(item.total),
                createCustomTooltip(item.posicao_nome, item.total + ' jogadores', cor)
            ];
        });

        data.addRows(rows);

        const options = {
            chartArea: { width: '60%', height: '80%' },
            legend: {
                position: 'right',
                textStyle: styles.textStyle
            },
            animation: { startup: true, duration: 800, easing: 'out' },
            pieHole: 0,
            pieSliceBorderColor: 'transparent',
            tooltip: { isHtml: true },
            colors: dynamicColors,
        };

        const chart = new google.visualization.PieChart(container);
        chart.draw(data, options);
    }

    function drawOrigemChart() {
        const container = document.getElementById('chart-origem');

        const rawData = JSON.parse(container.dataset.json);

        const data = new google.visualization.DataTable();
        data.addColumn('string', 'Origem');
        data.addColumn('number', 'Candidaturas');
        data.addColumn({ type: 'string', role: 'tooltip', p: { html: true } });

        const rows = rawData.map(item => {
            return [
                item.estado,
                parseInt(item.total),
                createCustomTooltip(item.estado, item.total + ' candidaturas', styles.colors.origem[0])
            ];
        });

        data.addRows(rows);

        const options = {
            chartArea: { width: '90%', height: '70%', top: 20 },
            legend: { position: 'none' }, 

            animation: { startup: true, duration: 800, easing: 'out' },
            tooltip: { isHtml: true },
            colors: styles.colors.origem,
            bar: { groupWidth: '60%' },
            
            hAxis: {
                textStyle: { 
                    textStyle: styles.textStyle,
                    color: '#6b7280',
                    bold: false,
                    italic: false
                },
                gridlines: { color: 'transparent' },
                baselineColor: '#e5e7eb'
            },
            
            vAxis: {
                textStyle: { 
                    textStyle: styles.textStyle,
                    color: '#6b7280',
                    bold: false,
                    italic: false
                },
                gridlines: { color: '#f3f4f6' },
                baselineColor: 'transparent',
                minValue: 0
            }
        };

        const chart = new google.visualization.ColumnChart(container);
        chart.draw(data, options);
    }

    function drawEvolucaoChart() {
        const container = document.getElementById('chart-evolucao');
        const rawData = JSON.parse(container.dataset.json);

        const data = new google.visualization.DataTable();
        data.addColumn('string', 'Mês');
        data.addColumn('number', 'Candidaturas');
        data.addColumn({ type: 'string', role: 'tooltip', p: { html: true } });

        const rows = rawData.map(item => {
            return [
                item.rotulo,
                parseInt(item.total),
                createCustomTooltip(item.rotulo, item.total + ' candidaturas', styles.colors.evolucao[0])
            ];
        });

        data.addRows(rows);

        const options = {
            chartArea: { width: '95%', height: '70%' },
            legend: { position: 'none' },
            animation: { startup: true, duration: 800, easing: 'out' },
            tooltip: { isHtml: true },
            colors: styles.colors.evolucao,
            lineWidth: 3,
            pointSize: 7,
            pointShape: 'circle',
            curveType: 'function',
            series: {
                0: { areaOpacity: 0.2 }
            },
            hAxis: {
                textStyle: styles.textStyle,
                slantedText: false,
                showTextEvery: 1,
                gridlines: styles.gridlines
            },
            vAxis: {
                textStyle: styles.textStyle,
                gridlines: styles.gridlines
            }
        };

        const chart = new google.visualization.LineChart(container);
        chart.draw(data, options);
    }

    function createCustomTooltip(titulo, subtitulo, cor) {
        return `
            <div role="tooltip"
                class="absolute z-10 flex flex-col gap-y-1 px-3 py-2 text-sm font-medium text-white 
                    bg-stone-950 rounded-md leading-none whitespace-nowrap">
                
                <div class="flex items-center gap-x-1">
                    <span class="w-2.5 h-2.5 rounded-full" style="background:${cor}"></span>
                    <span class="font-semibold">${titulo}</span>
                </div>

                <div class="font-medium">${subtitulo}</div>
            </div>
        `;
    }

    function generateGreenGradient(steps) {
        const startHex = styles.colors.gradientStart;
        const endHex = styles.colors.gradientEnd;

        if (steps < 2) return [startHex];

        const startRgb = hexToRgb(startHex);
        const endRgb = hexToRgb(endHex);
        
        let palette = [];

        for (let i = 0; i < steps; i++) {
            const percentage = i / (steps - 1);

            const r = Math.round(startRgb.r + (endRgb.r - startRgb.r) * percentage);
            const g = Math.round(startRgb.g + (endRgb.g - startRgb.g) * percentage);
            const b = Math.round(startRgb.b + (endRgb.b - startRgb.b) * percentage);

            palette.push(rgbToHex(r, g, b));
        }

        return palette;
    }

    function hexToRgb(hex) {
        hex = hex.replace(/^#/, '');

        const bigint = parseInt(hex, 16);
        const r = (bigint >> 16) & 255;
        const g = (bigint >> 8) & 255;
        const b = bigint & 255;

        return { r, g, b };
    }

    function rgbToHex(r, g, b) {
        return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
    }

    window.addEventListener('resize', renderDashboardCharts);
</script>