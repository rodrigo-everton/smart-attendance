@extends('layouts.main')

@section('title', $materia->nome . ' - Gerenciar - Smart Attendance')

@section('body-class', 'bg-gray-100 text-gray-800')

@push('styles')
<style>
    .header-bg { background: linear-gradient(135deg, #4c1d95, #c026d3); }
    .card-shadow { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.06); }
    
    /* Input de nota estilizado */
    .nota-input {
        width: 70px;
        text-align: center;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 6px 4px;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.2s;
        background: white;
    }
    .nota-input:focus {
        outline: none;
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15);
    }
    .nota-input.saving {
        border-color: #f59e0b;
        background: #fffbeb;
    }
    .nota-input.saved {
        border-color: #10b981;
        background: #ecfdf5;
    }
    .nota-input.error {
        border-color: #ef4444;
        background: #fef2f2;
    }

    /* Tooltip customizado */
    .falta-badge {
        position: relative;
        cursor: help;
    }
</style>
@endpush

@section('footer-class', 'py-4 text-center text-sm text-gray-400')

@section('content')
    <header class="header-bg text-white p-4 shadow-lg">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold">{{ $materia->nome }}</h1>
                    <p class="text-white/70 text-sm mt-1">Sala: {{ $materia->sala }} · {{ $alunos->count() }} alunos matriculados</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('professor.gerenciar.index') }}" 
                       class="bg-white text-dark_purple hover:bg-gray-200 py-1 px-3 rounded-full text-sm font-semibold transition duration-200">
                        ← Matérias
                    </a>
                    <a href="{{ route('dashboard.professor') }}" 
                       class="bg-white/20 text-white hover:bg-white/30 py-1 px-3 rounded-full text-sm font-semibold transition duration-200 border border-white/40">
                        🏠 Dashboard
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-6 mt-6">

        {{-- Cards de resumo --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-white p-4 rounded-xl card-shadow text-center">
                <p class="text-3xl font-extrabold text-purple-600">{{ $alunos->count() }}</p>
                <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Alunos</p>
            </div>
            <div class="bg-white p-4 rounded-xl card-shadow text-center">
                <p class="text-3xl font-extrabold text-blue-600">{{ $totalAulas }}</p>
                <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Aulas no Semestre</p>
            </div>
            <div class="bg-white p-4 rounded-xl card-shadow text-center">
                <p class="text-3xl font-extrabold text-indigo-600">{{ $aulasRealizadas }}</p>
                <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Aulas Realizadas</p>
            </div>
            <div class="bg-white p-4 rounded-xl card-shadow text-center">
                @php
                    $mediaGeral = $alunos->map(function($a) {
                        $notas = collect([$a->pivot->prova1, $a->pivot->trabalho1, $a->pivot->trabalho2, $a->pivot->prova2])->filter(fn($n) => $n !== null);
                        return $notas->isNotEmpty() ? $notas->avg() : null;
                    })->filter(fn($m) => $m !== null);
                @endphp
                <p class="text-3xl font-extrabold text-green-600">{{ $mediaGeral->isNotEmpty() ? number_format($mediaGeral->avg(), 1) : '--' }}</p>
                <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Média Geral</p>
            </div>
            <div class="bg-white p-4 rounded-xl card-shadow text-center">
                @php
                    $aprovados = $mediaGeral->filter(fn($m) => $m >= 5)->count();
                @endphp
                <p class="text-3xl font-extrabold text-emerald-600">{{ $mediaGeral->isNotEmpty() ? round(($aprovados / $mediaGeral->count()) * 100) . '%' : '--' }}</p>
                <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Taxa Aprovação</p>
            </div>
        </div>

        {{-- Tabela de Alunos --}}
        <div class="bg-white rounded-2xl card-shadow overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-purple-800 to-purple-600 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    📋 Alunos Matriculados
                </h2>
                <div class="flex items-center gap-3">
                    <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full font-bold">
                        Previstas: {{ $totalAulas }}
                    </span>
                    <span class="bg-white/30 text-white text-xs px-3 py-1 rounded-full font-bold">
                        Realizadas: {{ $aulasRealizadas }}/{{ $totalAulas }}
                    </span>
                </div>
            </div>

            @if($alunos->isEmpty())
                <div class="p-12 text-center text-gray-400">
                    <p class="text-5xl mb-4">📭</p>
                    <p class="text-lg">Nenhum aluno matriculado nesta disciplina.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                                <th class="py-3 px-4 text-left font-bold">#</th>
                                <th class="py-3 px-4 text-left font-bold">Aluno</th>
                                <th class="py-3 px-4 text-left font-bold">RA</th>
                                <th class="py-3 px-4 text-center font-bold">Presenças</th>
                                <th class="py-3 px-4 text-center font-bold">Faltas</th>
                                <th class="py-3 px-4 text-center font-bold">1ª Prova</th>
                                <th class="py-3 px-4 text-center font-bold">1º Trabalho</th>
                                <th class="py-3 px-4 text-center font-bold">2º Trabalho</th>
                                <th class="py-3 px-4 text-center font-bold">2ª Prova</th>
                                <th class="py-3 px-4 text-center font-bold">Média</th>
                                <th class="py-3 px-4 text-center font-bold">Situação</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @foreach($alunos as $index => $aluno)
                                @php
                                    $presencas = $presencasPorAluno[$aluno->ra] ?? 0;
                                    $faltas = $totalAulas - $presencas;
                                    $percentPresenca = $totalAulas > 0 ? round(($presencas / $totalAulas) * 100) : 100;
                                    
                                    $notasArr = collect([$aluno->pivot->prova1, $aluno->pivot->trabalho1, $aluno->pivot->trabalho2, $aluno->pivot->prova2])->filter(fn($n) => $n !== null);
                                    $media = $notasArr->isNotEmpty() ? round($notasArr->avg(), 2) : null;
                                    
                                    // Situação
                                    $reprovadoFalta = $totalAulas > 0 && $percentPresenca < 75;
                                    $aprovado = $media !== null && $media >= 5 && !$reprovadoFalta;
                                @endphp
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition {{ $index % 2 === 0 ? '' : 'bg-gray-50/50' }}">
                                    <td class="py-3 px-4 text-gray-400 font-mono text-xs">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 font-medium text-gray-800 whitespace-nowrap">{{ $aluno->nome }}</td>
                                    <td class="py-3 px-4 font-mono text-purple-600 text-xs">{{ $aluno->ra }}</td>
                                    
                                    {{-- Presenças --}}
                                    <td class="py-3 px-4 text-center">
                                        <span class="font-bold {{ $percentPresenca >= 75 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $presencas }}/{{ $totalAulas }}
                                        </span>
                                        <span class="text-xs text-gray-400 ml-1">({{ $percentPresenca }}%)</span>
                                    </td>
                                    
                                    {{-- Faltas --}}
                                    <td class="py-3 px-4 text-center">
                                        @if($faltas > 0)
                                            <span class="falta-badge inline-block bg-red-100 text-red-700 py-1 px-2 rounded-full text-xs font-bold">
                                                {{ $faltas }}
                                            </span>
                                        @else
                                            <span class="text-green-600 font-bold text-xs">0</span>
                                        @endif
                                    </td>

                                    {{-- 1ª Prova --}}
                                    <td class="py-3 px-4 text-center">
                                        <input type="number" 
                                               class="nota-input" 
                                               data-aluno="{{ $aluno->ra }}" 
                                               data-campo="prova1"
                                               value="{{ $aluno->pivot->prova1 !== null ? number_format($aluno->pivot->prova1, 1) : '' }}"
                                               min="0" max="10" step="0.1"
                                               placeholder="--">
                                    </td>

                                    {{-- 1º Trabalho --}}
                                    <td class="py-3 px-4 text-center">
                                        <input type="number" 
                                               class="nota-input" 
                                               data-aluno="{{ $aluno->ra }}" 
                                               data-campo="trabalho1"
                                               value="{{ $aluno->pivot->trabalho1 !== null ? number_format($aluno->pivot->trabalho1, 1) : '' }}"
                                               min="0" max="10" step="0.1"
                                               placeholder="--">
                                    </td>

                                    {{-- 2º Trabalho --}}
                                    <td class="py-3 px-4 text-center">
                                        <input type="number" 
                                               class="nota-input" 
                                               data-aluno="{{ $aluno->ra }}" 
                                               data-campo="trabalho2"
                                               value="{{ $aluno->pivot->trabalho2 !== null ? number_format($aluno->pivot->trabalho2, 1) : '' }}"
                                               min="0" max="10" step="0.1"
                                               placeholder="--">
                                    </td>

                                    {{-- 2ª Prova --}}
                                    <td class="py-3 px-4 text-center">
                                        <input type="number" 
                                               class="nota-input" 
                                               data-aluno="{{ $aluno->ra }}" 
                                               data-campo="prova2"
                                               value="{{ $aluno->pivot->prova2 !== null ? number_format($aluno->pivot->prova2, 1) : '' }}"
                                               min="0" max="10" step="0.1"
                                               placeholder="--">
                                    </td>

                                    {{-- Média --}}
                                    <td class="py-3 px-4 text-center" id="media-{{ $aluno->ra }}">
                                        @if($media !== null)
                                            <span class="font-extrabold text-base {{ $media >= 5 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($media, 1) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">--</span>
                                        @endif
                                    </td>

                                    {{-- Situação --}}
                                    <td class="py-3 px-4 text-center" id="situacao-{{ $aluno->ra }}">
                                        @if($reprovadoFalta)
                                            <span class="bg-red-100 text-red-700 py-1 px-2 rounded-full text-xs font-bold">Rep. Falta</span>
                                        @elseif($media !== null && $aprovado)
                                            <span class="bg-green-100 text-green-700 py-1 px-2 rounded-full text-xs font-bold">Aprovado</span>
                                        @elseif($media !== null && !$aprovado)
                                            <span class="bg-red-100 text-red-700 py-1 px-2 rounded-full text-xs font-bold">Reprovado</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-500 py-1 px-2 rounded-full text-xs font-bold">Pendente</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Legenda --}}
        <div class="mt-6 bg-white rounded-xl card-shadow p-4 flex flex-wrap gap-6 text-xs text-gray-500">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                Aprovado (Média ≥ 5.0 e Presença ≥ 75%)
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                Reprovado (Média < 5.0 ou Presença < 75%)
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-gray-400 rounded-full"></span>
                Pendente (Notas não lançadas)
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                As notas são salvas automaticamente ao sair do campo
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const saveUrl = "{{ route('professor.gerenciar.salvar_notas', $materia->id) }}";

        // Auto-save ao sair do campo (blur) ou ao pressionar Enter
        document.querySelectorAll('.nota-input').forEach(input => {
            let valorOriginal = input.value;

            input.addEventListener('focus', function() {
                valorOriginal = this.value;
            });

            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.blur();
                }
            });

            input.addEventListener('blur', function() {
                const novoValor = this.value;
                
                // Se não mudou, não salva
                if (novoValor === valorOriginal) return;

                // Validação básica
                const num = parseFloat(novoValor);
                if (novoValor !== '' && (isNaN(num) || num < 0 || num > 10)) {
                    this.classList.add('error');
                    setTimeout(() => {
                        this.classList.remove('error');
                        this.value = valorOriginal;
                    }, 1500);
                    return;
                }

                const alunoRa = this.dataset.aluno;
                const campo = this.dataset.campo;
                const valor = novoValor === '' ? null : num;

                // Feedback visual: salvando
                this.classList.add('saving');

                fetch(saveUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        aluno_ra: alunoRa,
                        campo: campo,
                        valor: valor,
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erro ao salvar');
                    return response.json();
                })
                .then(data => {
                    this.classList.remove('saving');
                    this.classList.add('saved');
                    valorOriginal = novoValor;
                    
                    // Atualiza a média na mesma linha
                    atualizarMedia(alunoRa);

                    setTimeout(() => this.classList.remove('saved'), 2000);
                })
                .catch(error => {
                    console.error('Erro:', error);
                    this.classList.remove('saving');
                    this.classList.add('error');
                    setTimeout(() => {
                        this.classList.remove('error');
                        this.value = valorOriginal;
                    }, 2000);
                });
            });
        });

        function atualizarMedia(alunoRa) {
            const inputs = document.querySelectorAll(`.nota-input[data-aluno="${alunoRa}"]`);
            const notas = [];
            
            inputs.forEach(input => {
                const val = parseFloat(input.value);
                if (!isNaN(val)) notas.push(val);
            });

            const mediaCell = document.getElementById(`media-${alunoRa}`);
            const situacaoCell = document.getElementById(`situacao-${alunoRa}`);

            if (notas.length > 0) {
                const media = notas.reduce((sum, n) => sum + n, 0) / notas.length;
                const mediaFormatada = media.toFixed(1);
                const cor = media >= 5 ? 'text-green-600' : 'text-red-600';
                mediaCell.innerHTML = `<span class="font-extrabold text-base ${cor}">${mediaFormatada}</span>`;

                // Atualiza situação
                if (media >= 5) {
                    situacaoCell.innerHTML = `<span class="bg-green-100 text-green-700 py-1 px-2 rounded-full text-xs font-bold">Aprovado</span>`;
                } else {
                    situacaoCell.innerHTML = `<span class="bg-red-100 text-red-700 py-1 px-2 rounded-full text-xs font-bold">Reprovado</span>`;
                }
            } else {
                mediaCell.innerHTML = `<span class="text-gray-400 text-xs">--</span>`;
                situacaoCell.innerHTML = `<span class="bg-gray-100 text-gray-500 py-1 px-2 rounded-full text-xs font-bold">Pendente</span>`;
            }
        }
    });
</script>
@endpush
