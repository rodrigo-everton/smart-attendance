@extends('layouts.main')

@section('title', 'Painel Administrativo Master - Smart Attendance')

@section('body-class', 'bg-gray-50 text-gray-800')

@push('styles')
<style>
    .header-gradient { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); }
    .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.2); }
    .stat-icon { width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; border-radius: 16px; font-size: 1.5rem; }
</style>
@endpush

@section('content')
    <nav class="header-gradient text-white shadow-lg">
        <div class="container mx-auto px-6 py-5 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <span class="text-3xl">🛡️</span>
                <div>
                    <span class="text-xl font-bold tracking-wide block">Painel Master</span>
                    <span class="text-xs text-white/70">Smart Attendance</span>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <span class="text-sm opacity-90 hidden sm:block">Olá, {{ $master->nome ?? 'Administrador' }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="bg-white/10 border border-white/30 hover:bg-white/20 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-10">

        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-gray-800 mb-2">Visão Geral do Sistema</h1>
            <p class="text-gray-500">Selecione uma seção para gerenciar.</p>
        </div>

        {{-- Cards de Resumo (números) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-2xl shadow-md p-6 flex items-center gap-5 border border-gray-100">
                <div class="stat-icon bg-blue-100 text-blue-600">👨‍🏫</div>
                <div>
                    <p class="text-3xl font-extrabold text-gray-800">{{ $professoresCount }}</p>
                    <p class="text-sm text-gray-500">Professores cadastrados</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 flex items-center gap-5 border border-gray-100">
                <div class="stat-icon bg-purple-100 text-purple-600">🧑‍🎓</div>
                <div>
                    <p class="text-3xl font-extrabold text-gray-800">{{ $alunosCount }}</p>
                    <p class="text-sm text-gray-500">Alunos cadastrados</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-6 flex items-center gap-5 border border-gray-100">
                <div class="stat-icon bg-teal-100 text-teal-600">📚</div>
                <div>
                    <p class="text-3xl font-extrabold text-gray-800">{{ $materiasCount }}</p>
                    <p class="text-sm text-gray-500">Matérias cadastradas</p>
                </div>
            </div>
        </div>

        {{-- Cards de Navegação --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Card Professores --}}
            <a href="{{ route('master.professores') }}" class="card-hover group bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 block">
                <div class="bg-gradient-to-r from-blue-800 to-blue-500 p-6">
                    <div class="flex items-center justify-between">
                        <span class="text-4xl">👨‍🏫</span>
                        <span class="bg-white/20 text-white text-sm px-3 py-1 rounded-full font-bold">{{ $professoresCount }}</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white mt-4">Professores</h2>
                    <p class="text-white/70 text-sm mt-1">Gerenciar professores cadastrados</p>
                </div>
                <div class="p-5 flex items-center justify-between">
                    <span class="text-sm text-gray-500">Visualizar, pesquisar e gerenciar</span>
                    <span class="text-blue-600 font-bold group-hover:translate-x-1 transition-transform duration-200">→</span>
                </div>
            </a>

            {{-- Card Alunos --}}
            <a href="{{ route('master.alunos') }}" class="card-hover group bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 block">
                <div class="bg-gradient-to-r from-purple-800 to-purple-500 p-6">
                    <div class="flex items-center justify-between">
                        <span class="text-4xl">🧑‍🎓</span>
                        <span class="bg-white/20 text-white text-sm px-3 py-1 rounded-full font-bold">{{ $alunosCount }}</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white mt-4">Alunos</h2>
                    <p class="text-white/70 text-sm mt-1">Gerenciar alunos matriculados</p>
                </div>
                <div class="p-5 flex items-center justify-between">
                    <span class="text-sm text-gray-500">Visualizar, pesquisar e gerenciar</span>
                    <span class="text-purple-600 font-bold group-hover:translate-x-1 transition-transform duration-200">→</span>
                </div>
            </a>

            {{-- Card Matérias --}}
            <a href="{{ route('master.materias') }}" class="card-hover group bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 block">
                <div class="bg-gradient-to-r from-teal-700 to-teal-500 p-6">
                    <div class="flex items-center justify-between">
                        <span class="text-4xl">📚</span>
                        <span class="bg-white/20 text-white text-sm px-3 py-1 rounded-full font-bold">{{ $materiasCount }}</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white mt-4">Matérias</h2>
                    <p class="text-white/70 text-sm mt-1">Gerenciar disciplinas do sistema</p>
                </div>
                <div class="p-5 flex items-center justify-between">
                    <span class="text-sm text-gray-500">Visualizar, pesquisar e gerenciar</span>
                    <span class="text-teal-600 font-bold group-hover:translate-x-1 transition-transform duration-200">→</span>
                </div>
            </a>

        </div>

        {{-- Card Chamada QR Code --}}
        <a href="{{ route('master.presenca') }}" class="card-hover group bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 block mt-8">
            <div class="bg-gradient-to-r from-orange-500 to-red-600 p-6 flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-3xl">📱</span>
                        <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-full font-bold">Novo</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Chamada - QR Code</h2>
                    <p class="text-white/80 text-sm mt-1">Gerar códigos de aula e monitorar presenças em tempo real</p>
                </div>
                <div class="bg-white/20 p-4 rounded-2xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </div>
            </div>
            <div class="p-5 flex items-center justify-between">
                <span class="text-sm text-gray-500">Acessar painel de chamadas</span>
                <span class="text-orange-600 font-bold group-hover:translate-x-1 transition-transform duration-200">→</span>
            </div>
        </a>

    </div>
@endsection
