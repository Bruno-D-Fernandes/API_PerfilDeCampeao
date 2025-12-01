<x-layouts.clube title="Minhas Oportunidades" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Minhas Oportunidades' => null
]">
    <x-slot:action>
        <x-button onclick="openModal('create-opportunity')" size="md" color="clube">
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </x-slot:icon>

            Criar Oportunidade
        </x-button>
    </x-slot:action>

    <x-modal maxWidth="xl" name="create-opportunity" title="Nova Oportunidade" titleSize="2xl" titleColor="green">
        <x-form id="form-create" class="flex flex-col gap-[0.42vw]">
            @csrf

            <x-form-group label="Título da Oportunidade" name="tituloOportunidades" id="oportunidade-titulo" labelColor="green" textSize="xl" required>
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type-icon"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
                </x-slot:icon>
            </x-form-group>

            <div class="grid grid-cols-2 gap-[0.42vw]">
                <x-form-group label="Esporte" type="select" name="esporte_id" id="oportunidade-esporte" labelColor="green" textSize="xl" required onchange="atualizarPosicoes('oportunidade-esporte', 'oportunidade-posicoes')">
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                    </x-slot:icon>

                    <option value="" data-posicoes="[]">Selecione...</option>

                    @foreach($esportes as $esporte)
                        <option 
                            value="{{ $esporte->id }}" 
                            data-posicoes="{{ $esporte->posicoes }}"
                        >
                            {{ $esporte->nomeEsporte ?? $esporte->nome }}
                        </option>
                    @endforeach
                </x-form-group>

                <x-form-group label="Posições (Segure Ctrl)" name="posicoes_ids[]" id="oportunidade-posicoes" type="select" multiple size="1" labelColor="green" textSize="xl">
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target-icon"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                    </x-slot:icon>

                    <option value="">Selecione um esporte...</option>
                </x-form-group>
            </div>

            <div class="grid grid-cols-3 gap-[0.42vw]">
                <x-form-group label="Idade Mín." type="number" name="idadeMinima" id="oportunidade-idade-min" labelColor="green" textSize="xl" required>
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down-to-line"><path d="M12 17V3"/><path d="m6 11 6 6 6-6"/><path d="M19 21H5"/></svg>
                    </x-slot:icon>
                </x-form-group>

                <x-form-group label="Idade Máx." type="number" name="idadeMaxima" id="oportunidade-idade-max" labelColor="green" textSize="xl" required>
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-from-line"><path d="m18 9-6-6-6 6"/><path d="M12 3v14"/><path d="M5 21h14"/></svg>
                    </x-slot:icon>
                </x-form-group>

                <x-form-group label="Vagas" type="number" name="limite_inscricoes" id="oportunidade-limite" labelColor="green" textSize="xl" required>
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </x-slot:icon>
                </x-form-group>
            </div>

            <x-form-group label="Descrição Detalhada" name="descricaoOportunidades" id="oportunidade-descricao" labelColor="green" textSize="xl" required>
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-align-left"><line x1="21" x2="3" y1="6" y2="6"/><line x1="15" x2="3" y1="12" y2="12"/><line x1="17" x2="3" y1="18" y2="18"/></svg>
                </x-slot:icon>
            </x-form-group>
        </x-form>

        <x-slot:footer>
            <div class="w-full flex gap-x-[0.42vw] justify-end">
                <x-button color="gray" size="md" onclick="closeModal('create-opportunity')">
                    Cancelar
                </x-button>

                <x-button color="clube" size="md" onclick="saveOpportunity('form-create', 'create')">
                    Salvar
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>

    <x-slot:action>
        <x-button onclick="openModal('create-opportunity')" size="sm" color="clube">
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            </x-slot:icon>

            Criar oportunidade
        </x-button>
    </x-slot:action>

    <div class="w-full relative" id="opportunities-list">
        @include('clube.partials.opportunity-grid', ['oportunidades' => $oportunidades])
    </div>
    
    <div id="opportunities-loading" class="absolute inset-0 bg-white/50 backdrop-blur-sm z-[9999] flex items-center justify-center hidden rounded-[0.42vw]">
        <svg class="animate-spin h-[1.67vw] w-[1.67vw] text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>

    <script>
        function showProfileLoading() {
            document.getElementById('opportunities-loading').classList.remove('hidden');
        }

        function hideProfileLoading() {
            document.getElementById('opportunities-loading').classList.add('hidden');
        }

        function atualizarPosicoes(idSelectEsporte, idSelectAlvo) {
            let selectEsporte = document.getElementById(idSelectEsporte);
            let selectAlvo = document.getElementById(idSelectAlvo);

            if (selectEsporte && selectEsporte.tagName !== 'SELECT') {
                selectEsporte = selectEsporte.querySelector('select');
            }

            if (selectAlvo && selectAlvo.tagName !== 'SELECT') {
                selectAlvo = selectAlvo.querySelector('select');
            }

            if (!selectEsporte || !selectAlvo) {
                console.error("Erro: Não encontrei os selects.", { origem: idSelectEsporte, alvo: idSelectAlvo });
                return;
            }

            selectAlvo.innerHTML = '<option value="">Selecione...</option>';

            const index = selectEsporte.selectedIndex;

            if (index < 0) return; 
            
            const opcaoSelecionada = selectEsporte.options[index];

            const dadosJSON = opcaoSelecionada.getAttribute('data-posicoes');

            if (dadosJSON) {
                try {
                    const posicoes = JSON.parse(dadosJSON);

                    posicoes.forEach(pos => {
                        const option = document.createElement('option');
                        option.value = pos.id;

                        option.text = pos.nomePosicao || pos.nome || pos.titulo; 
                        selectAlvo.appendChild(option);
                    });
                } catch (e) {
                    console.error("Erro ao ler JSON de posições:", e);
                }
            }
        }

        function openModal(name) {
            document.querySelector(`[data-modal-name="${name}"]`)?.classList.remove("hidden");
        }

        function closeModal(name) {
            document.querySelector(`[data-modal-name="${name}"]`)?.classList.add("hidden");
        }

        function toggleLoading(button, isLoading) {
            if (isLoading) {
                button.dataset.original = button.innerText;
                button.innerText = "Salvando...";
                button.disabled = true;
            } else {
                button.innerText = button.dataset.original || "Salvar";
                button.disabled = false;
            }
        }

        // --- SALVAR (CRIAR E EDITAR) ---
        async function saveOpportunity(formId, type, recordId = null) {
        
        const form = document.getElementById(formId);

        if (!form) {
            console.error("Erro: Formulário não encontrado com ID:", formId);
            return;
        }

        // Tenta achar o botão de salvar para o efeito de loading
        const modal = document.querySelector('#create-opportunity');
        const button = modal ? modal.querySelector('button[color="clube"]') : null;

        if (button) toggleLoading(button, true);

        // URL da API
        let url = "";
        if (type === 'edit' && recordId) {
            url = `/api/clube/oportunidade-painel/${recordId}`;
        } else {
            url = `/api/clube/oportunidade-painel`;
        }

        try {
        const formData = new FormData(form);

        // --- CORREÇÃO PARA GARANTIR O NOME CORRETO ---
        
        // 1. Procura o select de posições pelo nome PLURAL
        const selectPosicoes = form.querySelector('select[name="posicoes_ids[]"]');
        
        // 2. Se achou o select, força a captura dos valores
        if (selectPosicoes) {
                formData.delete('posicoes_ids[]'); 
                
                Array.from(selectPosicoes.selectedOptions).forEach(option => {
                    // --- CORREÇÃO AQUI ---
                    // Só adiciona se o valor não for vazio e for um número
                    if (option.value && option.value.trim() !== "") {
                        formData.append('posicoes_ids[]', option.value);
                    }
                });
            }

        // Verifica se selecionou pelo menos uma (Validação Front-end)
        if (!formData.has('posicoes_ids[]')) {
            alert("Selecione pelo menos uma posição!");
            if(button) toggleLoading(button, false);
            return;
        }

            // Se for Edit, adiciona o spoofing de PUT
            if (type === 'edit') {
                formData.append('_method', 'PUT');
            }

            showProfileLoading();
            // Debug: Mostra no console o que está sendo enviado
            // for (var pair of formData.entries()) { console.log(pair[0]+ ', ' + pair[1]); }

            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                // Se o erro for de validação, formata para ficar legível
                let msg = data.message;
                if(data.errors) {
                    msg = Object.values(data.errors).flat().join('\n');
                }
                throw new Error(msg || "Erro desconhecido");
            }

            document.querySelector('#opportunities-list').innerHTML = data.data;

        } catch (error) {
            alert("Atenção:\n" + error.message);
            if (button) toggleLoading(button, false);
        } finally {
            closeModal('create-opportunity');
            hideProfileLoading();
        }
    }

        // --- DELETAR ---
        async function deleteOpportunity(id, button) {
            if(!confirm("Tem certeza?")) return;

            if(button) {
                button.innerText = "...";
                button.disabled = true;
            }

            try {
                // URL MANUAL
                const url = `/api/clube/oportunidade-painel/${id}`;

                const response = await fetch(url, {
                    method: 'POST', // POST com _method DELETE
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ _method: 'DELETE' })
                });

                if (!response.ok) {
                    const data = await response.json();
                    throw new Error(data.message || "Erro ao excluir");
                }

                window.location.reload();

            } catch (error) {
                alert(error.message);
                if(button) {
                    button.innerText = "Sim, excluir";
                    button.disabled = false;
                }
            }
        }
    </script>
</x-layouts.clube>