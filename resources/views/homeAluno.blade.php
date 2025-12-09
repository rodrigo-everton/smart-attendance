<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Como Funciona? - Smart Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Define a fonte Inter como padrão e remove margens padrão */
        body {
            font-family: "Inter", sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Cores personalizadas para o tema */
        :root {
            --bg-dark-purple: #4c1d95;
            /* Roxo escuro para o fundo principal */
            --card-fuchsia: #e90d8a;
            /* Fúcsia vibrante para os cards */
            --button-yellow: #fde047;
            /* Amarelo vibrante para o botão */
            --text-light: #ffffff;
            /* Texto claro */
            --text-dark: #333333;
            /* Texto escuro para contraste, se necessário */
        }

        .bg-dark-purple {
            background-color: var(--bg-dark-purple);
        }

        .bg-card-fuchsia {
            background-color: var(--card-fuchsia);
        }

        .bg-button-yellow {
            background-color: var(--button-yellow);
        }

        .text-light {
            color: var(--text-light);
        }

        .text-dark {
            color: var(--text-dark);
        }

        .border-button-yellow {
            border-color: var(--button-yellow);
        }
    </style>
    <script>
        // Configuração do Tailwind para usar as cores customizadas
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark_purple: '#4c1d95', // Roxo escuro para o fundo
                        card_fuchsia: '#e90d8a', // Fúcsia vibrante para os cards
                        button_yellow: '#fde047', // Amarelo vibrante para o botão
                        light: '#ffffff', // Branco
                        dark: '#333333', // Preto/Cinza escuro para texto, se necessário
                    },
                }
            }
        }
    </script>
</head>

<body class="bg-dark_purple min-h-screen flex flex-col items-center p-4">

    <h1 class="text-3xl md:text-4xl font-bold text-light mt-8 mb-6">Como funciona?</h1>

    <a href="{{ Auth::check() ? route('dashboard') : route('login_form') }}"
        class="mb-10 w-full max-w-xs py-3 px-8 bg-button_yellow text-dark font-bold text-lg rounded-full 
             shadow-lg shadow-button_yellow/50 hover:shadow-button_yellow/70 
             transition duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-button_yellow/50">
        Próximo
    </a>

    <div class="flex flex-col space-y-6 w-full max-w-md">

        <div class="bg-card_fuchsia p-6 rounded-xl shadow-lg flex flex-col items-center text-center">
            <span class="text-5xl mb-4" role="img" aria-label="graduation cap">🎓</span>
            <p class="text-light text-base md:text-lg font-medium">O docente acessa o Smart Attendance com seu RA,
                e-mail institucional ou CPF.</p>
        </div>

        <div class="bg-card_fuchsia p-6 rounded-xl shadow-lg flex flex-col items-center text-center">
            <span class="text-5xl mb-4" role="img" aria-label="QR code">
                <img src="{{ asset('img/qr-code.png') }}" alt="QR Code Placeholder" class="w-20 h-20 mx-auto">
            </span>
            <p class="text-light text-base md:text-lg font-medium">O docente escaneia o QR Code que será gerado pelo
                professor.</p>a
        </div>

        <div class="bg-card_fuchsia p-6 rounded-xl shadow-lg flex flex-col items-center text-center">
            <span class="text-5xl mb-4" role="img" aria-label="check mark">✅</span>
            <p class="text-light text-base md:text-lg font-medium">Com o app, o estudante escaneia o QR Code do
                professor para registrar presença.</p>
        </div>

    </div>

    @auth
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="mt-12 w-full max-w-xs py-4 px-8 border-2 border-button-yellow text-light font-bold text-xl rounded-full 
               hover:bg-button_yellow hover:text-dark transition duration-300 transform hover:scale-[1.02] 
               focus:outline-none focus:ring-4 focus:ring-button_yellow/50">
            Sair
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endauth

</body>

</html>
