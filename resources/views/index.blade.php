<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleção de Perfil - Smart Attendance</title>
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
        // Configuração do Tailwind (mantida)
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
            class="w-full max-w-lg bg-card_purple p-8 rounded-xl shadow-2xl transition duration-500 
                     hover:shadow-card_purple/70 transform text-light">

            <div class="text-center mb-10">
                <h1 class="text-4xl font-extrabold tracking-wider text-light mb-1">CEUB</h1>
                <hr class="w-full border-t border-light/50 my-4" />
                <h2 class="text-2xl font-bold text-button_accent mt-4">Smart Attendance</h2>
                <p class="text-light font-semibold mt-2 text-lg">Selecione seu perfil de acesso</p>
                <hr class="w-full border-t border-light/50 my-4" />
            </div>

            <div class="flex flex-col md:flex-row space-y-6 md:space-y-0 md:space-x-6 justify-center">

                {{-- Card de ALUNO --}}
                <a href="{{ route('login.aluno.form') }}"
                    class="flex flex-col items-center justify-center p-6 bg-primary rounded-xl shadow-xl hover:bg-indigo-700 
                           transition duration-300 transform hover:scale-[1.05] w-full md:w-1/2 cursor-pointer border-2 border-button_accent/0 hover:border-button_accent">

                    <span class="text-6xl mb-3" role="img" aria-label="estudante">🧑‍🎓</span>
                    <h3 class="text-2xl font-bold text-light">ALUNO</h3>
                    <p class="text-sm text-gray-300">Acessar com RA, CPF ou E-Mail</p>
                </a>

                {{-- Card de PROFESSOR --}}
                <a href="{{ route('login.professor.form') }}"
                    class="flex flex-col items-center justify-center p-6 bg-primary rounded-xl shadow-xl hover:bg-indigo-700 
                           transition duration-300 transform hover:scale-[1.05] w-full md:w-1/2 cursor-pointer border-2 border-button_accent/0 hover:border-border-button_accent">

                    <span class="text-6xl mb-3" role="img" aria-label="professor">👨‍🏫</span>
                    <h3 class="text-2xl font-bold text-light">PROFESSOR</h3>
                    <p class="text-sm text-gray-300">Acessar com CPF ou E-Mail</p>
                </a>
            </div>

            <p class="text-center text-xs text-gray-400 mt-8">Você será redirecionado para o formulário de login
                específico.</p>

        </div>
    </div>

</body>

</html>
