@extends('layouts.main')

@section('title', 'Erro na confirmação - Smart Attendance')

@section('body-class', 'bg-gray-100')

@section('content')
    <div class="flex-grow flex items-center justify-center p-4">

        <div class="bg-white p-8 rounded-2xl shadow-xl max-w-md w-full text-center">
            
            <div class="mb-6 flex justify-center">
                <div class="bg-red-100 p-4 rounded-full">
                    <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mb-2">Ops! Algo deu errado</h1>
            <p class="text-red-500 font-medium mb-6">{{ $mensagem ?? 'Ocorreu um erro ao confirmar sua presença.' }}</p>

            <div class="flex flex-col gap-4">
                 <a href="{{ route('dashboard.aluno') }}" class="block w-full bg-gray-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-gray-700 transition duration-200">
                    Voltar à Página Principal
                </a>
            </div>
        </div>

    </div>
@endsection
