<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>
    <div class="container">
        <div class="main-container">
            <!-- Header -->
            <div class="header-section text-center">
                <h1 class="display-4 mb-2">
                    <i class="bi bi-check-circle"></i> Test Connessione
                </h1>
                <p class="lead mb-0">MeTe Licenze - Verifica Database PostgreSQL</p>
            </div>
            
            <!-- Content -->
            <div class="p-4">
                <?php if(isset($error)): ?>
                    <!-- Error Status Badge -->
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                        <strong>Connessione Database Fallita</strong>
                    </div>
                    
                    <!-- Error Info Card -->
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-md-12">
                            <div class="card border-danger">
                                <div class="card-header bg-danger text-white text-center">
                                    <i class="bi bi-database-x"></i> Errore di Connessione PostgreSQL
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-danger mb-4" role="alert">
                                        <div class="d-flex align-items-start">
                                            <i class="bi bi-bug-fill me-3 fs-4 text-danger"></i>
                                            <div>
                                                <h5 class="alert-heading">Messaggio di Errore:</h5>
                                                <p class="mb-0 font-monospace"><?= esc($error) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Troubleshooting Steps -->
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="card border-warning bg-warning bg-opacity-10">
                                                <div class="card-body">
                                                    <h6 class="card-title text-warning">
                                                        <i class="bi bi-tools"></i> Possibili Soluzioni
                                                    </h6>
                                                    <ul class="list-unstyled mb-0 small">
                                                        <li><i class="bi bi-arrow-right text-muted me-2"></i>Verifica file .env</li>
                                                        <li><i class="bi bi-arrow-right text-muted me-2"></i>Controlla credenziali database</li>
                                                        <li><i class="bi bi-arrow-right text-muted me-2"></i>PostgreSQL in esecuzione?</li>
                                                        <li><i class="bi bi-arrow-right text-muted me-2"></i>Porta 5432 disponibile?</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="card border-info bg-info bg-opacity-10">
                                                <div class="card-body">
                                                    <h6 class="card-title text-info">
                                                        <i class="bi bi-info-circle"></i> Configurazione
                                                    </h6>
                                                    <div class="small">
                                                        <div class="mb-2">
                                                            <span class="text-muted">Host:</span>
                                                            <code class="ms-2">localhost</code>
                                                        </div>
                                                        <div class="mb-2">
                                                            <span class="text-muted">Porta:</span>
                                                            <code class="ms-2">5432</code>
                                                        </div>
                                                        <div class="mb-2">
                                                            <span class="text-muted">Driver:</span>
                                                            <code class="ms-2">Postgre</code>
                                                        </div>
                                                        <div>
                                                            <span class="text-muted">Schema:</span>
                                                            <code class="ms-2"><?= env('database.default.schema', 'public') ?></code>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Error Action Buttons -->
                    <div class="row justify-content-center mt-4">
                        <div class="col-auto">
                            <button onclick="location.reload()" class="btn btn-warning me-3">
                                <i class="bi bi-arrow-clockwise"></i> Riprova Connessione
                            </button>
                            <a href="/" class="btn btn-outline-secondary">
                                <i class="bi bi-house"></i> Homepage
                            </a>
                        </div>
                    </div>
                    
                <?php else: ?>
                    <!-- Success Status Badge -->
                    <div class="status-connection">
                        <i class="bi bi-check-circle-fill"></i>
                        Connessione Database Stabilita
                    </div>
                    
                    <!-- Connection Info Card -->
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-10">
                            <div class="card info-card">
                                <div class="card-header text-center">
                                    <i class="bi bi-database-check"></i> Informazioni Connessione PostgreSQL
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                <div class="me-3">
                                                    <i class="bi bi-server text-primary fs-3"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 text-muted">Database</h6>
                                                    <span class="table-name fs-5"><?= esc($dbInfo->db_name) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                <div class="me-3">
                                                    <i class="bi bi-translate text-success fs-3"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 text-muted">Encoding</h6>
                                                    <span class="badge bg-success fs-6"><?= esc($dbInfo->encoding) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                <div class="me-3">
                                                    <i class="bi bi-sort-alpha-down text-warning fs-3"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 text-muted">Collation</h6>
                                                    <span class="table-name"><?= esc($dbInfo->collation) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center p-3 bg-light rounded">
                                                <div class="me-3">
                                                    <i class="bi bi-type text-info fs-3"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 text-muted">CType</h6>
                                                    <span class="table-name"><?= esc($dbInfo->ctype) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Success Message -->
                                    <div class="alert alert-success d-flex align-items-center mt-4" role="alert">
                                        <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                                        <div>
                                            <strong>Connessione riuscita!</strong> Il database PostgreSQL è configurato correttamente e funzionante.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Success Action Buttons -->
                    <div class="row justify-content-center mt-4">
                        <div class="col-auto">
                            <a href="/database/info" class="btn btn-custom me-3">
                                <i class="bi bi-info-circle"></i> Informazioni Dettagliate
                            </a>
                            <a href="/" class="btn btn-outline-secondary">
                                <i class="bi bi-house"></i> Homepage
                            </a>
                        </div>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="row g-3 mt-4">
                        <div class="col-md-4">
                            <div class="card border-0 bg-primary bg-opacity-10">
                                <div class="card-body text-center">
                                    <i class="bi bi-lightning-charge text-primary fs-1"></i>
                                    <h5 class="mt-2">Connessione Veloce</h5>
                                    <p class="text-muted mb-0">Latenza ottimizzata</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card border-0 bg-success bg-opacity-10">
                                <div class="card-body text-center">
                                    <i class="bi bi-shield-check text-success fs-1"></i>
                                    <h5 class="mt-2">Sicurezza</h5>
                                    <p class="text-muted mb-0">Connessione protetta</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card border-0 bg-warning bg-opacity-10">
                                <div class="card-body text-center">
                                    <i class="bi bi-gear text-warning fs-1"></i>
                                    <h5 class="mt-2">Configurazione</h5>
                                    <p class="text-muted mb-0">Setup completato</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
<?php $this->endSection() ?>