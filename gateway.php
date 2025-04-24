#!/usr/local/bin/php
<?php
require_once("/etc/inc/globals.inc");
require_once("/etc/inc/functions.inc");
require_once("classes/autoload.inc.php");

function getGateways() {
    $a_gateways = return_gateways_array();
    $dados = array();
    foreach ($a_gateways as $gw) {
        $dados[] = [
            '{#NAME}' => strtoupper($gw['name']),
            '{#GW}'   => strtoupper($gw['gateway']),
        ];
    }
    return $dados;
}

function getStatusGateways($nome, $item) {
    $gateways_status = return_gateways_status(true);

    if (empty($nome) || empty($item)) {
        echo 'ZBX_NOTSUPPORTED';
        return;
    }

    if (!isset($gateways_status[$nome][$item])) {
        echo 'ZBX_NOTSUPPORTED';
        return;
    }

    $valor = strtolower($gateways_status[$nome][$item]);

    if ($item == 'status') {
        switch ($valor) {
            case 'none':
            case 'online':
                echo 1; break;
            case 'down':
                echo 0; break;
            case 'loss':
                echo 2; break;
            case 'delay':
                echo 3; break;
            default:
                echo 4; break;
        }
    } else {
        echo 'ZBX_NOTSUPPORTED';
    }
}

// Dispatcher
if (isset($argv[1]) && $argv[1] == 'discovery') {
    echo json_encode(['data' => getGateways()], JSON_UNESCAPED_UNICODE);
} elseif (isset($argv[1]) && isset($argv[2])) {
    getStatusGateways($argv[1], $argv[2]);
} else {
    echo 'ZBX_NOTSUPPORTED';
}
