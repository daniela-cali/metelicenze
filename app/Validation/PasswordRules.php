<?php

namespace App\Validation;

use CodeIgniter\Shield\Authentication\Passwords;

class PasswordRules
{
    public function checkCurrentPassword()
    {

        return true;
    }
}
