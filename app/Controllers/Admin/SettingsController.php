<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Settings\SiteSettings;

class SettingsController extends BaseController
{
    public function index()
    {
        $settings = setting(SiteSettings::class);

        return view('admin/settings', [
            'settings' => $settings,
        ]);
    }

    public function save()
    {
        $data = $this->request->getPost();

        $settings = setting(SiteSettings::class);
        $settings->siteName = $data['siteName'] ?? 'Default name';
        $settings->maintenanceMode = isset($data['maintenanceMode']);

        setting()->save($settings);

        return redirect()->back()->with('success', 'Impostazioni salvate correttamente.');
    }
}
