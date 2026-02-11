@extends('layouts.main')

@section('title', 'Presença Confirmada! - Smart Attendance')

@section('body-class', 'bg-gray-100')

@push('styles')
<style>
    .bg-gradient { background: linear-gradient(135deg, #10b981, #34d399); }
</style>
@endpush

@section('content')
    <div class="flex-grow flex items-center justify-center p-4">

        <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full text-center">
            
            <div class="mb-6 flex justify-center">
                <div class="bg-green-100 p-4 rounded-full">
                    <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-2">Presença Confirmada!</h1>
            <p class="text-gray-500 mb-6">{{ $mensagem ?? 'Sua presença foi registrada com sucesso.' }}</p>

            @if(isset($materia) && isset($presenca))
                <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left border border-gray-200">
                    <p class="text-sm text-gray-500 mb-1">Disciplina</p>
                    <p class="font-bold text-gray-800 text-lg">{{ $materia->nome }}</p>
                    
                    <div class="mt-3 flex justify-between">
                        <div>
                            <p class="text-xs text-gray-500">Data</p>
                            <p class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($presenca->data_aula)->format('d/m/Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Horário</p>
                            <p class="font-medium text-gray-700">{{ $presenca->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <a href="{{ route('dashboard.aluno') }}" class="block w-full bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 transition duration-200">
                Voltar ao Início
            </a>
        </div>

    </div>
@endsection
