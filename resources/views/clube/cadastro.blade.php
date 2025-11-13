<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/Clube/Cadastro/cadastro.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="  https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css  ">
    <style>
#part1{
    display: block;
}
#part2{
display: none;
}
#part3{
display: none;
}
#part4{
display: none;
}
    </style>
</head>
<body>

  <div class="modal" id="addModal">
    <div class="modal-content">
      <div class="success add">Adicionado com sucesso!</div>
    </div>
  </div>

<div class="layout-wrapper">
    <!-- Frase exatamente como na imagem -->
    <div class="side-slogan">
        <span class="line">PRATIQUE O</span>
        <span class="line">ESPORTE COMO</span>
        <span class="line"><span class="highlight">VOCÊ</span> NUNCA VIU!</span>
    </div>
    <!-- Formulário -->
    <div class="form-section">
        <div class="progress-section">
            <div class="runner-icon" id="runnerIcon">
                <i class="fas fa-running" style="color: #00ff95; font-size: 24px;"></i>
            </div>
            <div class="progress-container">
                <div class="progress-bar" id="progressBar"></div>
                <div class="progress-percentage" id="progressPercentage">0%</div>
            </div>
        </div>

        <div class="container">
            <h2 id="step-title">Informações do Clube</h2>
            
            <div class="step-indicators">
                <div class="step-dot" id="dot1"></div>
                <div class="step-dot" id="dot2"></div>
                <div class="step-dot" id="dot3"></div>
                <div class="step-dot" id="dot4"></div> 
            </div>
    <form action="" id="cadastro-clube">
        @csrf
    <div id='part1'>


<div class="form-step active" id="step1">
                    <div class="input-group">
                        <label for="clube-email">E-mail do clube:</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="emailClube" id="clube-email email" class="with-icon" placeholder="Seu@email.com" required />
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="clube-nome">Nome do clube:</label>
                        <div class="input-wrapper">
                            <i class="fas fa-trophy input-icon"></i>
                            <input type="text" name="nomeClube" id="clube-nome nomeClube" class="with-icon" placeholder="Nome do clube" required />
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="clube-ano-criacao">Data de criação:</label>
                        <div class="input-wrapper">
                            <i class="fas fa-calendar-alt input-icon"></i>
                            <input type="date" name="anoCriacaoClube" id="anoCriacao clube-ano-criacao" class="with-icon" required />
                        </div>
                    </div>
                    <input type="button" class="btn-next" value="Próximo ➥" id="p1">

                    </div>
                </div>



       
        <!-- <button type="button"  >Proximo</button> -->


<div id='part2'>
        <label for="clube-categoria">Categoria:</label>
        <select name="categoria_id" id="clube-categoria">
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nomeCategoria }}</option>
            @endforeach
        </select>

        <label for="clube-esporte">Esporte:</label>
        <select name="esporte_id" id="clube-esporte">
            @foreach($esportes as $esporte)
                <option value="{{ $esporte->id }}">{{ $esporte->nomeEsporte }}</option>
            @endforeach
        </select>
        <br><br>
        <div class='juntos'>
        <input type="button" value="<- Anterior" id="v1">
        <input type="button" value="Proximo ->" id="p2">
        </div>
        <!-- <button type="button" id="p2" >Proximo</button> -->
</div>


<div id='part3'>

        <label for="clube-cidade">Cep</label>
        <input type="text" name="Cep" id="Cep">

        <label for="clube-cidade">Cidade:</label>
        <input type="text" name="cidadeClube" id="clube-cidade">

        <label for="clube-estado">Estado:</label>
        <input type="text" name="estadoClube" id="clube-estado">

        <label for="clube-endereco">Endereco:</label>
        <input type="text" name="enderecoClube" id="clube-endereco">
        <br><br>
<div class='juntos'>
        <input type="button" value="<- Anterior" id="v2">
        <input type="button" value="Proximo ->" id="p3">
</div>
</div>
<div id='part4'>
        <label for="clube-cnpj">Cnpj:</label>
        <input type="text" name="cnpjClube" id="clube-cnpj">

        <label for="clube-senha">Senha:</label>
        <input type="password" name="senhaClube" id="clube-senha">
        <br><br>
<div class='juntos'>
    <input type="button" value="<- Anterior" id="v3">
        <button type="submit" id='p4'>Enviar</button>
        </div>
    </form>
    
    </div>
