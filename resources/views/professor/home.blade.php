@extends('layouts.main')

@section('title', 'Dashboard do Professor - Smart Attendance')

@section('body-class', 'bg-gray-100 text-gray-800')

@push('styles')
<style>
    .header-bg {
        background: linear-gradient(135deg, #4c1d95, #c026d3);
    }
    .card-shadow {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.06);
    }
</style>
@endpush



@section('content')
    <header class="header-bg text-white p-4 shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Smart Attendance - Professor</h1>

            <div class="flex items-center space-x-4">
                {{-- O objeto $professor é passado do DashboardController --}}
                <span class="text-sm font-medium">
                    Olá, {{ $professor->nome ?? 'Docente' }}!
                </span>

                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="bg-white text-dark_purple hover:bg-gray-200 py-1 px-3 rounded-full text-sm font-semibold transition duration-200">
                    Sair
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-6 mt-8">

        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Dashboard de Presença</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-lg card-shadow border-t-4 border-prof_accent">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Gerar QR Code</h3>
                <p class="text-gray-600 mb-4">Crie um novo código de presença para a sua aula atual.</p>

                {{-- Ação para gerar QR Code --}}
                <a href="{{ route('professor.presenca.index') }}"
                    class="inline-block bg-prof_accent text-white py-2 px-4 rounded-lg font-semibold hover:bg-dark_purple transition duration-200">
                    Gerar Código Agora
                </a>
            </div>

            <div class="bg-white p-6 rounded-lg card-shadow border-t-4 border-dark_purple">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Histórico de Aulas</h3>
                <p class="text-gray-600 mb-4">Consulte as presenças registradas em aulas anteriores.</p>
                <a href="#"
                    class="inline-block border border-dark_purple text-dark_purple py-2 px-4 rounded-lg font-semibold hover:bg-dark_purple hover:text-white transition duration-200">
                    Ver Relatórios
                </a>
            </div>

            <div class="bg-white p-6 rounded-lg card-shadow border-t-4 border-gray-400">
                <h3 class="text-xl font-bold text-gray-700 mb-4">Minhas Matérias</h3>
                <p class="text-gray-600 mb-4">Configure turmas e disciplinas que você leciona.</p>
                <a href="{{ route('professor.gerenciar.index') }}"
                    class="inline-block border border-gray-400 text-gray-700 py-2 px-4 rounded-lg font-semibold hover:bg-gray-100 transition duration-200">
                    Gerenciar
                </a>
            </div>
        </div>

        <section id="qr-code-area" class="mt-10 p-8 bg-white rounded-lg card-shadow">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Área de Geração Ativa</h3>
            <p class="text-gray-500">Clique em "Gerar Código Agora" para criar um QR Code que os alunos poderão
                escanear. O código será exibido aqui.</p>

            {{-- 

[Image of QR Code]
 - Placeholder para o QR Code gerado --}}
            <div class="mt-6 text-center">
                <p class="text-gray-400 italic">O QR Code aparecerá após a geração.</p>
            </div>
        </section>

    </main>
@endsection
