<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeTe Licenze</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>">MeTe Licenze</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('licenze') ?>">Licenze</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('versioni') ?>">Versioni</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('aggiornamenti') ?>">Aggiornamenti</a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <?php if (function_exists('auth') && auth()->loggedIn()): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('logout') ?>">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('login') ?>">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('register') ?>">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<header class="bg-light py-5 text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Benvenuto in MeTe Licenze</h1>
        <p class="lead text-muted">Gestisci in modo semplice licenze, versioni e aggiornamenti software</p>
    </div>
</header>

<main class="container my-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-key-fill display-4 text-primary"></i>
                    <h5 class="card-title mt-3">Licenze</h5>
                    <p class="card-text text-muted">Visualizza, crea e gestisci le licenze dei clienti.</p>
                    <a href="<?= base_url('licenze') ?>" class="btn btn-primary">Vai alle licenze</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-code-slash display-4 text-success"></i>
                    <h5 class="card-title mt-3">Versioni</h5>
                    <p class="card-text text-muted">Monitora le versioni dei tuoi prodotti software.</p>
                    <a href="<?= base_url('versioni') ?>" class="btn btn-success">Vai alle versioni</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-arrow-repeat display-4 text-warning"></i>
                    <h5 class="card-title mt-3">Aggiornamenti</h5>
                    <p class="card-text text-muted">Tieni traccia degli aggiornamenti rilasciati.</p>
                    <a href="<?= base_url('aggiornamenti') ?>" class="btn btn-warning text-white">Vai agli aggiornamenti</a>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="bg-dark text-light py-3 text-center mt-5">
    <small>&copy; <?= date('Y') ?> MeTe Licenze - Tutti i diritti riservati</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
