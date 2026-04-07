<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Cadastro de Clientes')); ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body { background-color: #f0f2f5; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }
        .sidebar { min-height: calc(100vh - 56px); background: #fff; border-right: 1px solid #dee2e6; }
        .sidebar .nav-link { color: #495057; border-radius: 6px; margin-bottom: 2px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #e9ecef; color: #0d6efd; }
        .sidebar .nav-link i { width: 20px; }
        .card { border: none; box-shadow: 0 1px 4px rgba(0,0,0,.08); border-radius: 10px; }
        .table thead th { background: #f8f9fa; font-size: .85rem; text-transform: uppercase; letter-spacing: .5px; }
        .badge-estado { font-size: .75rem; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="<?php echo e(route('clientes.index')); ?>">
            <i class="bi bi-people-fill me-2"></i>ClientesCRM
        </a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-white-50 small">
                <i class="bi bi-person-circle me-1"></i><?php echo e(auth()->user()->name); ?>

            </span>
            <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-box-arrow-right me-1"></i>Sair
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Main Layout -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar py-4 px-3 d-none d-md-block">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('clientes.index') ? 'active' : ''); ?>"
                       href="<?php echo e(route('clientes.index')); ?>">
                        <i class="bi bi-list-ul me-2"></i>Clientes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->routeIs('clientes.create') ? 'active' : ''); ?>"
                       href="<?php echo e(route('clientes.create')); ?>">
                        <i class="bi bi-person-plus me-2"></i>Novo Cliente
                    </a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div class="col-md-10 py-4 px-4">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /var/www/resources/views/layouts/app.blade.php ENDPATH**/ ?>