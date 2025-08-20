<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): string
    {
        $config = config('SiteConfig');
        return view('home',[
            'siteName' => $config->siteName,
            'siteTheme' => $config->siteTheme,
        ]);
    }
}
