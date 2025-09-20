<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;

class MailTest extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'mail:test';
    protected $description = 'Invia una mail di test usando la configurazione Email di CodeIgniter.';

    public function run(array $params)
    {
        $email = Services::email();

        // destinatario di default, puoi sovrascriverlo da CLI
        $to = $params[0] ?? 'metelicenze@gmail.com';

        $email->setTo($to);
        $email->setSubject('📩 Test Email da CodeIgniter');
        $email->setMessage('<p>Se stai leggendo questa mail, la configurazione funziona 🎉</p>');
        $email->setMailType('html');

        CLI::write('Invio email di test a: ' . $to, 'yellow');

        if ($email->send()) {
            CLI::write('✅ Email inviata con successo!', 'green');
        } else {
            CLI::error('❌ Errore nell’invio della mail');
            CLI::write($email->printDebugger(['headers', 'subject', 'body']), 'red');
        }
    }
}
