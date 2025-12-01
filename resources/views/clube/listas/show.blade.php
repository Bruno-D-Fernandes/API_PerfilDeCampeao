<x-layouts.clube title="Zagueiros - Futebol" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Minhas Listas' => route('clube.listas'),
    $lista->nome => null
]">
    <div class="w-full h-full flex flex-col gap-[0.83vw]">
        <a href="" class="flex items-center gap-x-[0.21vw] text-emerald-500 hover:text-emerald-700 transition-colors font-medium">
            <svg class="w-[0.83vw] h-[0.83vw] stroke-[0.052vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>

            Voltar
        </a>

        <div id="list-details" class="relative w-full flex flex-col gap-[0.83vw]">
            @include('clube.partials.list-details', ['lista' => $lista, 'usuarios' => $lista->usuarios])
        </div>
    </div>

    <div id="list-loading" class="absolute inset-0 bg-white/50 backdrop-blur-sm z-[999] flex items-center justify-center hidden rounded-[0.42vw]">
        <svg class="animate-spin h-[1.67vw] w-[1.67vw] text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>

    <script>
        function showListLoading() {
            document.body.style.overflow = 'hidden';
            document.getElementById('list-loading').classList.remove('hidden');
        }

        function hideListLoading() {
            document.body.style.overflow = 'visible';
            document.getElementById('list-loading').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', () => {
            const table = document.getElementById('tabela-usuarios');
            const searchInput = table.querySelector('input');
            const headers = table.querySelectorAll('th.sortable-column');

            const urlParts = window.location.pathname.split('/');
            const listaId = urlParts[3];

            let sortColumn = null;
            let sortDirection = null;

            const fetchUsuarios = () => {
                const search = searchInput.value;

                const url = `/api/clube/listas/${listaId}/usuarios/search?search=${encodeURIComponent(search)}` +
                            (sortColumn ? `&sortColumn=${sortColumn}&sortDirection=${sortDirection}` : '');

                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.text())
                    .then(html => {
                        table.querySelector('tbody.table-body').innerHTML = html;
                    });
            };

            searchInput.addEventListener('input', fetchUsuarios);

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

                            const iconNeutralOther = other.querySelector('.icon-neutral');
                            const iconAscOther = other.querySelector('.icon-asc');
                            const iconDescOther = other.querySelector('.icon-desc');

                            if (iconNeutralOther) iconNeutralOther.classList.remove('hidden');
                            if (iconAscOther) iconAscOther.classList.add('hidden');
                            if (iconDescOther) iconDescOther.classList.add('hidden');
                        }
                    });

                    sortColumn = state === 'neutral' ? null : col;
                    sortDirection = state === 'neutral' ? null : state;
                    fetchUsuarios();
                });
            });

            document.addEventListener('change', function(e) {
                if (e.target && e.target.matches('input[type="checkbox"].save-list-checkbox')) {
                    const checkbox = e.target;
                    const listId = checkbox.dataset.listId;
                    const atletaId = checkbox.dataset.atletaId;
                    const isAdding = checkbox.checked;

                    if (!listId || !atletaId) return;

                    const method = isAdding ? 'POST' : 'DELETE';
                    const url = `/api/clube/listas/${listId}/usuarios/${atletaId}`;

                    fetch(url, {
                        method,
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(async response => {
                        if (!response.ok) throw new Error('Falha na requisição');

                        showToast('success', isAdding ? 'Adicionado!' : 'Removido!', `Atleta ${isAdding ? 'adicionado à' : 'removido da'} lista "${checkbox.closest('label').querySelector('span').innerText.trim()}"`);
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        checkbox.checked = !isAdding;
                        showToast('error', 'Erro', 'Não foi possível atualizar a lista.');
                    });
                }
            });
        });

        function confirmDeleteUser(userId, listId) {
            const url = `/api/clube/listas/${listId}/usuarios/${userId}`;

            showListLoading();

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.data) {
                    document.querySelector('#tabela-usuarios table tbody.table-body').innerHTML = data.data;
                } 
                
                closeModal(`remove-user-${userId}`);
            })
            .catch(err => {
                console.error(err);
            })
            .finally(() => {
                hideListLoading();
            });
        }
    </script>
</x-layouts.clube>