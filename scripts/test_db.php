<?php
require 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM medicine LIMIT 5");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>📦 Sample Medicines</h2>";
    if (count($results) === 0) {
        echo "No records found.";
    } else {
        foreach ($results as $row) {
            echo "<pre>" . print_r($row, true) . "</pre>";
        }
    }
} catch (PDOException $e) {
    echo "❌ Query failed: " . $e->getMessage();
}
?>
