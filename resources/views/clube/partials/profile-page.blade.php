<div class="flex flex-col gap-[0.83vw]">
    <div class="h-[15.83vw] mb-[0.5vw]">   
        <div class="relative w-full h-[13.33vw]">     
            <div class="absolute inset-0 w-full h-full rounded-[0.42vw] overflow-hidden bg-emerald-500 flex items-center justify-center">
                        
                @if($clube->fotoBannerClube)
                    <img id="display-banner" 
                        src="{{ asset('storage/'. $clube->fotoBannerClube) }}" 
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

                <div class="absolute left-[3.33vw] top-full -translate-y-1/2 h-[5vw] w-[5vw] rounded-full bg-white border-[0.425vw] border-white flex items-center justify-center overflow-hidden z-20">
                        
                    @if($clube->fotoPerfilClube)
                        <img id="display-perfil" 
                            src="{{ asset('storage/'. $clube->fotoPerfilClube) }}" 
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
                    <x-button color="clube" size="md" onclick="openModal('edit-profile')">
                        Editar
                    </x-button>
                </div>

        </div>
    </div>

    <div class="flex items-center gap-x-[0.83vw] pl-[0.5vw]">
        <h1 id="display-nome" class="text-[1.25vw] font-semibold text-gray-800">
            {{ $clube->nomeClube }}
        </h1>
    </div>

    <div class="w-full gap-[1.25vw]">
        <div class="w-full h-full rounded-[0.42vw] bg-white transition-colors">
            
            <x-tabs :options="['oportunidades' => 'Oportunidades', 'sobre' => 'Sobre']" default="oportunidades">
                
                <x-slot name="icon_oportunidades"><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M11 6a13 13 0 0 0 8.4-2.8A1 1 0 0 1 21 4v12a1 1 0 0 1-1.6.8A13 13 0 0 0 11 14H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z"/><path d="M6 14a12 12 0 0 0 2.4 7.2 2 2 0 0 0 3.2-2.4A8 8 0 0 1 10 14"/><path d="M8 6v8"/></svg></x-slot>
                <x-slot name="icon_sobre"><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg></x-slot>

                <x-slot name="oportunidades">
                    <div class="w-full grid grid-cols-3 gap-[0.83vw] auto-rows-auto">
                        @foreach($oportunidades as $item)
                            <x-opportunity-item :opportunity="$item" />
                        @endforeach
                    </div>  
                </x-slot>

                <x-slot name="sobre">
                    <div class="w-full flex flex-col gap-[0.83vw]">
                        
                        <div class="flex flex-col gap-[0.83vw]">
                            <span class="text-[0.83vw] font-semibold uppercase text-emerald-500 tracking-tight">Sobre</span>
                            <span id="display-bio" class="w-full text-[0.83vw] font-normal text-gray-900 line-clamp-3">
                                {{ $clube->bioClube ?? 'O clube ainda não adicionou uma biografia.' }}
                            </span>

                            <div id="badges-container" class="flex flex-wrap w-full items-center justify-start gap-[0.42vw]">
                                
                                <x-badge color="green" :border="false">
                                    <x-slot:icon><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M7.21 15 2.66 7.14a2 2 0 0 1 .13-2.2L4.4 2.8A2 2 0 0 1 6 2h12a2 2 0 0 1 1.6.8l1.6 2.14a2 2 0 0 1 .14 2.2L16.79 15"/><path d="M11 12 5.12 2.2"/><path d="m13 12 5.88-9.8"/><path d="M8 7h8"/><circle cx="12" cy="17" r="5"/><path d="M12 18v-2h-.5"/></svg></x-slot:icon>
                                    <span id="display-categoria">{{ $clube->categoria->nomeCategoria ?? 'Sem Categoria' }}</span>
                                </x-badge>

                                <x-badge color="green" :border="false">
                                    <x-slot:icon>
                                        <svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M11 14h1v4"/><path d="M16 2v4"/><path d="M3 10h18"/><path d="M8 2v4"/><rect x="3" y="4" width="18" height="18" rx="2"/>
                                        </svg>
                                    </x-slot:icon>
                                    
                                    Fundado em <span id="display-ano">{{ " " . \Carbon\Carbon::parse($clube->anoCriacaoClube)->format('Y') }}</span>
                                </x-badge>

                                <x-badge color="green" :border="false">
                                    <x-slot:icon><svg class="h-[0.63vw] w-[0.63vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg></x-slot:icon>
                                    <span id="display-local">{{ $clube->cidadeClube }} - {{ $clube->estadoClube }}</span>
                                </x-badge>

                                <x-badge color="green" :border="false">
                                    <x-slot:icon><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg></x-slot:icon>
                                    <span id="display-esporte">{{ $clube->esporte->nomeEsporte ?? 'Sem Esporte' }}</span>
                                </x-badge>

                                <div id="display-esportes-extras" class="contents">
                                    @if($clube->esportesExtras && $clube->esportesExtras->count() > 0)
                                        @foreach($clube->esportesExtras as $extra)
                                            <x-badge color="green" :border="false">
                                                <x-slot:icon><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg></x-slot:icon>
                                                {{ $extra->nomeEsporte }}
                                            </x-badge>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-[0.83vw]">
                            <span class="text-[0.83vw] font-semibold uppercase text-emerald-500 tracking-tight">Contato</span>
                            <span class="inline-flex gap-x-[0.42vw] text-[0.83vw] font-medium tracking-tight text-emerald-600">
                                Email:
                                <a href="mailto:{{ $clube->emailClube }}" id="display-email" class="text-[0.83vw] font-medium tracking-tight underline flex items-center gap-x-[0.42vw] text-gray-300 hover:text-emerald-400 transition-colors">
                                    {{ $clube->emailClube }}
                                </a>
                            </span>
                            <span class="inline-flex gap-x-[0.42vw] text-[0.83vw] font-medium tracking-tight text-emerald-600">
                                CNPJ:
                                <span id="display-cnpj" class="text-[0.83vw] font-medium tracking-tight text-emerald-500">
                                    {{ $clube->cnpjClube }}
                                </span>
                            </span>
                        </div>
                    </div>
                </x-slot>
            </x-tabs>
        </div>
    </div>
