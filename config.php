<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'devnotes');
define('DB_USER', 'root');
define('DB_PASS', '');
define('METHOD', $_SERVER['REQUEST_METHOD']);

$pdo = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS);

$apiReturn = [
    'error' => false,
    'message' => 'Success',
    'result' => []
];
