@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h4 class="fw-bold mb-0"><i class="bi bi-person-vcard me-2 text-primary"></i>Dados do Cliente</h4>
        <small class="text-muted">Visualização completa do cadastro</small>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">
        <div class="row g-4">

            <!-- Identificação -->
            <div class="col-12">
                <h6 class="text-muted text-uppercase small fw-bold mb-3 border-bottom pb-2">
                    <i class="bi bi-person me-1"></i>Identificação
                </h6>
                <div class="row g-3">
                    <div class="col-md-8">
                        <p class="mb-1 text-muted small">Nome</p>
                        <p class="fw-semibold mb-0 fs-5">{{ $cliente->nome }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 text-muted small">Telefone</p>
                        <p class="fw-semibold mb-0">
                            <i class="bi bi-telephone me-1 text-primary"></i>{{ $cliente->telefone }}
                        </p>
                    </div>
                    <div class="col-md-8">
                        <p class="mb-1 text-muted small">E-mail</p>
                        <p class="fw-semibold mb-0">
                            <i class="bi bi-envelope me-1 text-primary"></i>
                            <a href="mailto:{{ $cliente->email }}" class="text-decoration-none">
                                {{ $cliente->email }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Endereço -->
            <div class="col-12">
                <h6 class="text-muted text-uppercase small fw-bold mb-3 border-bottom pb-2">
                    <i class="bi bi-geo-alt me-1"></i>Endereço
                </h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <p class="mb-1 text-muted small">CEP</p>
                        <p class="fw-semibold mb-0">{{ $cliente->cep }}</p>
                    </div>
                    <div class="col-md-9">
                        <p class="mb-1 text-muted small">Rua</p>
                        <p class="fw-semibold mb-0">{{ $cliente->rua }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 text-muted small">Bairro</p>
                        <p class="fw-semibold mb-0">{{ $cliente->bairro }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted small">Cidade</p>
                        <p class="fw-semibold mb-0">{{ $cliente->cidade }}</p>
                    </div>
                    <div class="col-md-2">
                        <p class="mb-1 text-muted small">UF</p>
                        <p class="fw-semibold mb-0">
                            <span class="badge bg-primary">{{ $cliente->estado }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Meta -->
            <div class="col-12">
                <p class="text-muted small mb-0">
                    <i class="bi bi-clock me-1"></i>
                    Cadastrado em {{ $cliente->created_at->format('d/m/Y \à\s H:i') }}
                    @if($cliente->updated_at != $cliente->created_at)
                        &nbsp;·&nbsp; Atualizado em {{ $cliente->updated_at->format('d/m/Y \à\s H:i') }}
                    @endif
                </p>
            </div>
        </div>

        <hr class="my-4">
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-list me-1"></i>Voltar à lista
            </a>
            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i>Editar
            </a>
        </div>
    </div>
</div>
@endsection
