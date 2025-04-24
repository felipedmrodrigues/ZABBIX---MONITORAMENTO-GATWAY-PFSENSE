#!/usr/bin/php
<?php
require_once("/etc/inc/config.lib.inc");
require_once("/etc/inc/gwlb.inc");

function return_gateways_status($debug = false) {
    $status = return_gateway_groups_array(true);
    $data = [];
    foreach ($status as $gateway => $info) {
        $data[] = [
            "name" => $gateway,
            "ip" => $info['monitor'],
            "status" => $info['status'],
            "delay" => $info['delay'],
            "loss" => $info['loss'],
            "stddev" => $info['stddev'],
            "descr" => $info['descr']
        ];
    }
    if ($debug) {
        print_r($data);
    }
    return $data;
}
?>
