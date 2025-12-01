<x-layouts.admin title="Dashboard" :breadcrumb="[
    'Dashboard' => null,
]">
    <div class="h-full w-full flex flex-col overflow-y-hidden">
        <x-table tableId="tabela-funcoes">
            <x-slot:header>
                <x-table-header label="Nome" name="nome" :sortable="true" />
                <x-table-header label="Descrição" name="descricao" :sortable="true" />
                <x-table-header label="Status" name="status" />
                <x-table-header label="Ações" />
            </x-slot:header>

            <x-slot:body>
                
            </x-slot:body>
        </x-table>

        <script type="module">
            document.addEventListener('DOMContentLoaded', () => {
                
                new DataTable({
                    tableId: 'tabela-funcoes',
                    apiUrl: '{{ route("admin.funcoes.listar") }}',
                    tokenKey: 'admin_token',    
                    renderRow: (item) => {
                        
                        const isAtivo = item.status === 'ativo';
                        
                        const badgeStyle = isAtivo ? {
                            text: 'text-emerald-400',
                            bg: 'bg-emerald-50',
                            border: 'border-emerald-200',
                            dot: 'bg-emerald-400'
                        } : {
                            text: 'text-red-400',
                            bg: 'bg-red-50',
                            border: 'border-red-200',
                            dot: 'bg-red-400'
                        };


                        const btnBase = "cursor-pointer p-[0.42vw] rounded-[0.42vw] hover:bg-gray-100 focus:outline-none transition-colors duration-200";

                        const btnBlue = "text-sky-600 hover:text-sky-700 focus:ring-sky-500";
                        const btnRed = "text-red-600 hover:text-red-700 focus:ring-red-500";

                        return `
                            <tr class="bg-white hover:bg-gray-50 border-b border-gray-100 transition-colors">
                                
                                <td class="px-[1.25vw] py-[0.83vw] text-[0.73vw] text-gray-700 font-medium">
                                    ${item.nome}
                                </td>
                                
                                <td class="px-[1.25vw] py-[0.83vw] text-[0.73vw] text-gray-500">
                                    ${item.descricao || '<span class="italic text-gray-400">Sem descrição</span>'}
                                </td>
                                
                                <td class="px-[1.25vw] py-[0.83vw]">
                                    <span class="inline-flex items-center rounded-[0.83vw] py-[0.31vw] px-[0.73vw] text-[0.63vw] font-medium ring-[0.052vw] ring-inset ${badgeStyle.bg} ${badgeStyle.text} ${badgeStyle.border}">
                                        <span class="mr-[0.21vw] h-[0.21vw] w-[0.21vw] rounded-full ${badgeStyle.dot}"></span>
                                        ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
                                    </span>
                                </td>
                                
                                <td class="px-[1.25vw] py-[0.83vw] text-right">
                                    <div class="flex items-center justify-start gap-[0.42vw]">
                                        
                                        <button type="button" onclick="editarFuncao(${item.id})" 
                                            class="${btnBase} ${btnBlue}" title="Editar">
                                            <svg class="w-[0.83vw] h-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <button type="button" onclick="deletarFuncao(${item.id})" 
                                            class="${btnBase} ${btnRed}" title="Deletar">
                                            <svg class="w-[0.83vw] h-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        `;
                    }
                });

            });
        </script>
    </div>
</x-layouts.admin>