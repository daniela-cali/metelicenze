<?php $this->extend('layouts/main'); ?>
<?php $this->section('content'); ?>

<header class="bg-light py-5 text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Benvenuto in MeTe Licenze</h1>
        <p class="lead text-muted">Gestisci in modo semplice licenze, versioni e aggiornamenti software</p>
    </div>
</header>

<main class="container my-5">
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">

        <!-- Clienti -->
        <div class="col">
            <div class="card h-100 text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-people-fill display-4 text-success"></i>
                    <h5 class="card-title mt-3">Clienti</h5>
                    <p class="card-text text-muted">Visualizza e gestisci l’elenco dei clienti.</p>
                    <a href="<?= base_url('clienti') ?>" class="btn btn-success">Vai ai clienti</a>
                </div>
            </div>
        </div>

        <!-- Licenze -->
        <div class="col">
            <div class="card h-100 text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-key-fill display-4 text-primary"></i>
                    <h5 class="card-title mt-3">Licenze</h5>
                    <p class="card-text text-muted">Visualizza, crea e gestisci le licenze dei clienti.</p>
                    <a href="<?= base_url('licenze') ?>" class="btn btn-primary">Vai alle licenze</a>
                </div>
            </div>
        </div>

        <!-- Versioni -->
        <div class="col">
            <div class="card h-100 text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-tags-fill display-4 text-secondary"></i>
                    <h5 class="card-title mt-3">Versioni</h5>
                    <p class="card-text text-muted">Consulta le versioni disponibili del software.</p>
                    <a href="<?= base_url('versioni') ?>" class="btn btn-secondary">Vai alle versioni</a>
                </div>
            </div>
        </div>

        <!-- Aggiornamenti -->
        <div class="col">
            <div class="card h-100 text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-arrow-repeat display-4 text-warning"></i>
                    <h5 class="card-title mt-3">Aggiornamenti</h5>
                    <p class="card-text text-muted">Gestisci e visualizza gli aggiornamenti disponibili.</p>
                    <a href="<?= base_url('aggiornamenti') ?>" class="btn btn-warning">Vai agli aggiornamenti</a>
                </div>
            </div>
        </div>
    </div>


</main>

<?php $this->endSection(); ?>