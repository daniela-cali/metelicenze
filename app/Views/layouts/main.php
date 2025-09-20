<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'MeTe Licenze') ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables CSS (da CDN) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.bootstrap5.min.css">

    <!-- CSS personalizzato (DEVE essere ultimo per sovrascrivere) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">

    <?= $this->renderSection('styles') ?>
</head>

<body>
    <!-- Navbar -->
    <?= $this->include('partials/navbar') ?>

    <!-- Contenuto principale -->
    <main class="container my-4">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <?= $this->include('partials/footer') ?>

        <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables core + integrazione Bootstrap 5 -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Buttons core + integrazione Bootstrap 5 (ATTENZIONE all'ordine) -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>

    <!-- Dipendenze export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Buttons: HTML5 + Print -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <!-- FixedHeader (se usi l’header fisso) -->
    <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>

    <!-- baseUrl per i file locali (traduzioni ecc.) -->
    <script>const baseUrl = "<?= base_url() ?>";</script>

    <!-- Defaults: applica classi Bootstrap ai bottoni di default -->
    <script>
      // Assicura che i bottoni di Buttons usino classi Bootstrap
      $.extend(true, $.fn.dataTable.Buttons.defaults, {
        dom: { button: { className: 'btn btn-sm btn-outline-secondary' } }
      });
    </script>

    <!-- Tuo init globale (lingua IT + bottoni con icone/colori personalizzati) -->
    <script src="<?= base_url('assets/js/datatable-init.js') ?>"></script>

    <!-- Script specifici pagina -->
    <?= $this->renderSection('scripts') ?>

</body>
</html>
