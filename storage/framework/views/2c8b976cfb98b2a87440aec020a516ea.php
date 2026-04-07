<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0"><i class="bi bi-people me-2 text-primary"></i>Clientes</h4>
        <small class="text-muted">Total: <?php echo e($clientes->total()); ?> registro(s)</small>
    </div>
    <a href="<?php echo e(route('clientes.create')); ?>" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i>Novo Cliente
    </a>
</div>

<!-- Busca -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="<?php echo e(route('clientes.index')); ?>" class="d-flex gap-2">
            <input type="text" name="busca" value="<?php echo e($busca); ?>"
                   class="form-control" placeholder="Buscar por nome, e-mail ou cidade...">
            <button type="submit" class="btn btn-outline-primary px-4">
                <i class="bi bi-search"></i>
            </button>
            <?php if($busca): ?>
                <a href="<?php echo e(route('clientes.index')); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Tabela -->
<div class="card">
    <div class="card-body p-0">
        <?php if($clientes->isEmpty()): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox display-4 d-block mb-3"></i>
                <p>Nenhum cliente encontrado.</p>
                <a href="<?php echo e(route('clientes.create')); ?>" class="btn btn-primary btn-sm">Cadastrar primeiro cliente</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Nome</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Cidade / UF</th>
                            <th class="text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="ps-4 fw-semibold"><?php echo e($cliente->nome); ?></td>
                                <td class="text-muted"><?php echo e($cliente->email); ?></td>
                                <td><?php echo e($cliente->telefone); ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border badge-estado">
                                        <?php echo e($cliente->cidade); ?> – <?php echo e($cliente->estado); ?>

                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="<?php echo e(route('clientes.show', $cliente)); ?>"
                                       class="btn btn-sm btn-outline-secondary me-1" title="Visualizar">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('clientes.edit', $cliente)); ?>"
                                       class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Excluir"
                                            onclick="confirmarExclusao(<?php echo e($cliente->id); ?>, '<?php echo e($cliente->nome); ?>')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <form id="delete-<?php echo e($cliente->id); ?>"
                                          action="<?php echo e(route('clientes.destroy', $cliente)); ?>"
                                          method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Exibindo <?php echo e($clientes->firstItem()); ?>–<?php echo e($clientes->lastItem()); ?>

                    de <?php echo e($clientes->total()); ?> resultados
                </small>
                <?php echo e($clientes->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal de confirmação -->
<div class="modal fade" id="modalExclusao" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Confirmar exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o cliente <strong id="nomeCliente"></strong>?</p>
                <p class="text-danger small"><i class="bi bi-exclamation-triangle me-1"></i>Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarExclusao">
                    <i class="bi bi-trash me-1"></i>Excluir
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let formIdParaExcluir = null;

function confirmarExclusao(id, nome) {
    formIdParaExcluir = id;
    document.getElementById('nomeCliente').textContent = nome;
    new bootstrap.Modal(document.getElementById('modalExclusao')).show();
}

document.getElementById('btnConfirmarExclusao').addEventListener('click', function () {
    if (formIdParaExcluir) {
        document.getElementById('delete-' + formIdParaExcluir).submit();
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/resources/views/clientes/index.blade.php ENDPATH**/ ?>