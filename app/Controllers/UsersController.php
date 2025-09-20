<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;

class UsersController extends BaseController
{
    public function index()
    {
        $users = auth()->getProvider();

        $usersList = $users
            ->withGroups()
            ->withPermissions()
            ->findAll();

        return view('users/index', [
            'title' => 'Gestione Utenti',
            'usersList' => $usersList,
        ]);
    }
    public function pending()
    {
        return view('account/pending');
    }
}
