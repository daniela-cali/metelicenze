<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>
<div class="container">
    <div class="main-container">
        <!-- Header -->
        <div class="header-section text-center mb-4">
            <h1 class="display-5 mb-2">
                <i class="bi bi-check-circle"></i> Test Connessione - Doppio DB
            </h1>
            <p class="lead mb-0">MeTe Licenze - Verifica Connessione a due Database su due DBMS diversi</p>
        </div>

        <div class="row g-4">
            <!-- Database 1 -->
            <div class="col-md-6">
                <div class="card border-primary shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <i class="bi bi-database-check"></i> Connessione a MySQLi
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="text-muted">Nome DB:</span>
                            <code class="ms-2"><?= esc($db1->db_name) ?></code>
                        </div>
                        <div class="mb-3">
                            <span class="text-muted">Encoding:</span>
                            <span class="badge bg-success"><?= esc($db1->encoding) ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="text-muted">Collation:</span>
                            <code class="ms-2"><?= esc($db1->collation) ?></code>
                        </div>
                        <div>
                            <span class="text-muted">CType:</span>
                            <code class="ms-2"><?= esc($db1->ctype) ?></code>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Database 2 -->
            <div class="col-md-6">
                <div class="card border-secondary shadow-sm">
                    <div class="card-header bg-secondary text-white text-center">
                        <i class="bi bi-database-check"></i> Connessione a PostgreSQL)
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="text-muted">Nome DB:</span>
                            <code class="ms-2"><?= esc($db2->db_name) ?></code>
                        </div>
                        <div class="mb-3">
                            <span class="text-muted">Encoding:</span>
                            <span class="badge bg-success"><?= esc($db2->encoding) ?></span>
                        </div>
                        <div class="mb-3">
                            <span class="text-muted">Collation:</span>
                            <code class="ms-2"><?= esc($db2->collation) ?></code>
                        </div>
                        <div>
                            <span class="text-muted">CType:</span>
                            <code class="ms-2"><?= esc($db2->ctype) ?></code>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Azioni -->
        <div class="footer-section text-center mb-4 mt-5">
            <div class="text-center mt-4">
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