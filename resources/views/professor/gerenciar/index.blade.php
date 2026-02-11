@extends('layouts.main')

@section('title', 'Gerenciar Matérias - Smart Attendance')

@section('body-class', 'bg-gray-100 text-gray-800')

@push('styles')
<style>
    .header-bg { background: linear-gradient(135deg, #4c1d95, #c026d3); }
    .card-shadow { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.06); }
</style>
@endpush

@section('content')
    <header class="header-bg text-white p-4 shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Minhas Matérias</h1>
            <a href="{{ route('dashboard.professor') }}" 
               class="bg-white text-dark_purple hover:bg-gray-200 py-1 px-3 rounded-full text-sm font-semibold transition duration-200">
                ← Voltar ao Dashboard
            </a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto p-6 mt-8">
        <h2 class="text-3xl font-semibold text-gray-800 mb-2">Selecione uma Disciplina</h2>
        <p class="text-gray-500 mb-8">Visualize alunos matriculados, gerencie notas e acompanhe faltas.</p>

        @if($materias->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg" role="alert">
                <p class="font-bold">Nenhuma matéria encontrada</p>
                <p>Você não possui matérias cadastradas no sistema.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($materias as $materia)
                    <a href="{{ route('professor.gerenciar.materia', $materia->id) }}" 
                       class="group bg-white p-6 rounded-xl card-shadow hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-purple-300 transform hover:-translate-y-1">
                        
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-purple-100 text-purple-700 p-3 rounded-lg group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <span class="bg-gray-100 text-gray-600 text-xs font-bold py-1 px-2 rounded-full">
                                {{ $materia->alunos_count }} alunos
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-purple-700 transition-colors">{{ $materia->nome }}</h3>
                        
                        <div class="flex flex-wrap gap-2 mb-3">
                            @if($materia->horario_matutino)
                                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-medium">☀️ Matutino</span>
                            @endif
                            @if($materia->horario_vespertino)
                                <span class="text-xs bg-orange-100 text-orange-700 px-2 py-1 rounded-full font-medium">⛅ Vespertino</span>
                            @endif
                            @if($materia->horario_noturno)
                                <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full font-medium">🌙 Noturno</span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-400">Sala: {{ $materia->sala }}</p>
                        <p class="text-sm text-gray-400">Carga Horária: {{ $materia->carga_horaria }}h · {{ $materia->total_aulas }} aulas/semestre</p>
                        
                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-sm text-purple-600 font-semibold group-hover:text-purple-800">Ver detalhes →</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </main>
@endsection
