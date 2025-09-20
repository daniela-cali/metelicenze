<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class DatatablesToAssets extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'datatables:toassets';
    protected $description = 'Copia tutti i pacchetti DataTables da vendor/node_modules a public/assets/datatables';

    public function run(array $params)
    {
        // sorgente: puoi cambiare in base alla tua installazione
        $vendorBase = ROOTPATH . 'vendor/datatables.net/';
        $targetBase = FCPATH . 'assets/datatables/';

        if (! is_dir($vendorBase)) {
            CLI::error('❌ Directory vendor/datatables/ non trovata!');
            return;
        }

        // elenco pacchetti DataTables da copiare
        $packages = [
            'datatables.net',
            'datatables.net-bs5',
            'datatables.net-buttons',
            'datatables.net-buttons-bs5',
            'datatables.net-fixedheader',
            'datatables.net-fixedheader-bs5',
        ];

        foreach ($packages as $pkg) {
            $src = $vendorBase . $pkg;
            $dst = $targetBase . $pkg;

            if (! is_dir($src)) {
                CLI::write("⚠️  Pacchetto non trovato: $pkg", 'yellow');
                continue;
            }

            // crea cartella di destinazione
            if (! is_dir($dst)) {
                mkdir($dst, 0777, true);
            }

            // copia ricorsiva
            $this->copyRecursive($src, $dst);
            CLI::write("✅ Copiato: $pkg", 'green');
        }

        CLI::write('🎉 Tutti i pacchetti DataTables copiati in public/assets/datatables/', 'green');
    }

    private function copyRecursive($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst, 0777, true);

        while (false !== ($file = readdir($dir))) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $srcPath = $src . '/' . $file;
            $dstPath = $dst . '/' . $file;

            // ❌ salta le cartelle types
            if ($file === 'types') {
                continue;
            }

            if (is_dir($srcPath)) {
                $this->copyRecursive($srcPath, $dstPath);
            } else {
                // copia solo .js e .css
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if (in_array($ext, ['js', 'css'])) {
                    copy($srcPath, $dstPath);
                }
            }
        }

        closedir($dir);
    }
}
