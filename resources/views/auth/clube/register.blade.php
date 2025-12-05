<x-layouts.form title="Cadastro" class="p-8">
    <x-slot name="left">
        <div id="toast-container" class="fixed top-[0.83vw] left-[0.83vw] z-[9999] flex flex-col gap-[0.63vw] pointer-events-auto"></div>

        <div class="w-full h-full flex items-center justify-center">
            <x-form-card title="O Futur Começa Hoje" description="Informe seus dados e acesse o Perfil de Campeão hoje mesmo!  " color="green">
                <x-slot:logo>
                    <div class="flex items-center gap-x-[0.42vw] h-[3.33vw]">
                        <img src="{{ asset('img/logo-clube.png') }}" alt="" class="h-full object-fit">

                        <span class="text-[1.13vw] font-semibold text-emerald-600 tracking-tight">
                            Perfil de Campeão
                        </span>
                    </div>
                </x-slot:logo>

                <ol class="flex items-center w-full text-[0.73vw] font-medium text-center text-gray-700 sm:text-base">
                    <li id="crumb-1" class="flex md:w-full items-center sm:after:content-[''] after:w-full after:h-[0.21vw] after:border-b after:border-default after:border-px after:hidden sm:after:inline-block after:mx-[1.25vw] xl:after:mx-[2.1vw]">
                        <span class="me-[0.42vw]">
                            <span id="crumb-num-1">1</span>
                        
                            <svg id="crumb-check-1" class="w-[1.04vw] h-[1.04vw]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        </span>

                        Acesso
                    </li>

                    <li id="crumb-2" class="flex md:w-full items-center sm:after:content-[''] after:w-full after:h-[0.21vw] after:border-b after:border-default after:border-px after:hidden sm:after:inline-block after:mx-[1.25vw] xl:after:mx-[2.1vw]">
                        <span class="me-[0.42vw]">
                            <span id="crumb-num-2">2</span>
                        
                            <svg id="crumb-check-2" class="w-[1.04vw] h-[1.04vw]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        </span>

                        Identidade
                    </li>

                    <li id="crumb-3" class="flex items-center">
                        <span class="me-[0.42vw]">
                            <span id="crumb-num-3">3</span>
                        
                            <svg id="crumb-check-3" class="w-[1.04vw] h-[1.04vw]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        </span>

                        Localização
                    </li>
                </ol>

                <x-form method="POST" id="signup-form" action="{{ route('clube.cadastro.submit') }}" class="w-full flex flex-col gap-[0.83vw]">
                    <div id="step-1" class="form-step flex flex-col gap-[0.83vw]">
                        <h3 class="text-[0.93vw] font-semibold text-emerald-700/80">Dados de Acesso</h3>
                        
                        <x-form-group label="CNPJ" name="cnpjClube" type="text" labelColor="green" required>
                            <x-slot:icon>
                                <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-id-card-icon lucide-id-card"><path d="M16 10h2"/><path d="M16 14h2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><rect x="2" y="5" width="20" height="14" rx="2"/></svg>
                            </x-slot:icon>
                        </x-form-group>

                        <x-form-group label="Email" name="emailClube" type="text" labelColor="green" required>
                            <x-slot:icon>
                                <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                            </x-slot:icon>
                        </x-form-group>

                        <x-form-group label="Senha" name="senhaClube" type="password" labelColor="green" required>

                        </x-form-group>

                        <x-form-group label="Confirmar senha" name="senhaClube_confirmation" type="password" labelColor="green" required>
                            <x-slot:icon>
                                <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-key-round-icon lucide-key-round"><path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"/><circle cx="16.5" cy="7.5" r=".5" fill="currentColor"/></svg>
                            </x-slot:icon>
                        </x-form-group>
                    </div>

                    <div id="step-2" class="hidden form-step flex flex-col gap-[0.83vw]">
                        <h3 class="text-[0.93vw] font-semibold text-emerald-700/80">Identidade do Clube</h3>
                        
                        <x-form-group label="Nome" name="nomeClube" type="text" labelColor="green" required>
                            <x-slot:icon>
                                <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-id-card-icon lucide-id-card"><path d="M16 10h2"/><path d="M16 14h2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><rect x="2" y="5" width="20" height="14" rx="2"/></svg>
                            </x-slot:icon>
                        </x-form-group>

                        <x-form-group label="Ano de criação" name="anoCriacaoClube" type="date" labelColor="green" required>
                           
                        </x-form-group>

                        <x-form-group label="Esporte" name="esporte_id" type="select" labelColor="green" required>
                            <x-slot:icon>
                                <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                            </x-slot:icon>

                            @foreach($esportes as $esporte)
                                <option value="{{ $esporte->id }}">
                                    {{ $esporte->nomeEsporte }}
                                </option>
                            @endforeach
                        </x-form-group>

                        <x-form-group label="Categoria" name="categoria_id" type="select" labelColor="green" required>
                            <x-slot:icon>
                                <svg class="w-[1.04vw] h-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tag-icon lucide-tag"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/></svg>
                            </x-slot:icon>

                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">
                                    {{ $categoria->nomeCategoria }}
                                </option>
                            @endforeach
                        </x-form-group>
                    </div>

                    <div id="step-3" class="hidden form-step flex flex-col gap-[0.83vw]">
                        <h3 class="text-[0.93vw] font-semibold text-emerald-700/80">Localização do Clube</h3>
                        
                         <x-form-group id="cepClube" label="Cep" name="cepClube" type="text" onblur="cepComplete()"  labelColor="green">
                            <x-slot:icon>
                                <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pinned-icon lucide-map-pinned"><path d="M18 8c0 3.613-3.869 7.429-5.393 8.795a1 1 0 0 1-1.214 0C9.87 15.429 6 11.613 6 8a6 6 0 0 1 12 0"/><circle cx="12" cy="8" r="2"/><path d="M8.714 14h-3.71a1 1 0 0 0-.948.683l-2.004 6A1 1 0 0 0 3 22h18a1 1 0 0 0 .948-1.316l-2-6a1 1 0 0 0-.949-.684h-3.712"/></svg>
                            </x-slot:icon>
                        </x-form-group>

                        <x-form-group id="cidadeClube" label="Cidade" name="cidadeClube" type="text" labelColor="green" required>
                            <x-slot:icon>
                                <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-icon lucide-building"><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M12 6h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/><path d="M8 6h.01"/><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect x="4" y="2" width="16" height="20" rx="2"/></svg>
                            </x-slot:icon>
                        </x-form-group>

                        <x-form-group id="estadoClube" label="Estado" name="estadoClube" type="select" labelColor="green" required>
                            <x-slot:icon>
                                <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-icon lucide-map"><path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/></svg>
                            </x-slot:icon>

                            @foreach(['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES',
                            'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR',
                            'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC',
                            'SP', 'SE', 'TO'] as $estado)
                                <option value="{{ $estado }}">
                                    {{ $estado }}
                                </option>
                            @endforeach
                        </x-form-group>

                        <x-form-group id="enderecoClube" label="Endereço" name="enderecoClube" type="text" labelColor="green" required>
                            <x-slot:icon>
                                <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house-icon lucide-house"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                            </x-slot:icon>
                        </x-form-group>

                        <x-checkbox color="green" name="accepted">
                            <x-slot:link>
                                <span class="inline-flex gap-x-[0.21vw] text-[0.83vw] text-gray-500 font-medium">
                                    Eu concordo com os

                                    <a href="" class="text-emerald-500 underline">
                                        Termos e Condições
                                    </a>
                                </span>
                            </x-slot:link>
                        </x-checkbox>
                    </div>

                    <x-slot:actions>
                        <button type="button" id="btn-prev" onclick="changeStep(-1)" class="hidden cursor-pointer w-full bg-gray-200 text-gray-600 hover:bg-gray-300 font-medium text-[0.93vw] p-[0.83vw] rounded-[0.5w] transition-transform hover:-translate-y-0.5">
                            Voltar
                        </button>

                        <button type="button" id="btn-next" onclick="changeStep(1)" class="cursor-pointer w-full bg-emerald-500 hover:bg-emerald-600 text-white font-medium text-[0.93vw] p-[0.83vw] rounded-[0.5vw] transition-transform hover:-translate-y-0.5 transition-colors">
                            Avançar
                        </button>

                        <button type="submit" id="btn-submit" class="hidden cursor-pointer w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-[0.93vw] p-[0.83vw] rounded-[0.5vw] transition-transform hover:-translate-y-0.5 transition-colors">
                            Finalizar Cadastro
                        </button>
                    </x-slot:actions>

                    <x-slot:link>
                        <span class="inline-flex gap-x-[0.21vw]">
                            <span class="text-gray-600 font-medium text-[0.83vw]">
                                Já tem uma conta?
                            </span>

                            <a href="/clube/login" class="text-emerald-500 font-medium text-[0.83vw]">
                                Fazer login
                            </a>
                        </span>
                    </x-slot:link>
                </x-form>
            </x-form-card>
        </div>
    </x-slot>

    <x-slot name="right">
        <div class="relative w-full h-full rounded-[1vw] overflow-hidden">
            <img src="{{ asset('img/cadastro-clube-img.jpg') }}" class="w-full h-full object-cover" alt="" />

            <div class="absolute bottom-[1.67vw] left-[1.67vw] right-[1.67vw] flex flex-col gap-[0.83vw]">
                <h1 class="text-white text-[1.63vw] font-semibold tracking-tight">
                    O Futuro Começa Hoje.
                </h1>

                <h2 class="text-white text-[1.03vw] font-medium tracking-tight">
                    Descubra hoje os ídolos de amanhã.
                </h2>
            </div>

            <div class="absolute top-[1.67vw] right-[1.67vw] bg-black/40 rounded-[0.5vw] p-[0.83vw]">
                <p class="text-white text-[0.93vw] font-normal">
                    Encontre talentos.
                </p>
            </div>
        </div>
    </x-slot>
