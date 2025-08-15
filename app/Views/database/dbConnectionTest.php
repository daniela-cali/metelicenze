<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>

<div class="container my-5">
    <div class="main-container p-4">

        <!-- Header -->
        <div class="header-section text-center mb-5">
            <h1 class="display-5 mb-2">
                <i class="bi bi-check-circle"></i> Test Connessioni
            </h1>
            <p class="lead mb-0">MeTe Licenze - Verifica Connessione ai Database</p>
        </div>

        <div class="row g-4">
            <!-- Database 1 Card -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-header">
                        <i class="bi bi-database-check"></i> Connessione a MySQLi
                    </div>
                    <div class="card-body">
                        <div class="mb-2"><span class="text-muted">Nome DB:</span> <code class="ms-2"><?= esc($db1->db_name) ?></code></div>
                        <div class="mb-2"><span class="text-muted">Connection Group:</span> <code class="ms-2"><?= esc($db1_connection_group) ?></code></div>
                        <div class="mb-2"><span class="text-muted">Encoding:</span> <span class="badge bg-success"><?= esc($db1->encoding) ?></span></div>
                        <div class="mb-2"><span class="text-muted">Collation:</span> <code class="ms-2"><?= esc($db1->collation) ?></code></div>
                        <div class="mb-2"><span class="text-muted">CType:</span> <code class="ms-2"><?= esc($db1->ctype) ?></code></div>
                        <div class="mb-3"><span class="text-muted">Driver:</span> <code class="ms-2"><?= esc($db1_driver) ?></code></div>

                        <!-- Pulsanti -->
                        <div class="d-flex justify-content-center gap-2 mt-3">
                            <a href="<?= base_url('database/info/' . $db1_connection_group) ?>" class="btn btn-outline-primary">
                                <i class="bi bi-info-circle"></i> Info DB e Tabelle
                            </a>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Database 2 Card -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-header">
                        <i class="bi bi-database-check"></i> Connessione a PostgreSQL
                    </div>
                    <div class="card-body">
                        <div class="mb-2"><span class="text-muted">Nome DB:</span> <code class="ms-2"><?= esc($db2->db_name) ?></code></div>
                        <div class="mb-2"><span class="text-muted">Connection Group:</span> <code class="ms-2"><?= esc($db2_connection_group) ?></code></div>
                        <div class="mb-2"><span class="text-muted">Encoding:</span> <span class="badge bg-success"><?= esc($db2->encoding) ?></span></div>
                        <div class="mb-2"><span class="text-muted">Collation:</span> <code class="ms-2"><?= esc($db2->collation) ?></code></div>
                        <div class="mb-2"><span class="text-muted">CType:</span> <code class="ms-2"><?= esc($db2->ctype) ?></code></div>
                        <div class="mb-3"><span class="text-muted">Driver:</span> <code class="ms-2"><?= esc($db2_driver) ?></code></div>

                        <!-- Pulsanti -->
                        <div class="d-flex justify-content-center gap-2 mt-3">
                            <a href="<?= base_url('database/info/' . $db2_connection_group) ?>" class="btn btn-outline-success">
                                <i class="bi bi-info-circle"></i> Info DB e Tabelle
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="text-center mt-5">
            <button onclick="location.reload()" class="btn btn-warning me-3">
                <i class="bi bi-arrow-clockwise"></i> Riprova Connessione
            </button>
            <a href="/" class="btn btn-outline-secondary">
                <i class="bi bi-house"></i> Homepage
            </a>
        </div>

    </div>
</div>

<?php $this->endSection() ?>
