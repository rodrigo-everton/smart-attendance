@extends('layouts.main')

@section('title', 'Gerando Frequência - ' . $materia->nome)

@section('body-class', 'bg-gray-100 text-gray-800')

@push('styles')
<style>
    .header-bg { background: linear-gradient(135deg, #4c1d95, #c026d3); }
    .card-shadow { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
    @keyframes pulse-ring {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
    .timer-pulse { animation: pulse-ring 2s infinite; }
</style>
@endpush


@section('content')
    <header class="header-bg text-white p-4 shadow-lg">
        <div class="max-w-7xl mx-auto flex flex-col gap-2">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">{{ $materia->nome }} - Frequência</h1>
                <div class="flex items-center gap-3">
                    {{-- Timer --}}
                    <div id="timer-container" class="flex items-center gap-2 bg-white/20 backdrop-blur-sm py-2 px-4 rounded-full">
                        <div class="w-3 h-3 bg-green-400 rounded-full timer-pulse" id="timer-dot"></div>
                        <span id="timer-text" class="text-sm font-bold tracking-wider">--:--:--</span>
                    </div>
                    <span class="text-xs font-light hidden md:inline">Código: {{ $codigo_aula }}</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('professor.presenca.index') }}" 
                   class="bg-white text-dark_purple hover:bg-gray-200 py-1 px-3 rounded-full text-sm font-semibold transition duration-200">
                    ← Disciplinas
                </a>
                <a href="{{ route('dashboard.professor') }}" 
                   class="bg-white/20 text-white hover:bg-white/30 py-1 px-3 rounded-full text-sm font-semibold transition duration-200 border border-white/40">
                    🏠 Dashboard
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-6 mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Coluna Esquerda: QR Code --}}
        <div class="bg-white p-8 rounded-lg card-shadow flex flex-col items-center justify-center text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Escanear para Confirmar Presença</h2>
            
            <div id="qrcode" class="border-4 border-purple-700 p-2 rounded-lg bg-white mb-4"></div>

            {{-- Timer grande abaixo do QR --}}
            <div id="timer-big" class="mb-4 text-center">
                <p class="text-xs uppercase tracking-wider text-gray-400 font-bold">Tempo Restante</p>
                <p id="timer-big-text" class="text-4xl font-extrabold text-gray-800 tabular-nums">--:--:--</p>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div id="timer-bar" class="bg-green-500 h-2 rounded-full transition-all duration-1000" style="width: 100%;"></div>
                </div>
            </div>

            <p class="text-gray-500 mb-2 text-sm">Aponte a câmera do celular para o código acima.</p>
            <p class="text-xs text-gray-400">Ou acesse: <a href="{{ route('presenca.confirmar', $codigo_aula) }}" class="underline text-blue-500">{{ route('presenca.confirmar', $codigo_aula) }}</a></p>
            
            <div class="mt-6 p-4 bg-gray-50 rounded-lg text-left w-full border border-gray-100">
                <h3 class="font-bold text-gray-700 mb-2 text-sm uppercase tracking-wider">Dados da Aula</h3>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <p><strong class="text-gray-500">Matéria:</strong> {{ $materia->nome }}</p>
                    <p><strong class="text-gray-500">Semestre:</strong> {{ $semestre }}</p>
                    <p><strong class="text-gray-500">Horário:</strong> {{ $horario == 'M' ? 'Matutino' : ($horario == 'V' ? 'Vespertino' : 'Noturno') }}</p>
                    <p><strong class="text-gray-500">Data:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Coluna Direita: Lista de Presença em Tempo Real --}}
        <div class="bg-white p-6 rounded-lg card-shadow">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Alunos Presentes</h2>
                <span id="contador-alunos" class="bg-purple-600 text-white py-1 px-3 rounded-full text-sm font-bold">0</span>
            </div>

            <div class="overflow-y-auto max-h-[600px]">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-sm uppercase tracking-wider">
                            <th class="p-3 border-b">Nome</th>
                            <th class="p-3 border-b">RA</th>
                            <th class="p-3 border-b">Horário</th>
                            <th class="p-3 border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody id="lista-presenca" class="text-gray-700">
                        <tr id="empty-state">
                            <td colspan="4" class="p-4 text-center text-gray-400">Aguardando leituras...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    {{-- QR Expirado Overlay --}}
    <div id="expired-overlay" class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 text-center shadow-2xl">
            <div class="text-6xl mb-4">⏰</div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">QR Code Expirado!</h2>
            <p class="text-gray-500 mb-6">O tempo de validade deste código encerrou. Gere um novo código para a próxima chamada.</p>
            <a href="{{ route('professor.presenca.index') }}" 
               class="block w-full bg-purple-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-purple-800 transition">
                Voltar às Disciplinas
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        // Gerar QR Code
        const qrContent = "{{ route('presenca.confirmar', $codigo_aula) }}";
        new QRCode(document.getElementById("qrcode"), {
            text: qrContent,
            width: 256,
            height: 256,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });

        // ========== TIMER ==========
        const expiraEm = {{ $expiraEmTimestamp }}; // Timestamp UNIX em segundos
        const timerText = document.getElementById('timer-text');
        const timerBigText = document.getElementById('timer-big-text');
        const timerBar = document.getElementById('timer-bar');
        const timerDot = document.getElementById('timer-dot');
        const expiredOverlay = document.getElementById('expired-overlay');

        // Calcula duração total para a barra de progresso (2 horas = 7200s)
        const duracaoTotal = 2 * 60 * 60; // 2 horas em segundos

        function atualizarTimer() {
            const agora = Math.floor(Date.now() / 1000);
            const restante = expiraEm - agora;

            if (restante <= 0) {
                timerText.textContent = 'EXPIRADO';
                timerBigText.textContent = '00:00:00';
                timerBar.style.width = '0%';
                timerBar.classList.replace('bg-green-500', 'bg-red-500');
                timerDot.classList.replace('bg-green-400', 'bg-red-400');
                expiredOverlay.classList.remove('hidden');
                return;
            }

            const horas = Math.floor(restante / 3600);
            const minutos = Math.floor((restante % 3600) / 60);
            const segundos = restante % 60;
            const formatted = `${String(horas).padStart(2, '0')}:${String(minutos).padStart(2, '0')}:${String(segundos).padStart(2, '0')}`;

            timerText.textContent = formatted;
            timerBigText.textContent = formatted;

            // Barra de progresso
            const progresso = Math.max(0, (restante / duracaoTotal) * 100);
            timerBar.style.width = progresso + '%';

            // Muda cor quando falta pouco tempo (< 10 min)
            if (restante < 600) {
                timerBar.classList.replace('bg-green-500', 'bg-yellow-500');
                timerDot.classList.replace('bg-green-400', 'bg-yellow-400');
                timerBigText.classList.add('text-yellow-600');
            }
            if (restante < 120) {
                timerBar.classList.replace('bg-yellow-500', 'bg-red-500');
                timerDot.classList.replace('bg-yellow-400', 'bg-red-400');
                timerBigText.classList.remove('text-yellow-600');
                timerBigText.classList.add('text-red-600');
            }
        }

        // Atualiza timer a cada segundo
        setInterval(atualizarTimer, 1000);
        atualizarTimer();

        // ========== POLLING PRESENÇA ==========
        const tabelaBody = document.getElementById('lista-presenca');
        const contador = document.getElementById('contador-alunos');
        const emptyState = document.getElementById('empty-state');
        const checkUrl = "{{ route('professor.presenca.check', $codigo_aula) }}";

        function atualizarPresencas() {
            fetch(checkUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        if (emptyState) emptyState.style.display = 'none';
                        
                        tabelaBody.innerHTML = '';
                        
                        data.forEach(presenca => {
                            const row = document.createElement('tr');
                            row.className = "border-b hover:bg-gray-50 transition";
                            
                            const dataHora = new Date(presenca.created_at);
                            const horaFormatada = dataHora.toLocaleTimeString('pt-BR');

                            row.innerHTML = `
                                <td class="p-3 font-medium text-gray-800">${presenca.aluno ? presenca.aluno.nome : 'Desconhecido'}</td>
                                <td class="p-3 text-sm text-gray-500">${presenca.aluno_ra}</td>
                                <td class="p-3 text-sm text-gray-500">${horaFormatada}</td>
                                <td class="p-3"><span class="bg-green-100 text-green-700 py-1 px-2 rounded-full text-xs font-bold">Confirmado</span></td>
                            `;
                            tabelaBody.appendChild(row);
                        });

                        contador.innerText = data.length;
                    }
                })
                .catch(error => console.error('Erro ao buscar presenças:', error));
        }

        setInterval(atualizarPresencas, 3000);
        atualizarPresencas();
    </script>
@endpush
