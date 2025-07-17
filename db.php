<?php
$config = require __DIR__ . '/config.php';

try {
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $config['db']['host'], $config['db']['name']);
    $pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
