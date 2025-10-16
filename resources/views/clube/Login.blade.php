    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
            <form action="" id="formLogin">
                @csrf
                
                <input type="text" name="cnpjClube" required>
                <br>
                <input type="password" name="senhaClube" required>
                <br>
                <button type="submit">Login</button>
            </form>

        <script  src="{{ asset('js/clube/login.js')}}"></script>
    </body>
    </html>