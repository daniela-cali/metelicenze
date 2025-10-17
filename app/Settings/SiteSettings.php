<?php

namespace App\Settings;

use CodeIgniter\Settings\Settings;

class SiteSettings extends Settings
{
    public string $siteName = '';
    public string $siteTheme = '';
    public string $adminEmail = '';
    public string $siteURL = '';
    public bool $maintenanceMode = false;

    public static string $group = 'site';

    public function __construct(?\CodeIgniter\Settings\Config\Settings $store = null)
    {
        parent::__construct($store ?? service('settings'));
    }
}
