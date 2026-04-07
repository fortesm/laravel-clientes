@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0"><i class="bi bi-person-plus me-2 text-primary"></i>Novo Cliente</h4>
        <small class="text-muted">Preencha os dados abaixo para cadastrar um novo cliente</small>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('clientes.store') }}">
            @csrf
            @include('clientes._form')
            <hr class="my-4">
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg me-1"></i>Cancelar
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-1"></i>Salvar Cliente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
