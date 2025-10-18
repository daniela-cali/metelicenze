<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container my-5">
    <form method="get" action="">


        <div class="card shadow-sm">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-people"></i> Elenco Clienti</h5>

            </div>
            <div class="card-body">

                <?php if (!empty($clienti)): ?>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle datatable" id="clientiTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Codice cliente</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                    <th class="notexport">Città</th>
                                    <th>N°</th>
                                    <th>Tipi</th>
                                    <th class="notexport">Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clienti as $cliente): ?>
                                    <tr>
                                        <td><?= esc($cliente->codice) ?></td>
                                        <td><?= esc($cliente->nome) ?></td>
                                        <td><?= esc($cliente->email) ?></td>
                                        <td><?= esc($cliente->telefono) ?></td>
                                        <td><?= esc($cliente->citta) ?></td>
                                        <td>
                                            <?php if ($cliente->numLicenze > 0):
                                            ?>
                                                <span class="badge bg-success">
                                                    <?php echo $cliente->numLicenze ?> </span>
                                            <?php else:
                                            ?>
                                                <span class="badge bg-secondary">0</span>
                                            <?php endif;
                                            ?>
                                        </td>
                                        <td>
                                            <?php // Visualizzo i tipi di licenze come lista
                                            foreach ($cliente->tipiLicenze as $tipo): ?>                                            
                                                <span class="badge bg-transparent text-dark mb-1"><?= esc($tipo) ?></span>
                                            <?php endforeach; ?>
                                        </td>
                                        <td>
                                            <a href="/clienti/schedaCliente/<?= $cliente->id ?>" class="btn btn-sm btn-outline-primary" title="Scheda Cliente">
                                                <i class="bi bi-person-vcard"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Nessun cliente trovato nel database.
                    </div>
                <?php endif; ?>
            </div>
        </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>

</script>
<?= $this->endSection() ?>