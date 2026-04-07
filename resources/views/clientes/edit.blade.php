@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square me-2 text-primary"></i>Editar Cliente</h4>
        <small class="text-muted">Atualize os dados de <strong>{{ $cliente->nome }}</strong></small>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('clientes.update', $cliente) }}">
            @csrf
            @method('PUT')
            @include('clientes._form')
            <hr class="my-4">
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg me-1"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i>Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
