<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeTe Licenze</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">

</head>

<body>
    <?php
    // Carica le configurazioni del sito
    $config = config('SiteConfig');
    // Imposta il titolo della pagina
    $siteName = $config->siteName;
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/icons/logo.png') ?>" alt="logo" class="logo-navbar me-2">
                <span><?= esc($siteName) ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('clienti') ?>">Clienti</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('licenze') ?>">Licenze</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('versioni') ?>">Versioni</a>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="databaseDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Database
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="databaseDropdown">
                            <li><a class="dropdown-item" href="<?= base_url('database/') ?>">Test Connessioni</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('database/utenti') ?>">Utenti</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= base_url('database/log') ?>">Log Database</a></li>
                        </ul>
                    </li>


                </ul>

                <ul class="navbar-nav">
                    <?php if (function_exists('auth') && auth()->loggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('logout') ?>">
                                <i class="bi bi-box-arrow-right"></i>
                                Logout
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('login') ?>">
                                <i class="bi bi-box-arrow-in-left"></i>
                                Login
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('register') ?>">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenuto principale -->
    <main>
        <!-- Mostra eventuali messaggi di successo o errore -->

        <?php if (session()->getFlashdata('success') || session()->getFlashdata('error')): ?>
            <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 1100; max-width: 400px; width: 90%;">
                <div class="alert <?= session()->getFlashdata('success') ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show shadow" role="alert">
                    <?= session()->getFlashdata('success') ?: session()->getFlashdata('error'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <!-- Renderizza il contenuto della view specifica -->
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Bootstrap Bundle -->

    <footer class="bg-dark text-light py-3 text-center mt-5">
        <small>&copy; <?= date('Y') ?> MeTe Licenze - Tutti i diritti riservati</small>
    </footer>
    <script>
        // Dopo 5 secondi chiude automaticamente l'alert se presente
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                const alert = document.querySelector('.alert');
                if (alert) {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert.close();
                }
            }, 3000);
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>