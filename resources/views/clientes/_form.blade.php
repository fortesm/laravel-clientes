{{-- Partial: resources/views/clientes/_form.blade.php --}}
{{-- Uso: @include('clientes._form', ['cliente' => $cliente]) --}}

<div class="row g-3">
    <!-- Nome -->
    <div class="col-md-8">
        <label for="nome" class="form-label fw-semibold">Nome <span class="text-danger">*</span></label>
        <input type="text" id="nome" name="nome"
               class="form-control @error('nome') is-invalid @enderror"
               value="{{ old('nome', $cliente->nome ?? '') }}"
               placeholder="Nome completo do cliente">
        @error('nome')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Telefone -->
    <div class="col-md-4">
        <label for="telefone" class="form-label fw-semibold">Telefone <span class="text-danger">*</span></label>
        <input type="text" id="telefone" name="telefone"
               class="form-control @error('telefone') is-invalid @enderror"
               value="{{ old('telefone', $cliente->telefone ?? '') }}"
               placeholder="(00) 00000-0000" maxlength="20">
        @error('telefone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- E-mail -->
    <div class="col-md-8">
        <label for="email" class="form-label fw-semibold">E-mail <span class="text-danger">*</span></label>
        <input type="email" id="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $cliente->email ?? '') }}"
               placeholder="cliente@email.com">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- CEP -->
    <div class="col-md-4">
        <label for="cep" class="form-label fw-semibold">CEP <span class="text-danger">*</span></label>
        <div class="input-group">
            <input type="text" id="cep" name="cep"
                   class="form-control @error('cep') is-invalid @enderror"
                   value="{{ old('cep', $cliente->cep ?? '') }}"
                   placeholder="00000-000" maxlength="9">
            <button type="button" id="btnBuscarCep" class="btn btn-outline-secondary" title="Buscar CEP">
                <span id="cepSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                <i id="cepIcon" class="bi bi-search"></i>
            </button>
        </div>
        @error('cep')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
        <div id="cepErro" class="text-danger small mt-1 d-none"></div>
    </div>

    <!-- Rua -->
    <div class="col-md-8">
        <label for="rua" class="form-label fw-semibold">Rua <span class="text-danger">*</span></label>
        <input type="text" id="rua" name="rua"
               class="form-control @error('rua') is-invalid @enderror"
               value="{{ old('rua', $cliente->rua ?? '') }}"
               placeholder="Preenchido automaticamente pelo CEP">
        @error('rua')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Bairro -->
    <div class="col-md-4">
        <label for="bairro" class="form-label fw-semibold">Bairro <span class="text-danger">*</span></label>
        <input type="text" id="bairro" name="bairro"
               class="form-control @error('bairro') is-invalid @enderror"
               value="{{ old('bairro', $cliente->bairro ?? '') }}"
               placeholder="Bairro">
        @error('bairro')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Cidade -->
    <div class="col-md-7">
        <label for="cidade" class="form-label fw-semibold">Cidade <span class="text-danger">*</span></label>
        <input type="text" id="cidade" name="cidade"
               class="form-control @error('cidade') is-invalid @enderror"
               value="{{ old('cidade', $cliente->cidade ?? '') }}"
               placeholder="Cidade">
        @error('cidade')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Estado -->
    <div class="col-md-5">
        <label for="estado" class="form-label fw-semibold">Estado (UF) <span class="text-danger">*</span></label>
        <select id="estado" name="estado"
                class="form-select @error('estado') is-invalid @enderror">
            <option value="">Selecione...</option>
            @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                <option value="{{ $uf }}"
                    {{ old('estado', $cliente->estado ?? '') == $uf ? 'selected' : '' }}>
                    {{ $uf }}
                </option>
            @endforeach
        </select>
        @error('estado')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

@push('scripts')
<script>
// Máscara simples de CEP e telefone
document.getElementById('cep').addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '');
    if (v.length > 5) v = v.slice(0,5) + '-' + v.slice(5,8);
    this.value = v;
});

document.getElementById('telefone').addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '');
    if (v.length > 11) v = v.slice(0,11);
    if (v.length > 6) v = '(' + v.slice(0,2) + ') ' + v.slice(2,7) + '-' + v.slice(7);
    else if (v.length > 2) v = '(' + v.slice(0,2) + ') ' + v.slice(2);
    this.value = v;
});

// Busca CEP
async function buscarCep() {
    const cep = document.getElementById('cep').value.replace(/\D/g,'');
    const erroDiv = document.getElementById('cepErro');
    const spinner = document.getElementById('cepSpinner');
    const icon    = document.getElementById('cepIcon');

    erroDiv.classList.add('d-none');

    if (cep.length !== 8) {
        erroDiv.textContent = 'Digite um CEP com 8 dígitos.';
        erroDiv.classList.remove('d-none');
        return;
    }

    spinner.classList.remove('d-none');
    icon.classList.add('d-none');

    try {
        const res = await fetch(`/clientes/cep/${cep}`);
        const data = await res.json();

        if (!res.ok) {
            erroDiv.textContent = data.error || 'CEP não encontrado.';
            erroDiv.classList.remove('d-none');
        } else {
            document.getElementById('rua').value    = data.rua;
            document.getElementById('bairro').value = data.bairro;
            document.getElementById('cidade').value = data.cidade;
            const select = document.getElementById('estado');
            for (let opt of select.options) {
                if (opt.value === data.estado) { opt.selected = true; break; }
            }
        }
    } catch(e) {
        erroDiv.textContent = 'Erro de conexão ao consultar o CEP.';
        erroDiv.classList.remove('d-none');
    } finally {
        spinner.classList.add('d-none');
        icon.classList.remove('d-none');
    }
}

document.getElementById('btnBuscarCep').addEventListener('click', buscarCep);
document.getElementById('cep').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') { e.preventDefault(); buscarCep(); }
});
// Auto-busca quando o campo perde o foco com 9 chars
document.getElementById('cep').addEventListener('blur', function () {
    if (this.value.length === 9) buscarCep();
});
</script>
@endpush
