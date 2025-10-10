<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-key"></i> Elenco Licenze</h5>
            
            </a>
        </div>
        <div class="card-body">
            
            <?php 
            log_message('info', 'View licenze index variabile licenze' . print_r($licenze, true));
            if (!empty($licenze)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle datatable">
                        <thead class="table-light">
                            <tr>
                                <th>ID Licenza</th>
                                <th>Codice</th>
                                <th>Tipo</th>
                                <th>Cliente</th>
                                <th>Data Ult. Agg.</th>
                                <th>Versione attuale</th>
                                <th>Stato</th>
                                <th class="notexport">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($licenze as $licenza): ?>
                                <tr>
                                    <td><?= esc($licenza->id) ?></td>
                                    <td><?= esc($licenza->codice) ?></td>
                                    <td><?= esc($licenza->tipo) ?></td>
                                    <td><?= esc($licenza->clienteNome) ?></td>
                                    <td><?= esc($licenza->ultimoAggiornamento) ?></td>
                                    <td><?= esc($licenza->versioneUltimoAggiornamento) ?></td>
                                    <td>
                                        <?php if ($licenza->stato): ?>
                                            <span class="badge bg-success">
                                                <i class="bi bi-check"></i>
                                                Attiva
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= esc(ucfirst($licenza->stato)) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle" type="button" id="azione" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-list"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li>
                                                    
                                                    <a class="dropdown-item" href="<?= site_url('licenze/visualizza/' . $licenza->id) ?>">
                                                        <i class="bi bi-eye"></i>
                                                        Visualizza
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="<?= site_url('licenze/modifica/' . $licenza->id) ?>">
                                                        <i class="bi bi-pencil"></i>
                                                        Modifica
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>

                                                <li class="">
                                                    <a class="dropdown-item text-danger" href="<?= site_url('licenze/elimina/' . $licenza->id) ?>">
                                                        <i class="bi bi-trash"></i>
                                                        Elimina
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Nessuna licenza trovata nel database.
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?= $this->endSection() ?>