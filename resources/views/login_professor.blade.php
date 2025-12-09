<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Professor - Smart Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: "Inter", sans-serif;
        }

        .container-bg {
            background: radial-gradient(circle at center, #1e3a8a 0%, #0c4a6e 100%);
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a8a',
                        card_purple: '#4c1d95',
                        button_accent: '#c026d3',
                        button_hover: '#86198f',
                        light: '#ffffff',
                    },
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100">

    <div class="container-bg min-h-screen flex items-center justify-center p-4">

        <div
            class="w-full max-w-sm bg-card_purple p-8 rounded-xl shadow-2xl transition duration-500 hover:shadow-card_purple/70 transform text-light">

            <div class="text-center mb-6">
                <h1 class="text-4xl font-extrabold tracking-wider text-light mb-1">CEUB</h1>
                <hr class="w-full border-t border-light/50 my-4" />
                <h2 class="text-2xl font-bold text-button_accent mt-4">Smart Attendance</h2>
                <p class="text-light font-semibold mb-4">Login - Professor</p>
                <hr class="w-full border-t border-light/50 my-4" />
            </div>

            <form method="POST" action="{{ route('login.professor') }}" class="flex flex-col space-y-4">
                @csrf

                {{-- Exibe erros de validação (se houver) --}}
                @error('ra_email_cpf')
                    <div class="bg-red-600 text-light p-3 rounded-lg font-bold text-sm text-center">
                        {{ $message }}
                    </div>
                @enderror

                {{-- 1. CAMPO CPF OU EMAIL --}}
                <input type="text" name="ra_email_cpf" placeholder="CPF ou E-Mail"
                    class="w-full p-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-button_accent transition duration-200 text-gray-800"
                    required value="{{ old('ra_email_cpf') }}" />

                {{-- 2. CAMPO SENHA --}}
                <input type="password" name="password" placeholder="Senha"
                    class="w-full p-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-button_accent transition duration-200 text-gray-800"
                    required />

                {{-- Campo Lembrar de Mim (Checkbox) --}}
                <label
                    class="flex items-center space-x-2 text-light text-sm cursor-pointer hover:text-button_accent transition duration-200">
                    <input type="checkbox" name="remember"
                        class="form-checkbox text-button_accent rounded focus:ring-button_accent" />
                    <span>Lembrar de mim por 30 dias</span>
                </label>

                {{-- 3. BOTÃO DE SUBMISSÃO --}}
                <button type="submit"
                    class="mt-6 w-full p-3 bg-button_accent text-white font-bold rounded-full flex items-center justify-center space-x-2 
                            shadow-lg shadow-button_accent/50 hover:bg-button_hover transition duration-300 transform hover:scale-[1.01] 
                            focus:outline-none focus:ring-4 focus:ring-button_accent/50">
                    <span role="img" aria-label="login">
                        🔐
                    </span>
                    <span>Acessar</span>
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login_form') }}" class="text-light text-sm hover:text-button_accent transition">
                    ← Voltar à seleção de perfil
                </a>
            </div>

        </div>
    </div>

</body>

</html>
