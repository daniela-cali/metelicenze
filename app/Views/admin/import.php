<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h1><?= esc($title) ?></h1>
<p>Qui puoi importare i clienti nel database interno.</p>
<table id="importTable" class="table table-striped datatable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ragione Sociale</th>
            <th>Indirizzo</th>
            <th>Città</th>
            <th>CAP</th>
            <th>Prov.</th>
            <th>PIva</th>
            <th>Telefono</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($clienti) && is_array($clienti)): ?>
            <?php foreach ($clienti as $cliente): ?>
                <tr>
                    <td><?= esc($cliente->tbana_id_pk) ?></td>
                    <td><?= esc($cliente->tbana_ragsoc1) ?></td>
                    <td><?= esc($cliente->tbana_indirizzo1) ?></td>
                    <td><?= esc($cliente->tbana_citta) ?></td>
                    <td><?= esc($cliente->tbana_cap) ?></td>
                    <td><?= esc($cliente->tbana_provincia) ?></td>
                    <td><?= esc($cliente->tbana_piva) ?></td>
                    <td><?= esc($cliente->tbana_telefono1) ?></td>
                    <td><?= esc($cliente->tbana_email) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Nessun cliente disponibile per l'importazione.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
