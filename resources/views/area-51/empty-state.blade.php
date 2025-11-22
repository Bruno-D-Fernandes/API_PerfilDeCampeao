<x-layouts.admin title="Oportunidades" :breadcrumb="[
    'Dashboard' => route('admin-clubes'),
    'Oportunidades' => null
]">
    <x-empty-state text="Sem projetos.">
        <x-slot:icon>
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-code-icon lucide-folder-code"><path d="M10 10.5 8 13l2 2.5"/><path d="m14 10.5 2 2.5-2 2.5"/><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2z"/></svg>
        </x-slot:icon>

        <p class="text-gray-400 font-normal text-md">
            Você ainda não criou nenhum projeto.
        </p>

        <p class="text-gray-400 font-normal text-md">
            Crie um projeto agora.
        </p>

        <x-slot:actions>
            <button class="py-2 px-3 font-medium text-md text-white bg-sky-500 rounded-lg cursor-pointer hover:bg-sky-600 transition-transform hover:-translate-y-0.5 transition-colors">
                Adicionar projeto
            </button>
        </x-slot:actions>
    </x-empty-state>
</x-layouts.admin>