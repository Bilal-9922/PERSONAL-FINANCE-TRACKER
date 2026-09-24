<?php
declare(strict_types=1);

$host = 'sql204.infinityfree.com';
$db   = 'if0_43001795_FINANCETRACKER';
$user = 'if0_43001795';
$pass = 'qCnJPqILV0';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    exit('Database connection failed. Please check config/database.php and make sure MySQL is running.');
}
?>
