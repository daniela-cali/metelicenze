<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary  d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-key-fill"></i> <?= esc($title) ?> </h5>
            <a href="<?= previous_url() ?>" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> Indietro
            </a>
        </div>

        <div class="card-body">
            <!--Aggiungo la modalità di creazione o modifica per il js-->
            <form action="<?= $action ?>" method="post" data-mode="<?= $mode ?>">

                <div class="mb-3">
                    <label for="codice" class="form-label">Codice Licenza</label>
                    <input type="text" name="codice" id="codice" class="form-control" required placeholder="Es. ABC12345"
                        value="<?= isset($licenza) ? esc($licenza->codice) : '' ?>">
                </div>


                <div class="mb-3">
                    <label for="natura" class="form-label">Tipo</label>
                    <select name="tipo" id="tipo" class="form-select" required>
                        <option value="">-- Seleziona --</option>
                        <option value="Sigla" <?= (isset($licenza) && $licenza->tipo === 'Sigla') ? 'selected' : '' ?>>Sigla</option>
                        <option value="VarHub" <?= (isset($licenza) && $licenza->tipo === 'VarHub') ? 'selected' : '' ?>>VarHub</option>
                        <option value="SKNT" <?= (isset($licenza) && $licenza->tipo === 'SKNT') ? 'selected' : '' ?>>SKTN</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="modello" class="form-label">Modello</label>
                    <select name="modello" id="modello" class="form-select" required>
                        <option value="">-- Seleziona --</option>
                        <option value="Start" <?= (isset($licenza) && $licenza->modello === 'Start') ? 'selected' : '' ?>>Start</option>
                        <option value="Ultimate" <?= (isset($licenza) && $licenza->modello === 'Ultimate') ? 'selected' : '' ?>>Ultimate</option>
                        <option value="Cloud" <?= (isset($licenza) && $licenza->modello === 'Cloud') ? 'selected' : '' ?>>Cloud</option>
                        <option value="N/A" <?= (isset($licenza) && empty($licenza->modello)) ? 'selected' : '' ?>>Nessun tipo di modello</option>
                    </select>
                </div>

                <div class="mb-3 form-check">
                    <label class="form-check-label" class="form-label" for="stato">Licenza attiva</label>
                <input
                    type="checkbox"
                    class="form-check-input"
                    id="stato"
                    name="stato"                   
                    <?php if (!isset($licenza) || $licenza->stato) echo 'checked'; ?>>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Salva Licenza
            </button>
            <a href="<?= previous_url() ?>" class="btn btn-secondary">Annulla</a>
        </div>
        </form>
    </div>
</div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Inizializza il form con i dati della licenza se esistono
        const mode = $('form').data('mode');
        console.log('Modalità: ' + mode);
        if (mode === 'view') {
            // Se la modalità è "view", rendo tutti i campi readonly
            $('input, select, textarea').prop('readonly', true).prop('disabled', true);
            // Disabilito anche il bottone del form
            $('button[type="submit"]').prop('disabled', true);
        }

    });
</script>
<?= $this->endSection() ?>