@extends('layouts.main')

@section('title', 'Selecionar Matéria - Smart Attendance')

@section('body-class', 'bg-gray-100 text-gray-800')

@push('styles')
<style>
    .header-bg { background: linear-gradient(135deg, #4c1d95, #c026d3); }
    .card-shadow { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
</style>
@endpush


@section('content')
    <header class="header-bg text-white p-4 shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Gerar Frequência</h1>
            <a href="{{ route('dashboard.professor') }}" class="bg-white text-dark_purple hover:bg-gray-200 py-1 px-3 rounded-full text-sm font-semibold transition">Voltar ao Dashboard</a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto p-6 mt-8">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Selecione a Disciplina</h2>

        @if($materias->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p>Você não possui matérias cadastradas.</p>
            </div>
        @else
            @php $hasActiveCode = $materias->contains(fn($m) => $m->active_code); @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($materias as $materia)
                    <div class="bg-white p-6 rounded-lg card-shadow hover:shadow-lg transition duration-200 border border-gray-100">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">{{ $materia->nome }}</h3>
                                <p class="text-sm text-gray-500 mt-1 font-medium bg-gray-100 inline-block px-2 py-1 rounded">
                                    {{ $materia->horario_matutino ? '☀️ Matutino' : ($materia->horario_noturno ? '🌙 Noturno' : '⛅ Vespertino') }}
                                </p>
                            </div>
                            @if($materia->active_code)
                                <span class="bg-green-100 text-green-700 text-xs font-bold py-1 px-2 rounded-full">ATIVO</span>
                            @endif
                        </div>

                        @if($materia->active_code)
                            {{-- Já tem QR ativo: botão verde para VER --}}
                            <a href="{{ route('professor.presenca.gerar', $materia->id) }}" 
                               target="_blank"
                               class="block w-full bg-green-600 text-white text-center py-3 px-4 rounded-lg font-bold text-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                ✅ Mostrar QR Code
                            </a>
                        @else
                            {{-- Sem QR ativo: botão para gerar (com verificação de conflito) --}}
                            @if($hasActiveCode)
                                {{-- Outra matéria já tem QR ativo: mostra popup --}}
                                <button onclick="mostrarPopup('{{ $materia->nome }}')"
                                   class="block w-full bg-gray-400 text-white text-center py-3 px-4 rounded-lg font-bold text-lg hover:bg-gray-500 transition duration-300 shadow-md cursor-pointer">
                                    📷 Gerar QR Code
                                </button>
                            @else
                                {{-- Nenhum QR ativo: pode gerar livremente --}}
                                <a href="{{ route('professor.presenca.gerar', $materia->id) }}" 
                                   target="_blank"
                                   class="block w-full bg-purple-600 text-white text-center py-3 px-4 rounded-lg font-bold text-lg hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    📷 Gerar QR Code
                                </a>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    {{-- Modal/Popup de aviso --}}
    <div id="popup-overlay" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 text-center shadow-2xl transform transition-all">
            <div class="text-5xl mb-4">⚠️</div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">QR Code Já Ativo!</h2>
            <p class="text-gray-500 mb-2">Você já possui um QR Code de frequência ativo para outra disciplina.</p>
            <p class="text-gray-400 text-sm mb-6">Aguarde o término ou encerramento da chamada atual antes de gerar outro.</p>
            <p id="popup-materia" class="text-sm font-bold text-purple-600 mb-6"></p>
            
            <div class="flex gap-3">
                <button onclick="fecharPopup()" 
                    class="flex-1 bg-gray-200 text-gray-700 font-bold py-3 px-4 rounded-lg hover:bg-gray-300 transition">
                    Entendi
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function mostrarPopup(nomeMateria) {
            document.getElementById('popup-materia').textContent = 'Disciplina solicitada: ' + nomeMateria;
            document.getElementById('popup-overlay').classList.remove('hidden');
        }

        function fecharPopup() {
            document.getElementById('popup-overlay').classList.add('hidden');
        }

        // Fecha popup ao clicar fora
        document.getElementById('popup-overlay').addEventListener('click', function(e) {
            if (e.target === this) fecharPopup();
        });

        // Fecha popup com ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') fecharPopup();
        });
    </script>
@endpush
