@extends('admin.config.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Admin/perfil/perfil.css') }}">

<div class="perfil" data-storage-url="{{ asset('storage') }}" data-admin-id="{{ $admin->id }}">

        <div class="info">
            
            <div class="general">
                <div class="general-profile">
                <h2>Perfil</h2><br><br>

                    <div class="profile-picture">
                        @if($admin->foto_perfil)
                            <img src="{{ asset('storage/' . $admin->foto_perfil) }}" alt="Foto de Perfil">
                        @else
                            @endif
                    </div>

                    <div class="admin">
                        <span class="nome">
                            {{ $admin->nome }}
                        </span>

                        <span class="cargo">
                            Administrador
                        </span>
                    </div>
                </div>

                <button id="editar-perfil-btn">
                        Editar
                    </span>
                </button>
            </div>

            <div class="personal-info-container">
                <div class="personal-info-header">
                    <h2>
                        Informações Pessoais
                    </h2>

                    <button id="editar-informacoes-btn">
                        <span>
                            Editar
                        </span>
                    </button>
                </div>

                <div class="personal-info">
                    <div class="personal-info-group email">
                        <h3>
                            Email
                        </h3>

                        <span>
                            {{ $admin->email }}
                        </span>
                    </div>

                    <div class="personal-info-group telefone">
                        <h3>
                            Telefone
                        </h3>

                        <span>
                            @if($admin->telefone)
                                {{ $admin->telefone }}
                            @else
                                (Não informado)
                            @endif
                        </span>
                    </div>

                    <div class="personal-info-group endereco">
                        <h3>
                            Endereço
                        </h3>

                        <span>
                            @if($admin->endereco)
                                {{ $admin->endereco }}
                            @else
                                (Não informado)
                            @endif
                        </span>
                    </div>

                    <div class="personal-info-group data">
                        <h3>
                            Data de nascimento
                        </h3>

                        <span>
                            @if($admin->data_nascimento)
                                {{ \Carbon\Carbon::parse($admin->data_nascimento)
                                    ->locale('pt_BR')
                                    ->translatedFormat('d \d\e F \d\e Y')
                                }}
                            @else
                                (Não informado)
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="perfil-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Editar perfil</h2>
            <button class="close-modal-btn" data-modal-target="perfil-modal">&times;</button>
        </div>

        <form class="modal-body" id="perfil-form">
            <div id="perfil-view">
                <div class="form-group img">
                    <label for="perfil-form-foto">Foto:</label>

                    <<div class="img-preview foto">
                        <img 
                            src="{{ $admin->foto_perfil ? asset('storage/' . $admin->foto_perfil) : '' }}" 
                            alt="Preview" 
                            class="foto-preview" 
                            style="{{ $admin->foto_perfil ? '' : 'display: none;' }}"
                        >
                    </div>

                    <input type="file" name="foto_perfil" id="perfil-form-foto" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="perfil-form-nome">Nome:</label>
                    
                    <input 
                        type="text" 
                        name="nome" 
                        id="perfil-form-nome" 
                        value="{{ trim($admin->nome) }}"
                    >
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="perfil-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="perfil-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="informacoes-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Editar informações pessoais</h2>
            <button class="close-modal-btn" data-modal-target="informacoes-modal">&times;</button>
        </div>

        <form class="modal-body" id="informacoes-form">
            <div id="informacoes-view">
                <div class="form-group">
                    <label for="informacoes-form-email">Email:</label>

                    <input 
                        type="text" 
                        name="email" 
                        id="informacoes-form-email" 
                        value="{{ $admin->email }}"
                    >
                </div>

                <div class="form-group">
                    <label for="informacoes-form-contato">Telefone:</label>

                    <input 
                        type="text" 
                        name="telefone" 
                        id="informacoes-form-telefone" 
                        value="{{ $admin->telefone }}"
                    >
                </div>

                <div class="form-group">
                    <label for="informacoes-form-endereco">Endereço:</label>

                    <input 
                        type="text" 
                        name="endereco" 
                        id="informacoes-form-endereco" 
                        value="{{ $admin->endereco }}"
                    >
                </div>

                <div class="form-group">
                    <label for="informacoes-form-data">Data de Nascimento:</label>

                    <input 
                        type="date" 
                        name="data_nascimento" 
                        id="informacoes-form-data" 
                        value="{{ $admin->data_nascimento }}"
                    >
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="informacoes-cancelar-btn">
                <span>Cancelar</span>
            </button>

            <button id="informacoes-salvar-btn">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Você deseja excluir o perfil?</h3>
        </div>
        
        <div class="modal-body">
            <p class="modal-alert">
                Essa ação é irreversível.
            </p>
        </div>

        <div class="modal-footer">
            <button id="cancel-confirm-btn">
                <span>
                    Cancelar
                </span>
            </button>

            <button id="save-confirm-btn">
                <span>
                    Salvar
                </span>
            </button>
        </div>
    </div>
@endsection

@section('scripts')

    <script src="{{ asset('js/admin/perfil/dom-elements.js') }}"></script>
    <script src="{{ asset('js/admin/perfil/utils.js') }}"></script>
    <script src="{{ asset('js/admin/perfil/modals.js') }}"></script>
    <script src="{{ asset('js/admin/perfil/api.js') }}"></script>
    <script src="{{ asset('js/admin/perfil/events.js') }}"></script>

    <script src="{{ asset('js/admin/perfil/config.js') }}"></script>

@endsection