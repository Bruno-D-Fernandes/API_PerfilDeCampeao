<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
   <form action="" id="cadastro-esporte">
        <label for="">Nome:</label>
        <input type="text" name="nomeEsporte">

        <label for="">Descrição</label>
        <input type="text" name="descricaoEsporte">
        
        <button type="submit">Adicionar</button>
   </form>

   <div class="esportes">

   </div>

   <button type="button"></button>

   <script>
        const esportes = document.querySelector('.esportes');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetchEsportes();

        esportes.addEventListener('click', (e) => {
            if (e.target.classList.contains('listar-posicao')) {
                e.preventDefault();
                
                const esporteDiv = e.target.closest('.esporte');
                
                if (esporteDiv) {
                    const idEsporte = esporteDiv.dataset.esporteId;
                    fetchPosicoes(Number(idEsporte));
                } else {
                    console.error('Div pai .esporte não encontrada.');
                }
            }
        });

        const form = document.getElementById('cadastro-esporte');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const url = '../api/admin/esporte';

            const formData = new FormData(form);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Authorization': 'Bearer 4|wckUAadzLfkY60O0u7KtKn9JzgFa1ULq27Rk9ajj1a7ea27f' // Trocar depois para pegar do localstorage no merge

                },
                body: formData,
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                
                if (!data.error) {
                    alert('deu certo');
                }
            })
            .catch(e => {
                console.error('ocorreu um erro', e);
            })
        });

        async function fetchEsportes() {
            const url = '../api/admin/esporte';

            fetch(url, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Authorization': 'Bearer 4|wckUAadzLfkY60O0u7KtKn9JzgFa1ULq27Rk9ajj1a7ea27f' // Trocar depois para pegar do localstorage no merge
                },
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                
                if (!data.error) {
                    alert('deu certo');
                }

                for (esporte of data) {
                    esportes.appendChild(createEsporteRow(esporte));
                }
            })
            .catch(e => {
                console.error('ocorreu um erro', e);
            })
        }

        async function fetchPosicoes(idEsporte) {
            const url = `/api/admin/esporte/${idEsporte}/posicoes`;

            fetch(url, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Authorization': 'Bearer 4|wckUAadzLfkY60O0u7KtKn9JzgFa1ULq27Rk9ajj1a7ea27f' // Trocar depois para pegar do localstorage no merge

                },
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                
                if (!data.error) {
                    alert('deu certo');
                }
            })
            .catch(e => {
                console.error('ocorreu um erro', e);
            })
        }

        function createEsporteRow(esporte) {
            const div = document.createElement('div');
            div.className = 'esporte';

            const span = document.createElement('span');

            span.textContent = `Nome - ${esporte.nomeEsporte}. Descrição - ${esporte.descricaoEsporte ? esporte.descricaoEsporte : "Sem descrição"}`;

            div.appendChild(span);

            div.dataset.esporteId = esporte.id;

            const divPosicoes = document.createElement('div');
            divPosicoes.className = 'posicoes';

            esporte.posicoes.forEach(posicao => divPosicoes.appendChild(createPosicoesRow(posicao)));

            div.appendChild(divPosicoes);

            return div;
        }

        function createPosicoesRow(posicao) {
            const div = document.createElement('div');
            div.className = 'posicao';

            const span = document.createElement('span');
            span.textContent = `Nome: ${posicao.nomePosicao}`;

            div.appendChild(span);

            return div;
        }
   </script>
</body>
</html>