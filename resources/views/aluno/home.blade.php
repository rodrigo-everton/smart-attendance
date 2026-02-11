@extends('layouts.main')

@section('title', 'Como Funciona? - Smart Attendance')

@section('body-class', 'gradient-bg')

@section('footer-class', 'py-6 text-center text-sm text-white/60')

@section('content')
    <div class="flex flex-col items-center p-4 w-full">

        @if(session('pending_attendance_code'))
            <div class="w-full max-w-md mb-6 bg-green-500/90 backdrop-blur-md border border-green-300 p-6 rounded-xl shadow-2xl text-center animate-pulse">
                <span class="text-4xl mb-3 block">📋</span>
                <h2 class="text-2xl font-bold text-white mb-2">Presença Pendente!</h2>
                <p class="text-white/90 mb-4">Clique abaixo para confirmar sua presença na aula.</p>
                <a href="{{ route('presenca.confirmar', session('pending_attendance_code')) }}"
                    class="block w-full bg-white text-green-700 font-bold text-lg py-3 px-6 rounded-full 
                           shadow-lg hover:bg-green-50 transition duration-300 transform hover:scale-[1.02]">
                    ✅ Confirmar Presença Agora
                </a>
            </div>
        @endif

        <h1 class="text-3xl md:text-4xl font-bold text-light mt-8 mb-6">Como funciona?</h1>

        <a href="{{ Auth::check() ? route('dashboard') : route('login_form') }}"
            class="mb-10 w-full max-w-xs py-3 px-8 bg-white text-primary font-bold text-lg rounded-full 
                 shadow-lg shadow-white/20 hover:shadow-white/40 hover:bg-gray-100
                 transition duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-white/50 text-center">
            Próximo
        </a>

        <div class="flex flex-col space-y-6 w-full max-w-md">

            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-xl shadow-lg flex flex-col items-center text-center">
                <span class="text-5xl mb-4" role="img" aria-label="graduation cap">🎓</span>
                <p class="text-light text-base md:text-lg font-medium">O docente acessa o Smart Attendance com seu RA,
                    e-mail institucional ou CPF.</p>
            </div>

            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-xl shadow-lg flex flex-col items-center text-center">
                <span class="text-5xl mb-4" role="img" aria-label="QR code">
                    <img src="{{ asset('img/qr-code.png') }}" alt="QR Code Placeholder" class="w-20 h-20 mx-auto">
                </span>
                <p class="text-light text-base md:text-lg font-medium">O docente escaneia o QR Code que será gerado pelo
                    professor.</p>
            </div>

            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-xl shadow-lg flex flex-col items-center text-center">
                <span class="text-5xl mb-4" role="img" aria-label="check mark">✅</span>
                <p class="text-light text-base md:text-lg font-medium">Com o app, o estudante escaneia o QR Code do
                    professor para registrar presença.</p>
            </div>

        </div>

        @auth
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="mt-12 w-full max-w-xs py-4 px-8 border-2 border-white text-light font-bold text-xl rounded-full 
                   hover:bg-white hover:text-primary transition duration-300 transform hover:scale-[1.02] 
                   focus:outline-none focus:ring-4 focus:ring-white/50 text-center">
                Sair
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endauth

    </div>
@endsection
