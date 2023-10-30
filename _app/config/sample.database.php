<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;


$db['default'] = array(
        'dsn'   => '',
        'hostname' => 'HOSTNAME, PORT',
        'username' => 'USERNAME',
        'password' => 'PASSWORD',
        'database' => 'DB_NAME',
        'dbdriver' => 'sqlsrv',
        'dbprefix' => '',
        'pconnect' => FALSE,
        'db_debug' => (ENVIRONMENT !== 'production'),
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt' => FALSE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array(),
        'save_queries' => TRUE
);


$db['stagging'] = array(
        'dsn'   => '',
        'hostname' => '192.168.100.171, 1433',
        'username' => 'sa',
        'password' => '!@#Jogja!@#',
        'database' => 'siks_staging',
        'dbdriver' => 'sqlsrv',
        'dbprefix' => '',
        'pconnect' => FALSE,
        'db_debug' => (ENVIRONMENT !== 'production'),
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci',
        'swap_pre' => '',
        'encrypt' => FALSE,
        'compress' => FALSE,
        'stricton' => FALSE,
        'failover' => array(),
        'save_queries' => TRUE
);
