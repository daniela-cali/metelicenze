<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Settings\SiteSettings;
use CodeIgniter\Settings\Settings as SettingsService;

class TestSettings extends BaseController
{
    public function index()
    {
        // Recupero il servizio Settings
        /** @var SettingsService $settingsService */
        $settingsService = service('settings');

        // Proviamo a leggere l'oggetto SiteSettings
        $siteSettings = null;

        try {
            $siteSettings = $settingsService->get(SiteSettings::class);
        } catch (\Exception $e) {
            echo "Errore catturato: " . $e->getMessage() . PHP_EOL;
        }

        // Se non esiste, crea nuovo oggetto
        if (!$siteSettings) {
            $siteSettings = new SiteSettings($settingsService);
        }

        // Stampa tutti i valori
        echo '<pre>';
        print_r($siteSettings);
        echo '</pre>';

        // Salvataggio test
        $siteSettings->siteName = 'TEST ' . date('H:i:s');
        $settingsService->save($siteSettings);

        echo "<p>Salvato con successo!</p>";
    }
}
