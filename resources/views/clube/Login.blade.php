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
    <div class="main-container">

      <div class="text-section">
            <h1>
                Se você acredita,<br> 
                <span class="highlight">o mundo</span> também<br>
                vai acreditar.
            </h1>
        </div>
                <div class="form-section">
            <form action="" id="formLogin">
                <div class="login-form">
                @csrf
                
                 <div class="input-group">
                        <label for="email">Cnpj</label>
                        
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
                        <label for="password">Senha</label>
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
            </form>
</div>
        <script  src="{{ asset('js/clube/login.js')}}"></script>
    </body>
    </html>
