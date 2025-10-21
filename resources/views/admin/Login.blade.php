    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Admin</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{asset('css/admin/loginAdm.css')}}">
    </head>
    <body>
            <form action="" id="formLogin">
                @csrf
                <div class="box">
                <input type="text" name="email" required placeholder="email do usuario">
                <input type="password" name="password" required placeholder="senha">
                <input type="password" name="password" required placeholder="confirmar senha">
                <button type="submit">Login</button>
                </div>
            </form>

        <script src="{{ asset('js/admin/login.js')}}"></script>
    </body>
    </html>