<x-layouts.admin :title="'Oportunidades'" :breadcrumb="[
    ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
    ['label' => 'Oportunidades', 'url' => route('admin.oportunidades')],
]">
    <div
        class="h-full w-full flex flex-col"
        x-data="adminOportunidadesPage()"
        x-init="init()"
    >
        <div class="flex-grow grid grid-rows-[auto_1fr] gap-[0.83vw]">
            {{-- MÉTRICAS + FILTROS DE STATUS --}}
            <div class="w-full grid grid-cols-4 gap-[0.83vw]">
                {{-- Total --}}
                <button
                    type="button"
                    class="bg-white p-[0.83vw] rounded-lg border border-[0.15vw] transition-colors flex flex-col gap-[0.42vw] text-left"
                    :class="statusFilter === 'all' ? 'border-sky-500 bg-sky-50' : 'border-gray-200 hover:border-sky-500'"
                    @click="setStatusFilter('all')"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-[0.73vw] font-medium text-gray-500">
                            Oportunidades totais
                        </span>

                        <div class="flex items-center justify-center h-[1.46vw] w-[1.46vw] rounded-full bg-sky-50">
                            <svg class="h-[0.83vw] w-[0.83vw] text-sky-500/80" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 0-2-2V8a2 2 0 0 1 2-2z"/>
                                <path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"/>
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-baseline gap-[0.31vw]">
                        <span class="text-[1.25vw] font-semibold text-gray-900" x-text="metrics.total ?? 0">0</span>
                        <span class="text-[0.63vw] text-gray-500">
                            registradas
                        </span>
                    </div>

                    <p class="text-[0.63vw] text-gray-400">
                        Inclui aprovadas, pendentes e rejeitadas.
                    </p>
                </button>

                {{-- Aprovadas --}}
                <button
                    type="button"
                    class="bg-white p-[0.83vw] rounded-lg border border-[0.15vw] transition-colors flex flex-col gap-[0.42vw] text-left"
                    :class="statusFilter === 'approved' ? 'border-sky-500 bg-sky-50' : 'border-gray-200 hover:border-sky-500'"
                    @click="setStatusFilter('approved')"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-[0.73vw] font-medium text-gray-500">
                            Aprovadas
                        </span>

                        <div class="flex items-center justify-center h-[1.46vw] w-[1.46vw] rounded-full bg-green-50">
                            <svg class="h-[0.83vw] w-[0.83vw] text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-baseline gap-[0.31vw]">
                        <span class="text-[1.25vw] font-semibold text-gray-900" x-text="metrics.approved ?? 0">0</span>
                        <span class="text-[0.63vw] text-gray-500">
                            publicadas
                        </span>
                    </div>

                    <p class="text-[0.63vw] text-gray-400">
                        Visíveis para atletas na plataforma.
                    </p>
                </button>

                {{-- Pendentes --}}
                <button
                    type="button"
                    class="bg-white p-[0.83vw] rounded-lg border border-[0.15vw] transition-colors flex flex-col gap-[0.42vw] text-left"
                    :class="statusFilter === 'pending' ? 'border-sky-500 bg-sky-50' : 'border-gray-200 hover:border-sky-500'"
                    @click="setStatusFilter('pending')"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-[0.73vw] font-medium text-gray-500">
                            Pendentes
                        </span>

                        <div class="flex items-center justify-center h-[1.46vw] w-[1.46vw] rounded-full bg-amber-50">
                            <svg class="h-[0.83vw] w-[0.83vw] text-amber-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 6v6l3 3"/>
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-baseline gap-[0.31vw]">
                        <span class="text-[1.25vw] font-semibold text-gray-900" x-text="metrics.pending ?? 0">0</span>
                        <span class="text-[0.63vw] text-gray-500">
                            aguardando análise
                        </span>
                    </div>

                    <p class="text-[0.63vw] text-gray-400">
                        Aguardando aprovação ou recusa do admin.
                    </p>
                </button>

                {{-- Rejeitadas --}}
                <button
                    type="button"
                    class="bg-white p-[0.83vw] rounded-lg border border-[0.15vw] transition-colors flex flex-col gap-[0.42vw] text-left"
                    :class="statusFilter === 'rejected' ? 'border-sky-500 bg-sky-50' : 'border-gray-200 hover:border-sky-500'"
                    @click="setStatusFilter('rejected')"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-[0.73vw] font-medium text-gray-500">
                            Rejeitadas
                        </span>

                        <div class="flex items-center justify-center h-[1.46vw] w-[1.46vw] rounded-full bg-red-50">
                            <svg class="h-[0.83vw] w-[0.83vw] text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="m15 9-6 6"/>
                                <path d="m9 9 6 6"/>
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-baseline gap-[0.31vw]">
                        <span class="text-[1.25vw] font-semibold text-gray-900" x-text="metrics.rejected ?? 0">0</span>
                        <span class="text-[0.63vw] text-gray-500">
                            não aprovadas
                        </span>
                    </div>

                    <p class="text-[0.63vw] text-gray-400">
                        Exigem revisão da justificativa enviada.
                    </p>
                </button>
            </div>

            {{-- CONTEÚDO PRINCIPAL: FILTROS + TABELA --}}
            <div class="flex-1 h-full">
                <div class="h-full bg-white p-[0.83vw] rounded-lg border border-[0.15vw] border-gray-200 hover:border-sky-500 transition-colors flex flex-col gap-[0.63vw]">
                    {{-- Header da tabela / filtros --}}
                    <div class="flex items-center justify-between gap-[0.83vw]">
                        <div class="flex flex-col gap-[0.21vw]">
                            <h2 class="text-[0.94vw] font-semibold text-gray-800">
                                Gerenciamento de oportunidades
                            </h2>
                            <p class="text-[0.63vw] text-gray-500">
                                Visualize, filtre e gerencie as oportunidades criadas pelos clubes.
                            </p>
                        </div>

                        <div class="flex items-center gap-[0.63vw]">
                            <div class="relative">
                                <input
                                    type="text"
                                    class="border border-gray-200 focus:border-sky-500 focus:ring-0 rounded-md text-[0.73vw] px-[0.73vw] py-[0.42vw] w-[10.4vw] placeholder:text-gray-400"
                                    placeholder="Buscar por título ou clube..."
                                    x-model.debounce.500ms="search"
                                    @input="fetchOportunidades()"
                                >
                                <svg class="h-[0.73vw] w-[0.73vw] text-gray-400 absolute right-[0.52vw] top-1/2 -translate-y-1/2 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"/>
                                    <path d="m21 21-4.3-4.3"/>
                                </svg>
                            </div>

                            <select
                                class="border border-gray-200 focus:border-sky-500 focus:ring-0 rounded-md text-[0.73vw] px-[0.73vw] py-[0.31vw] bg-white"
                                x-model.number="perPage"
                                @change="changePerPage()"
                            >
                                <option value="10">10 por página</option>
                                <option value="15">15 por página</option>
                                <option value="25">25 por página</option>
                                <option value="50">50 por página</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tabela --}}
                    <div class="flex-1 flex flex-col min-h-0">
                        <div class="flex-1 overflow-auto">
                            <x-table class="w-full">
                                <x-slot:header>
                                    <th class="text-left text-[0.73vw] font-semibold text-gray-600 px-[0.63vw] py-[0.52vw]">
                                        Clube
                                    </th>
                                    <th class="text-left text-[0.73vw] font-semibold text-gray-600 px-[0.63vw] py-[0.52vw]">
                                        Oportunidade
                                    </th>
                                    <th class="text-left text-[0.73vw] font-semibold text-gray-600 px-[0.63vw] py-[0.52vw]">
                                        Esporte
                                    </th>
                                    <th class="text-left text-[0.73vw] font-semibold text-gray-600 px-[0.63vw] py-[0.52vw]">
                                        Inscrições
                                    </th>
                                    <th class="text-left text-[0.73vw] font-semibold text-gray-600 px-[0.63vw] py-[0.52vw]">
                                        Publicada em
                                    </th>
                                    <th class="text-left text-[0.73vw] font-semibold text-gray-600 px-[0.63vw] py-[0.52vw]">
                                        Status
                                    </th>
                                    <th class="text-right text-[0.73vw] font-semibold text-gray-600 px-[0.63vw] py-[0.52vw]">
                                        Ações
                                    </th>
                                </x-slot:header>

                                {{-- slot de ações vazio pra não dar erro --}}
                                <x-slot:actions></x-slot:actions>

                                <x-slot:body>
                                    {{-- loading --}}
                                    <tr x-show="loading">
                                        <td colspan="7" class="px-[0.83vw] py-[0.83vw] text-center">
                                            <span class="text-[0.73vw] text-gray-500">
                                                Carregando oportunidades...
                                            </span>
                                        </td>
                                    </tr>

                                    {{-- vazio --}}
                                    <tr x-show="!loading && (!oportunidades.data || oportunidades.data.length === 0)">
                                        <td colspan="7" class="px-[0.83vw] py-[0.83vw]">
                                            <x-empty-state text="Nenhuma oportunidade encontrada.">
                                                <x-slot:icon>
                                                    <svg class="h-[1.67vw] w-[1.67vw] text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 0-2-2V8a2 2 0 0 1 2-2z"/>
                                                        <path d="M8 6v8"/>
                                                        <path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"/>
                                                    </svg>
                                                </x-slot:icon>
                                                <p class="text-gray-400 font-normal text-[0.83vw]">
                                                    Ajuste os filtros ou tente uma nova busca.
                                                </p>
                                            </x-empty-state>
                                        </td>
                                    </tr>

                                    {{-- linhas --}}
                                    <template x-if="!loading && oportunidades.data && oportunidades.data.length">
                                        <template x-for="opp in oportunidades.data" :key="opp.id">
                                            <tr class="border-b border-gray-100 hover:bg-sky-50/50 transition-colors">
                                                {{-- Clube --}}
                                                <td class="px-[0.63vw] py-[0.52vw]">
                                                    <div class="flex items-center gap-[0.52vw]">
                                                        <div class="flex-shrink-0">
                                                            <template x-if="opp.clube && opp.clube.fotoPerfilClube">
                                                                <img
                                                                    :src="opp.clube.fotoPerfilClube"
                                                                    class="h-[1.46vw] w-[1.46vw] rounded-full object-cover border border-gray-200"
                                                                    alt=""
                                                                >
                                                            </template>
                                                            <template x-if="!opp.clube || !opp.clube.fotoPerfilClube">
                                                                <div class="h-[1.46vw] w-[1.46vw] rounded-full bg-sky-50 flex items-center justify-center border border-sky-100">
                                                                    <span class="text-[0.73vw] font-semibold text-sky-500" x-text="(opp.clube && opp.clube.nomeClube ? opp.clube.nomeClube.charAt(0) : '?')"></span>
                                                                </div>
                                                            </template>
                                                        </div>

                                                        <div class="flex flex-col min-w-0">
                                                            <span class="text-[0.73vw] font-medium text-gray-800 truncate" x-text="opp.clube?.nomeClube ?? 'Clube'"></span>
                                                            <span class="text-[0.63vw] text-gray-400 truncate" x-text="opp.clube?.cidadeClube && opp.clube?.estadoClube ? (opp.clube.cidadeClube + ' - ' + opp.clube.estadoClube) : ''"></span>
                                                        </div>
                                                    </div>
                                                </td>

                                                {{-- Oportunidade --}}
                                                <td class="px-[0.63vw] py-[0.52vw] max-w-[12vw]">
                                                    <div class="flex flex-col gap-[0.10vw] min-w-0">
                                                        <span class="text-[0.73vw] font-medium text-gray-800 truncate" x-text="opp.tituloOportunidades"></span>
                                                        <span class="text-[0.63vw] text-gray-400 truncate" x-text="opp.descricaoOportunidades"></span>
                                                    </div>
                                                </td>

                                                {{-- Esporte --}}
                                                <td class="px-[0.63vw] py-[0.52vw]">
                                                    <span class="inline-flex items-center gap-[0.31vw] text-[0.73vw] text-gray-700">
                                                        <svg class="h-[0.73vw] w-[0.73vw] text-sky-500/80" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <circle cx="9" cy="9" r="4"/>
                                                            <path d="M9 13v9"/>
                                                            <path d="m17 3-5 5"/>
                                                            <path d="m21 7-5-5"/>
                                                        </svg>
                                                        <span x-text="opp.esporte?.nomeEsporte ?? '—'"></span>
                                                    </span>
                                                </td>

                                                {{-- Inscrições --}}
                                                <td class="px-[0.63vw] py-[0.52vw]">
                                                    <div class="flex items-center gap-[0.31vw] text-[0.73vw] text-gray-700">
                                                        <svg class="h-[0.73vw] w-[0.73vw] text-sky-500/80" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                                            <circle cx="9" cy="7" r="4"/>
                                                        </svg>
                                                        <span x-text="opp.inscricoes_count ?? 0"></span>
                                                    </div>
                                                </td>

                                                {{-- data --}}
                                                <td class="px-[0.63vw] py-[0.52vw]">
                                                    <span class="text-[0.73vw] text-gray-600" x-text="formatDate(opp.datapostagemOportunidades)"></span>
                                                </td>

                                                {{-- status --}}
                                                <td class="px-[0.63vw] py-[0.52vw]">
                                                    <span
                                                        class="inline-flex items-center gap-[0.31vw] px-[0.52vw] py-[0.21vw] rounded-full border text-[0.63vw] font-medium"
                                                        :class="statusBadgeClass(opp.status)"
                                                    >
                                                        <span
                                                            class="h-[0.42vw] w-[0.42vw] rounded-full"
                                                            :class="statusDotClass(opp.status)"
                                                        ></span>
                                                        <span x-text="statusLabel(opp.status)"></span>
                                                    </span>
                                                </td>

                                                {{-- Ações --}}
                                                <td class="px-[0.63vw] py-[0.52vw] text-right">
                                                    <div class="flex items-center justify-end gap-[0.31vw]">
                                                        <button
                                                            type="button"
                                                            class="text-[0.63vw] px-[0.52vw] py-[0.31vw] rounded-md border border-gray-200 text-gray-700 hover:border-sky-500 hover:text-sky-600 transition-colors"
                                                            @click="openDetalhes(opp)"
                                                        >
                                                            Ver detalhes
                                                        </button>

                                                        <button
                                                            type="button"
                                                            class="text-[0.63vw] px-[0.52vw] py-[0.31vw] rounded-md border border-gray-200 text-gray-700 hover:border-sky-500 hover:text-sky-600 transition-colors"
                                                            @click="openInscritos(opp)"
                                                        >
                                                            Ver inscritos
                                                        </button>

                                                        <button
                                                            type="button"
                                                            class="text-[0.63vw] px-[0.52vw] py-[0.31vw] rounded-md bg-sky-500 text-white hover:bg-sky-600 transition-colors"
                                                            @click="openEditar(opp)"
                                                        >
                                                            Editar
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </template>
                                </x-slot:body>
                            </x-table>
                        </div>

                        {{-- Paginação --}}
                        <div class="flex items-center justify-between pt-[0.52vw]">
                            <div class="text-[0.63vw] text-gray-500" x-show="oportunidades.total">
                                <span x-text="`Mostrando ${oportunidades.from ?? 0} - ${oportunidades.to ?? 0} de ${oportunidades.total ?? 0} oportunidades`"></span>
                            </div>

                            <div class="flex items-center gap-[0.31vw]">
                                <button
                                    type="button"
                                    class="px-[0.52vw] py-[0.21vw] rounded-md border border-gray-200 text-[0.63vw] text-gray-600 disabled:opacity-40 disabled:cursor-not-allowed hover:border-sky-500 hover:text-sky-600 transition-colors"
                                    :disabled="!oportunidades.prev_page_url"
                                    @click="changePage(oportunidades.current_page - 1)"
                                >
                                    Anterior
                                </button>
                                <span class="text-[0.63vw] text-gray-500">
                                    Página <span x-text="oportunidades.current_page ?? 1"></span>
                                    de <span x-text="oportunidades.last_page ?? 1"></span>
                                </span>
                                <button
                                    type="button"
                                    class="px-[0.52vw] py-[0.21vw] rounded-md border border-gray-200 text-[0.63vw] text-gray-600 disabled:opacity-40 disabled:cursor-not-allowed hover:border-sky-500 hover:text-sky-600 transition-colors"
                                    :disabled="!oportunidades.next_page_url"
                                    @click="changePage(oportunidades.current_page + 1)"
                                >
                                    Próxima
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL: DETALHES --}}
        <div
            x-show="modalDetalhesOpen"
            x-cloak
            @click.self="closeAllModals()"
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/40 hidden"
        >
            <div class="bg-white rounded-lg shadow-lg w-[32vw] max-h-[80vh] flex flex-col border border-gray-200">
                <div class="px-[0.83vw] py-[0.63vw] border-b border-gray-100 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="text-[0.83vw] font-semibold text-gray-800">
                            Detalhes da oportunidade
                        </span>
                        <span class="text-[0.63vw] text-gray-500" x-text="selectedOpp?.tituloOportunidades ?? ''"></span>
                    </div>

                    <button
                        type="button"
                        class="h-[1.25vw] w-[1.25vw] flex items-center justify-center rounded-full hover:bg-gray-100"
                        @click="closeAllModals()"
                    >
                        <svg class="h-[0.73vw] w-[0.73vw] text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 6 6 18"/>
                            <path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="px-[0.83vw] py-[0.63vw] flex-1 overflow-auto space-y-[0.63vw]">
                    <div class="flex items-center gap-[0.52vw]">
                        <div class="flex-shrink-0">
                            <template x-if="selectedOpp?.clube && selectedOpp?.clube.fotoPerfilClube">
                                <img
                                    :src="selectedOpp.clube.fotoPerfilClube"
                                    class="h-[1.88vw] w-[1.88vw] rounded-full object-cover border border-gray-200"
                                    alt=""
                                >
                            </template>
                            <template x-if="!selectedOpp?.clube || !selectedOpp?.clube.fotoPerfilClube">
                                <div class="h-[1.88vw] w-[1.88vw] rounded-full bg-sky-50 flex items-center justify-center border border-sky-100">
                                    <span class="text-[0.83vw] font-semibold text-sky-500" x-text="selectedOpp?.clube?.nomeClube ? selectedOpp.clube.nomeClube.charAt(0) : '?'"></span>
                                </div>
                            </template>
                        </div>

                        <div class="flex flex-col min-w-0">
                            <span class="text-[0.78vw] font-medium text-gray-800 truncate" x-text="selectedOpp?.clube?.nomeClube ?? 'Clube'"></span>
                            <span class="text-[0.63vw] text-gray-500 truncate" x-text="selectedOpp?.clube?.cidadeClube && selectedOpp?.clube?.estadoClube ? (selectedOpp.clube.cidadeClube + ' - ' + selectedOpp.clube.estadoClube) : ''"></span>
                        </div>
                    </div>

                    <div class="border border-gray-100 rounded-md p-[0.63vw] space-y-[0.31vw]">
                        <p class="text-[0.73vw] font-medium text-gray-700">
                            Informações gerais
                        </p>
                        <p class="text-[0.73vw] text-gray-600" x-text="selectedOpp?.descricaoOportunidades ?? 'Sem descrição.'"></p>

                        <div class="grid grid-cols-2 gap-[0.52vw] pt-[0.31vw]">
                            <div class="flex flex-col gap-[0.10vw]">
                                <span class="text-[0.63vw] text-gray-500">
                                    Esporte
                                </span>
                                <span class="text-[0.73vw] text-gray-800" x-text="selectedOpp?.esporte?.nomeEsporte ?? '—'"></span>
                            </div>
                            <div class="flex flex-col gap-[0.10vw]">
                                <span class="text-[0.63vw] text-gray-500">
                                    Publicada em
                                </span>
                                <span class="text-[0.73vw] text-gray-800" x-text="formatDate(selectedOpp?.datapostagemOportunidades)"></span>
                            </div>
                            <div class="flex flex-col gap-[0.10vw]">
                                <span class="text-[0.63vw] text-gray-500">
                                    Idade mínima
                                </span>
                                <span class="text-[0.73vw] text-gray-800" x-text="selectedOpp?.idadeMinima ?? '—'"></span>
                            </div>
                            <div class="flex flex-col gap-[0.10vw]">
                                <span class="text-[0.63vw] text-gray-500">
                                    Idade máxima
                                </span>
                                <span class="text-[0.73vw] text-gray-800" x-text="selectedOpp?.idadeMaxima ?? '—'"></span>
                            </div>
                            <div class="flex flex-col gap-[0.10vw]">
                                <span class="text-[0.63vw] text-gray-500">
                                    Limite de inscrições
                                </span>
                                <span class="text-[0.73vw] text-gray-800" x-text="selectedOpp?.limite_inscricoes ?? 'Sem limite'"></span>
                            </div>
                            <div class="flex flex-col gap-[0.10vw]">
                                <span class="text-[0.63vw] text-gray-500">
                                    Status
                                </span>
                                <span
                                    class="inline-flex items-center gap-[0.31vw] px-[0.52vw] py-[0.21vw] rounded-full border text-[0.63vw] font-medium w-max"
                                    :class="statusBadgeClass(selectedOpp?.status)"
                                >
                                    <span class="h-[0.42vw] w-[0.42vw] rounded-full" :class="statusDotClass(selectedOpp?.status)"></span>
                                    <span x-text="statusLabel(selectedOpp?.status)"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <template x-if="selectedOpp?.rejection_reason">
                        <div class="border border-red-100 bg-red-50/40 rounded-md p-[0.63vw] space-y-[0.31vw]">
                            <p class="text-[0.73vw] font-medium text-red-700">
                                Motivo da rejeição
                            </p>
                            <p class="text-[0.73vw] text-red-600" x-text="selectedOpp?.rejection_reason"></p>
                        </div>
                    </template>
                </div>

                <div class="px-[0.83vw] py-[0.63vw] border-t border-gray-100 flex justify-end gap-[0.42vw]">
                    <button
                        type="button"
                        class="px-[0.83vw] py-[0.42vw] rounded-md border border-gray-200 text-[0.73vw] text-gray-700 hover:border-sky-500 hover:text-sky-600 transition-colors"
                        @click="closeAllModals()"
                    >
                        Fechar
                    </button>
                </div>
            </div>
        </div>

        {{-- MODAL: INSCRITOS --}}
        <div
            x-show="modalInscritosOpen"
            x-cloak
            @click.self="closeAllModals()"
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/40 hidden"
        >
            <div class="bg-white rounded-lg shadow-lg w-[30vw] max-h-[80vh] flex flex-col border border-gray-200">
                <div class="px-[0.83vw] py-[0.63vw] border-b border-gray-100 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="text-[0.83vw] font-semibold text-gray-800">
                            Inscritos na oportunidade
                        </span>
                        <span class="text-[0.63vw] text-gray-500" x-text="selectedOpp?.tituloOportunidades ?? ''"></span>
                    </div>

                    <button
                        type="button"
                        class="h-[1.25vw] w-[1.25vw] flex items-center justify-center rounded-full hover:bg-gray-100"
                        @click="closeAllModals()"
                    >
                        <svg class="h-[0.73vw] w-[0.73vw] text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 6 6 18"/>
                            <path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="px-[0.83vw] py-[0.63vw] flex-1 overflow-auto space-y-[0.42vw]">
                    <template x-if="loadingInscritos">
                        <p class="text-[0.73vw] text-gray-500">
                            Carregando inscritos...
                        </p>
                    </template>

                    <template x-if="!loadingInscritos && (!inscritos || inscritos.length === 0)">
                        <x-empty-state text="Nenhum inscrito encontrado.">
                            <x-slot:icon>
                                <svg class="h-[1.46vw] w-[1.46vw] text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <line x1="17" x2="22" y1="8" y2="13"/>
                                    <line x1="22" x2="17" y1="8" y2="13"/>
                                </svg>
                            </x-slot:icon>
                            <p class="text-gray-400 font-normal text-[0.83vw]">
                                Ainda não há candidaturas para esta oportunidade.
                            </p>
                        </x-empty-state>
                    </template>

                    <template x-if="!loadingInscritos && inscritos && inscritos.length">
                        <div class="flex flex-col gap-[0.42vw]">
                            <template x-for="insc in inscritos" :key="insc.id">
                                <div class="flex items-center justify-between gap-[0.52vw] border-b border-gray-100 last:border-b-0 pb-[0.42vw]">
                                    <div class="flex items-center gap-[0.42vw] min-w-0">
                                        <div class="h-[1.25vw] w-[1.25vw] rounded-full bg-sky-50 flex items-center justify-center">
                                            <svg class="h-[0.73vw] w-[0.73vw] text-sky-500/80" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                                <circle cx="12" cy="7" r="4"/>
                                            </svg>
                                        </div>

                                        <div class="flex flex-col min-w-0">
                                            <span class="text-[0.73vw] font-medium text-gray-800 truncate" x-text="insc.usuario?.nomeCompletoUsuario ?? 'Usuário'"></span>
                                            <span class="text-[0.63vw] text-gray-500 truncate" x-text="insc.usuario?.emailUsuario ?? ''"></span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-end gap-[0.10vw]">
                                        <span
                                            class="inline-flex items-center gap-[0.21vw] px-[0.42vw] py-[0.10vw] rounded-full border text-[0.63vw] font-medium"
                                            :class="statusBadgeClass(insc.status)"
                                        >
                                            <span class="h-[0.36vw] w-[0.36vw] rounded-full" :class="statusDotClass(insc.status)"></span>
                                            <span x-text="statusLabel(insc.status)"></span>
                                        </span>
                                        <span class="text-[0.63vw] text-gray-400" x-text="formatDateTime(insc.created_at)"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>

                <div class="px-[0.83vw] py-[0.63vw] border-t border-gray-100 flex justify-end">
                    <button
                        type="button"
                        class="px-[0.83vw] py-[0.42vw] rounded-md border border-gray-200 text-[0.73vw] text-gray-700 hover:border-sky-500 hover:text-sky-600 transition-colors"
                        @click="closeAllModals()"
                    >
                        Fechar
                    </button>
                </div>
            </div>
        </div>

        {{-- MODAL: EDITAR (BÁSICO / STATUS) --}}
        <div
            x-show="modalEditarOpen"
            x-cloak
            @click.self="closeAllModals()"
            class="fixed inset-0 z-40 flex items-center justify-center bg-black/40 hidden"
        >
            <div class="bg-white rounded-lg shadow-lg w-[28vw] max-h-[80vh] flex flex-col border border-gray-200">
                <div class="px-[0.83vw] py-[0.63vw] border-b border-gray-100 flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="text-[0.83vw] font-semibold text-gray-800">
                            Editar oportunidade
                        </span>
                        <span class="text-[0.63vw] text-gray-500" x-text="selectedOpp?.tituloOportunidades ?? ''"></span>
                    </div>

                    <button
                        type="button"
                        class="h-[1.25vw] w-[1.25vw] flex items-center justify-center rounded-full hover:bg-gray-100"
                        @click="closeAllModals()"
                    >
                        <svg class="h-[0.73vw] w-[0.73vw] text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 6 6 18"/>
                            <path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </div>

                <form @submit.prevent="submitEditar">
                    <div class="px-[0.83vw] py-[0.63vw] flex-1 overflow-auto space-y-[0.52vw]">
                        <div class="flex flex-col gap-[0.21vw]">
                            <label class="text-[0.63vw] text-gray-600">
                                Título
                            </label>
                            <input
                                type="text"
                                class="border border-gray-200 focus:border-sky-500 focus:ring-0 rounded-md text-[0.73vw] px-[0.63vw] py-[0.31vw] w-full"
                                x-model="formEditar.tituloOportunidades"
                            >
                        </div>

                        <div class="flex flex-col gap-[0.21vw]">
                            <label class="text-[0.63vw] text-gray-600">
                                Descrição
                            </label>
                            <textarea
                                rows="3"
                                class="border border-gray-200 focus:border-sky-500 focus:ring-0 rounded-md text-[0.73vw] px-[0.63vw] py-[0.31vw] w-full resize-none"
                                x-model="formEditar.descricaoOportunidades"
                            ></textarea>
                        </div>

                        <div class="grid grid-cols-3 gap-[0.52vw]">
                            <div class="flex flex-col gap-[0.21vw]">
                                <label class="text-[0.63vw] text-gray-600">
                                    Idade mín.
                                </label>
                                <input
                                    type="number"
                                    min="0"
                                    class="border border-gray-200 focus:border-sky-500 focus:ring-0 rounded-md text-[0.73vw] px-[0.52vw] py-[0.31vw]"
                                    x-model.number="formEditar.idadeMinima"
                                >
                            </div>
                            <div class="flex flex-col gap-[0.21vw]">
                                <label class="text-[0.63vw] text-gray-600">
                                    Idade máx.
                                </label>
                                <input
                                    type="number"
                                    min="0"
                                    class="border border-gray-200 focus:border-sky-500 focus:ring-0 rounded-md text-[0.73vw] px-[0.52vw] py-[0.31vw]"
                                    x-model.number="formEditar.idadeMaxima"
                                >
                            </div>
                            <div class="flex flex-col gap-[0.21vw]">
                                <label class="text-[0.63vw] text-gray-600">
                                    Limite inscrições
                                </label>
                                <input
                                    type="number"
                                    min="0"
                                    class="border border-gray-200 focus:border-sky-500 focus:ring-0 rounded-md text-[0.73vw] px-[0.52vw] py-[0.31vw]"
                                    x-model.number="formEditar.limite_inscricoes"
                                >
                            </div>
                        </div>

                        <div class="flex flex-col gap-[0.21vw]">
                            <label class="text-[0.63vw] text-gray-600">
                                Status
                            </label>
                            <div class="flex items-center gap-[0.42vw]">
                                <label class="inline-flex items-center gap-[0.21vw] text-[0.73vw] text-gray-700 cursor-pointer">
                                    <input
                                        type="radio"
                                        value="approved"
                                        x-model="formEditar.status"
                                        class="h-[0.63vw] w-[0.63vw] text-sky-500 border-gray-300"
                                    >
                                    <span>Aprovada</span>
                                </label>
                                <label class="inline-flex items-center gap-[0.21vw] text-[0.73vw] text-gray-700 cursor-pointer">
                                    <input
                                        type="radio"
                                        value="pending"
                                        x-model="formEditar.status"
                                        class="h-[0.63vw] w-[0.63vw] text-sky-500 border-gray-300"
                                    >
                                    <span>Pendente</span>
                                </label>
                                <label class="inline-flex items-center gap-[0.21vw] text-[0.73vw] text-gray-700 cursor-pointer">
                                    <input
                                        type="radio"
                                        value="rejected"
                                        x-model="formEditar.status"
                                        class="h-[0.63vw] w-[0.63vw] text-sky-500 border-gray-300"
                                    >
                                    <span>Rejeitada</span>
                                </label>
                            </div>
                        </div>

                        <template x-if="formEditar.status === 'rejected'">
                            <div class="flex flex-col gap-[0.21vw]">
                                <label class="text-[0.63vw] text-red-600">
                                    Motivo da rejeição
                                </label>
                                <textarea
                                    rows="2"
                                    class="border border-red-200 focus:border-red-500 focus:ring-0 rounded-md text-[0.73vw] px-[0.63vw] py-[0.31vw] w-full resize-none"
                                    x-model="formEditar.rejection_reason"
                                    placeholder="Descreva brevemente o motivo da rejeição..."
                                ></textarea>
                            </div>
                        </template>

                        <template x-if="formEditarError">
                            <p class="text-[0.63vw] text-red-500" x-text="formEditarError"></p>
                        </template>
                    </div>

                    <div class="px-[0.83vw] py-[0.63vw] border-t border-gray-100 flex justify-end gap-[0.42vw]">
                        <button
                            type="button"
                            class="px-[0.83vw] py-[0.42vw] rounded-md border border-gray-200 text-[0.73vw] text-gray-700 hover:border-sky-500 hover:text-sky-600 transition-colors"
                            @click="closeAllModals()"
                        >
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            class="px-[0.94vw] py-[0.42vw] rounded-md bg-sky-500 text-[0.73vw] font-medium text-white hover:bg-sky-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="savingEditar"
                        >
                            <span x-show="!savingEditar">Salvar alterações</span>
                            <span x-show="savingEditar">Salvando...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>

