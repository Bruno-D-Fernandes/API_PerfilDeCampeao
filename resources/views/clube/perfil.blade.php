<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        .hidden {
            display: none !important;
        }

        .container, .profile-info, #profile, .profile-details, .modal-body, .form-group, #oportunidade-view, #opportunities, #members-list, .members-list-group, .members-list-group-function, .members-list-rows, #adicionar-membro-view, #about, #clube-view {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .form-group.img {
            align-items: center;
        }

        .form-group.img .img-btns {
            display: flex;
            gap: 16px;
        }

        .form-group label {
            width: 100%;
        }

        .img-preview {
            background-color: #000;
        }

        .img-preview.foto {
            height: 96px;
            aspect-ratio: 1 / 1;
            border-radius: 50%;
            overflow: hidden;
        }

        .img-preview.banner {
            height: 48px;
            aspect-ratio: 3 / 1;
            overflow: hidden;
            flex-shrink: 0;
        }

        .img-preview img {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .tabs {
            display: flex;
            gap: 16px; 
        }

        .profile-imgs {
            width: 100%;
            height: 228px;
            position: relative;
        }

        .profile-imgs img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner {
            width: 100%;
            height: 180px;
            background-color: #000;
        }

        .picture {
            height: 96px;
            aspect-ratio: 1 / 1;
            border-radius: 50%;
            background-color: #fff;
            border: 8px solid #fff;
            position: absolute;
            left: 48px;
            bottom: 0px;
            overflow: hidden;
        }
        
        .opportunity {
            width: 100%;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }

        .opportunity-details, .members-btns {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .opportunity-options {
            display: flex;
            flex-direction: column;
            gap: 4px;
            position: absolute;
            top: 100%;
            right: 0;
            z-index: 100;
        }

        .modal-backdrop {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 100;
        }

        .app-modal {
            width: 600px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            z-index: 101;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            max-height: 300px;
            overflow-y: auto;
        }

        .close-modal-btn {
            width: 32px;
            height: 32px;
        }

        .modal-body, .form-group, #oportunidade-view {
            width: 100%;
        }

        .modal-footer {
            width: 100%;
            height: 48px;
            display: flex;
            justify-content: center;
            gap: 32px;
        }

        .modal-footer button {
            width: 50%;
            height: 100%;
        }

        #members-list, .members-list-group, .members-list-group-function, .members-list-rows, .members-list-row {
            width: 100%;
        }

        .members-list-search {
            width: 100%;
            height: 32px;
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .members-list-row, .opportunities-header, .about-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .no-data {
            width: 100%;
            min-height: 140px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-user {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .search-user-container {
            width: 100%;
            max-height: 100px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .search-user-row {
            width: 100%;
            flex-shrink: 0;
            background-color: #fafafa;
        }

        .user-selected {
            width: 100%;
            height: 48px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-picture {
            height: 75%;
            aspect-ratio: 1 / 1;
            border-radius: 50%;
            background-color: #000;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .tab-content.active {
            display: flex !important;
        }

        .tab-content {
            display: none !important;
        }

        #confirmar-modal, #adicionar-membro-modal, #inscritos-modal {
            width: 420px;
        }

        .about-container {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
        }

        .info {
            aspect-ratio: 5 / 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }
    </style>
</head>
<body>
    <div class="container" data-storage-url="{{ asset('/storage') }}" data-clube-id="{{ $clube->id }}">
        <h1>Clube</h1>

        <div id="profile">
            <div class="profile-info">
                <div class="profile-imgs">
                    <div class="banner">
                        @if($clube->fotoBannerClube)
                            <img src="{{ asset('storage/' . $clube->fotoBannerClube) }}" alt="Banner do clube">
                        @endif
                    </div>

                    <div class="picture">
                        @if($clube->fotoPerfilClube)
                            <img src="{{ asset('storage/' . $clube->fotoPerfilClube) }}" alt="Foto de perfil do clube">
                        @endif
                    </div>
                </div>

                <div class="profile-details">
                    <span class="profile-name">
                        {{ $clube->nomeClube }}
                    </span>

                    <span class="profile-bio">
                        {{ $clube->bioClube }}
                    </span>
                </div>
            </div>

            <div class="tabs">
                <button data-target-tab="opportunities">
                    <span>
                        Oportunidades
                    </span>
                </button>

                <button data-target-tab="members-list">
                    <span>
                        Membros
                    </span>
                </button>

                <button data-target-tab="about">
                    <span>
                        Sobre
                    </span>
                </button>
            </div>

            <div class="tab-container">
                <div id="opportunities" class="tab-content active">
                    <div class="opportunities-header">
                        <h3>
                            Oportunidades
                        </h3>

                        <button id="oportunidade-add-btn">
                            <span>
                                Adicionar oportunidade
                            </span>
                        </button>
                    </div>

                    @foreach($clube->oportunidades as $oportunidade)
                        <div class="opportunity" data-oportunidade-id="{{ $oportunidade->id }}">
                            <div class="opportunity-details">
                                <span>
                                    {{ $oportunidade->posicao->nomePosicao }}
                                </span>
                                
                                <span>
                                    {{ $oportunidade->esporte->nomeEsporte }}
                                </span>
                                
                                <span>
                                    Sub - {{ $oportunidade->idadeMaxima }}
                                </span>

                                <span>
                                    Interessados - {{ $oportunidade->candidatos->count() }}
                                </span>
                            </div>

                            <button class="see-details-btn">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>

                            <div class="opportunity-options hidden">
                                <button class="oportunidade-ver-btn">
                                    <span>
                                        Ver
                                    </span>
                                </button>

                                <button class="oportunidade-editar-btn">
                                    <span>
                                       Editar 
                                    </span>
                                </button>

                                <button class="oportunidade-excluir-btn">
                                    <span>
                                        Excluir
                                    </span>
                                </button>

                                <button class="oportunidade-inscritos-btn">
                                    <span>
                                        Inscritos
                                    </span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="members-list" class="tab-content">
                    <h3>
                        Membros
                    </h3>

                    <div class="members-list-search">
                        
                        <input type="text" id="member-search-input" placeholder="Buscar membro">

                        <button id="add-member-btn">
                            <span>
                                Adicionar membro
                            </span>
                        </button>

                        <button class="clear-search-btn" type="button" data-clear-target="member-search-input">
                            <span>
                                Limpar busca
                            </span>
                        </button>
                    </div>

                    <div class="members-list-group">
                        @if(empty($membrosAgrupados))
                            <div class="no-data">
                                <span>
                                    Sem dados para mostrar
                                </span>
                            </div>
                        @else
                            @foreach($membrosAgrupados as $esporteNome => $funcoesNoEsporte)
                                <span>{{ $esporteNome }}:</span>

                                @foreach($funcoesNoEsporte as $funcaoNome => $listaDeMembrosPorFuncao) 
                                    <div class="members-list-group-function">
                                        <span>{{ $funcaoNome }}:</span>
                                        <div class="members-list-rows">
                                            @foreach($listaDeMembrosPorFuncao as $membro) 
                                                <div class="members-list-row" data-member-id="{{ $membro->id }}" data-esporte-id="{{ $membro->pivot->esporte_id ?? '' }}" data-funcao-id="{{ $membro->pivot->funcao_id ?? '' }}">
                                                    <span>
                                                        {{ $membro->nomeCompletoUsuario }}
                                                    </span>

                                                    <div class="members-btns">
                                                        <button class="membro-ver-btn">
                                                            <span>
                                                                Ver perfil
                                                            </span>
                                                        </button>
                                                        
                                                        <button class="membro-excluir-btn">
                                                            <span>
                                                                Remover
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        @endif
                    </div>
                </div>

                <div id="about" class="tab-content">
                    <div class="about-header">
                        <h3>
                            Sobre
                        </h3>

                        <div>
                            <button id="clube-editar-btn">
                                <span>Editar Clube</span>
                            </button>
                        </div>
                    </div>

                    <div class="about-container">
                        <div class="info">
                            <h4>
                                Fundado em
                            </h4>
                                
                            <p>
                                {{ \Carbon\Carbon::parse($clube->anoCriacaoClube)
                            ->locale('pt_BR')
                            ->translatedFormat('d \d\e F \d\e Y') }}
                            </p>
                        </div>

                        <div class="info">
                            <h4>
                                Esporte
                            </h4>

                            <p>
                                {{ $clube->esporte->nomeEsporte }}
                            </p>
                        </div>

                        <div class="info">
                            <h4>
                                Categoria
                            </h4>

                            <p>
                                {{ $clube->categoria->nomeCategoria }}
                            </p>
                        </div>

                        <div class="info">
                            <h4>
                                Localização
                            </h4>

                            <p>
                                {{ $clube->enderecoClube }}

                                <br>

                                {{ $clube->cidadeClube }} - {{ $clube->estadoClube }}
                            </p>
                        </div>

                        <div class="info">
                            <h4>
                                Contato
                            </h4>

                            <p>
                                {{ $clube->emailClube }}
                            </p>
                        </div>

                        <div class="info">
                            <h4>
                                CNPJ
                            </h4>

                            <p>
                                {{ $clube->cnpjClube }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-backdrop hidden"></div>

    <div id="inscritos-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Inscritos</h2>
            <button class="close-modal-btn" data-modal-target="inscritos-modal">&times;</button>
        </div>

        <div class="modal-body" id="inscritos-modal-body">
            <div id="inscritos-list">
                
            </div>
        </div>
    </div>

    <div id="clube-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Editar informações do clube</h2>
            <button class="close-modal-btn" data-modal-target="clube-modal">&times;</button>
        </div>

        <form class="modal-body" id="clube-form" enctype="multipart/form-data">
            <div id="clube-view">
                <div class="form-group img">
                    <label for="clube-form-foto">Foto:</label>

                    <div class="img-preview foto">
                        <img class="foto-preview" src="" style="display:none;" />
                    </div>

                    <input type="file" name="fotoPerfilClube" id="clube-form-foto" accept="image/*">
                </div>

                <div class="form-group img">
                    <label for="clube-form-banner">Banner:</label>

                    <div class="img-preview banner">
                        <img class="banner-preview" src="" style="display:none;" />
                    </div>

                    <input type="file" name="fotoBannerClube" id="clube-form-banner" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="clube-form-nome">Nome:</label>

                    <input type="text" name="nomeClube" id="clube-form-nome" value="{{ $clube->nomeClube ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="clube-form-data">Data de Criação:</label>

                    <input type="date" name="anoCriacaoClube" id="clube-form-data" value="{{ $clube->anoCriacaoClube ? \Carbon\Carbon::parse($clube->anoCriacaoClube)->format('Y-m-d') : '' }}">
                </div>

                <div class="form-group">
                    <label for="clube-form-endereco">Endereço:</label>

                    <input type="text" name="enderecoClube" id="clube-form-endereco" value="{{ $clube->enderecoClube ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="clube-form-cidade">Cidade:</label>

                    <input type="text" name="cidadeClube" id="clube-form-cidade" value="{{ $clube->cidadeClube ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="clube-form-estado">Estado:</label>

                    <input type="text" name="estadoClube" id="clube-form-estado" value="{{ $clube->estadoClube ?? '' }}">
                </div>

                <div class="form-group">
                    <label for="clube-form-bio">Biografia:</label>

                    <textarea name="bioClube" id="clube-form-bio">{{ $clube->bioClube ?? '' }}</textarea>
                </div>

                <div class="form-group">
                    <label for="clube-form-categoria">Categoria:</label>

                    <select name="categoria_id" id="clube-form-categoria">
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ isset($clube) && $clube->categoria && $clube->categoria->id == $categoria->id ? 'selected' : '' }}>{{ $categoria->nomeCategoria }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="clube-form-esporte">Esporte:</label>

                    <select name="esporte_id" id="clube-form-esporte">
                        @foreach($esportes as $esporte)
                            <option value="{{ $esporte->id }}" {{ isset($clube) && $clube->esporte && $clube->esporte->id == $esporte->id ? 'selected' : '' }}>{{ $esporte->nomeEsporte }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="clube-cancelar-btn">Cancelar</button>
            <button id="clube-salvar-btn">Salvar</button>
        </div>
    </div>

    <div id="adicionar-membro-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Adicionar membro:</h2>
            <button class="close-modal-btn" data-modal-target="adicionar-membro-modal">&times;</button>
        </div>

        <form class="modal-body" id="adicionar-membro-form">
            <div id="adicionar-membro-view">
                <div class="search-user">
                    <input type="text" id="user-search-input" placeholder="Buscar usuário">
                        
                    <button class="clear-search-btn" type="button" data-clear-target="user-search-input">
                        <span>
                            Limpar busca
                        </span>
                    </button>
                </div>

                <div class="search-user-container">
                    
                </div>

                <div class="user-selected user-needed hidden">
                    <div class="profile-picture">

                    </div>

                    <span>
                        João
                    </span>
                </div>

                <div class="form-group user-needed hidden">
                    <label for="adicionar-membro-form-esporte">Esporte:</label>

                    <select name="esporte_id" id="adicionar-membro-form-esporte">
                        @foreach($esportes as $esporte)
                            <option value="{{ $esporte->id }}">{{ $esporte->nomeEsporte }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group user-needed hidden">
                    <label for="adicionar-membro-form-funcao">Função:</label>

                    <select name="funcao_id" id="adicionar-membro-form-funcao">
                        @foreach($funcoes as $funcao)
                            <option value="{{ $funcao->id }}">{{ $funcao->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="adicionar-membro-cancelar-btn" disabled>
                <span>Cancelar</span>
            </button>

            <button id="adicionar-membro-salvar-btn" disabled type="button">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="oportunidade-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Detalhes da Oportunidade:</h2>
            <button class="close-modal-btn" data-modal-target="oportunidade-modal">&times;</button>
        </div>

        <form class="modal-body" id="oportunidade-form">
            <div id="oportunidade-view">
                <div class="form-group"> 
                    <label for="oportunidade-form-descricao">Descrição:</label>
                    
                    <textarea name="descricaoOportunidades" id="oportunidade-form-descricao"></textarea> 
                </div>
                
                <div class="form-group">
                    <label for="oportunidade-form-data">Data de Postagem:</label>
                    
                    <input type="date" id="oportunidade-form-data" name="datapostagemOportunidades"> 
                </div> 

                <div class="form-group"> 
                    <label for="oportunidade-form-esporte">Esporte:</label>

                    <select name="esporte_id" id="oportunidade-form-esporte">
                        @foreach($esportes as $esporte)
                            <option value="{{ $esporte->id }}">{{ 
                                $esporte->nomeEsporte }}
                            </option> 
                        @endforeach 
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="oportunidade-form-posicao">Posição:</label>
                    
                    <select name="posicoes_id" id="oportunidade-form-posicao">
                        @foreach($posicoes as $posicao)
                            <option value="{{ $posicao->id }}">{{ $posicao->nomePosicao }}</option>
                        @endforeach 
                    </select> 
                </div> 
                
                <div class="form-group"> 
                    <label for="oportunidade-form-idade-minima">Idade mínima:</label> 
                    
                    <input type="number" id="oportunidade-form-idade-minima" name="idadeMinima" min="0"> 
                </div> 
                
                <div class="form-group"> 
                    <label for="oportunidade-form-idade-maxima">Idade máxima:</label> 
                    
                    <input type="number" id="oportunidade-form-idade-maxima" name="idadeMaxima" min="0"> 
                </div> 
                
                <div class="form-group"> 
                    <label for="oportunidade-form-endereco">Endereço:</label> 
                    
                    <input type="text" id="oportunidade-form-endereco" name="enderecoOportunidade"> 
                </div> 

                <div class="form-group"> 
                    <label for="oportunidade-form-cidade">Cidade:</label> 
                    
                    <input type="text" id="oportunidade-form-cidade" name="cidadeOportunidade"> 
                </div>
                
                <div class="form-group"> 
                    <label for="oportunidade-form-estado">Estado:</label>
                    
                    <input type="text" id="oportunidade-form-estado" name="estadoOportunidade"> 
                </div> 
                
                <div class="form-group"> 
                    <label for="oportunidade-form-cep">CEP:</label> 
                    
                    <input type="text" id="oportunidade-form-cep" name="cepOportunidade"> 
                </div>
            </div>
        </form>

        <div class="modal-footer">
            <button id="oportunidade-cancelar-btn" disabled>
                <span>Cancelar</span>
            </button>

            <button id="oportunidade-salvar-btn" disabled type="button">
                <span>Salvar</span>
            </button>
        </div>
    </div>

    <div id="confirmar-modal" class="app-modal hidden">
        <div class="modal-header">
            <h2 class="modal-title">Você deseja excluir esta função?</h3>
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

    <script src="{{ asset('js/clube/perfil/dom-elements.js') }}"></script>
    <script src="{{ asset('js/clube/perfil/utils.js') }}"></script>
    <script src="{{ asset('js/clube/perfil/modals.js') }}"></script>
    <script src="{{ asset('js/clube/perfil/api.js') }}"></script>
    <script src="{{ asset('js/clube/perfil/events.js') }}"></script>
</body>
</html>