<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-warning d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill"></i> Account in attesa di approvazione</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-warning" role="alert">
                <h4 class="alert-heading">Il tuo account è in stato "In attesa di approvazione"</h4>
                <p>Il tuo account è stato creato con successo, ma è attualmente in attesa di approvazione da parte di un amministratore del sistema. Non potrai accedere alle funzionalità dell'applicazione fino a quando il tuo account non sarà approvato.</p>
                <hr>
                <p class="mb-0">Ti preghiamo di attendere che un amministratore esamini e approvi il tuo account. Riceverai una notifica via email una volta che il tuo account sarà stato approvato.</p>
            </div>  
            <p class="text-muted">Se ritieni che ci sia un errore o hai bisogno di assistenza, contatta l'amministratore del sistema.</p>
        </div>
    </div>
</div>  
<?= $this->endSection() ?>

