<div class="flex oportunidades-center justify-between">
    <div class="w-full flex oportunidades-center gap-x-[0.83vw]">
        <p class="text-4xl font-medium tracking-tight text-emerald-500">
            {{ $oportunidade->tituloOportunidades }}
        </p>

        @php
            $badgeColor = match($oportunidade->status) {
                'rejected' => 'red',
                'approved' => 'green',
                default => 'gray',
            };
        @endphp

        <x-badge color="{{ $badgeColor }}" :border="false" class="px-2.5">
            {!! $oportunidade->showHTMLStatus() !!}
        </x-badge>
    </div>

    <div class="flex oportunidades-center gap-x-[0.42vw]">
        <x-icon-button color="blue" onclick="openModal('edit-opportunity-{{ $oportunidade->id }}')">
            <svg class="h-[1.25vw] w-[1.25vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
        </x-icon-button>

        <div class="w-px h-[0.83vw] bg-gray-200"></div>

        <x-icon-button color="red" onclick="openModal('delete-opportunity-{{ $oportunidade->id }}')">
            <svg class="h-[1.25vw] w-[1.25vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
        </x-icon-button>
    </div>
</div>  

<div class="flex gap-x-[0.83vw] font-medium text-md">
    <div class="flex gap-x-[0.42vw] oportunidades-center text-gray-400">
        <svg class="h-[1.25vw] w-[1.25vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>

        {{ $oportunidade->inscricoes->count() }}/{{ $oportunidade->limite_inscricoes }} inscritos
    </div>

    <div class="flex gap-x-[0.42vw] oportunidades-center text-emerald-500">
        <svg class="h-[1.25vw] w-[1.25vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-icon lucide-circle-check"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>

        {{ $oportunidade->inscricoesAprovadas->count() }} aprovados
    </div>
</div>

<x-tabs 
    :options="[
        'todas' => 'Todas Inscrições',
        'detalhes' => 'Detalhes'
    ]" 
    default="todas"
