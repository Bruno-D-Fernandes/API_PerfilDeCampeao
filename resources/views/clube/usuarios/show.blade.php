<x-layouts.clube title="Perfil" :breadcrumb="['Dashboard' => route('clube.dashboard'), 'Perfil' => null]">
    <div id="profile-page" class="w-full h-full">
        <div class="flex flex-col gap-[0.83vw]">
            <div class="h-[15.83vw] mb-[0.5vw]">   
                <div class="relative w-full h-[13.33vw]">     
                    <div class="absolute inset-0 w-full h-full rounded-[0.42vw] overflow-hidden bg-emerald-500 flex items-center justify-center">    
                        @if($usuario->fotoBannerUsuario)
                            <img id="display-banner" 
                                src="{{ asset('storage/'. $usuario->fotoBannerUsuario) }}" 
                                class="w-full h-full object-cover"
                                alt="Banner do Clube">
                        @else
                            <svg id="placeholder-banner" class="h-[3.33vw] w-[3.33vw] text-white stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                                <circle cx="9" cy="9" r="2"/>
                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                            </svg>

                            <img id="display-banner" class="hidden w-full h-full object-cover">
                        @endif
                    </div>

                    <div class="absolute left-[3.33vw] top-full -translate-y-1/2 h-[5vw] w-[5vw] rounded-full bg-emerald-500 border-[0.425vw] border-white flex items-center justify-center overflow-hidden z-20">   
                        @if($usuario->fotoPerfilUsuario)
                            <img id="display-perfil" 
                                src="{{ asset('storage/'. $usuario->fotoPerfilUsuario) }}" 
                                class="w-full h-full object-cover"
                                alt="Foto de Perfil">
                        @else
                            <svg id="placeholder-perfil" class="h-[2.08vw] w-[2.08vw] text-emerald-500 stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M13.997 4a2 2 0 0 1 1.76 1.05l.486.9A2 2 0 0 0 18.003 7H20a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1.997a2 2 0 0 0 1.759-1.048l.489-.904A2 2 0 0 1 10.004 4z"/>
                                <circle cx="12" cy="13" r="3"/>
                            </svg>
                            <img id="display-perfil" class="hidden w-full h-full object-cover">
                        @endif

                    </div>

                    <div class="absolute right-0 top-full translate-y-[0.63vw] z-10">
                        <div class="flex gap-[0.42vw]">
                            <x-button color="clube" size="md" onclick="openModal('edit-profile')">
                                Adicionar à lista
                            </x-button>

                            <x-button color="clube" size="md" onclick="openModal('edit-profile')">
                                Enviar mensagem
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-x-[0.83vw] pl-[0.5vw]">
                <h1 id="display-nome" class="text-[1.25vw] font-semibold text-gray-800">
                    {{ $usuario->nomeCompletoUsuario }}
                </h1>
            </div>

            <div class="w-full gap-[1.25vw]">
                <div class="w-full h-full rounded-[0.42vw] bg-white transition-colors">
                    @php
                        $tabOptions = [];
                        
                        if($usuario->perfis) {
                            foreach($usuario->perfis as $perfil) {
                                $nomeEsporte = $perfil->esporte->nomeEsporte ?? 'Esporte';
                                $tabOptions['perfil_' . $perfil->id] = $nomeEsporte;
                            }
                        }

                        $tabOptions['sobre'] = 'Sobre';

                        $defaultTab = array_key_first($tabOptions) ?? 'sobre';
                    @endphp

                    <x-tabs :options="$tabOptions" :default="$defaultTab">
                        @foreach($usuario->perfis as $perfil)
                            <x-slot :name="'icon_perfil_' . $perfil->id">
                                <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trophy-icon lucide-trophy"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg>
                            </x-slot>

                            <x-slot :name="'perfil_' . $perfil->id">
                                <div class="w-full grid grid-cols-3 gap-[0.83vw] auto-rows-auto">
                                    <div class="col-span-3 py-[2vw] text-center text-gray-400 bg-gray-50 rounded-[0.42vw] border border-dashed border-gray-200 text-[0.73vw]">
                                        Mídia e estatísticas de {{ $perfil->esporte->nomeEsporte ?? 'Esporte' }}
                                    </div>
                                </div>  
                            </x-slot>

                        @endforeach

                        <x-slot name="icon_sobre">
                            <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        </x-slot>

                        <x-slot name="sobre">
                            <div class="w-full flex flex-col gap-[1.25vw]">
                                <div class="flex flex-col gap-[0.83vw]">
                                    <span class="text-[0.83vw] font-semibold uppercase text-emerald-500 tracking-tight">Ficha Técnica</span>
                                    
                                    <div class="flex flex-wrap w-full items-center justify-start gap-[0.42vw]">
                                        @if($usuario->dataNascimentoUsuario)
                                            <x-badge color="green" :border="false">
                                                <x-slot:icon><svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg></x-slot:icon>
                                                {{ \Carbon\Carbon::parse($usuario->dataNascimentoUsuario)->age }} anos
                                            </x-badge>
                                        @endif

                                        @if($usuario->alturaCm)
                                            <x-badge color="blue" :border="false">
                                                <x-slot:icon>
                                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ruler-icon lucide-ruler"><path d="M21.3 15.3a2.4 2.4 0 0 1 0 3.4l-2.6 2.6a2.4 2.4 0 0 1-3.4 0L2.7 8.7a2.41 2.41 0 0 1 0-3.4l2.6-2.6a2.41 2.41 0 0 1 3.4 0Z"/><path d="m14.5 12.5 2-2"/><path d="m11.5 9.5 2-2"/><path d="m8.5 6.5 2-2"/><path d="m17.5 15.5 2-2"/></svg>
                                                </x-slot:icon>
                                                {{ number_format($usuario->alturaCm / 100, 2) }}m
                                            </x-badge>
                                        @endif

                                        @if($usuario->pesoKg)
                                            <x-badge color="blue" :border="false">
                                                <x-slot:icon>
                                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scale-icon lucide-scale"><path d="M12 3v18"/><path d="m19 8 3 8a5 5 0 0 1-6 0zV7"/><path d="M3 7h1a17 17 0 0 0 8-2 17 17 0 0 0 8 2h1"/><path d="m5 8 3 8a5 5 0 0 1-6 0zV7"/><path d="M7 21h10"/></svg>
                                                </x-slot:icon>
                                                {{ $usuario->pesoKg }}kg
                                            </x-badge>
                                        @endif

                                        @if($usuario->peDominante)
                                            <x-badge color="purple" :border="false">
                                                <x-slot:icon>
                                                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-footprints-icon lucide-footprints"><path d="M4 16v-2.38C4 11.5 2.97 10.5 3 8c.03-2.72 1.49-6 4.5-6C9.37 2 10 3.8 10 5.5c0 3.11-2 5.66-2 8.68V16a2 2 0 1 1-4 0Z"/><path d="M20 20v-2.38c0-2.12 1.03-3.12 1-5.62-.03-2.72-1.49-6-4.5-6C14.63 6 14 7.8 14 9.5c0 3.11 2 5.66 2 8.68V20a2 2 0 1 0 4 0Z"/><path d="M16 17h4"/><path d="M4 13h4"/></svg>
                                                </x-slot:icon>
                                                Pé: {{ ucfirst($usuario->peDominante) }}
                                            </x-badge>
                                        @endif

                                        @if($usuario->maoDominante)
                                            <x-badge color="purple" :border="false">
                                                <x-slot:icon><svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v0"/><path d="M14 10V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v2"/><path d="M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v8"/><path d="M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"/></svg></x-slot:icon>
                                                Mão: {{ ucfirst($usuario->maoDominante) }}
                                            </x-badge>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex flex-col gap-[0.83vw]">
                                    <span class="text-[0.83vw] font-semibold uppercase text-emerald-500 tracking-tight">Informações Pessoais</span>
                                    
                                    <div class="grid grid-cols-1 gap-[0.42vw]">
                                        @if($usuario->cidadeUsuario && $usuario->estadoUsuario)
                                            <span class="inline-flex gap-x-[0.42vw] text-[0.83vw] font-medium tracking-tight text-gray-500">
                                                Localização:
                                                <span class="text-gray-900 font-semibold flex items-center gap-x-[0.2vw]">
                                                    {{ $usuario->cidadeUsuario }} - {{ $usuario->estadoUsuario }}
                                                </span>
                                            </span>
                                        @endif

                                        @if($usuario->generoUsuario)
                                            <span class="inline-flex gap-x-[0.42vw] text-[0.83vw] font-medium tracking-tight text-gray-500">
                                                Gênero:
                                                <span class="text-gray-900 font-semibold capitalize">
                                                    {{ $usuario->generoUsuario }}
                                                </span>
                                            </span>
                                        @endif

                                        <span class="inline-flex gap-x-[0.42vw] text-[0.83vw] font-medium tracking-tight text-gray-500">
                                            Email:
                                            <a href="mailto:{{ $usuario->emailUsuario }}" class="text-emerald-600 font-semibold underline hover:text-emerald-700 transition-colors">
                                                {{ $usuario->emailUsuario }}
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </x-slot>
                    </x-tabs>
                </div>
            </div>
        </div>        
    </div>

    <div id="profile-loading" class="absolute inset-0 bg-white/50 backdrop-blur-sm z-50 flex items-center justify-center hidden rounded-[0.42vw]">
        <svg class="animate-spin h-[1.67vw] w-[1.67vw] text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
        
    <script>
        function showProfileLoading() {
            document.getElementById('profile-loading').classList.remove('hidden');
        }

        function hideProfileLoading() {
            document.getElementById('profile-loading').classList.add('hidden');
        }

        function previewImage(input, imgId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(imgId).setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function consultarCep() {
            let cepInput = document.getElementById('evt-cep');
            let cep = cepInput.value.replace(/\D/g, '');
            if (cep != "") {
                let validacep = /^[0-9]{8}$/;
                if(validacep.test(cep)) {
                    document.getElementById('clube-endereco').value = "Carregando...";
                    document.getElementById('clube-cidade').value = "...";
                    
                    fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!("erro" in data)) {
                            document.getElementById('clube-endereco').value = data.logradouro + ", " + data.bairro;
                            document.getElementById('clube-cidade').value = data.localidade;
                            document.getElementById('clube-estado').value = data.uf;
                        } else {
                            alert("CEP não encontrado.");
                            document.getElementById('clube-endereco').value = "";
                        }
                    })
                    .catch(error => { console.error(error); alert("Erro ao buscar CEP."); });
                } else { alert("Formato de CEP inválido."); }
            }
        }

        async function submitAjax(formId, url, method, modalName, callbackName, sTitle, sMsg, eTitle, eMsg) {
            
            const form = document.getElementById(formId);
            
            if (!form) return;
            
            const btn = document.querySelector(`[onclick*="${formId}"]`);
            const originalBtnText = btn ? btn.innerText : 'Salvar';
            
            if(btn) { 
                btn.disabled = true; 
                btn.innerText = 'Salvando...'; 
                btn.classList.add('opacity-50', 'cursor-not-allowed'); 
            }

            const formData = new FormData(form);
            
            if (method.toUpperCase() === 'PUT') { 
                if (!formData.has('_method')) formData.append('_method', 'PUT'); 
            }

            showProfileLoading();

            try {
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 
                        'Accept': 'application/json' 
                    },
                    body: formData
                });
                
                const data = await response.json();

                if (response.ok) {
                    document.querySelector('#profile-page').innerHTML = data.data.html;
                } else {
                    
                    if (response.status === 422) {
                        let errorMessages = "";
                        for (const [field, msgs] of Object.entries(data.errors || {})) { 
                            errorMessages += `• ${msgs[0]}\n`; 
                        }
                        alert("Verifique os campos:\n" + errorMessages);
                    } else { 
                        alert(`${eTitle}\n${eMsg}`); 
                    }
                }

            } catch (error) { 
                console.error(error); 
                alert('Erro de conexão.'); 
            } finally { 
                hideProfileLoading();

                if(btn) { 
                    btn.disabled = false; 
                    btn.innerText = originalBtnText; 
                    btn.classList.remove('opacity-50', 'cursor-not-allowed'); 
                } 
            }
        }
    </script>
</x-layouts.clube>