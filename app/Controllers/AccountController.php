<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AccountController extends BaseController
{
    public function pending()
    {
        return view('account/pending');
    }
}
