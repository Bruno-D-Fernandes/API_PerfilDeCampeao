<x-layouts.clube title="Peneira Sub-17" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Minhas Oportunidades' => route('clube.minhas-oportunidades'),
    'Peneira Sub-17' => null
]">
    <div class="flex flex-col gap-6">
        <a href="{{ route('clube.minhas-oportunidades') }}" class="flex items-center gap-x-1 text-emerald-500 hover:text-emerald-700 transition-colors font-medium">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>

            Voltar
        </a>

        <div class="relative w-full flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div class="w-full flex items-center gap-x-4">
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

                <div class="flex items-center gap-x-2">
                    <x-icon-button color="blue">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                    </x-icon-button>
            
                    <div class="w-px h-4 bg-gray-200"></div>

                    <x-icon-button color="red">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </x-icon-button>
                </div>
            </div>  

            <div class="flex gap-x-4 font-medium text-md">
                <div class="flex gap-x-2 items-center text-gray-400">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>

                    {{ $oportunidade->inscricoes->count() }}/{{ $oportunidade->limite_inscricoes }} inscritos
                </div>

                <div class="flex gap-x-2 items-center text-emerald-500">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-icon lucide-circle-check"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>

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
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </x-slot>

                <x-slot name="icon_detalhes">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info-icon lucide-info"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
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
                                @forelse($oportunidade->inscricoes as $inscricao)
                                    @php
                                        $usuario = $inscricao->usuario;
                                    @endphp

                                    <tr class="hover:bg-gray-50 border-b border-gray-100 transition-colors">
                                        <td class="p-[0.75vw]">
                                            <div class="flex items-center gap-[0.83vw]">
                                                <img 
                                                    src="{{ $usuario->fotoPerfilUsuario ? asset('storage/'.$usuario->fotoPerfilUsuario) : asset('assets/images/default-avatar.png') }}" 
                                                    alt="{{ $usuario->nomeCompletoUsuario }}" 
                                                    class="h-[2vw] w-[2vw] rounded-full object-cover border border-gray-200"
                                                >
                                                <div class="flex flex-col">
                                                    <span class="text-[0.73vw] font-semibold text-gray-800">
                                                        {{ $usuario->nomeCompletoUsuario }}
                                                    </span>
                                                    <span class="text-[0.63vw] text-gray-500">
                                                        {{ $usuario->emailUsuario }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="p-[0.75vw] text-[0.73vw] text-gray-700">
                                            {{ $usuario->cidadeUsuario }} - {{ $usuario->estadoUsuario }}
                                        </td>

                                        <td class="p-[0.75vw] text-[0.73vw] text-gray-700">
                                            {{ \Carbon\Carbon::parse($usuario->dataNascimentoUsuario)->age }} anos
                                        </td>

                                        <td class="p-[0.75vw] text-[0.73vw] text-gray-700 capitalize">
                                            {{ $usuario->generoUsuario }}
                                        </td>

                                        @php
                                            $inscBadgeColor = match($inscricao->status) {
                                                'rejected' => 'red',
                                                'approved' => 'green',
                                                default => 'gray',
                                            };
                                        @endphp

                                        <td class="p-[0.75vw] text-[0.73vw] text-gray-700 capitalize">
                                            <x-badge color="{{ $inscBadgeColor }}" :border="false" class="px-2.5">
                                                {!! $inscricao->showHTMLStatus() !!}
                                            </x-badge>
                                        </td>

                                        <td class="p-[0.75vw]">
                                            <div class="flex items-center gap-[0.42vw]">
                                                <x-button size="sq" color="blue" type="button">
                                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                                </x-button>

                                                @if($inscricao->status === $inscricao::STATUS_APPROVED)
                                                    <x-button size="sq" color="red" onclick="openModal('remove-user-{{ $usuario->id }}')" title="Remover da Lista">
                                                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                                    </x-button>
                                                @elseif($inscricao->status === $inscricao::STATUS_PENDING)
                                                    <x-button size="sq" color="green" type="button">
                                                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                                                    </x-button>

                                                    <x-button size="sq" color="red" onclick="openModal('remove-user-{{ $usuario->id }}')">
                                                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                                    </x-button>
                                                @else
                                                    <x-button size="sq" color="red" onclick="openModal('remove-user-{{ $usuario->id }}')">
                                                        <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                                    </x-button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-[1.25vw] text-center text-gray-500 text-[0.94vw]">
                                            Nenhum usuário encontrado nesta lista.
                                        </td>
                                    </tr>
                                @endforelse
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

                            <div id="badges-container" class="flex flex-wrap w-full items-center justify-start gap-[0.42vw]">
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
                                    Limite: {{ $oportunidade->limite_inscricoes }} inscrições
                                </x-badge>

                                <x-badge color="gray" :border="false">
                                    Idade: {{ $oportunidade->idadeMinima ?? 0 }} - {{ $oportunidade->idadeMaxima ?? '∞' }}
                                </x-badge>

                                <x-badge color="{{ $oportunidade->status == 'approved' ? 'green' : ($oportunidade->status == 'rejected' ? 'red' : 'gray') }}" :border="false">
                                    {!! $oportunidade->showHTMLStatus() !!}
                                </x-badge>
                            </div>
                        </div>

                        {{-- Clube dono da oportunidade --}}
                        <div class="flex flex-col gap-[0.83vw] mt-[1vw]">
                            <span class="text-[0.83vw] font-semibold uppercase text-emerald-500 tracking-tight">Clube</span>
                            <span id="display-clube-nome" class="text-[0.83vw] font-semibold text-gray-900">
                                {{ $oportunidade->clube->nomeClube ?? 'Sem Nome' }}
                            </span>

                            <div class="flex flex-wrap gap-[0.42vw]">
                                <x-badge color="green" :border="false">
                                    Cidade: {{ $oportunidade->clube->cidadeClube ?? '-' }} - {{ $oportunidade->clube->estadoClube ?? '-' }}
                                </x-badge>

                                <x-badge color="green" :border="false">
                                    Fundado em {{ $oportunidade->clube->anoCriacaoClube ? \Carbon\Carbon::parse($oportunidade->clube->anoCriacaoClube)->format('Y') : '-' }}
                                </x-badge>

                                <x-badge color="green" :border="false">
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
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.getElementById('tabela-usuarios'); 
            const searchInput = table.querySelector('input');
            const headers = table.querySelectorAll('th.sortable-column');

            const urlParts = window.location.pathname.split('/');
            const oportunidadeId = urlParts[3];

            let sortColumn = null;
            let sortDirection = null;

            const fetchInscricoes = () => {
                const search = searchInput ? searchInput.value : '';

                const url = `/api/clube/oportunidade/${oportunidadeId}/inscricoes/search?search=${encodeURIComponent(search)}` +
                            (sortColumn ? `&sortColumn=${sortColumn}&sortDirection=${sortDirection}` : '');

                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.json())
                    .then(data => {
                        table.querySelector('tbody.table-body').innerHTML = data.html;
                    });
            };

            if (searchInput) {
                searchInput.addEventListener('input', fetchInscricoes);
            }

            headers.forEach(th => {
                th.addEventListener('click', () => {
                    const col = th.dataset.col;
                    let state = th.dataset.state;

                    state = state === 'neutral' ? 'asc' : state === 'asc' ? 'desc' : 'neutral';
                    th.dataset.state = state;

                    const iconNeutral = th.querySelector('.icon-neutral');
                    const iconAsc = th.querySelector('.icon-asc');
                    const iconDesc = th.querySelector('.icon-desc');

                    if (iconNeutral) iconNeutral.classList.toggle('hidden', state !== 'neutral');
                    if (iconAsc) iconAsc.classList.toggle('hidden', state !== 'asc');
                    if (iconDesc) iconDesc.classList.toggle('hidden', state !== 'desc');

                    headers.forEach(other => {
                        if (other !== th) {
                            other.dataset.state = 'neutral';
                            const iNeutral = other.querySelector('.icon-neutral');
                            const iAsc = other.querySelector('.icon-asc');
                            const iDesc = other.querySelector('.icon-desc');
                            if (iNeutral) iNeutral.classList.remove('hidden');
                            if (iAsc) iAsc.classList.add('hidden');
                            if (iDesc) iDesc.classList.add('hidden');
                        }
                    });

                    sortColumn = state === 'neutral' ? null : col;
                    sortDirection = state === 'neutral' ? null : state;
                    fetchInscricoes();
                });
            });
        });
    </script>
</x-layouts.clube>