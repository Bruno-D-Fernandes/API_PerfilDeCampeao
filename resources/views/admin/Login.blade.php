    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Admin</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{asset('css/admin/loginAdm.css')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <form class="row g-3" action="" id="formLogin">
                @csrf
                <div class="imagem">
                    <img src="{{asset('/img/logoLoginAdm.png')}}" alt="" class="logo">
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Login - Administrador</label>
                </div>
                <div class="mb-3 input-container">
                    <img src="{{asset('/img/iconEmailAdm.png')}}" class="iconEmail" alt="">
                    <input type="email" class="form-control" name="email" placeholder="Email do usuário" required>
                </div>
                <div class="mb-3 input-container">
                    <img src="{{asset('/img/iconSenhaAdm.png')}}" class="iconSenha" alt=""><input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Senha" required>
                </div>
                <div class="mb-3 input-container">
                    <img src="{{asset('/img/iconSenhaAdm.png')}}" class="iconConfirma" alt=""><input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Confirmar senha" required>
                </div>
                <button type="submit" class="btn btn-primary">Fazer login</button>
            <div>
                <label for="" class="footer">© 2025 Norven – Todos os direitos reservados</label>
            </div>
                <script src="{{ asset('js/admin/login.js')}}"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
        </div>
    </body>
    </html>