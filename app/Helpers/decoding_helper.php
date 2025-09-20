<?php
if (! function_exists('decodingTipo')) {
    function decodingTipo($tipo): string
    {
        log_message('info', 'Decoding tipo: ' . $tipo);
        switch ($tipo) {
            case 'SI':
                return 'Sigla';
            case 'VA':
                return 'VarHub';
            case 'SK':
                return 'SKNT';
            default:
                return 'Nessuno';
        }
    }
}
if (! function_exists('decodingModello')) {
    function decodingModello($modello): string
    {
        log_message('info', 'Decoding modello: ' . $modello);
        switch ($modello) {
            case 'S':
                return 'Start';
            case 'U':
                return 'Ultimate';
            case 'C':
                return 'Cloud';
            default:
                return 'Nessuno';
        }
    }
}