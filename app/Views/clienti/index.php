<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container my-5">
<form method="post" action="">
    <div class="card mb-3">
        <div class="card-header">
            <i class="bi bi-search"></i>
            Filtri di ricerca
        </div>
        <div class="card-body d-flex flex-wrap gap-3 align-items-end">
            <div>
                <label for="filterLicenza" class="form-label">Licenza</label>
                <select id="filterLicenza" name="tipoLicenza" class="form-select w-auto">
                    <option value="SI">Licenza Sigla</option>
                    <option value="VA">Licenza VarHub</option>
                    <option value="SK">Licenza SKNT</option>
                </select>
            </div>

            <div>
                <label for="filterOrdine" class="form-label">Ordina per</label>
                <select id="filterOrdine" name="filterOrdine" class="form-select w-auto">
                    <option value="">-- Ordina per --</option>
                    <option value="recenti">Più recenti</option>
                    <option value="vecchie">Più vecchie</option>
                </select>
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Cerca</button>
            </div>
        </div>
    </div>
</form>

    <div class="card shadow-sm">
        <div class="card-header bg-primary d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-people"></i> Elenco Clienti</h5>

        </div>
        <div class="card-body">

            <?php if (!empty($clienti)): ?>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle" id="clientiTable">
                        <thead class="table-light">
                            <tr>
                                <th>Codice cliente</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th>Città</th>
                                <th>Licenze</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clienti as $cliente): ?>
                                <tr>
                                    <td><?= esc($cliente->codice_cliente) ?></td>
                                    <td><?= esc($cliente->nome) ?></td>
                                    <td><?= esc($cliente->email) ?></td>
                                    <td><?= esc($cliente->telefono) ?></td>
                                    <td><?= esc($cliente->citta) ?></td>
                                    <td></td>

                                    <!--<td>
                                        <? //php if ($cliente->licenze_attive > 0): 
                                        ?>
                                            <span class="badge bg-success"><? //php $cliente->licenze_attive 
                                                                            ?> attive</span>
                                        <? //php else: 
                                        ?>
                                            <span class="badge bg-secondary">Nessuna</span>
                                        <? //php endif; 
                                        ?>
                                    </td>-->
                                    <td>
                                        <a href="/clienti/schedaCliente/<?= $cliente->id ?>" class="btn btn-sm btn-outline-primary" title="Scheda Cliente">
                                            <i class="bi bi-person-vcard"></i>
                                        </a>
                                        <a href="/licenze/nuova/<?= $cliente->id ?>" class="btn btn-sm btn-outline-primary" title="Crea Licenza per il cliente">
                                            <i class="bi bi-key-fill"></i>
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
    $(document).ready(function() {
        var table = new DataTable('#clientiTable', {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.3.2/i18n/it-IT.json',
            },
            responsive: true,
            order: [
                [0, 'asc']
            ],
            columnDefs: [{
                targets: 5,
                orderable: true,
                searchable: true
            }],
            paging: true,
            pageLength: 20,
            lengthChange: false,
            info: true,
            searching: true,
            autoWidth: false,

        });
    });
</script>
<?= $this->endSection() ?>