>
    <x-slot name="icon_todas">
        <svg class="w-[0.83vw] h-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
    </x-slot>

    <x-slot name="icon_detalhes">
        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info-icon lucide-info"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
    </x-slot>

    <x-slot name="todas">
        <div class="w-full flex justify-center">
            <x-table tableId="tabela-usuarios">
                <x-slot:header>
                    <x-table-header label="Atleta" name="nomeCompletoUsuario" :sortable="true" />
                    
                    <x-table-header label="Localização" name="cidadeUsuario" :sortable="true" />
                    
                    <x-table-header label="Idade" name="dataNascimentoUsuario" :sortable="true" />

                    <x-table-header label="Gênero" name="generoUsuario" :sortable="true" />

                    <x-table-header label="Status" name="status" :sortable="true" />
                    
                    <x-table-header label="Ações" />
                </x-slot:header>

                <x-slot:body>
                    @include('clube.partials.inscricoes-table-body', ['inscricoes' => $oportunidade->inscricoes])
                </x-slot:body>
            </x-table>
        </div>
    </x-slot>

    <x-slot name="detalhes">
        <div class="w-full flex flex-col gap-[0.83vw]">
            <div class="flex flex-col gap-[0.83vw]">
                <span class="text-[0.83vw] font-semibold uppercase text-emerald-500 tracking-tight">Detalhes da Oportunidade</span>
                
                <span id="display-titulo" class="w-full text-[0.83vw] font-semibold text-gray-900">
                    {{ $oportunidade->tituloOportunidades }}
                </span>

                <span id="display-descricao" class="w-full text-[0.83vw] font-normal text-gray-700 line-clamp-4">
                    {{ $oportunidade->descricaoOportunidades }}
                </span>

                <div id="badges-container" class="flex flex-wrap w-full oportunidades-center justify-start gap-[0.42vw]">
                    <x-badge color="green" :border="false">
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                        </x-slot:icon>

                        {{ $oportunidade->esporte->nomeEsporte ?? 'Sem Esporte' }}
                    </x-badge>

                    @foreach($oportunidade->posicoes as $posicao)
                        <x-badge color="blue" :border="false">
                            <x-slot:icon>
                                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-star-icon lucide-circle-star"><path d="M11.051 7.616a1 1 0 0 1 1.909.024l.737 1.452a1 1 0 0 0 .737.535l1.634.256a1 1 0 0 1 .588 1.806l-1.172 1.168a1 1 0 0 0-.282.866l.259 1.613a1 1 0 0 1-1.541 1.134l-1.465-.75a1 1 0 0 0-.912 0l-1.465.75a1 1 0 0 1-1.539-1.133l.258-1.613a1 1 0 0 0-.282-.867l-1.156-1.152a1 1 0 0 1 .572-1.822l1.633-.256a1 1 0 0 0 .737-.535z"/><circle cx="12" cy="12" r="10"/></svg>
                            </x-slot:icon>
                            {{ $posicao->nomePosicao }}
                        </x-badge>
                    @endforeach

                    <x-badge color="emerald" :border="false">
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ban-icon lucide-ban"><path d="M4.929 4.929 19.07 19.071"/><circle cx="12" cy="12" r="10"/></svg>
                        </x-slot:icon>

                        {{ $oportunidade->limite_inscricoes }} inscrições
                    </x-badge>

                    <x-badge color="gray" :border="false">
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.93vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                        </x-slot:icon>

                        {{ $oportunidade->idadeMinima ?? 0 }} - {{ $oportunidade->idadeMaxima ?? '∞' }} anos
                    </x-badge>

                    <x-badge color="{{ $oportunidade->status == 'approved' ? 'green' : ($oportunidade->status == 'rejected' ? 'red' : 'gray') }}" :border="false">
                        {!! $oportunidade->showHTMLStatus() !!}
                    </x-badge>
                </div>
            </div>

            <div class="flex flex-col gap-[0.83vw] mt-[1vw]">
                <span class="text-[0.83vw] font-semibold uppercase text-emerald-500 tracking-tight">Clube</span>
                <span id="display-clube-nome" class="text-[0.83vw] font-semibold text-gray-900">
                    {{ $oportunidade->clube->nomeClube ?? 'Sem Nome' }}
                </span>

                <div class="flex flex-wrap gap-[0.42vw]">
                    <x-badge color="green" :border="false">
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-icon lucide-map"><path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/></svg>
                        </x-slot:icon>

                        {{ $oportunidade->clube->cidadeClube ?? '-' }} - {{ $oportunidade->clube->estadoClube ?? '-' }}
                    </x-badge>

                    <x-badge color="green" :border="false">
                        <x-slot:icon>
                            <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-icon lucide-calendar"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                        </x-slot:icon>

                        Fundado em {{ $oportunidade->clube->anoCriacaoClube ? \Carbon\Carbon::parse($oportunidade->clube->anoCriacaoClube)->format('Y') : '-' }}
                    </x-badge>

                    <x-badge color="green" :border="false">
                        <x-slot:icon>
                            <svg class="w-[0.83vw] h-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag-icon lucide-tag"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/></svg>
                        </x-slot:icon>

                        Categoria: {{ $oportunidade->clube->categoria->nomeCategoria ?? 'Sem Categoria' }}
                    </x-badge>
                </div>

                <span class="text-[0.83vw] font-normal text-gray-700 mt-[0.5vw]">
                    {{ $oportunidade->clube->bioClube ?? 'O clube ainda não adicionou uma biografia.' }}
                </span>
            </div>
        </div>
    </x-slot>
</x-tabs>

