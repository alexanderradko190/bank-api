<?php
require_once __DIR__ . '/vendor/autoload.php'; // Это важно!

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo 'getenv: ';
var_dump(getenv('DB_HOST'));
echo '$_ENV: ';
var_dump($_ENV['DB_HOST'] ?? null);
echo '$_SERVER: ';
var_dump($_SERVER['DB_HOST'] ?? null);
