<?php
$dbParams = [
    'host' => 'localhost',
    'dbname' => 'userApiRest',
    'username' => 'root',
    'password' => '',
];

try {
    $db = new PDO("mysql:host={$dbParams['host']};dbname={$dbParams['dbname']}", $dbParams['username'], $dbParams['password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit;
}
