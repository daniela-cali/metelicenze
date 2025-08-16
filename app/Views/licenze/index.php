
<?php $this->extend('layouts/main') ?>
<?php $this->section('content') ?>
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary  d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-key"></i> Elenco Licenze</h5>
            <a href="/licenze/crea" class="btn btn-light btn-sm">
                <i class="bi bi-plus-circle"></i> Aggiungi Licenza
            </a>
        </div>
        <div class="card-body">

            <?php if (!empty($licenze)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID Licenza</th>
                                <th>Nome Licenza</th>
                                <th>Tipo</th>
                                <th>Descrizione</th>
                                <th>ID Cliente</th>
                                <th>Stato</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($licenze as $licenza): ?>
                                <tr>
                                    <td><?= esc($licenza->id) ?></td>
                                    <td><?= esc($licenza->nome_licenza) ?></td>
                                    <td><?= esc($licenza->tipo) ?></td>
                                    <td><?= esc($licenza->descrizione) ?></td>
                                    <td><?= esc($licenza->id_cliente) ?></td>
                                    <td>
                                        <?php if ($licenza->stato == 't'): ?>
                                            <span class="badge bg-success">Attiva</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?= esc(ucfirst($licenza->stato)) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="/licenze/visualizza/<?= $licenza->id ?>" class="btn btn-sm btn-outline-primary" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/licenze/modifica/<?= $licenza->id ?>" class="btn btn-sm btn-outline-secondary" title="Modifica">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="/licenze/elimina/<?= $licenza->id ?>" class="btn btn-sm btn-outline-danger" title="Elimina" onclick="return confirm('Eliminare la licenza?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
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


