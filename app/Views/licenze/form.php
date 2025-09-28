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
                <input type="hidden" name="backTo" value="<?= isset($backTo) ? esc($backTo) : '' ?>">

                <div class="mb-3" data-licenza="Common">
                    <label for="natura" class="form-label">Tipo</label>
                    <select name="tipo" id="tipo" class="form-select" required>
                        <option value="Common">-- Seleziona --</option>
                        <option value="Sigla" <?= (isset($licenza) && $licenza->tipo === 'Sigla') ? 'selected' : '' ?>>Sigla</option>
                        <option value="VarHub" <?= (isset($licenza) && $licenza->tipo === 'VarHub') ? 'selected' : '' ?>>VarHub</option>
                        <option value="SKNT" <?= (isset($licenza) && $licenza->tipo === 'SKNT') ? 'selected' : '' ?>>SKTN</option>
                    </select>
                </div>
                <div class="mb-3 d-none" data-licenza="Sigla,SKNT">
                    <label for="codice" class="form-label">Codice Licenza</label>
                    <input type="text" name="codice" id="codice" class="form-control" required placeholder="Es. ABC12345"
                        value="<?= isset($licenza) ? esc($licenza->codice) : '' ?>">
                </div>
                <div class="mb-3 d-none" data-licenza="VarHub">
                    <label for="ambiente" class="form-label">Ambiente</label>
                    <input type="text" name="ambiente" id="ambiente" class="form-control" required placeholder="Es. usr_12345"
                        value="<?= isset($licenza) ? esc($licenza->ambiente) : '' ?>">
                </div>
                <div class="mb-3 d-none" data-licenza="VarHub">
                    <label for="nodo" class="form-label">Nodo</label>
                    <input type="text" name="nodo" id="nodo" class="form-control" required placeholder="CLNT_12345XYZ"
                        value="<?= isset($licenza) ? esc($licenza->nodo) : '' ?>">
                </div>
                <div class="mb-3 d-none" data-licenza="VarHub">
                    <label for="invii" class="form-label">Invii</label>
                    <input type="text" name="invii" id="invii" class="form-control" required placeholder="500"
                        value="<?= isset($licenza) ? esc($licenza->invii) : 500 ?>">
                </div>
                <div class="mb-3 d-none" data-licenza="VarHub">
                    <label for="giga" class="form-label">Giga</label>
                    <input type="text" name="giga" id="giga" class="form-control" required placeholder="Invii * 2"
                        value="<?= isset($licenza) ? esc($licenza->giga) : '' ?>">
                </div>
                <div class="mb-3 d-none" data-licenza="Sigla">
                    <label for="modello" class="form-label" data-licenza="Sigla">Modello</label>
                    <select name="modello" id="modello" class="form-select" required>
                        <option value="Common">-- Seleziona --</option>
                        <option value="Start" <?= (isset($licenza) && $licenza->modello === 'Start') ? 'selected' : '' ?>>Start</option>
                        <option value="Ultimate" <?= (isset($licenza) && $licenza->modello === 'Ultimate') ? 'selected' : '' ?>>Ultimate</option>
                        <option value="Cloud" <?= (isset($licenza) && $licenza->modello === 'Cloud') ? 'selected' : '' ?>>Cloud</option>
                        <option value="N/A" <?= (isset($licenza) && empty($licenza->modello)) ? 'selected' : '' ?>>Nessun tipo di modello</option>
                    </select>
                </div>
                <div class="mb-3 d-none" data-licenza="Sigla">
                    <label for="postazioni" class="form-label">Postazioni Licenza</label>
                    <input type="text" name="postazioni" id="postazioni" class="form-control" required placeholder="1"
                        value="<?= isset($licenza) ? esc($licenza->postazioni) : 1 ?>" />
                </div>
                <div class="mb-3 form-check d-none" data-licenza="Sigla">
                    <label class="form-check-label" class="form-label" for="stato"><i>Licenza Figlio</i></label>
                    <input
                        type="checkbox"
                        class="form-check-input"
                        id="figlio_sn"
                        name="figlio_sn"
                        <?= (isset($licenza) && $licenza->figlio_sn) ? 'checked' : '' ?>>
                    </input>
                </div>
                <div class=" mb-3 form-group d-none" data-licenza="Common">
                    <label for="server">Server</label>
                    <input type="text" class="form-control" id="server" name="server" placeholder="192.168.0.1, localhost, ecc." value="<?= isset($licenza) ? esc($licenza->server) : '' ?>">
                    </input>
                </div>
                <div class=" mb-3 form-group d-none" data-licenza="Sigla">
                    <label for="server">Connessioni</label>
                    <textarea class="form-control" id="server" name="server" rows="3"><?= 
                         isset($licenza) ? esc($licenza->server) : '' 
                    ?></textarea>
                </div>
                                    
                <div class=" mb-3 form-group" data-licenza="Common">
                    <label for="note">Note Licenza</label>
                    <textarea class="form-control" id="note" name="note" rows="3"><?= 
                        isset($licenza) ? esc($licenza->note) : '' 
                    ?></textarea>
                </div>
                <div class="mb-3 form-check" data-licenza="Common">
                    <label class="form-check-label" class="form-label" for="stato">Licenza attiva</label>
                    <input
                        type="checkbox"
                        class="form-check-input"
                        id="stato"
                        name="stato"
                        <?php if (!isset($licenza) || $licenza->stato) echo 'checked'; ?> />
                </div>

                <div class="mt-4 " data-licenza="Common">
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

        document.getElementById("tipo").addEventListener("change", function() {
            const tipoSelezionato = this.value;
            console.log("Tipo selezionato: " + tipoSelezionato);

            document.querySelectorAll('[data-licenza]').forEach(wrapper => {
                console.log("Wrapper con data-licenza: " + wrapper.getAttribute('data-licenza'));
                if (wrapper.getAttribute('data-licenza').includes(tipoSelezionato) || wrapper.getAttribute('data-licenza') === 'Common') {
                    wrapper.classList.remove('d-none');
                    // Rendo i campi all'interno del wrapper obbligatori se non sono in modalità view
                    if (mode !== 'view') {
                        wrapper.querySelectorAll('input, select, textarea').forEach(campo => {
                            if (campo.name === 'note') return; // Escludo il campo note dall'essere obbligatorio
                            campo.required = true;
                        });
                    }
                } else {
                    wrapper.classList.add('d-none');
                    // Rimuovo l'obbligatorietà dai campi all'interno del wrapper
                    wrapper.querySelectorAll('input, select, textarea').forEach(campo => {
                        campo.required = false;
                        campo.value = ''; // Pulisce il valore del campo quando viene nascosto
                    });
                }

            });

        });

    });
</script>
<?= $this->endSection() ?>