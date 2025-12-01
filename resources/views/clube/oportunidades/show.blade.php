<x-layouts.clube title="Peneira Sub-17" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Minhas Oportunidades' => route('clube.minhas-oportunidades'),
    'Peneira Sub-17' => null
]">
    <div class="flex flex-col gap-[0.83vw]">
        <a href="{{ route('clube.minhas-oportunidades') }}" class="flex items-center gap-x-[0.21vw] text-emerald-500 hover:text-emerald-700 transition-colors font-medium">
            <svg class="w-[0.83vw] h-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left"><path d="m15 18-6-6 6-6"/></svg>

            Voltar
        </a>

        <div id="opportunity-details" class="relative w-full flex flex-col gap-4">
            @include('clube.partials.opportunity-details', ['oportunidade' => $oportunidade, 'esportes' => $esportes])
        </div>

        <div id="opportunity-loading" class="absolute inset-0 bg-white/50 backdrop-blur-sm z-[999] flex items-center justify-center hidden rounded-[0.42vw]">
            <svg class="animate-spin h-[1.67vw] w-[1.67vw] text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    <script>
        function showOpportunityLoading() {
            document.body.style.overflow = 'hidden';
            document.getElementById('opportunity-loading').classList.remove('hidden');
        }

        function hideOpportunityLoading() {
            document.body.style.overflow = 'visible';
            document.getElementById('opportunity-loading').classList.add('hidden');
        }

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
            })
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
            })
        }
    </script>
</x-layouts.clube>