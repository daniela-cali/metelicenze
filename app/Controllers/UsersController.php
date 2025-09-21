<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Authorization\Groups;
use CodeIgniter\Database\Exceptions\DatabaseException;

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

    public function visualizza($id)
    {
        $users = auth()->getProvider();

        $user = $users
            ->withGroups()
            ->withPermissions()
            ->find($id);
        log_message('info', 'Utente trovato: ' . print_r($user, true));
        if (!$user) {
            return redirect()->to('/utenti')->with('error', 'Utente non trovato.');
        }
        $user->groups = $user->getGroups();
        $user->permissions = $user->getPermissions();
        log_message('info', 'Gruppi dell\'utente: ' . print_r($user->groups, true));
        log_message('info', 'Permessi dell\'utente: ' . print_r($user->permissions, true));
        $allGroups = config('AuthGroups')->groups;
        log_message('info', 'All Groups: ' . print_r($allGroups, true));
        $allPermissions = config('AuthGroups')->permissions;
        log_message('info', 'All Permissions: ' . print_r($allPermissions, true));

        return view('users/form', [
            'title' => 'Dettagli Utente: ' . esc($user->username),
            'mode' => 'view',
            'action' => '',
            'user' => $user,
            "allGroups" => $allGroups,
            "allPermissions" => $allPermissions,
        ]);
    }
    public function modifica($id)
    {
        $users = auth()->getProvider();

        $user = $users
            ->withGroups()
            ->withPermissions()
            ->find($id);
        log_message('info', 'Utente trovato: ' . print_r($user, true));
        if (!$user) {
            return redirect()->to('/utenti')->with('error', 'Utente non trovato.');
        }
        $user->groups = $user->getGroups();
        $user->permissions = $user->getPermissions();
        log_message('info', 'Gruppi dell\'utente: ' . print_r($user->groups, true));

        $allGroups = config('AuthGroups')->groups;
        log_message('info', 'All Groups: ' . print_r($allGroups, true));
        $allPermissions = config('AuthGroups')->permissions;
        log_message('info', 'All Permissions: ' . print_r($allPermissions, true));

        return view('users/form', [
            'title' => 'Modifica Utente: ' . esc($user->username),
            'mode' => 'edit',
            'action' => base_url('/utenti/salva/' . $id),
            'user' => $user,
            "allGroups" => $allGroups,
            "allPermissions" => $allPermissions,
        ]);
    }
    public function crea($id = null)
    {
        $allGroups = config('AuthGroups')->groups;
        log_message('info', 'CREA::All Groups: ' . print_r($allGroups, true));

        // Validazione dei dati
        $rules = [
            'username' => 'required|min_length[3]|max_length[30]|alpha_numeric',
            'email'    => 'required|valid_email',
        ];

        if ($id === null || !empty($data['password'])) {
            $rules['password'] = 'required|min_length[8]|max_length[255]|matches[password_confirm]';
            $rules['password_confirm'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('alert', $this->validator->getErrors());
        }

        return view('users/form', [
            'title' => 'Crea Nuovo Utente',
            'mode' => 'create',
            'action' => base_url('/utenti/salva'), // Non ha ancora ID
            'user' => null,
            "allGroups" => $allGroups,
            "allPermissions" => config('AuthGroups')->permissions,

        ]);
    }
    public function salva($id = null)
    {
        log_message('info', 'Salvataggio utente, ID: ' . ($id ?? 'Nuovo Utente'));
        $db = db_connect();
        $users = auth()->getProvider();
        $data = $this->request->getPost();
        // Gestione gruppi
        $selectedGroups = $this->request->getPost('groups') ?? [];
        //$groups = "'" . implode("', '", $selectedGroups) . "'";
        log_message('info', "Gruppi selezionati: " . print_r($selectedGroups, true));

        log_message('info', 'Dati ricevuti per il salvataggio: ' . print_r($data, true));


        if ($id) {
            // Modifica utente esistente
            $user = $users->find($id);
            if (!$user) {
                return redirect()->to('/utenti')->with('alert', 
                ['type'=> 'warning',
                 'message' => 'Utente non trovato.']);
            }
            $user->username = $data['username'];
            $user->email = $data['email'];

            if (!$users->save($user)) {
                return redirect()->back()->withInput()
                ->with('alert_type', 'danger')
                ->with('alert_message', $users->errors());
            }
            //Cancello tutti i gruppi dell'utente
            $db->table('auth_groups_users')
            ->where('user_id', $id)
            ->delete();

            $message = 'Utente aggiornato con successo.';
        } else {
            // Creazione nuovo utente
            $user = new User($data);
            if (!$users->save($user)) {
                return redirect()->back()->withInput()->with('errors', $users->errors());
            }
            $message = 'Nuovo utente creato con successo.';
        }
        // Aggiungo l'utente ai gruppi selezionati
        foreach ($selectedGroups as $group) {
            try {
                $user->addGroup($group);
            } catch (DatabaseException $e) {
                log_message('error', 'Errore nell\'aggiungere l\'utente al gruppo ' . $group . ': ' . $e->getMessage());
            }
        }

        return redirect()->to('utenti/')->with('alert', ['type' => 'success', 'message' => $message]);
    }
    public function approva ($id)
    {
        $users = auth()->getProvider();

        $user = $users
            ->withGroups()
            ->withPermissions()
            ->find($id);
        log_message('info', 'Utente trovato per approvazione: ' . print_r($user, true));
        if (!$user) {
            return redirect()->to('/utenti')->with('error', 'Utente non trovato.');
        }
        $user->groups = $user->getGroups();
        $user->permissions = $user->getPermissions();


        // Rimuovo il gruppo 'pending' e aggiungo il gruppo 'user'
        if (in_array('pending', $user->groups)) {
            try {
                $user->removeGroup('pending');
                $user->addGroup('user');
            } catch (DatabaseException $e) {
                log_message('error', 'Errore nell\'approvare l\'utente ID ' . $id . ': ' . $e->getMessage());
                return redirect()->to('/utenti')->with('error', 'Errore nell\'approvare l\'utente.');
            }
        } else {
            return redirect()->to('/utenti')->with('info', 'L\'utente non è in stato "pending".');
        }

        return redirect()->to('/utenti')->with('success', 'Utente approvato con successo.');
    }
    public function email($id)
    {
        // Logica per inviare email all'utente


    }
}
