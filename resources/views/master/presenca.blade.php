@extends('layouts.main')

@section('title', 'Gerenciar Presenças - Master')

@section('body-class', 'bg-gray-50 text-gray-800')

@push('styles')
<style>
    @media print {
        @page { 
            size: A4 landscape; 
            margin: 10mm; 
        }
        body { 
            margin: 0; 
            padding: 0;
            -webkit-print-color-adjust: exact !important; 
            print-color-adjust: exact !important;
        }
        body * { visibility: hidden; }
        #printable-content, #printable-content * { visibility: visible; }
        
        #printable-content { 
            position: absolute; 
            left: 0; 
            top: 0; 
            width: 100%; 
            margin: 0;
            padding: 0;
        }
        
        .no-print { display: none !important; }
        
        /* Tabela Ocupando tudo */
        table { 
            width: 100% !important; 
            table-layout: fixed !important; /* Força obediência às larguras */
            border-collapse: collapse !important;
            font-size: 11px !important; /* Fonte levemente menor para caber bem */
        }
        
        th, td {
            border-bottom: 1px solid #ddd !important;
            padding: 8px 4px !important;
            word-wrap: break-word !important; /* Quebra texto longo */
        }

        /* Estilização específica para impressão */
        .card-shadow { box-shadow: none !important; border: none !important; }
        .text-center { text-align: center !important; }
        
        /* Rodapé fixo em todas as páginas */
        .print-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            background-color: white;
            padding: 10px 0;
            border-top: 1px solid #e5e7eb;
        }

        /* Espaço para não cobrir o conteúdo */
        #printable-content { 
            margin-bottom: 50px; 
        }
    }
</style>
@endpush

