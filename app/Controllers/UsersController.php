<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
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
            'title'     => 'Gestione Utenti',
            'usersList' => $usersList,
        ]);
    }

    public function visualizza($id)
    {
        $users = auth()->getProvider();
        $user  = $users
            ->withGroups()
            ->withPermissions()
            ->find($id);

        if (!$user) {
            return redirect()->to('/utenti')->with('alert', [
                'type'    => 'danger',
                'message' => 'Utente non trovato.',
            ]);
        }

        return view('users/form', [
            'title'          => 'Dettagli Utente: ' . esc($user->username),
            'mode'           => 'view',
            'action'         => '',
            'user'           => $user,
            'allGroups'      => config('AuthGroups')->groups,
            'allPermissions' => config('AuthGroups')->permissions,
        ]);
    }

    public function modifica($id)
    {
        $users = auth()->getProvider();
        $user  = $users
            ->withGroups()
            ->withPermissions()
            ->find($id);

        if (!$user) {
            return redirect()->to('/utenti')->with('alert', [
                'type'    => 'danger',
                'message' => 'Utente non trovato.',
            ]);
        }

        return view('users/form', [
            'title'          => 'Modifica Utente: ' . esc($user->username),
            'mode'           => 'edit',
            'action'         => base_url('/utenti/salva/' . $id),
            'user'           => $user,
            'allGroups'      => config('AuthGroups')->groups,
            'allPermissions' => config('AuthGroups')->permissions,
        ]);
    }
    public function elimina($id)
    {
        $users = auth()->getProvider();
        $user  = $users->find($id);

        if (!$user) {
            return redirect()->to('/utenti')->with('alert', [
                'type'    => 'danger',
                'message' => 'Utente non trovato.',
            ]);
        }

        try {
            $users->delete($id);
        } catch (DatabaseException $e) {
            return redirect()->to('/utenti')->with('alert', [
                'type'    => 'danger',
                'message' => 'Errore nell\'eliminazione utente.',
            ]);
        }

        return redirect()->to('/utenti')->with('alert', [
            'type'    => 'success',
            'message' => 'Utente eliminato con successo.',
        ]);
    }
    
    public function salva($id = null)
    {
        if (!$id) {
            return redirect()->to('/utenti')->with('alert', [
                'type'    => 'warning',
                'message' => 'La creazione utenti avviene solo dal frontend.',
            ]);
        }

        $users = auth()->getProvider();
        $data  = $this->request->getPost();

        $user = $users->find($id);
        if (!$user) {
            return redirect()->to('/utenti')->with('alert', [
                'type'    => 'danger',
                'message' => 'Utente non trovato.',
            ]);
        }

        // Aggiornamento campi base
        $user->username = $data['username'];
        $user->email    = $data['email'];

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('alert', [
                'type'    => 'danger',
                'message' => $users->errors(),
            ]);
        }

        // Gestione gruppi selezionati
        $db = db_connect();
        $db->table('auth_groups_users')->where('user_id', $id)->delete();
        $selectedGroups = $this->request->getPost('groups') ?? [];
        foreach ($selectedGroups as $group) {
            try {
                $user->addGroup($group);
            } catch (DatabaseException $e) {
                log_message('error', "Errore nell'aggiungere utente al gruppo $group: " . $e->getMessage());
            }
        }

        return redirect()->to('/utenti')->with('alert', [
            'type'    => 'success',
            'message' => 'Utente aggiornato con successo.',
        ]);
    }

    public function approva($id)
    {
        $users = auth()->getProvider();
        $user  = $users->withGroups()->withPermissions()->find($id);
        $siteConfig = config('SiteConfig');

        if (!$user) {
            return redirect()->to('/utenti')->with('alert', [
                'type'    => 'danger',
                'message' => 'Utente non trovato.',
            ]);
        }

        if (in_array('pending', $user->getGroups())) {
            try {
                $user->removeGroup('pending');
                $user->addGroup('user');
                // ==== Invio email di notifica approvazione ====
                $admin = config('SiteConfig')->adminEmail;
                $email = \Config\Services::email();
                $email->setFrom($admin, 'MeTe Licenze Admin');
                $email->setTo($user->email);
                $email->setSubject('Account Approvato');
                $content = "
                    <p>Ciao <strong>" . esc($user->username) . "</strong>,</p>
                    <p>Il tuo account è stato approvato. Ora puoi effettuare il login.</p>
                     <p><a href='{$siteConfig->siteURL}/login' class='button'>Accedi al gestionale</a></p>
                    ";
                $message = view('emails/layout', [
                    'title'   => 'Account approvato su MeTe Licenze',
                    'content' => $content
                ]);
                $email->setMessage($message);

                $email->setMailType('html');
                if (!$email->send()) {
                    log_message('error', "Errore nell'invio della mail di approvazione a {$user->email}: " . $email->printDebugger(['headers', 'subject', 'body']));
                }
            } catch (DatabaseException $e) {
                log_message('error', "Errore nell'approvare utente $id: " . $e->getMessage());
                return redirect()->to('/utenti')->with('alert', [
                    'type'    => 'danger',
                    'message' => 'Errore nell\'approvazione utente.',
                ]);
            }
        } else {
            return redirect()->to('/utenti')->with('alert', [
                'type'    => 'info',
                'message' => 'L\'utente non è in stato pending.',
            ]);
        }

        return redirect()->to('/utenti')->with('alert', [
            'type'    => 'success',
            'message' => 'Utente approvato con successo.',
        ]);
    }
}
