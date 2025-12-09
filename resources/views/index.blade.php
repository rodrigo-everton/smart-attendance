<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Attendance</title>
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

    <div class="container-bg min-h-screen flex items-center justify-center p-4">

        <div
            class="w-full max-w-sm bg-card_purple p-8 rounded-xl shadow-2xl transition duration-500 
                     hover:shadow-card_purple/70 transform hover:-translate-y-1 text-light">

            <div class="text-center mb-6">
                <h1 class="text-4xl font-extrabold tracking-wider text-light mb-1">CEUB</h1>
                <hr class="w-full border-t border-light/50 my-4" />
                <h2 class="text-2xl font-bold text-button_accent mt-4">Smart Attendance</h2>
                <p class="text-light font-semibold mb-4">Registro Acadêmico</p>
                <hr class="w-full border-t border-light/50 my-4" />
            </div>

            <form method="POST" action="{{ route('login') }}" class="flex flex-col space-y-4">
                @csrf

                {{-- Exibe erros de validação (se houver) --}}
                @error('ra_email_cpf')
                    <div class="bg-red-600 text-light p-3 rounded-lg font-bold text-sm text-center">
                        {{ $message }}
                    </div>
                @enderror

                {{-- 🚨 NOVO: SELETOR DE PERFIL (ALUNO/PROFESSOR) --}}
                <div class="relative">
                    <label for="user_role" class="block text-sm font-medium text-light mb-1">Entrar como:</label>
                    <select id="user_role" name="user_role" required
                        class="w-full p-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-button_accent transition duration-200 text-gray-800 appearance-none bg-white">
                        <option value="aluno" {{ old('user_role') == 'aluno' ? 'selected' : '' }}>Aluno</option>
                        <option value="professor" {{ old('user_role') == 'professor' ? 'selected' : '' }}>Professor
                        </option>
                    </select>
                    {{-- Ícone para melhor visual --}}
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 top-6 flex items-center px-3 text-gray-800">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>


                {{-- 1. CAMPO MATRÍCULA/CPF/E-MAIL --}}
                <input type="text" name="ra_email_cpf" placeholder="Matrícula, RA, CPF ou E-Mail"
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
        </div>
    </div>

</body>

</html>
