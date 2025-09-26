<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;
use App\Validation\PasswordRules; 

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        PasswordRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    /**14.08.2025 Marino aggiunge custom rules per utilizzare login solo per nome utente */    
    public array $login = [
        'username' => [
            'label' => 'Auth.username',
            'rules' => [
                'required',
                'max_length[254]',
                'min_length[3]',
            ],
        ],
        'password' => [
            'label'  => 'Auth.password',
            'rules'  => [
                'required',
                'max_length[255]'
            ],
            'errors' => [
                'max_byte' => 'Auth.errorPasswordTooLongBytes',
            ],
        ],

    ];
}
