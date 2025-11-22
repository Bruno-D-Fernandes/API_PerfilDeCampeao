<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Clube</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <link rel="stylesheet" href="{{ asset('css/Clube/perfil/perfil.css') }}">
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>

    </style>
</head>
<body>

@include('clube.sidebar.sidebar')

<div class="modal" id="addModal">
    <div class="modal-content">
      <div class="success add">Membro Adicionado Com Sucesso!</div>
    </div>
  </div>
    <div class="modal" id="esporteModal">
    <div class="modal-content">
      <div class="success erro">Erro ao Adicinoar Membro!</div>
    </div>
  </div>

   <div class="modal" id="caraModal">
    <div class="modal-content">
      <div class="success erro">Membro Excluido com sucesso!</div>
    </div>
  </div>

  <div class="modal" id="erroModal">
    <div class="modal-content">
      <div class="success erro">Oportunidade Excluida com Sucesso!</div>
    </div>
  </div>

    <div class="modal" id="opoModal">
    <div class="modal-content">
      <div class="success erro">Oportunidade Adicionada com Sucesso!</div>
    </div>
  </div>

  <div class="modal" id="erro2Modal">
    <div class="modal-content">
      <div class="success erro">Erro ao criar Oportunidade</div>
    </div>
  </div>

    <div class="modal" id="clubesalvoModal">
    <div class="modal-content">
      <div class="success add">Clube Salvo Com Sucesso</div>
    </div>
  </div>


    
    <div class="container" data-storage-url="{{ asset('/storage') }}" data-clube-id="{{ $clube->id }}">
    
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
                         @else
                            <img src="{{ asset('img/fotoUsuario.png')}}" alt="Banner do clube">
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
                <button class='active'data-target-tab="opportunities" id='atoportunidade'>
                    <span>
                        Oportunidades
                    </span>
                </button>

                <button data-target-tab="members-list" id='atmembros'>
                    <span>
                        Membros
                    </span>
                </button>

                <button data-target-tab="about" id='atsobre'>
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

                        <button class='hidden' id="oportunidade-add-btn">
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
                        <div class="search-box">
                    <i class='bx bx-search'></i>
                    <input type="text" id="member-search-input" placeholder="Buscar membro">
                </div>
                        

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
                    <label for="oportunidade-form-cep">CEP:</label> 
                    
                    <input type="text" id="oportunidade-form-cep" name="cepOportunidade"> 
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
    <script src="{{ asset('js/clube/perfis/perfil/ativo.js') }}"></script>
    <script src="{{ asset('js/clube/perfis/perfil/dom-elements.js') }}"></script>
    <script src="{{ asset('js/clube/perfis/perfil/utils.js') }}"></script>
    <script src="{{ asset('js/clube/perfis/perfil/modals.js') }}"></script>
    <script src="{{ asset('js/clube/perfis/perfil/api.js') }}"></script>
    <script src="{{ asset('js/clube/perfis/perfil/events.js') }}"></script>
    <script src="{{ asset('js/clube/perfis/perfil/viacep.js') }}"></script>
    <script src="{{ asset('js/theme-init.js') }}"></script>
      <script src="{{asset('js/clube/dashboard/logout.js')}}"></script>

<script>// Força o primeiro item (Dashboard) como ativo
const dashboardItem = document.querySelector('.menu-navegacao li:nth-child(3)');
if (dashboardItem) {
    dashboardItem.classList.add('ativo');
}

// Alternativa: buscar especificamente pelo link do dashboard
const dashboardLink = document.querySelector('a[href*="admin-clubes"], a[href*="dashboard"]');
if (dashboardLink && dashboardLink.closest('li')) {
    // Remove ativo de todos primeiro
    menuItems.forEach(item => item.classList.remove('ativo'));
    // Adiciona no dashboard
    dashboardLink.closest('li').classList.add('ativo');
}

</script>

</body>
</html>