</div>        

<x-modal maxWidth="2xl" name="edit-profile" title="Editar Perfil" titleSize="[1.25vw]" titleColor="green"> 
    <x-form id="edit-profile-form" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-tabs :options="['midia'=>'Mídia', 'dados'=>'Dados', 'esportes'=>'Esportes', 'bio'=>'Bio']" default="midia">
            
            <x-slot name="icon_midia"><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></x-slot>
            <x-slot name="icon_dados"><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M16 10h2"/><path d="M16 14h2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><rect x="2" y="5" width="20" height="14" rx="2"/></svg></x-slot>
            <x-slot name="icon_esportes"><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg></x-slot>
            <x-slot name="icon_bio"><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg></x-slot>

            <x-slot name="midia">
                <div class="flex flex-col gap-[1vw]">
                    <div class="flex items-center gap-[1vw]">
                        <div class="w-[5vw] h-[5vw] rounded-full overflow-hidden border border-gray-200 shrink-0 bg-gray-50 flex items-center justify-center relative">
                            <img id="modal-preview-perfil" 
                                src="{{ $clube->fotoPerfilClube ? asset('storage/'. $clube->fotoPerfilClube) : '' }}" 
                                class="w-full h-full object-cover absolute inset-0 {{ $clube->fotoPerfilClube ? '' : 'hidden' }}">
                            <div id="modal-placeholder-perfil" class="{{ $clube->fotoPerfilClube ? 'hidden' : '' }}">
                                <svg class="h-[2vw] w-[2vw] text-gray-400 stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <x-form-group label="Foto de Perfil" name="fotoPerfilClube" id="clube-foto-perfil" type="file" labelColor="green" textSize="[1.04vw]" onchange="previewImage(this, 'modal-preview-perfil', 'modal-placeholder-perfil')" />
                        </div>
                    </div>
                    <div class="h-[0.1vw] bg-gray-100 w-full"></div>
                    <div class="flex flex-col gap-[0.5vw]">
                        <div class="w-full h-[6vw] rounded-[0.4vw] overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center relative">
                            <img id="modal-preview-banner" 
                                src="{{ $clube->fotoBannerClube ? asset('storage/'. $clube->fotoBannerClube) : '' }}" 
                                class="w-full h-full object-cover absolute inset-0 {{ $clube->fotoBannerClube ? '' : 'hidden' }}">
                            <div id="modal-placeholder-banner" class="{{ $clube->fotoBannerClube ? 'hidden' : '' }}">
                                <svg class="h-[2vw] w-[2vw] text-gray-400 stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                            </div>
                        </div>
                        <x-form-group label="Banner do Perfil" name="fotoBannerClube" id="clube-foto-banner" type="file" labelColor="green" textSize="[1.04vw]" onchange="previewImage(this, 'modal-preview-banner', 'modal-placeholder-banner')" />
                    </div>
                </div>
            </x-slot>

            <x-slot name="dados">
                <div class="grid grid-cols-2 gap-x-[1vw] gap-y-[0.42vw]">
                    <x-form-group label="Nome do Clube" name="nomeClube" id="clube-nome" labelColor="green" textSize="[1.04vw]" class="col-span-2" value="{{ $clube->nomeClube }}">
                        <x-slot:icon><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M16 10h2"/><path d="M16 14h2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><rect x="2" y="5" width="20" height="14" rx="2"/></svg></x-slot:icon>
                    </x-form-group>
                    
                    <div class="col-span-1 flex gap-[0.42vw] items-end">
                        <div class="flex-1">
                            <x-form-group label="CEP" name="cepClube" id="evt-cep" labelColor="green" placeholder="00000-000" required value="{{ $clube->cepClube }}">
                                <x-slot:icon><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8c0 3.613-3.869 7.429-5.393 8.795a1 1 0 0 1-1.214 0C9.87 15.429 6 11.613 6 8a6 6 0 0 1 12 0"/><circle cx="12" cy="8" r="2"/><path d="M8.714 14h-3.71a1 1 0 0 0-.948.683l-2.004 6A1 1 0 0 0 3 22h18a1 1 0 0 0 .948-1.316l-2-6a1 1 0 0 0-.949-.684h-3.712"/></svg></x-slot:icon>
                            </x-form-group>
                        </div>
                        <button type="button" onclick="consultarCep()" class="h-[2.5vw] w-[2.5vw] bg-gray-100 text-gray-600 hover:bg-gray-200 border border-[0.052vw] border-gray-200 rounded-[0.42vw] transition-colors flex items-center justify-center shrink-0 mb-[0.1vw]"> 
                            <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        </button>
                    </div>

                    <x-form-group label="Data de Criação" name="anoCriacaoClube" id="clube-ano" type="date" labelColor="green" textSize="[1.04vw]" class="col-span-1" value="{{ \Carbon\Carbon::parse($clube->anoCriacaoClube)->format('Y-m-d') }}"
                    />
                    
                    <x-form-group label="Endereço" name="enderecoClube" id="clube-endereco" labelColor="green" textSize="[1.04vw]" class="col-span-2" value="{{ $clube->enderecoClube }}">
                        <x-slot:icon><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></x-slot:icon>
                    </x-form-group>
                    
                    <x-form-group label="Cidade" name="cidadeClube" id="clube-cidade" labelColor="green" textSize="[1.04vw]" class="col-span-1" value="{{ $clube->cidadeClube }}">
                        <x-slot:icon><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M12 6h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M16 6h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/><path d="M8 6h.01"/><path d="M9 22v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/><rect x="4" y="2" width="16" height="20" rx="2"/></svg></x-slot:icon>
                    </x-form-group>
                    
                    <x-form-group label="Estado" name="estadoClube" id="clube-estado" type="select" labelColor="green" textSize="[1.04vw]" class="col-span-1">
                        <x-slot:icon><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/></svg></x-slot:icon>
                        <option value="">UF</option>
                        @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                            <option value="{{ $uf }}" {{ $clube->estadoClube == $uf ? 'selected' : '' }}>{{ $uf }}</option>
                        @endforeach
                    </x-form-group>
                </div>
            </x-slot>

            <x-slot name="esportes">
                <div class="flex flex-col gap-[0.83vw]">
                    <div class="grid grid-cols-2 gap-[1vw]">
                        
                        <x-form-group label="Categoria" name="categoria_id" id="clube-categoria" type="select" labelColor="green" textSize="[1.04vw]">
                            <x-slot:icon><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/></svg></x-slot:icon>
                            <option value="">Selecione...</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ $clube->categoria_id == $categoria->id ? 'selected' : '' }}>{{ $categoria->nomeCategoria }}</option>
                            @endforeach
                        </x-form-group>
                        
                        <x-form-group label="Esporte Principal" name="esporte_id" id="clube-esporte" type="select" labelColor="green" textSize="[1.04vw]">
                            <x-slot:icon><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M10 14.66v1.626a2 2 0 0 1-.976 1.696A5 5 0 0 0 7 21.978"/><path d="M14 14.66v1.626a2 2 0 0 0 .976 1.696A5 5 0 0 1 17 21.978"/><path d="M18 9h1.5a1 1 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M6 9a6 6 0 0 0 12 0V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1z"/><path d="M6 9H4.5a1 1 0 0 1 0-5H6"/></svg></x-slot:icon>
                            <option value="">Selecione...</option>
                            <option value="1" {{ $clube->esporte_id == 1 ? 'selected' : '' }}>Futebol</option>
                            <option value="2" {{ $clube->esporte_id == 2 ? 'selected' : '' }}>Vôlei</option>
                            <option value="3" {{ $clube->esporte_id == 3 ? 'selected' : '' }}>Basquete</option>
                        </x-form-group>
                    </div>
                    
                    <div class="w-full">
                        @php 
                            $extrasIds = $clube->esportesExtras ? $clube->esportesExtras->pluck('id')->toArray() : []; 
                        @endphp
                        <x-form-group label="Esportes Extras (Segure Ctrl)" name="esportes_extras[]" id="clube-esportes-extras" type="select" multiple size="1" labelColor="green" textSize="[1.04vw]" class="h-[2.5vw]">
                            <option value="1" {{ in_array(1, $extrasIds) ? 'selected' : '' }}>Futebol</option>
                            <option value="2" {{ in_array(2, $extrasIds) ? 'selected' : '' }}>Vôlei</option>
                            <option value="3" {{ in_array(3, $extrasIds) ? 'selected' : '' }}>Basquete</option>
                            <option value="4" {{ in_array(4, $extrasIds) ? 'selected' : '' }}>Natação</option>
                            <option value="5" {{ in_array(5, $extrasIds) ? 'selected' : '' }}>Tênis</option>
                        </x-form-group>
                    </div>
                </div>
            </x-slot>

            <x-slot name="bio">
                <div class="flex flex-col gap-[0.83vw] h-full">
                    <x-form-group label="Bio / Sobre o Clube" name="bioClube" id="clube-bio" labelColor="green" textSize="[1.04vw]" class="h-full" value="{{ $clube->bioClube }}">
                        <x-slot:icon><svg class="h-[0.83vw] w-[0.83vw] stroke-[0.1vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg></x-slot:icon>
                    </x-form-group>
                </div>
            </x-slot>
        </x-tabs>
    </x-form>

    <x-slot:footer>
        <div class="w-full flex gap-x-[0.42vw] justify-end">
            <x-button color="gray" size="md" onclick="resetAndClose('edit-profile-form', 'edit-profile')">
                Cancelar
            </x-button>
            <x-button color="clube" type="button" size="md" onclick="submitAjax('edit-profile-form', '/api/clube/update', 'PUT', 'edit-profile', 'updateProfileView', 'Sucesso!', 'Perfil atualizado!', 'Erro!', 'Falha ao atualizar.')">
                Salvar Alterações
            </x-button>
        </div>
    </x-slot:footer>
</x-modal>
