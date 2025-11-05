<?php
// db_connect.php

$host = '127.0.0.1'; // '127.0.0.1' es a veces más confiable que 'localhost'
$db   = 'libro'; // Tu base de datos
$user = 'root'; // Tu usuario
$pass = 'root_password'; // Tu contraseña
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e.getMessage(), (int)$e.getCode());
}
?>