@section('content')
    {{-- ... (Navbar e Filtros mantidos) ... --}}
    <div class="no-print">
        {{-- Navbar e Forms --}}
        <nav class="bg-gradient-to-r from-orange-600 to-red-600 text-white shadow-lg mb-8">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                 <div class="flex items-center space-x-3">
                     <a href="{{ route('dashboard.master') }}" class="text-2xl hover:scale-110 transition-transform">🛡️</a>
                    <div>
                        <h1 class="text-xl font-bold tracking-wide">Painel de Chamadas</h1>
                        <a href="{{ route('dashboard.master') }}" class="text-xs text-white/70 hover:text-white underline">Voltar ao Painel Master</a>
                    </div>
                </div>
            </div>
        </nav>
    
        <div class="container mx-auto px-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <form action="{{ route('master.presenca') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    {{-- Inputs do form mantidos --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Professor</label>
                        <input type="text" name="professor" value="{{ request('professor') }}" placeholder="Nome..." class="w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 shadow-sm p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Matéria</label>
                        <input type="text" name="materia" value="{{ request('materia') }}" placeholder="Nome..." class="w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 shadow-sm p-2 border">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Aluno</label>
                        <input type="text" name="aluno" value="{{ request('aluno') }}" placeholder="Nome..." class="w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 shadow-sm p-2 border">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg flex-1 transition shadow">Filtrar</button>
                        <a href="{{ route('master.presenca') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-3 rounded-lg transition" title="Limpar">✖</a>
                        <button type="button" onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex-1 transition shadow flex items-center justify-center gap-2">
                            PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="printable-content" class="w-full px-4 pb-12">
        {{-- Título PDF --}}
        <div class="hidden print:block text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 uppercase tracking-wider">Gerenciar Presenças - Master</h1>
            <p class="text-sm text-gray-500 mt-1">Relatório Oficial de Acompanhamento</p>
        </div>

        <div class="bg-white rounded-2xl print:shadow-none shadow-xl overflow-hidden border border-gray-200 card-shadow">
           {{-- Tabela mantida (conteúdo igual ao anterior) --}}
           {{-- ... --}}
           <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center no-print">
                <h2 class="text-lg font-bold text-gray-800">Relatório de Presenças</h2>
                <span class="text-sm text-gray-500">Total: {{ $presencas->total() }} registros</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-xs font-bold tracking-wider border-b-2 border-gray-300">
                            <th class="py-3 px-2" style="width: 15%;">Data / Hora</th>
                            <th class="py-3 px-2" style="width: 25%;">Aluno (RA)</th>
                            <th class="py-3 px-2" style="width: 20%;">Matéria</th>
                            <th class="py-3 px-2" style="width: 20%;">Professor (CPF)</th>
                            <th class="py-3 px-2 text-center" style="width: 10%;">Faltas</th>
                            <th class="py-3 px-2 text-center" style="width: 10%;">Média</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @forelse($presencas as $p)
                        {{-- Logica PHP mantida --}}
                        @php
                            $materiaPivot = $p->aluno->materias->where('id', $p->materia_id)->first()->pivot ?? null;
                            $media = null;
                            if($materiaPivot) {
                                $notas = collect([$materiaPivot->prova1, $materiaPivot->prova2, $materiaPivot->trabalho1, $materiaPivot->trabalho2])
                                    ->filter(fn($n) => !is_null($n));
                                if($notas->isNotEmpty()) {
                                    $media = round($notas->avg(), 1);
                                }
                            }

                            $totalAulas = $p->materia->total_aulas ?? 0;
                            $presencasAluno = \App\Models\Presenca::where('materia_id', $p->materia_id)
                                ->where('aluno_ra', $p->aluno_ra)
                                ->count();
                            $faltas = max(0, $totalAulas - $presencasAluno);
                            
                            $corMedia = 'text-gray-400';
                            if($media !== null) {
                                $corMedia = $media >= 6 ? 'text-green-600 font-bold' : 'text-red-600 font-bold';
                            }
                        @endphp

                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition print:border-gray-300">
                            <td class="py-3 px-2 whitespace-nowrap">
                                <span class="block font-bold text-gray-800">{{ \Carbon\Carbon::parse($p->data_aula)->format('d/m/Y') }}</span>
                                <span class="block text-xs text-gray-500">{{ $p->created_at->format('H:i') }}</span>
                            </td>
                            <td class="py-3 px-2">
                                <span class="block font-medium text-gray-800">{{ $p->aluno->nome ?? 'N/A' }}</span>
                                <span class="block text-xs text-gray-500 font-mono">{{ $p->aluno_ra }}</span>
                            </td>
                            <td class="py-3 px-2">
                                <span class="block font-medium text-gray-800">{{ $p->materia->nome ?? 'N/A' }}</span>
                            </td>
                            <td class="py-3 px-2">
                                <span class="block text-gray-800">{{ $p->professor->nome ?? 'N/A' }}</span>
                                <span class="block text-xs text-gray-500 font-mono">{{ $p->professor_cpf }}</span>
                            </td>
                            
                            <td class="py-3 px-2 text-center align-middle">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="{{ $faltas > 0 ? 'text-red-600 font-bold' : 'text-green-600' }} text-lg">
                                        {{ $faltas }}
                                    </span>
                                    <span class="text-[10px] text-gray-400">de {{ $totalAulas }}</span>
                                </div>
                            </td>

                            <td class="py-3 px-2 text-center align-middle">
                                <span class="{{ $corMedia }} text-lg block">
                                    {{ $media !== null ? number_format($media, 1) : '--' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-400 italic">Nenhum registro encontrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 no-print">
                {{ $presencas->withQueryString()->links() }}
            </div>
        </div>
        
        {{-- Rodapé Fixo nas Impressões --}}
        <div class="print-footer hidden print:block">
            <div class="flex flex-col items-center justify-center space-y-1">
                <span class="text-xs">Gerado em {{ now()->format('d/m/Y H:i:s') }} por {{ Auth::guard('masters')->user()->nome ?? 'Master' }}</span>
                <span class="text-[10px] uppercase font-bold text-gray-400">© {{ date('Y') }} Smart Attendance. Todos os direitos reservados.</span>
            </div>
        </div>
    </div>
@endsection
