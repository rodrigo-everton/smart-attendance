@extends('layouts.main')

@section('title', 'Gerenciar Matérias - Master')

@section('body-class', 'bg-gray-50 text-gray-800')

@push('styles')
<style>
    .header-gradient { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); }
    .t-row:nth-child(even) { background-color: #f3f4f6; }
</style>
@endpush

@section('content')
    <nav class="header-gradient text-white shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                 <a href="{{ route('dashboard.master') }}" class="text-2xl hover:scale-110 transition-transform">🛡️</a>
                <div>
                    <h1 class="text-xl font-bold tracking-wide">Gerenciar Matérias</h1>
                    <a href="{{ route('dashboard.master') }}" class="text-xs text-white/70 hover:text-white underline">Voltar ao Painel Master</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-10">

        <!-- Matérias Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-teal-700 to-teal-500 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    📚 Matérias Cadastradas
                </h2>
                <div class="flex items-center gap-4">
                    <input type="text" id="search-materias" placeholder="Pesquisar Matéria..." 
                        class="px-3 py-1 rounded text-black text-sm focus:outline-none focus:ring-2 focus:ring-teal-300">
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Matéria</th>
                            <th class="py-3 px-6 text-center">Matutino</th>
                            <th class="py-3 px-6 text-center">Vespertino</th>
                            <th class="py-3 px-6 text-center">Noturno</th>

                            <th class="py-3 px-6 text-center">Professores</th>
                            <th class="py-3 px-6 text-center">Alunos</th>
                        </tr>
                    </thead>
                    <tbody id="materias-body" class="text-gray-600 text-sm font-light">
                        @foreach($materias as $materia)
                        <tr onclick='openModal("materia", @json($materia))' class="cursor-pointer border-b border-gray-200 hover:bg-gray-100 transition t-row">
                            <td class="py-3 px-6 text-left whitespace-nowrap font-medium text-gray-800">
                                {{ $materia->nome }}
                                <div class="text-xs text-gray-400 font-mono">{{ $materia->sala }}</div>
                                <div class="text-[10px] text-gray-400 font-mono">{{ $materia->carga_horaria }}h • {{ $materia->total_aulas }} aulas</div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <span class="{{ $materia->horario_matutino ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} py-1 px-2 rounded-full text-xs font-bold">
                                    {{ $materia->horario_matutino ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                             <td class="py-3 px-6 text-center">
                                <span class="{{ $materia->horario_vespertino ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} py-1 px-2 rounded-full text-xs font-bold">
                                    {{ $materia->horario_vespertino ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                             <td class="py-3 px-6 text-center">
                                <span class="{{ $materia->horario_noturno ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} py-1 px-2 rounded-full text-xs font-bold">
                                    {{ $materia->horario_noturno ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>

                            <td class="py-3 px-6 text-center">
                                <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold">{{ $materia->professores_count }}</span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <span class="bg-purple-100 text-purple-700 py-1 px-3 rounded-full text-xs font-bold">{{ $materia->alunos_count }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($materias->isEmpty())
                    <div id="materias-empty" class="p-6 text-center text-gray-400">Nenhuma matéria encontrada.</div>
                @else
                    <div id="materias-empty" class="hidden p-6 text-center text-gray-400">Nenhuma matéria encontrada.</div>
                @endif
                
                <div class="p-4">
                    {{ $materias->links() }}
                </div>
            </div>
        </div>

    </div>

    <!-- Info Modal -->
    <div id="info-modal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center backdrop-blur-sm transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 transform transition-all scale-95" id="modal-content-container">
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <h3 id="modal-title" class="text-2xl font-bold text-gray-800">Detalhes</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div id="modal-body" class="space-y-4">
                <!-- Dynamic Content -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/dashboard_modal.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
             const escapeHtml = (unsafe) => {
                if (unsafe === null || unsafe === undefined) return '';
                return String(unsafe).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
            };

            const setupSearch = (inputId, url, tbodyId, emptyId, renderRow) => {
                const input = document.getElementById(inputId);
                const tbody = document.getElementById(tbodyId);
                const emptyMsg = document.getElementById(emptyId);

                const triggerSearch = async () => {
                    const query = input.value;
                    try {
                        const response = await fetch(`${url}?q=${query}`);
                        const data = await response.json();

                        tbody.innerHTML = '';
                        if (data.length === 0) {
                            emptyMsg.classList.remove('hidden');
                        } else {
                            emptyMsg.classList.add('hidden');
                            data.forEach(item => {
                                const jsonItem = JSON.stringify(item).replace(/"/g, '&quot;').replace(/'/g, '&apos;');
                                tbody.innerHTML += renderRow(item, jsonItem, escapeHtml);
                            });
                        }
                    } catch (error) {
                        console.error('Erro na pesquisa:', error);
                    }
                };

                input.addEventListener('input', triggerSearch);
                input.addEventListener('focus', triggerSearch);
            };

            setupSearch('search-materias', '{{ route("master.search.materias") }}', 'materias-body', 'materias-empty', (materia, jsonItem, esc) => `
                <tr onclick='openModal("materia", ${jsonItem})' class="cursor-pointer border-b border-gray-200 hover:bg-gray-100 transition t-row">
                    <td class="py-3 px-6 text-left whitespace-nowrap font-medium text-gray-800">
                        ${esc(materia.nome)}
                        <div class="text-xs text-gray-400 font-mono">${esc(materia.sala)}</div>
                        <div class="text-[10px] text-gray-400 font-mono">${esc(materia.carga_horaria)}h • ${esc(materia.total_aulas)} aulas</div>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="${materia.horario_matutino ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'} py-1 px-2 rounded-full text-xs font-bold">
                            ${esc(materia.horario_matutino || 'Inativo')}
                        </span>
                    </td>
                     <td class="py-3 px-6 text-center">
                        <span class="${materia.horario_vespertino ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'} py-1 px-2 rounded-full text-xs font-bold">
                            ${esc(materia.horario_vespertino || 'Inativo')}
                        </span>
                    </td>
                     <td class="py-3 px-6 text-center">
                        <span class="${materia.horario_noturno ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'} py-1 px-2 rounded-full text-xs font-bold">
                            ${esc(materia.horario_noturno || 'Inativo')}
                        </span>
                    </td>

                    <td class="py-3 px-6 text-center">
                        <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold">${materia.professores_count ?? 0}</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-purple-100 text-purple-700 py-1 px-3 rounded-full text-xs font-bold">${materia.alunos_count ?? 0}</span>
                    </td>
                </tr>
            `);
        });
    </script>
@endpush
