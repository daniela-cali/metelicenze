<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use CodeIgniter\HotReloader\HotReloader;
use CodeIgniter\Shield\Entities\User;
helper('html'); // per poter usare esc()
/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', static function (): void {
    if (ENVIRONMENT !== 'testing') {
        if (ini_get('zlib.output_compression')) {
            throw FrameworkException::forEnabledZlibOutputCompression();
        }

        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(static fn ($buffer) => $buffer);
    }
Events::on('DBQuery', function ($query) {
    // Scrive ogni query nel log
    log_message('debug', 'SQL: ' . $query->getQuery());
});
    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (CI_DEBUG && ! is_cli()) {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        service('toolbar')->respond();
        // Hot Reload route - for framework use on the hot reloader.
        if (ENVIRONMENT === 'development') {
            service('routes')->get('__hot-reload', static function (): void {
                (new HotReloader())->run();
            });
        }
    }
});

/*
 |--------------------------------------------------------------------
 | Evento: Nuova Registrazione Utente
 |--------------------------------------------------------------------
 | Ogni volta che un utente si registra, inviamo una mail
 | all’amministratore con i dettagli principali.
 */
Events::on('register', static function (User $user) {
    $user->addGroup('pending');
    $email = Services::email();
    log_message('info', 'Evento register catturato per utente: ' . $user->email);

    // Mittente (se non impostato in Config/Email.php)
    $email->setFrom('noreply@mete-licenze.it', 'MeTe Licenze');

    // Destinatario: admin
    $email->setTo('nhildra.morwen@gmail.com');
    $email->setSubject('Nuova registrazione utente su MeTe Licenze');

    // Corpo HTML dell’email
    $message = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { padding: 20px; }
                .header { font-size: 18px; font-weight: bold; margin-bottom: 15px; }
                .details { background: #f8f9fa; padding: 10px; border: 1px solid #dee2e6; border-radius: 5px; }
                .details p { margin: 0 0 5px; }
                .footer { margin-top: 20px; font-size: 12px; color: #6c757d; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">📩 Nuovo utente registrato</div>
                <p>Un nuovo utente si è appena registrato su <strong>MeTe Licenze</strong>. Ecco i dettagli:</p>
                <p>Proviene da IP: ' . esc($_SERVER['REMOTE_ADDR'] ?? 'N/A') . '</p>
                <p>Autorizzare utente se necessario.</p>
                <div class="details">
                    <p><strong>Username:</strong> ' . esc($user->username) . '</p>
                    <p><strong>Email:</strong> ' . esc($user->email) . '</p>
                    <p><strong>Registrato il:</strong> ' . date('d/m/Y H:i') . '</p>
                </div>
                <div class="footer">
                    Questo è un messaggio automatico generato da MeTe Licenze.
                </div>
            </div>
        </body>
        </html>
    ';

    $email->setMessage($message);
    $email->setMailType('html'); // fondamentale per HTML

    if (! $email->send()) {
        // log in caso di errore
        log_message('error', 'Errore invio mail admin nuova registrazione: ' . $email->printDebugger(['headers']));
    } else {
        log_message('info', 'Notifica inviata a admin per nuova registrazione utente: ' . $user->email);
    }
});

