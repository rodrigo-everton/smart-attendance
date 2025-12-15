@extends('layouts.main')

@section('title', 'Painel Administrativo Master - Smart Attendance')

@section('body-class', 'bg-gray-50 text-gray-800')

@push('styles')
<style>
    .gradient-bg { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); }
    .table-header { background-color: #1e3a8a; color: white; }
    .t-row:nth-child(even) { background-color: #f3f4f6; }
</style>
@endpush

@push('scripts')
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1e3a8a',
                        secondary: '#4f46e5',
                        accent: '#c026d3',
                    },
                }
            }
        }
    </script>
@endpush

@section('content')
    <!-- Navbar -->
    <nav class="bg-primary text-white shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">🛡️</span>
                <span class="text-xl font-bold tracking-wide">Painel Master</span>
            </div>
            
            <div class="flex items-center gap-4">
                <span class="text-sm opacity-90 hidden sm:block">Olá, {{ $master->nome ?? 'Administrador' }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition shadow-md">
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-6 py-10">

        <!-- Header Section -->
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-3xl font-extrabold text-primary mb-2">Visão Geral do Sistema</h1>
            <p class="text-gray-500">Gerencie todos os usuários cadastrados na plataforma.</p>
        </div>

    <!-- Professores Section -->
        <div class="mb-12 bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-blue-800 to-blue-600 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    👨‍🏫 Professores Cadastrados
                </h2>
                <div class="flex items-center gap-4">
                    <input type="text" id="search-professores" placeholder="Pesquisar Professor..." 
                        class="px-3 py-1 rounded text-black text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-full">{{ $professoresCount }} Total</span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Nome</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-center">Matérias</th>
                            <th class="py-3 px-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="professores-body" class="text-gray-600 text-sm font-light">
                        @foreach($professores as $prof)
                        <tr onclick='openModal("professor", @json($prof))' class="cursor-pointer border-b border-gray-200 hover:bg-gray-100 transition t-row">
                            <td class="py-3 px-6 text-left whitespace-nowrap font-medium text-gray-800">{{ $prof->nome }}</td>
                            <td class="py-3 px-6 text-left">{{ $prof->email }}</td>
                            <td class="py-3 px-6 text-center">
                                <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold">{{ $prof->materias_count }}</span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs font-bold">Ativo</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="professores-empty" class="p-6 text-center text-gray-400 {{ $professores->isEmpty() ? '' : 'hidden' }}">Nenhum professor encontrado.</div>
            </div>
        </div>

        <!-- Alunos Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 mb-12">
            <div class="bg-gradient-to-r from-purple-800 to-purple-600 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    🧑‍🎓 Alunos Cadastrados
                </h2>
                <div class="flex items-center gap-4">
                    <input type="text" id="search-alunos" placeholder="Pesquisar Aluno..." 
                        class="px-3 py-1 rounded text-black text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
                    <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-full">{{ $alunosCount }} Total</span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Nome</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-left">RA</th>
                            <th class="py-3 px-6 text-center">Matérias</th>
                        </tr>
                    </thead>
                    <tbody id="alunos-body" class="text-gray-600 text-sm font-light">
                        @foreach($alunos as $aluno)
                        <tr onclick='openModal("aluno", @json($aluno))' class="cursor-pointer border-b border-gray-200 hover:bg-gray-100 transition t-row">
                            <td class="py-3 px-6 text-left whitespace-nowrap font-medium text-gray-800">{{ $aluno->nome }}</td>
                            <td class="py-3 px-6 text-left">{{ $aluno->email }}</td>
                            <td class="py-3 px-6 text-left font-mono text-purple-600">{{ $aluno->ra }}</td>
                            <td class="py-3 px-6 text-center">
                                <span class="bg-purple-100 text-purple-700 py-1 px-3 rounded-full text-xs font-bold">{{ $aluno->materias_count }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="alunos-empty" class="p-6 text-center text-gray-400 {{ $alunos->isEmpty() ? '' : 'hidden' }}">Nenhum aluno encontrado.</div>
            </div>
        </div>

        <!-- Matérias Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-teal-700 to-teal-500 px-6 py-4 flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    📚 Matérias Cadastradas
                </h2>
                <div class="flex items-center gap-4">
                    <input type="text" id="search-materias" placeholder="Pesquisar Matéria..." 
                        class="px-3 py-1 rounded text-black text-sm focus:outline-none focus:ring-2 focus:ring-teal-300">
                    <span class="bg-white/20 text-white text-xs px-2 py-1 rounded-full">{{ $materiasCount }} Total</span>
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
                <div id="materias-empty" class="p-6 text-center text-gray-400 {{ $materias->isEmpty() ? '' : 'hidden' }}">Nenhuma matéria encontrada.</div>
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

                <div class="mt-8 flex justify-end">
                    <button onclick="closeModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-5 py-2 rounded-lg font-medium transition">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/dashboard_modal.js') }}"></script>
    <script>
        // Search Logic
        document.addEventListener('DOMContentLoaded', () => {
            const setupSearch = (inputId, url, tbodyId, emptyId, renderRow) => {
                const input = document.getElementById(inputId);
                const tbody = document.getElementById(tbodyId);
                const emptyMsg = document.getElementById(emptyId);

                input.addEventListener('input', async (e) => {
                    const query = e.target.value;
                    try {
                        const response = await fetch(`${url}?q=${query}`);
                        const data = await response.json();

                        tbody.innerHTML = '';
                        if (data.length === 0) {
                            emptyMsg.classList.remove('hidden');
                        } else {
                            emptyMsg.classList.add('hidden');
                            data.forEach(item => {
                                // Escape JSON for HTML attribute
                                const jsonItem = JSON.stringify(item).replace(/"/g, '&quot;');
                                tbody.innerHTML += renderRow(item, jsonItem);
                            });
                        }
                    } catch (error) {
                        console.error('Erro na pesquisa:', error);
                    }
                });
            };

            // Search Professores
            setupSearch('search-professores', '{{ route("master.search.professores") }}', 'professores-body', 'professores-empty', (prof, jsonItem) => `
                <tr onclick='openModal("professor", ${jsonItem})' class="cursor-pointer border-b border-gray-200 hover:bg-gray-100 transition t-row">
                    <td class="py-3 px-6 text-left whitespace-nowrap font-medium text-gray-800">${prof.nome}</td>
                    <td class="py-3 px-6 text-left">${prof.email}</td>
                     <td class="py-3 px-6 text-center">
                        <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold">${prof.materias.length}</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs font-bold">Ativo</span>
                    </td>
                </tr>
            `);

            // Search Alunos
            setupSearch('search-alunos', '{{ route("master.search.alunos") }}', 'alunos-body', 'alunos-empty', (aluno, jsonItem) => `
                <tr onclick='openModal("aluno", ${jsonItem})' class="cursor-pointer border-b border-gray-200 hover:bg-gray-100 transition t-row">
                    <td class="py-3 px-6 text-left whitespace-nowrap font-medium text-gray-800">${aluno.nome}</td>
                    <td class="py-3 px-6 text-left">${aluno.email}</td>
                    <td class="py-3 px-6 text-left font-mono text-purple-600">${aluno.ra}</td>
                     <td class="py-3 px-6 text-center">
                        <span class="bg-purple-100 text-purple-700 py-1 px-3 rounded-full text-xs font-bold">${aluno.materias.length}</span>
                    </td>
                </tr>
            `);

            // Search Materias
            setupSearch('search-materias', '{{ route("master.search.materias") }}', 'materias-body', 'materias-empty', (materia, jsonItem) => `
                <tr onclick='openModal("materia", ${jsonItem})' class="cursor-pointer border-b border-gray-200 hover:bg-gray-100 transition t-row">
                    <td class="py-3 px-6 text-left whitespace-nowrap font-medium text-gray-800">
                        ${materia.nome}
                        <div class="text-xs text-gray-400 font-mono">${materia.sala}</div>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="${materia.horario_matutino ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'} py-1 px-2 rounded-full text-xs font-bold">
                            ${materia.horario_matutino ? 'Ativo' : 'Inativo'}
                        </span>
                    </td>
                     <td class="py-3 px-6 text-center">
                        <span class="${materia.horario_vespertino ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'} py-1 px-2 rounded-full text-xs font-bold">
                            ${materia.horario_vespertino ? 'Ativo' : 'Inativo'}
                        </span>
                    </td>
                     <td class="py-3 px-6 text-center">
                        <span class="${materia.horario_noturno ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'} py-1 px-2 rounded-full text-xs font-bold">
                            ${materia.horario_noturno ? 'Ativo' : 'Inativo'}
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
