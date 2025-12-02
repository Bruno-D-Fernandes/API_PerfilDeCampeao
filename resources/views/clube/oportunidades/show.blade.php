<x-layouts.clube 
    :title="$oportunidade->tituloOportunidades ?? 'Oportunidade'" 
    :breadcrumb="[
        'Dashboard' => route('clube.dashboard'),
        'Minhas Oportunidades' => route('clube.minhas-oportunidades'),
        $oportunidade->tituloOportunidades ?? 'Detalhes' => null,
    ]"
>   
    <div class="flex flex-col gap-[0.83vw]">
        <a href="{{ route('clube.minhas-oportunidades') }}" class="flex items-center gap-x-[0.21vw] text-emerald-500 hover:text-emerald-700 transition-colors font-medium">
            <svg class="w-[0.83vw] h-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            Voltar
        </a>

        <div class="w-full relative" id="opportunity-wrapper">
            <div id="opportunity-details" class="w-full flex flex-col gap-4">
                @include('clube.partials.opportunity-details', [
                    'oportunidade' => $oportunidade,
                    'esportes'     => $esportes,
                ])
            </div>
        </div>

        <div id="opportunity-loading" class="absolute inset-0 bg-white/50 backdrop-blur-sm z-[999] flex items-center justify-center hidden rounded-[0.42vw]">
            <svg class="animate-spin h-[1.67vw] w-[1.67vw] text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    {{-- MODAL DE EDIÇÃO --}}
    <x-modal 
        maxWidth="xl" 
        name="edit-opportunity-{{ $oportunidade->id }}" 
        title="Editar Oportunidade" 
        titleSize="2xl" 
        titleColor="green"
    >
        <x-form id="form-edit-{{ $oportunidade->id }}" class="flex flex-col gap-[0.42vw]">
            @csrf

            <x-form-group 
                label="Título da Oportunidade" 
                name="tituloOportunidades" 
                id="edit-oportunidade-titulo" 
                labelColor="green" 
                textSize="xl" 
                required
            >
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/>
                    </svg>
                </x-slot:icon>
                <input 
                    type="text" 
                    name="tituloOportunidades" 
                    id="edit-oportunidade-titulo-input"
                    class="hidden"
                    value="{{ old('tituloOportunidades', $oportunidade->tituloOportunidades) }}"
                >
            </x-form-group>

            <div class="grid grid-cols-2 gap-[0.42vw]">
                <x-form-group 
                    label="Esporte" 
                    type="select" 
                    name="esporte_id" 
                    id="edit-esporte-{{ $oportunidade->id }}" 
                    labelColor="green" 
                    textSize="xl" 
                    required
                    onchange="atualizarPosicoes('edit-esporte-{{ $oportunidade->id }}', 'edit-posicoes-{{ $oportunidade->id }}')"
                >
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/>
                        </svg>
                    </x-slot:icon>

                    <option value="" data-posicoes="[]">Selecione...</option>

                    @foreach($esportes as $esporte)
                        <option 
                            value="{{ $esporte->id }}" 
                            data-posicoes="{{ $esporte->posicoes }}"
                            @if($oportunidade->esporte_id == $esporte->id) selected @endif
                        >
                            {{ $esporte->nomeEsporte ?? $esporte->nome }}
                        </option>
                    @endforeach
                </x-form-group>

                <x-form-group 
                    label="Posições (Segure Ctrl)" 
                    name="posicoes_ids[]" 
                    id="edit-posicoes-{{ $oportunidade->id }}" 
                    type="select" 
                    multiple 
                    size="1" 
                    labelColor="green" 
                    textSize="xl"
                >
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>
                        </svg>
                    </x-slot:icon>

                    @php
                        $posicoesSelecionadas = $oportunidade->posicoes->pluck('id')->toArray();
                        $esporteAtual = $esportes->firstWhere('id', $oportunidade->esporte_id);
                        $posicoesEsporteAtual = $esporteAtual ? $esporteAtual->posicoes : collect();
                    @endphp

                    @foreach($posicoesEsporteAtual as $pos)
                        <option 
                            value="{{ $pos->id }}"
                            @if(in_array($pos->id, $posicoesSelecionadas)) selected @endif
                        >
                            {{ $pos->nomePosicao ?? $pos->nome ?? $pos->titulo }}
                        </option>
                    @endforeach
                </x-form-group>
            </div>

            <div class="grid grid-cols-3 gap-[0.42vw]">
                <x-form-group 
                    label="Idade Mín." 
                    type="number" 
                    name="idadeMinima" 
                    id="edit-oportunidade-idade-min" 
                    labelColor="green" 
                    textSize="xl" 
                    required
                >
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 17V3"/><path d="m6 11 6 6 6-6"/><path d="M19 21H5"/>
                        </svg>
                    </x-slot:icon>
                    <input 
                        type="number" 
                        name="idadeMinima"
                        class="hidden"
                        value="{{ old('idadeMinima', $oportunidade->idadeMinima) }}"
                    >
                </x-form-group>

                <x-form-group 
                    label="Idade Máx." 
                    type="number" 
                    name="idadeMaxima" 
                    id="edit-oportunidade-idade-max" 
                    labelColor="green" 
                    textSize="xl" 
                    required
                >
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m18 9-6-6-6 6"/><path d="M12 3v14"/><path d="M5 21h14"/>
                        </svg>
                    </x-slot:icon>
                    <input 
                        type="number" 
                        name="idadeMaxima"
                        class="hidden"
                        value="{{ old('idadeMaxima', $oportunidade->idadeMaxima) }}"
                    >
                </x-form-group>

                <x-form-group 
                    label="Vagas" 
                    type="number" 
                    name="limite_inscricoes" 
                    id="edit-oportunidade-limite" 
                    labelColor="green" 
                    textSize="xl" 
                    required
                >
                    <x-slot:icon>
                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </x-slot:icon>
                    <input 
                        type="number" 
                        name="limite_inscricoes"
                        class="hidden"
                        value="{{ old('limite_inscricoes', $oportunidade->limite_inscricoes) }}"
                    >
                </x-form-group>
            </div>

            <x-form-group 
                label="Descrição Detalhada" 
                name="descricaoOportunidades" 
                id="edit-oportunidade-descricao" 
                labelColor="green" 
                textSize="xl" 
                required
            >
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="21" x2="3" y1="6" y2="6"/><line x1="15" x2="3" y1="12" y2="12"/><line x1="17" x2="3" y1="18" y2="18"/>
                    </svg>
                </x-slot:icon>
                <textarea 
                    name="descricaoOportunidades" 
                    class="hidden"
                >{{ old('descricaoOportunidades', $oportunidade->descricaoOportunidades) }}</textarea>
            </x-form-group>
        </x-form>

        <x-slot:footer>
            <div class="w-full flex gap-x-[0.42vw] justify-end">
                <x-button color="gray" size="md" onclick="closeModal('edit-opportunity-{{ $oportunidade->id }}')">
                    Cancelar
                </x-button>

                <x-button 
                    id="btn-save-opportunity"
                    color="clube" 
                    size="md" 
                    onclick="saveOpportunityShow('form-edit-{{ $oportunidade->id }}', {{ $oportunidade->id }})"
                >
                    Salvar
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>

    {{-- MODAL DE DELETE --}}
    <x-modal 
        maxWidth="sm" 
        name="delete-opportunity-{{ $oportunidade->id }}" 
        title="Excluir oportunidade" 
        titleSize="xl" 
        titleColor="red"
    >
        <p class="text-sm text-gray-600">
            Tem certeza que deseja excluir a oportunidade 
            <span class="font-semibold">{{ $oportunidade->tituloOportunidades }}</span>?<br>
            Essa ação não pode ser desfeita.
        </p>

        <x-slot:footer>
            <div class="w-full flex gap-x-[0.42vw] justify-end">
                <x-button color="gray" size="md" onclick="closeModal('delete-opportunity-{{ $oportunidade->id }}')">
                    Cancelar
                </x-button>

                <x-button 
                    color="red" 
                    size="md" 
                    onclick="deleteOpportunityShow({{ $oportunidade->id }}, this)"
                >
                    Excluir
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>

    <script>
        const oportunidadesIndexUrl = "{{ route('clube.minhas-oportunidades') }}";

        function showOpportunityLoading() {
            document.body.style.overflow = 'hidden';
            document.getElementById('opportunity-loading')?.classList.remove('hidden');
        }

        function hideOpportunityLoading() {
            document.body.style.overflow = 'visible';
            document.getElementById('opportunity-loading')?.classList.add('hidden');
        }

        function openModal(name) {
            document.querySelector(`[data-modal-name="${name}"]`)?.classList.remove("hidden");
        }

        function closeModal(name) {
            document.querySelector(`[data-modal-name="${name}"]`)?.classList.add("hidden");
        }

        function toggleLoading(button, isLoading, loadingText = "Salvando...") {
            if (!button) return;

            if (isLoading) {
                button.dataset.original = button.innerText;
                button.innerText = loadingText;
                button.disabled = true;
            } else {
                button.innerText = button.dataset.original || "Salvar";
                button.disabled = false;
            }
        }

        function atualizarPosicoes(idSelectEsporte, idSelectAlvo) {
            let selectEsporte = document.querySelector(`#${idSelectEsporte} select`);
            let selectAlvo = document.querySelector(`#${idSelectAlvo} select`);

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

        async function saveOpportunityShow(formId, recordId) {
            const form = document.getElementById(formId);

            if (!form) {
                console.error("Formulário não encontrado:", formId);
                return;
            }

            const modal = document.querySelector(`#edit-opportunity-${recordId}`);
            const button = document.getElementById('btn-save-opportunity');

            toggleLoading(button, true);

            let url = `/api/clube/oportunidade-painel/${recordId}`;

            try {
                const formData = new FormData(form);

                const selectPosicoes = form.querySelector('select[name="posicoes_ids[]"]');
                if (selectPosicoes) {
                    formData.delete('posicoes_ids[]');
                    Array.from(selectPosicoes.selectedOptions).forEach(option => {
                        if (option.value && option.value.trim() !== "") {
                            formData.append('posicoes_ids[]', option.value);
                        }
                    });
                }

                if (!formData.has('posicoes_ids[]')) {
                    alert("Selecione pelo menos uma posição!");
                    toggleLoading(button, false);
                    return;
                }

                formData.append('_method', 'PUT');

                showOpportunityLoading();

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: formData,
                });

                const data = await response.json();

                if (!response.ok) {
                    let msg = data.message;
                    if (data.errors) {
                        msg = Object.values(data.errors).flat().join('\n');
                    }
                    throw new Error(msg || "Erro ao salvar oportunidade.");
                }

                // aqui é mais simples recarregar a página para atualizar os detalhes
                if (data.htmlGrid) {
                    document.querySelector('#opportunity-details').innerHTML = data.htmlGrid;
                }

                closeModal(`edit-opportunity-${recordId}`);

            } catch (error) {
                alert("Atenção:\n" + error.message);
                console.error(error);
                toggleLoading(button, false);
                hideOpportunityLoading();
            } finally {
                closeModal(`edit-opportunity-${recordId}`);
            }
        }

        async function deleteOpportunityShow(id, button) {
            const originalText = button.innerText;
            button.innerText = "Excluindo...";
            button.disabled = true;

            showOpportunityLoading();

            try {
                const url = `/api/clube/oportunidade-painel/${id}`;

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ _method: 'DELETE' }),
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || "Erro ao excluir oportunidade.");
                }

                closeModal(`delete-opportunity-${id}`);
                // depois de excluir, manda de volta pra lista
                window.location.href = oportunidadesIndexUrl;

            } catch (error) {
                alert(error.message);
                console.error(error);
                button.innerText = originalText;
                button.disabled = false;
            } finally {
                hideOpportunityLoading();
            }
        }

        // AS FUNÇÕES DE ACEITAR / REMOVER INSCRIÇÃO QUE VOCÊ JÁ TINHA:
        function aceitarInscricao(oportunidadeId, usuarioId) {
            showOpportunityLoading();

            fetch(`/api/clube/oportunidade/${oportunidadeId}/inscricoes/${usuarioId}/aceitar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                if (data.html) {
                    document.querySelector('#opportunity-details').innerHTML = data.html;
                }
            })
            .catch(err => console.error(err))
            .finally(() => {
                hideOpportunityLoading();
            });
        }

        function removerInscricao(oportunidadeId, usuarioId) {
            showOpportunityLoading();

            fetch(`/api/clube/oportunidade/${oportunidadeId}/inscricoes/${usuarioId}/remover`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                if (data.html) {
                    document.querySelector('#opportunity-details').innerHTML = data.html;
                }
            })
            .catch(err => console.error(err))
            .finally(() => {
                hideOpportunityLoading();
            });
        }
    </script>
</x-layouts.clube>