@push('scripts')
<script>
    function adminOportunidadesPage() {
        return {
            // estado
            loading: false,
            statusFilter: 'all',
            search: '',
            perPage: 15,
            page: 1,

            metrics: {
                total: 0,
                approved: 0,
                pending: 0,
                rejected: 0,
            },

            oportunidades: {
                data: [],
                current_page: 1,
                last_page: 1,
                from: 0,
                to: 0,
                total: 0,
                prev_page_url: null,
                next_page_url: null,
            },

            // modais
            modalDetalhesOpen: false,
            modalInscritosOpen: false,
            modalEditarOpen: false,

            selectedOpp: null,
            inscritos: [],
            loadingInscritos: false,

            formEditar: {
                id: null,
                tituloOportunidades: '',
                descricaoOportunidades: '',
                idadeMinima: null,
                idadeMaxima: null,
                limite_inscricoes: null,
                status: 'pending',
                rejection_reason: '',
            },
            formEditarError: '',
            savingEditar: false,

            apiBase() {
                return '{{ url('/admin/oportunidades') }}';
            },
            init() {
                this.fetchMetrics();
                this.fetchOportunidades();
            },

            closeAllModals() {
                this.modalDetalhesOpen = false;
                this.modalInscritosOpen = false;
                this.modalEditarOpen   = false;
            },

            async fetchMetrics() {
    try {
        const url = this.apiBase() + '/metrics';
        const res = await fetch(url, { credentials: 'include' });

        console.log('[ADMIN OPORTUNIDADES] metrics status', res.status);

        if (!res.ok) {
            console.error('Resposta não OK em /metrics');
            return;
        }

        const data = await res.json();
        console.log('[ADMIN OPORTUNIDADES] metrics data', data);

        this.metrics.total    = data.total ?? 0;
        this.metrics.approved = data.approved ?? 0;
        this.metrics.pending  = data.pending ?? 0;
        this.metrics.rejected = data.rejected ?? 0;
    } catch (e) {
        console.error('Erro ao carregar métricas:', e);
    }
},

async fetchOportunidades() {
    this.loading = true;

    const params = new URLSearchParams();
    if (this.statusFilter !== 'all') {
        params.set('status', this.statusFilter);
    }
    if (this.search) {
        params.set('search', this.search);
    }
    params.set('per_page', this.perPage);
    params.set('page', this.page);

    try {
        const url = this.apiBase() + '/list?' + params.toString();
        console.log('[ADMIN OPORTUNIDADES] GET', url);

        const res = await fetch(url, { credentials: 'include' });

        console.log('[ADMIN OPORTUNIDADES] list status', res.status);

        if (!res.ok) {
            // se estiver vindo HTML de login, isso aqui ajuda a ver
            const text = await res.text();
            console.error('Resposta não OK em /list, corpo:', text);
            this.loading = false;
            return;
        }

        const data = await res.json();
        console.log('[ADMIN OPORTUNIDADES] list data', data);

        this.oportunidades = data;
    } catch (e) {
        console.error('Erro ao carregar oportunidades:', e);
    } finally {
        this.loading = false;
    }
},

            setStatusFilter(status) {
                this.statusFilter = status;
                this.page = 1;
                this.fetchOportunidades();
            },

            changePerPage() {
                this.page = 1;
                this.fetchOportunidades();
            },

            changePage(newPage) {
                if (newPage < 1 || newPage > (this.oportunidades.last_page ?? 1)) return;
                this.page = newPage;
                this.fetchOportunidades();
            },

            statusLabel(status) {
                if (status === 'approved') return 'Aprovada';
                if (status === 'rejected') return 'Rejeitada';
                if (status === 'pending') return 'Pendente';
                return '—';
            },

            statusBadgeClass(status) {
                if (status === 'approved') {
                    return 'border-green-200 bg-green-50 text-green-700';
                }
                if (status === 'rejected') {
                    return 'border-red-200 bg-red-50 text-red-700';
                }
                if (status === 'pending') {
                    return 'border-amber-200 bg-amber-50 text-amber-700';
                }
                return 'border-gray-200 bg-gray-50 text-gray-600';
            },

            statusDotClass(status) {
                if (status === 'approved') return 'bg-green-500';
                if (status === 'rejected') return 'bg-red-500';
                if (status === 'pending') return 'bg-amber-500';
                return 'bg-gray-400';
            },

            formatDate(dateStr) {
                if (!dateStr) return '—';
                const d = new Date(dateStr);
                if (Number.isNaN(d.getTime())) return dateStr;
                return d.toLocaleDateString('pt-BR');
            },

            formatDateTime(dateStr) {
                if (!dateStr) return '—';
                const d = new Date(dateStr);
                if (Number.isNaN(d.getTime())) return dateStr;
                return d.toLocaleString('pt-BR');
            },

            openDetalhes(opp) {
                this.selectedOpp = opp;
                this.closeAllModals();
                this.modalDetalhesOpen = true;
            },

            async openInscritos(opp) {
                this.selectedOpp = opp;
                this.closeAllModals();
                this.modalInscritosOpen = true;
                this.loadingInscritos = true;
                this.inscritos = [];

                try {
                    const url = this.apiBase() + '/' + opp.id + '/inscritos';
                    const res = await fetch(url, { credentials: 'include' });
                    if (!res.ok) {
                        console.error('Erro ao carregar inscritos', res.status);
                        this.loadingInscritos = false;
                        return;
                    }

                    const data = await res.json();
                    this.inscritos = data.data ?? data ?? [];
                } catch (e) {
                    console.error('Erro ao carregar inscritos:', e);
                } finally {
                    this.loadingInscritos = false;
                }
            },

            openEditar(opp) {
                this.selectedOpp = opp;
                this.formEditar = {
                    id: opp.id,
                    tituloOportunidades: opp.tituloOportunidades ?? '',
                    descricaoOportunidades: opp.descricaoOportunidades ?? '',
                    idadeMinima: opp.idadeMinima ?? null,
                    idadeMaxima: opp.idadeMaxima ?? null,
                    limite_inscricoes: opp.limite_inscricoes ?? null,
                    status: opp.status ?? 'pending',
                    rejection_reason: opp.rejection_reason ?? '',
                };
                this.formEditarError = '';
                this.closeAllModals();
                this.modalEditarOpen = true;
            },

            async submitEditar() {
                this.formEditarError = '';
                this.savingEditar = true;

                try {
                    const url = this.apiBase() + '/' + this.formEditar.id;
                    const res = await fetch(url, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        credentials: 'include',
                        body: JSON.stringify(this.formEditar),
                    });

                    if (!res.ok) {
                        const data = await res.json().catch(() => ({}));
                        this.formEditarError = data.message ?? 'Erro ao salvar alterações.';
                        this.savingEditar = false;
                        return;
                    }

                    this.closeAllModals();
                    this.fetchMetrics();
                    this.fetchOportunidades();
                } catch (e) {
                    console.error('Erro ao editar oportunidade:', e);
                    this.formEditarError = 'Erro inesperado ao salvar.';
                } finally {
                    this.savingEditar = false;
                }
            },
        }
    }
</script>
@endpush
