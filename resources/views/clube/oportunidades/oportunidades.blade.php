<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oportunidades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('/css/clube/oportunidadesClube.css')}}">
    <link rel="stylesheet" href="{{ asset('css//clube/sidebar/sidebar.css') }}">
</head>
<body>
    <nav class="barra-lateral" id="barra-lateral">

        <!--ESPAÇO PRA LOGO LT1-->
        <div class="logo-container">
            <!-- LOGO PEQUENA-->
            <img src="../img/logo-clube-reduzida.png" alt="Logo" class="logo-pequena">
            <!--LOGO GRANDE-->
            <img src="../img/logo-clube-completa.jpeg" alt="Logo" class="logo-grande">
            <!--ESPAÇO PRA LOGO LT1-->
        </div>

        <ul class="menu-navegacao">
            <li>
                <a href="./index.html">
                    <i class='bx bx-home-alt'></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="ativo">
                <a href="">
                    <i class='bx bx-briefcase'></i>
                    <span>Oportunidades</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-list-ul'></i>
                    <span>Listas</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-message-dots'></i>
                    <span>Mensagens</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-bell'></i>
                    <span>Notificações</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-user'></i>
                    <span>Perfil</span>
                </a>
            </li>
            <li>
                <a href="./tela-pesquisa/pesquisa.html">
                    <i class='bx bx-search'></i>
                    <span>Pesquisa</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-cog'></i>
                    <span>Configurações</span>
                </a>
            </li>
            <li>
            <hr class="barra-vermelha">  
            <li class="sair-link"> 
                <a href="#">
                    <i class='bx bx-log-out'></i>
                    <span>Sair</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <h1>Oportunidades</h1>
        <div class="box">
        <h3>Minhas oportunidades</h3>
        <div class="container text-center mt-5">
        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
        <img src="{{asset('/img/novoBotao.png')}}" class="iconNovo" alt=""><button type="submit" class="botaoNovo" data-bs-toggle="modal" data-bs-target="#modalOportunidades">
                Novo
             </button>
             <!--quando tiver opção colocar ativos aqui-->
        </div>
        </div>
        </div>
<!--modal adicionar oportunidade-->
         <div class="modal fade" id="modalOportunidades" tabindex="-1" aria-labelledby="modalOportunidadesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
        
            <div class="modal-header">
                <h4 class="modal-title" id="modalOportunidadesLabel">Cadastrar Oportunidade</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <form class="row g-3" action="" id="formOportunidades">
                    @csrf
                    <div class="col">
                    <div class="mb-3 input-conteiner">
                        <input class="form-control" type="text" name="nomeOportunidade" placeholder="Nome" required>
                    </div>

                    <div class="mb-3 input-conteiner">
                        <input class="form-control" type="text" name="descricaoOportunidade" placeholder="Descrição" required>
                    </div>

                    <div class="mb-3 input-conteiner">
                        <input class="form-control" type="number" name="idadeMinima" placeholder="Idade Minima" required>
                    </div>  

                    <div class="mb-3 input-conteiner">
                        <input class="form-control" type="number" name="idadeMaxima" placeholder="Idade máxima" required>
                    </div>
                    </div>
                    <div class="col">
                                    <div class="mb-3 input-conteiner">
                                        <input class="form-control" type="text" name="cepOportunidade" id="cep" maxlength="8" onblur="handleCepBlur()" placeholder="Cep" required>
                                    </div>
                    
                    <select class="form-select"  name="estadoOportunidade" id="estadoOportunidade" required>
                        <option value="" selected disabled>Estado</option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                    </select>
                    <div class="mb-3 input-conteiner">
                        <input class="form-control" type="text" name="cidadeOportunidade" id="cidadeOportunidade" placeholder="Cidade" required>
                    </div>
                    <div class="mb-3 input-conteiner">
                        <input class="form-control" type="text" name="enderecoOportunidade" id="enderecoOportunidade" placeholder="Endereço" required>
                    </div>
                    </div>
                    <button class="botaoEnviar" type="submit">Enviar</button>
            </form>
        </div>
        </div>
        </div>
    </div>

    <script src="{{ asset('js/clube/oportunidades/events.js')}}"></script>
    <script src="{{ asset('js/clube/oportunidades/dom-elements.js')}}"></script>
    <script src="{{ asset('js/clube/oportunidades/api.js')}}"></script>
    <script src="{{ asset('js/clube/oportunidades/modals.js')}}"></script>
    <script src="{{ asset('js/clube/oportunidades/utils.js')}}"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</body>
</html>