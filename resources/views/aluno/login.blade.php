@extends('layouts.main')

@section('title', 'Login Aluno - Smart Attendance')

@section('body-class', 'gradient-bg relative')

@section('footer-class', 'fixed bottom-4 w-full text-center text-sm text-white/60')

@section('content')
    <div class="flex-grow flex items-center justify-center p-4">

        <div
            class="w-full max-w-sm bg-card_purple p-8 rounded-xl shadow-2xl transition duration-500 hover:shadow-card_purple/70 transform text-light">

            <div class="text-center mb-6">
                <h1 class="text-4xl font-extrabold tracking-wider text-light mb-1">CEUB</h1>
                <hr class="w-full border-t border-light/50 my-4" />
                <h2 class="text-2xl font-bold text-button_accent mt-4">Smart Attendance</h2>
                <p class="text-light font-semibold mb-4">Login - Aluno</p>
                <hr class="w-full border-t border-light/50 my-4" />
            </div>

            <form method="POST" action="{{ route('login.aluno') }}" class="flex flex-col space-y-4">
                @csrf

                {{-- Exibe erros de validação (se houver) --}}
                @error('ra_email_cpf')
                    <div class="bg-red-600 text-light p-3 rounded-lg font-bold text-sm text-center">
                        {{ $message }}
                    </div>
                @enderror

                {{-- 1. CAMPO MATRÍCULA --}}
                <input type="text" name="ra_email_cpf" placeholder="Matrícula, RA, CPF ou E-Mail"
                    class="w-full p-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-button_accent transition duration-200 text-gray-800 placeholder-gray-900"
                    required value="{{ old('ra_email_cpf') }}" />

                {{-- 2. CAMPO SENHA --}}
                <div class="relative w-full">
                    <input type="password" name="password" id="password" placeholder="Senha"
                        class="w-full p-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-button_accent transition duration-200 text-gray-800 pr-10 placeholder-gray-900"
                        required />
                    <button type="button" onclick="togglePassword()"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-button_accent focus:outline-none">
                        <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

                {{-- Campo Lembrar de Mim (Checkbox) --}}
                <label
                    class="flex items-center space-x-2 text-light text-sm cursor-pointer hover:text-button_accent transition duration-200">
                    <input type="checkbox" name="remember"
                        class="form-checkbox text-button_accent rounded focus:ring-button_accent" />
                    <span>Lembrar de mim por 30 dias</span>
                </label>

                {{-- 3. BOTÃO DE SUBMISSÃO --}}
                <button type="submit"
                    class="mt-6 w-full p-3 bg-yellow-500 text-white font-bold rounded-full flex items-center justify-center space-x-2 
                            shadow-lg hover:shadow-xl hover:bg-yellow-600 transition duration-300 transform hover:scale-[1.01] 
                            focus:outline-none focus:ring-4 focus:ring-yellow-500/50">
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
@endsection

@push('scripts')
<script src="{{ asset('js/toggle_password.js') }}"></script>
@endpush
