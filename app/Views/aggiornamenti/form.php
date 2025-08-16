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
            <form action="" method="post" data-mode ="">

                <div class="mb-3">
                    <label for="data_agg" class="form-label">Data Aggiornamento</label>
                    <input type="date" name="data_agg" id="data_agg" class="form-control" required 
                    value="<?= isset($aggiornamento) ? esc($aggiornamento->data_agg) : '' ?>">
                </div>

                <div class="mb-3">
                    <label for="descrizione" class="form-label">Descrizione</label>
                    <input type="text" name="descrizione" id="descrizione" class="form-control" rows="3" placeholder="Descrizione della licenza" required
                        value="<?= isset($licenza) ? esc($licenza->descrizione) : '' ?>">
                        
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