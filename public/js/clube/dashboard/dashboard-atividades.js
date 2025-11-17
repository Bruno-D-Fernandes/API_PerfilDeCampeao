/**
 * Busca as oportunidades do clube, processa os dados e renderiza um gráfico
 * de barras mostrando a quantidade de oportunidades criadas nos últimos 6 meses.
 */
async function criarGraficoOportunidades() {
    const canvas = document.getElementById('graficoOportunidades');
    if (!canvas) {
        console.error('Elemento canvas #graficoOportunidades não encontrado.');
        return;
    }

    try {
        // 1. Buscar todas as oportunidades do clube
        const { data: oportunidades, ok } = await window.ClubDash.api.fetchMinhasOportunidades();

        if (!ok || !oportunidades) {
            console.error('Falha ao buscar oportunidades.');
            // Você pode exibir uma mensagem de erro no lugar do gráfico se quiser
            return;
        }

        // 2. Processar os dados para o gráfico
        // Vamos contar as oportunidades por mês nos últimos 6 meses.
        const contagemPorMes = {};
        const nomesDosMeses = [];
        const hoje = new Date();

        // Inicializa os últimos 6 meses com contagem 0
        for (let i = 5; i >= 0; i--) {
            const dataMes = new Date(hoje.getFullYear(), hoje.getMonth() - i, 1);
            const nomeMes = dataMes.toLocaleString('pt-BR', { month: 'long' });
            const anoMes = dataMes.getFullYear();
            const chave = `${nomeMes.charAt(0).toUpperCase() + nomeMes.slice(1)}/${anoMes}`;
            
            nomesDosMeses.push(chave);
            contagemPorMes[chave] = 0;
        }

        // Preenche a contagem com os dados das oportunidades
        oportunidades.forEach(op => {
            const dataCriacao = new Date(op.created_at);
            const nomeMes = dataCriacao.toLocaleString('pt-BR', { month: 'long' });
            const anoMes = dataCriacao.getFullYear();
            const chave = `${nomeMes.charAt(0).toUpperCase() + nomeMes.slice(1)}/${anoMes}`;

            if (chave in contagemPorMes) {
                contagemPorMes[chave]++;
            }
        });

        const dadosDoGrafico = nomesDosMeses.map(chave => contagemPorMes[chave]);

        // 3. Renderizar o gráfico com Chart.js
        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Tipo de gráfico: barras
            data: {
                labels: nomesDosMeses, // Rótulos do eixo X (os meses)
                datasets: [{
                    label: 'Nº de Oportunidades Criadas',
                    data: dadosDoGrafico, // Dados do eixo Y (a contagem)
                    backgroundColor: 'rgba(0, 123, 255, 0.5)', // Cor das barras
                    borderColor: 'rgba(0, 123, 255, 1)', // Cor da borda das barras
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, // Torna o gráfico responsivo
                maintainAspectRatio: false, // Permite que o gráfico preencha o container
                scales: {
                    y: {
                        beginAtZero: true, // Eixo Y começa no zero
                        ticks: {
                            // Garante que o eixo Y só mostre números inteiros
                            stepSize: 1 
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // Oculta a legenda, pois o título já é claro
                    }
                }
            }
        });

    } catch (error) {
        console.error('Erro ao criar o gráfico de oportunidades:', error);
    }
}

/**
 * Adiciona estilos para o container do gráfico, garantindo que ele tenha um tamanho.
 */
function adicionarEstilosGrafico() {
    const style = document.createElement('style');
    style.innerHTML = `
        .grafico-container {
            position: relative;
            height: 300px; /* Defina a altura que desejar */
            width: 100%;
        }
    `;
    document.head.appendChild(style);
}


// Inicia a execução quando o DOM estiver completamente carregado
document.addEventListener('DOMContentLoaded', () => {
    adicionarEstilosGrafico();
    criarGraficoOportunidades();
});
