<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Attendance</title>

    {{-- 💡 Estilos CSS (Adaptados do seu Home.module.css) --}}
    <style>
        :root {
            --color-primary: #1e3a8a;
            /* Azul Escuro */
            --color-secondary: #0c4a6e;
            /* Azul Marinho (para hover) */
            --color-accent: #f59e0b;
            /* Amarelo/Laranja (para destaque) */
            --color-light: #ffffff;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        .container {
            background-color: var(--color-primary);
            color: var(--color-light);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 320px;
            background-color: var(--color-primary);
            padding: 2rem;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        .logo {
            font-size: 3rem;
            font-weight: 900;
            letter-spacing: 2px;
            margin-bottom: 1rem;
        }

        .hr {
            width: 100%;
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.4);
        }

        .title {
            color: var(--color-accent);
            margin-top: 1rem;
            font-weight: 700;
        }

        .subtitle {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .form {
            width: 100%;
            display: flex;
            flex-direction: column;
            margin-top: 1.5rem;
            gap: 0.8rem;
        }

        .input {
            padding: 0.8rem;
            border-radius: 20px;
            border: none;
            outline: none;
            width: 100%;
        }

        .checkboxLabel {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .button {
            margin-top: 0.5rem;
            background-color: var(--color-accent);
            border-radius: 20px;
            padding: 0.8rem;
            font-weight: bold;
            color: var(--color-light);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: 0.3s;
            border: none;
            cursor: pointer;
        }

        .button:hover {
            background-color: var(--color-secondary);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <h1 class="logo">CEUB</h1>

            <hr class="hr" />

            <h2 class="title">Smart Attendance</h2>
            <p class="subtitle">Registro Acadêmico</p>

            <hr class="hr" />

            {{-- FORMULÁRIO APONTA PARA A ROTA REAL DE LOGIN --}}
            <form method="POST" action="{{ route('login') }}" class="form">
                @csrf

                {{-- Exibe erros de validação (se houver) --}}
                @error('ra_email_cpf')
                    <div style="color: yellow; font-weight: bold; text-align: center;">
                        {{ $message }}
                    </div>
                @enderror


                {{-- 1. CAMPO MATRÍCULA (ou RA/E-mail/CPF) --}}
                <input type="text" name="ra_email_cpf" placeholder="Matrícula, RA ou E-Mail" class="input" required
                    value="{{ old('ra_email_cpf') }}" />

                {{-- 2. CAMPO SENHA --}}
                <input type="password" name="password" placeholder="Senha" class="input" required />

                {{-- Campo Lembrar de Mim (Checkbox) --}}
                <label class="checkboxLabel">
                    <input type="checkbox" name="remember" />
                    Lembrar de mim por 30 dias
                </label>

                {{-- 3. BOTÃO DE SUBMISSÃO --}}
                <button type="submit" class="button">
                    <span role="img" aria-label="login">
                        🔐
                    </span>
                    Acessar
                </button>
            </form>
        </div>
    </div>

</body>

</html>
