<?php
// app/Controllers/DatabaseInfoController.php
namespace App\Controllers;

class DatabaseInfoController extends BaseController
{
    public function doppiodb()
    {
         // Connessione al primo DB (MySQLi)
        $db1 = db_connect('default', false);
        $query1 = $db1->query("
            SELECT 
                DATABASE() AS db_name,
                @@character_set_database AS encoding,
                @@collation_database AS collation,
                '' AS ctype
        ")->getRow();

        // Connessione al secondo DB (PostgreSQL)
        $db2 = db_connect('superba', false);
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
        return view('database/dbTestDoppio', [
            'db1' => $query1,
            'db2' => $query2
        ]);
    }
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            
            // Test connessione e codifica
            $query = $db->query("
                SELECT 
                    current_database() as db_name,
                    pg_encoding_to_char(encoding) as encoding,
                    datcollate as collation,
                    datctype as ctype
                FROM pg_database 
                WHERE datname = current_database()
            ");
            
            $result = $query->getRow();
            
            return view('database/dbTest', ['dbInfo' => $result]);
            
        } catch (\Exception $e) {
            // Passa l'errore alla view
            return view('database/dbTest', ['error' => $e->getMessage()]);
        }
    }

    public function getTableFields($tableName)
    {
        try {
            log_message('info', 'Richiesta campi per la tabella: ' . $tableName);
            $db = \Config\Database::connect();
            $schema = env('database.default.schema', 'public');
            
            $query = $db->query("
                SELECT column_name, data_type, is_nullable, column_default
                FROM information_schema.columns 
                WHERE table_name = ? AND table_schema = ?
                ORDER BY ordinal_position
            ", [$tableName, $schema]);
            $result = $query->getResultArray();
            log_message('info', 'Ho eseguito la query per ottenere i campi della tabella: ' . $tableName);
            //log_message('info', 'Risultato: ' . print_r($result, true));
            $allowedFields = [];
            foreach ($result as $key => $value) {
                $allowedFields[] = $value['column_name'];
            }

            log_message('info', 'Campi consentiti: ' . print_r($allowedFields, true));
            return view('database/dbFields', ['fields' => $result, 'table_name' => $tableName, 'allowed_fields' => $allowedFields]);
            
        } catch (\Exception $e) {
            log_message('error', 'Errore nel recupero campi: ' . $e->getMessage());
            return view('database/dbFields', ['error' => $e->getMessage()]);
        }
    }

    public function info()
    {
        try {
            $db = \Config\Database::connect();
            $schema = env('database.default.schema', 'public');
            
            // Ottieni informazioni database
            $dbInfo = $db->query("
                SELECT 
                    current_database() as db_name,
                    pg_encoding_to_char(encoding) as encoding,
                    datcollate as collation,
                    datctype as ctype
                FROM pg_database 
                WHERE datname = current_database()
            ")->getRow();
            
            // Tabelle dello schema
            $tables = $db->query("
                SELECT tablename 
                FROM pg_tables 
                WHERE schemaname = ? 
                ORDER BY tablename
            ", [$schema])->getResult();
            
            // Struttura tbana
            $columns_tbana = $db->query("
                SELECT column_name, data_type, is_nullable, column_default
                FROM information_schema.columns 
                WHERE table_name = 'tbana' 
                AND table_schema = ?
                ORDER BY ordinal_position
            ", [$schema])->getResult();
            
            // Struttura tblic
            $columns_tblic = $db->query("
                SELECT column_name, data_type, is_nullable, column_default
                FROM information_schema.columns 
                WHERE table_name = 'tblic' 
                AND table_schema = ?
                ORDER BY ordinal_position
            ", [$schema])->getResult();
            
            $data = [
                'dbInfo' => $dbInfo,
                'schema' => $schema,
                'tables' => $tables,
                'columns_ana' => $columns_tbana,
                'columns_lic' => $columns_tblic, 
            ];
            
            return view('database/dbInfo', $data);
            
        } catch (\Exception $e) {
            return view('database/dbTest', ['error' => $e->getMessage()]);
        }
    }
}