</x-layouts.form>

@once
<script>
    let currentStep = 1;
    const totalSteps = 3;

    document.addEventListener('DOMContentLoaded', () => {
        updateUI();
    });

    function changeStep(direction) {
        if (direction === 1 && !validateStep(currentStep)) {
            return;
        }

        document.getElementById(`step-${currentStep}`).classList.add('hidden');
        
        currentStep += direction;
        
        document.getElementById(`step-${currentStep}`).classList.remove('hidden');

        updateUI();
    }

    function validateStep(step) {
        const currentDiv = document.getElementById(`step-${step}`);
        const inputs = currentDiv.querySelectorAll('input, select');
        
        let isValid = true;

        for (let input of inputs) {
            if (!input.checkValidity()) {
                input.reportValidity();
                isValid = false;
                break;
            }
        }

        return isValid;
    }

    function updateUI() {
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');
        const btnSubmit = document.getElementById('btn-submit');

        if (currentStep === 1) btnPrev.classList.add('hidden');
        else btnPrev.classList.remove('hidden');

        if (currentStep === totalSteps) {
            btnNext.classList.add('hidden');
            btnSubmit.classList.remove('hidden');
        } else {
            btnNext.classList.remove('hidden');
            btnSubmit.classList.add('hidden');
        }

        for (let i = 1; i <= totalSteps; i++) {
            const crumb = document.getElementById(`crumb-${i}`);
            const num = document.getElementById(`crumb-num-${i}`);
            const check = document.getElementById(`crumb-check-${i}`);
            
            crumb.classList.remove('text-emerald-600', 'text-gray-500', 'text-gray-400');

            if (i < currentStep) {
                crumb.classList.add('text-emerald-600');
                num.classList.add('hidden');
                check.classList.remove('hidden');
            } 
            else if (i === currentStep) {
                crumb.classList.add('text-emerald-600');
                num.classList.remove('hidden');
                check.classList.add('hidden');
            } 
            else {
                crumb.classList.add('text-gray-400');
                num.classList.remove('hidden');
                check.classList.add('hidden');
            }
        }
    }
</script>
@endonce