<x-modal maxWidth="2xl" name="edit-opportunity-{{ $oportunidade->id }}" title="Editar oportunidade" titleSize="2xl" titleColor="blue">
    <x-form id="form-edit-{{ $oportunidade->id }}" class="flex flex-col gap-[0.42vw]">
        @csrf
        @method('PUT')
        
        <x-form-group label="Título" name="tituloOportunidades" id="oportunidade-titulo-{{ $oportunidade->id }}" labelColor="blue" textSize="xl" value="{{ $oportunidade->tituloOportunidades }}" required>
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type-icon"><path d="M12 4v16"/><path d="M4 7V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2"/><path d="M9 20h6"/></svg>
            </x-slot:icon>
        </x-form-group>

        <div class="grid grid-cols-2 gap-[0.42vw]">
            <x-form-group label="Esporte" type="select" name="esporte_id" id="oportunidade-esporte-{{ $oportunidade->id }}" labelColor="blue" textSize="xl" required onchange="atualizarPosicoes('edit-esporte-{{ $oportunidade->id }}', 'oportunidade-posicoes-{{ $oportunidade->id }}')">
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                </x-slot:icon>

                <option value="">Selecione...</option>
                    @foreach($esportes as $esporte)
                        <option value="{{ $esporte->id }}" {{ $oportunidade->esporte_id == $esporte->id ? 'selected' : '' }}>
                            {{ $esporte->nomeEsporte ?? $esporte->nome }}
                        </option>
                    @endforeach
            </x-form-group>

            <x-form-group label="Posições (Segure Ctrl)" name="posicoes_ids[]" id="oportunidade-posicoes" type="select" multiple size="1" labelColor="blue" textSize="xl" class="h-[2.5vw]">
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-target-icon"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                </x-slot:icon>
                
                @foreach($oportunidade->esporte->posicoes as $pos)
                    <option value="{{ $pos->id }}" {{ $oportunidade->posicoes->contains($pos->id) ? 'selected' : '' }}>
                        {{ $pos->nomePosicao ?? $pos->nome }}
                    </option>
                @endforeach
            </x-form-group>
        </div>

        <div class="grid grid-cols-3 gap-[0.42vw]">
            <x-form-group label="Idade Mín." type="number" name="idadeMinima" id="oportunidade-idade-min-{{ $oportunidade->id }}" labelColor="blue" textSize="xl" value="{{ $oportunidade->idadeMinima }}" required>
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down-to-line"><path d="M12 17V3"/><path d="m6 11 6 6 6-6"/><path d="M19 21H5"/></svg>
                </x-slot:icon>
            </x-form-group>

            <x-form-group label="Idade Máx." type="number" name="idadeMaxima" id="oportunidade-idade-max-{{ $oportunidade->id }}" labelColor="blue" textSize="xl" value="{{ $oportunidade->idadeMaxima }}" required>
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-from-line"><path d="m18 9-6-6-6 6"/><path d="M12 3v14"/><path d="M5 21h14"/></svg>
                </x-slot:icon>
            </x-form-group>

            <x-form-group label="Vagas" type="number" name="limite_inscricoes" id="oportunidade-limite-{{ $oportunidade->id }}" labelColor="blue" textSize="xl" value="{{ $oportunidade->limite_inscricoes }}" required>
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </x-slot:icon>
            </x-form-group>
        </div>

        <x-form-group label="Descrição" name="descricaoOportunidades" id="oportunidade-descricao-{{ $oportunidade->id }}" labelColor="blue" textSize="xl" value="{{ $oportunidade->descricaoOportunidades }}" required>
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-text-align-center-icon"><path d="M21 5H3"/><path d="M17 12H7"/><path d="M19 19H5"/></svg>
            </x-slot:icon>
        </x-form-group>
    </x-form>

    <x-slot:footer>
        <div class="w-full flex gap-x-[0.42vw] justify-end">
            <x-button color="gray" size="md" onclick="closeModal('edit-opportunity-{{ $oportunidade->id }}')">
                Cancelar
            </x-button>

            <x-button color="none" size="md" class="bg-sky-300 text-white hover:bg-sky-600"  onclick="saveOpportunityAjax({{ $oportunidade->id }})">
                Salvar
            </x-button>
        </div>
    </x-slot:footer>
</x-modal>

<x-modal maxWidth="lg" name="delete-opportunity-{{ $oportunidade->id }}" title="Excluir oportunidade" titleSize="xl" titleColor="red">
    <div class="p-[0.83vw] text-center">
        <div class="mx-auto flex items-center justify-center h-[2.5vw] w-[2.5vw] rounded-full bg-red-100 mb-[0.83vw]">
            <svg class="h-[1.25vw] w-[1.25vw] text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h3 class="text-[0.94vw] leading-6 font-medium text-gray-900">Tem certeza absoluta?</h3>
        <p class="text-[0.73vw] text-gray-500 mt-[0.42vw]">
            Você está prestes a excluir <strong>"{{ $oportunidade->tituloOportunidades }}"</strong>. Essa ação é irreversível.
        </p>
    </div>

    <x-slot:footer>
        <div class="w-full flex gap-x-[0.42vw] justify-end">
            <x-button color="gray" size="md" onclick="closeModal('delete-opportunity-{{ $oportunidade->id }}')">Cancelar</x-button>
            <x-button color="red" size="md">Sim, excluir</x-button>
        </div>
    </x-slot:footer>
</x-modal>

<script>
    function saveOpportunityAjax(opportunityId) {
        const form = document.getElementById(`form-edit-${opportunityId}`);
        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        showOpportunityLoading();

        fetch(`/api/clube/oportunidade-painel/${opportunityId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            document.querySelector('#opportunity-details').innerHTML = data.data.htmlShow;
        })
        .catch(err => {
            console.error(err);
            alert('Erro na requisição!');
        })
        .finally(() => {
            hideOpportunityLoading();
        });
    }

    function deleteOpportunityAjax(opportunityId) {
        if (!confirm('Tem certeza que deseja excluir esta oportunidade?')) return;

        showOpportunityLoading();

        fetch(`/api/oportunidades/${opportunityId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            hideOpportunityLoading();
            if (data.success) {
                alert('Oportunidade excluída!');
                window.location.href = '/oportunidades';
            } else {
                alert(data.message || 'Erro ao excluir!');
            }
        })
        .catch(err => {
            hideOpportunityLoading();
            console.error(err);
            alert('Erro na requisição!');
        });
    }
</script>