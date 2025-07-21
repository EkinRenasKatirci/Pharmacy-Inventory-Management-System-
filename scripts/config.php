<?php
$host = '127.0.0.1';     // or use 'localhost'
$port = 3306;            // default MySQL port
$user = 'root';          // your MySQL username
$password = 'Azadazs21';         // your MySQL password (if you have one)
$dbname = 'pharmacydb'; // name of your actual database

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}
?>
