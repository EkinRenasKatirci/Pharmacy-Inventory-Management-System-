<?php
require __DIR__ . '/../../config.php';

$rows = [];
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("CALL GetLowStockMedicines(:threshold)");
        $stmt->execute([':threshold' => $_POST['threshold']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Stored Procedure: GetLowStockMedicines</title>
  <style>
    body { font-family: sans-serif; padding:20px; }
    table { border-collapse: collapse; width: 50%; }
    th, td { border: 1px solid #ccc; padding: 8px; }
    .error { color: red; }
    fieldset { max-width: 300px; }
    button { margin-right: 10px; }
  </style>
</head>
<body>

  <h1>Stored Procedure: <code>GetLowStockMedicines</code></h1>
  <p><em>Integrated by: <strong>Fikret Dara Aktaş</strong></em></p>

  <p>
    Returns all medicines whose <code>stock_quantity &lt; p_threshold</code>.
  </p>

  <form method="post">
    <fieldset>
      <legend>Enter threshold</legend>
      <label>
        Threshold:
        <input name="threshold" id="thr" type="number" value="50" min="0" required>
      </label><br><br>

      <button type="button"
              onclick="document.getElementById('thr').value=50; this.form.submit();">
        Case 1: threshold = 50
      </button>
      <button type="button"
              onclick="document.getElementById('thr').value=10; this.form.submit();">
        Case 2: threshold = 10
      </button>
      <button type="submit">Submit Custom</button>
    </fieldset>
  </form>

  <p><small><strong>Test Data:</strong>
    Case 1 returns medicines with stock &lt; 50 (e.g. IDs 3, 5).  
    Case 2 returns stock &lt; 10 (e.g. ID 7).
  </small></p>

  <?php if ($error): ?>
    <p class="error">❌ Error: <?= $error ?></p>
  <?php elseif ($rows): ?>
    <h2>Results</h2>
    <table>
      <thead><tr><th>medicine_id</th><th>name</th><th>stock_quantity</th></tr></thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['medicine_id']) ?></td>
            <td><?= htmlspecialchars($r['name']) ?></td>
            <td><?= htmlspecialchars($r['stock_quantity']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <p><a href="../index.php">← Back to homepage</a></p>
</body>
</html>
