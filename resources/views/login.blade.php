<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Attendance</title>
    <!-- Carrega o Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Define a fonte Inter como padrão */
        body {
            font-family: "Inter", sans-serif;
        }

        /* Aplica um gradiente de fundo sutil para dar profundidade */
        .container-bg {
            background: radial-gradient(circle at center, #1e3a8a 0%, #0c4a6e 100%);
        }
    </style>
    <script>
        // Configuração do Tailwind para usar as novas cores customizadas
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a8a', // Azul Escuro Principal (Fundo)
                        card_purple: '#4c1d95', // Roxo mais forte para o Card
                        button_accent: '#c026d3', // Roxo Rosado (Fúcsia) para o Botão e Título
                        button_hover: '#86198f', // Fúcsia Escuro para o Hover
                        light: '#ffffff', // Branco
                    },
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100">

    <!-- Container principal: min-height 100vh, centralizado e com fundo azul customizado -->
    <div class="container-bg min-h-screen flex items-center justify-center p-4">

        <!-- Cartão de Login: fundo roxo forte. Texto claro. -->
        <div
            class="w-full max-w-sm bg-card_purple p-8 rounded-xl shadow-2xl transition duration-500 
                    hover:shadow-card_purple/70 transform hover:-translate-y-1 text-light">

            <!-- Header do Cartão -->
            <div class="text-center mb-6">
                <!-- Logo: Cor clara (Branco) -->
                <h1 class="text-4xl font-extrabold tracking-wider text-light mb-1">CEUB</h1>
                <!-- Linha Divisória: Cor clara (Branco semi-transparente) -->
                <hr class="w-full border-t border-light/50 my-4" />
                <!-- Título: AGORA com a cor Roxo Rosado (button_accent) -->
                <h2 class="text-2xl font-bold text-button_accent mt-4">Smart Attendance</h2>
                <!-- Subtítulo: Cor clara (Branco) -->
                <p class="text-light font-semibold mb-4">Registro Acadêmico</p>
                <!-- Linha Divisória: Cor clara (Branco semi-transparente) -->
                <hr class="w-full border-t border-light/50 my-4" />
            </div>

            <!-- FORMULÁRIO APONTA PARA A ROTA REAL DE LOGIN -->
            <form method="POST" action="{{ route('login') }}" class="flex flex-col space-y-4">
                @csrf

                {{-- Exibe erros de validação (se houver) --}}
                @error('ra_email_cpf')
                    <div class="bg-red-600 text-light p-3 rounded-lg font-bold text-sm text-center">
                        {{ $message }}
                    </div>
                @enderror

                {{-- 1. CAMPO MATRÍCULA (Inputs mantêm fundo branco e texto escuro para contraste) --}}
                <input type="text" name="ra_email_cpf" placeholder="Matrícula, RA ou E-Mail"
                    class="w-full p-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-button_accent transition duration-200 text-gray-800"
                    required value="{{ old('ra_email_cpf') }}" />

                {{-- 2. CAMPO SENHA --}}
                <input type="password" name="password" placeholder="Senha"
                    class="w-full p-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-button_accent transition duration-200 text-gray-800"
                    required />

                {{-- Campo Lembrar de Mim (Checkbox) --}}
                <!-- Label: Cor do texto alterada para Branco (text-light). Hover para o roxo rosado do botão. -->
                <label
                    class="flex items-center space-x-2 text-light text-sm cursor-pointer hover:text-button_accent transition duration-200">
                    <input type="checkbox" name="remember"
                        class="form-checkbox text-button_accent rounded focus:ring-button_accent" />
                    <span>Lembrar de mim por 30 dias</span>
                </label>

                {{-- 3. BOTÃO DE SUBMISSÃO --}}
                <!-- Botão: Cor de fundo Roxo Rosado (button_accent) e Hover Roxo Rosado Escuro (button_hover) -->
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
        </div>
    </div>

</body>

</html>
