<?php
// app/Controllers/DatabaseInfoController.php
namespace App\Controllers;

class DatabaseInfoController extends BaseController
{
    public function connectionTest()
    {
        // Connessione al primo DB (MySQLi)
        $connectionGroup1 = 'default';
        $db1 = db_connect($connectionGroup1, false);
        $driver1 = $db1->DBDriver;

        log_message('info', 'Driver del primo database: ' . $driver1);
        $query1 = $db1->query("
            SELECT 
                DATABASE() AS db_name,
                @@character_set_database AS encoding,
                @@collation_database AS collation,
                '' AS ctype
        ")->getRow();

        // Connessione al DB esterno  (PostgreSQL)
        $connectionGroup2 = 'external';
        $db2 = db_connect($connectionGroup2, false);

        $driver2 = $db2->DBDriver;
        log_message('info', 'Driver del secondo database: ' . $driver2);
        $query2 = $db2->query("
            SELECT 
                current_database() AS db_name,
                pg_encoding_to_char(encoding) AS encoding,
                datcollate AS collation,
                datctype AS ctype
            FROM pg_database 
            WHERE datname = current_database()
        ")->getRow();

        // Passa i dati alla view
        $data = [
            'db1'           => $query1,
            'db1_driver'    => $driver1,
            'db1_connection_group' => $connectionGroup1,
            'db2'           => $query2,
            'db2_driver'    => $driver2,
            'db2_connection_group' => $connectionGroup2,
            'title'         => 'Test Connessioni Database',
        ];
        return view('database/dbConnectionTest', $data);
    }

    /**
     * Visualizza le informazioni del database specificato
     * Uso interno alla classe per evitare duplicazioni
     **/
    private function getDatabaseInfo($database)
    {
        // Connessione al database
        $db = db_connect($database, false);
        $config = config('Database');
        $schema = $config->{$database}['schema'] ?? null;
        $driver = $db->DBDriver;
        $db = [
            'db_name'  => $db->getDatabase(),
            // Recupera encoding, collation e ctype tramite query SQL
            'encoding' => $db->query("SELECT @@character_set_database AS encoding")->getRow('encoding') ?? null,
            'collation' => $db->query("SELECT @@collation_database AS collation")->getRow('collation') ?? null,
            'ctype' => null, // MySQL non ha ctype, per PostgreSQL serve una query diversa
            'schema' => $schema,
            'driver'    => $driver,
            'connection_group' => $database,
            'connection' => $db,
        ];
    }

    public function getTableFields($database = 'default', $tableName = '')
    {
        log_message('info', 'Richiesta campi per la tabella: ' . $tableName . ' nel database: ' . $database);

        try {
            // Connessione diretta
            $db = db_connect($database, false);
            $driver = $db->DBDriver;

            // Imposta schema per PostgreSQL
            $schema = null;
            if ($driver === 'Postgre') {
                $config = config('Database');
                $schema = $config->{$database}['schema'] ?? 'public';
            }

            // Esegui query in base al driver
            switch ($driver) {
                case 'MySQLi':
                    // Per MySQL lo "schema" è il database stesso
                    $dbName = $db->database ?? null;
                    $query = $db->query("
                    SELECT COLUMN_NAME as column_name,
                           COLUMN_TYPE as data_type,
                           IS_NULLABLE as is_nullable,
                           COLUMN_DEFAULT as column_default
                    FROM information_schema.columns
                    WHERE table_name = ? AND table_schema = ?
                    ORDER BY ORDINAL_POSITION
                ", [$tableName, $dbName]);
                    break;

                case 'Postgre':
                    $query = $db->query("
                    SELECT column_name, data_type, is_nullable, column_default
                    FROM information_schema.columns
                    WHERE table_name = ? AND table_schema = ?
                    ORDER BY ordinal_position
                ", [$tableName, $schema]);
                    break;

                default:
                    throw new \Exception("Driver $driver non supportato per la lettura dei campi");
            }

            $result = $query->getResultArray();

            // Lista dei nomi dei campi
            $allowedFields = array_filter(
                array_column($result, 'column_name'),
                fn($field) => $field !== 'id'
            );

            return view('database/dbFields', [
                'fields' => $result,
                'table_name' => $tableName,
                'allowed_fields' => $allowedFields
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Errore nel recupero campi: ' . $e->getMessage());
            return view('database/dbFields', [
                'error' => $e->getMessage(),
                'table_name' => $tableName
            ]);
        }
    }


    public function showLog()
    {
        log_message('info', 'Richiesta visualizzazione log per il database');
        // Percorso del file di log
        $default = db_connect('default', false);
        $defaultDriver = $default->DBDriver;

        $folder_default = $default->query("SHOW VARIABLES LIKE 'datadir';");
        $log_file_default = $default->query("SHOW VARIABLES where variable_name = 'log_error'");
        echo 'Folder default: ' . $folder_default->getRow()->Value . '<br>';
        echo 'Log file default: ' . $log_file_default->getRow()->Value . '<br>';
        $path_default = $folder_default->getRow()->Value. $log_file_default->getRow()->Value;
        log_message('info', 'Percorso del log per il database default: ' . $path_default);
        echo $path_default;
        die();

        $external = db_connect('external', false);

        $file = WRITEPATH . 'logs/db_log.txt'; // oppure dove tieni il file
        $lines = [];

        if (is_file($file)) {
            $lines = file($file, FILE_IGNORE_NEW_LINES);
        }

        return view('log_database', [
            'file_name' => basename($file),
            'log_lines' => $lines
        ]);
    }




    public function info($connectionGroup = 'default')
    {
        log_message('info', 'Richiesta informazioni per il database: ' . $connectionGroup);

        try {
            // Connessione al database
            $db = db_connect($connectionGroup, false);
            $config = config('Database');
            $schema = $config->{$connectionGroup}['schema'] ?? null;

            // Driver del database
            $driver = $db->DBDriver;
            log_message('info', 'Schema utilizzato: ' . $schema);
            log_message('info', 'Driver del database: ' . $driver);

            switch ($driver) {
                case 'MySQLi':
                    log_message('info', 'Driver MySQLi rilevato');

                    $dbInfoRaw = $db->query("
                    SELECT 
                        DATABASE() AS db_name,
                        @@character_set_database AS charset,
                        @@collation_database AS collation
                ")->getRow();

                    // Normalizzo le proprietà per la view
                    $dbInfo = (object)[
                        'db_name'   => $dbInfoRaw->db_name,
                        'encoding'  => $dbInfoRaw->charset,
                        'collation' => $dbInfoRaw->collation,
                        'ctype'     => null
                    ];

                    // Tabelle dello schema
                    $tables = $db->query("
                    SELECT table_name AS tablename
                    FROM information_schema.tables
                    WHERE table_schema = ?
                    ORDER BY table_name
                ", [$dbInfo->db_name])->getResult();
                    break;

                case 'Postgre':
                    log_message('info', 'Driver PostgreSQL rilevato');

                    // Informazioni sul database
                    $dbInfoRaw = $db->query("
                    SELECT 
                        current_database() AS db_name,
                        pg_encoding_to_char(encoding) AS encoding,
                        datcollate AS collation,
                        datctype AS ctype
                    FROM pg_database 
                    WHERE datname = current_database()
                ")->getRow();

                    // Normalizzo le proprietà per la view
                    $dbInfo = (object)[
                        'db_name'   => $dbInfoRaw->db_name,
                        'encoding'  => $dbInfoRaw->encoding,
                        'collation' => $dbInfoRaw->collation,
                        'ctype'     => $dbInfoRaw->ctype
                    ];

                    // Tabelle dello schema
                    $tables = $db->query("
                    SELECT tablename 
                    FROM pg_tables 
                    WHERE schemaname = ? 
                    ORDER BY tablename
                ", [$schema])->getResult();
                    break;

                default:
                    throw new \Exception("Driver $driver non supportato");
            }

            $data = [
                'dbInfo'   => $dbInfo,
                'schema'   => $schema,
                'tables'   => $tables,
                'title'    => 'Informazioni Database',
                'database' => $connectionGroup,
            ];

            return view('database/dbInfo', $data);
        } catch (\Exception $e) {
            return view('database/dbTest', ['error' => $e->getMessage()]);
        }
    }
}
