<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            padding-top: 50px;
        }

        h1 {
            color: #1e3a8a;
        }

        a {
            color: #f59e0b;
            text-decoration: none;
        }
    </style>
</head>

<body>
    {{-- Verifica se o usuário está logado --}}
    @auth
        {{-- O Auth::user() neste caso é um objeto Aluno --}}
        <h1>Bem-vindo ao Dashboard, {{ Auth::user()->nome }}!</h1>
        <p>Você está logado como Aluno (RA: {{ Auth::user()->ra }}).</p>

        {{-- Link de Sair (Logout) --}}
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Sair
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endauth

    @guest
        <h1>Bem-vindo à página Dashboard.</h1>
        <a href="{{ route('login_form') }}">Ir para Login</a>
    @endguest
</body>

</html>
