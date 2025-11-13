    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="{{ asset('css/Clube/login/login.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
          <div class="modal" id="addModal">
    <div class="modal-content">
      <div class="success add">Login Efetuado Com Sucesso!</div>
    </div>
  </div>

  <div class="modal" id="creModal">
    <div class="modal-content">
      <div class="success add">Credenciais Invalidas!</div>
    </div>
  </div>

  <div class="modal" id="deleteModal">
    <div class="modal-content">
      <div class="success delete">Credenciais Invalidas!</div>
    </div>
  </div>
    <div class="main-container">

      <div class="text-section">
            <h1>
                SE VOCÊ ACREDITA,<br> 
                <span class="highlight">O MUNDO</span> TAMBÉM<br>
                VAI ACREDITAR.
            </h1>
        </div>
                <div class="form-section">
            <form action="" id="formLogin">
                <div class="login-form">
                @csrf
                
                 <div class="input-group">
                        <label for="email">Cnpj:</label>
                        
                        <input 
                            type="text" 
                            id="email" 
                            name="cnpjClube"
                            placeholder="Cnpj"
                            required
                        >
                        <div class="error-message" id="emailError"></div>
                    </div>

                     <div class="input-group">
                        <label for="password">Senha:</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="senhaClube"
                            required
                            placeholder="Senha"
                        >
                        <div class="error-message" id="passwordError"></div>
                    </div>

                <br>
                <button type="submit" class="submit-button">Login</button>

                <a href="{{route('clube-cadastro')}}" class="cadastro-link">Cadastre-se</a>
            </form>
</div>
        <script  src="{{ asset('js/clube/login.js')}}"></script>
    </body>
    </html>