</div>
</div>

    <Script>
        parte1 = document.getElementById('part1')
        parte2 = document.getElementById('part2')
        parte3 = document.getElementById('part3')
        parte4 = document.getElementById('part4')


        botao1 = document.getElementById('p1')
        botao2 = document.getElementById('p2')
        botao3 = document.getElementById('p3')
        botao4 = document.getElementById('p4')


        voltar1 = document.getElementById('v1')
        voltar2 = document.getElementById('v2')
        voltar3 = document.getElementById('v3')


        barra = document.getElementById('progressBar')
        valorbarra = document.getElementById('progressPercentage')
        corredor = document.getElementById('runnerIcon')

        ponto1 = document.getElementById('dot1')
        ponto2 = document.getElementById('dot2')
        ponto3 = document.getElementById('dot3')
        ponto4 = document.getElementById('dot4')

        
        
         botao1.addEventListener("click", function() {
            /* const bioverificação = bio.value.trim();
            const nomeverificação = nome.value.trim();
            const dataverificação = data.value.trim();
            const emailverificação = email.value.trim();
            if (bioverificação === "" || emailverificação === "" || dataverificação === "" || nomeverificação === "" ){
            alert('escreva todos os campos')
            }
            else{ */
            valorbarra.textContent = '25%'

            ponto2.style.background = '#00D17A'

            botao1.style.display = 'none'
            botao2.style.display = 'block'

            parte1.style.display = 'none'
            parte2.style.display ='block'

            voltar1.style.display = 'block'

            barra.style.width = '25%'
            corredor.style.left = '20%'
         /* } */
        });
        botao2.addEventListener("click", function() {
            /* const cidadeverificação = cidade.value.trim();
            const estadoverificação = estado.value.trim();
            const enderecoverificação = endereco.value.trim();
            
            if (cidadeverificação === "" || estadoverificação === "" || enderecoverificação === ""){
            alert('escreva todos os campos')
            }
            else{ */
            valorbarra.textContent = '50%'

            ponto3.style.background = '#00D17A'

            botao2.style.display = 'none'
            botao3.style.display = 'block'

            parte2.style.display ='none'
            parte3.style.display ='block'
            
            voltar1.style.display = 'none'
            voltar2.style.display = 'block'
            barra.style.width = '50%'
            corredor.style.left = '45%'
            /* } */
        });

        botao3.addEventListener("click", function() {

            ponto4.style.background = '#00D17A'

            valorbarra.textContent = '75%'
            botao3.style.display = 'none'
            botao4.style.display = 'block'


            parte3.style.display ='none'
            parte4.style.display ='block'

            voltar2.style.display = 'none'
            voltar3.style.display = 'block'

            barra.style.width = '75%'
            corredor.style.left = '70%'

        });

        botao4.addEventListener("click", function() {

            ponto1.style.background = '#d0d0d0'
            ponto2.style.background = '#d0d0d0'
            ponto3.style.background = '#d0d0d0'
            ponto4.style.background = '#d0d0d0'

            valorbarra.textContent = '100%'
            barra.style.width = '100%'
            corredor.style.left = '95%'
        });

        voltar1.addEventListener('click',function(){

            valorbarra.textContent = '0%'
            barra.style.width = '0%'
            corredor.style.left = '0%'
            
            parte1.style.display ='block'
            parte2.style.display ='none'

            botao1.style.display = 'block'
            botao2.style.display = 'none'

            voltar1.style.display = 'none'
            
        });

         voltar2.addEventListener('click',function(){
            valorbarra.textContent = '25%'
            barra.style.width = '25%'
            corredor.style.left = '20%'
            
            parte2.style.display ='block'
            parte3.style.display ='none'

            botao2.style.display = 'block'
            botao3.style.display = 'none'

            voltar2.style.display = 'none'
            voltar1.style.display = 'block'
            
        });

        voltar3.addEventListener('click',function(){
            valorbarra.textContent = '50%'
            barra.style.width = '50%'
            corredor.style.left = '45%'
            
            parte3.style.display ='block'
            parte4.style.display ='none'

            botao3.style.display = 'block'
            botao4.style.display = 'none'

            voltar3.style.display = 'none'
            voltar2.style.display = 'block'
            
        });



    </Script>
    <script src="{{ asset('js/clube/cadastro/cadastro.js') }}"></script>
    <script src="{{ asset('js/clube/cadastro/viacep.js') }}"></script>
    
</body>
</html>