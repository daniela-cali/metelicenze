<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Gestione Licenze') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/2dce9b8c56.js" crossorigin="anonymous"></script>
    <!-- CSS personalizzato -->
    <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet">
    <?= $this->renderSection('head') ?>
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-person shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <img src="<?= base_url('assets/icons/logo.png') ?>" alt="Logo" height="50"> MeTe Licenze
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/clienti') ?>"><i class="bi bi-people-fill"></i> Clienti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/licenze') ?>"><i class="bi bi-key-fill"></i> Licenze</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/database/info') ?>"><i class="bi bi-database-fill-check"></i> Test DB</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenuto principale -->
    <main>
        <?php log_message('info', 'Flashdata'.session()->getFlashdata('success'));
        if (session()->getFlashdata('success') !== NULL): 
            ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo session()->getFlashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php elseif ((session()->getFlashdata('error') !== NULL)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo session()->getFlashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Bootstrap Bundle -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
