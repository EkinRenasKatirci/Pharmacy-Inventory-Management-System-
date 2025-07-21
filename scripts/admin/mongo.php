<?php
require __DIR__ . '/../vendor/autoload.php';

try {
    // MongoDB istemcisi oluşturuluyor
    $client = new MongoDB\Client("mongodb://localhost:27017");

    // cs306_hw3 veritabanını seç
    $db = $client->cs306_hw3;

    // tickets koleksiyonunu seç
    $ticketsCol = $db->tickets;

} catch (Exception $e) {
    die("MongoDB connection failed: " . $e->getMessage());
}
?>
