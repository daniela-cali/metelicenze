<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

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

<?php $this->endSection(); ?>
