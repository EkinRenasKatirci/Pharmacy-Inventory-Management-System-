<?php
require __DIR__ . '/../../config.php';

$updated = null;
$error   = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // 1) Insert into Order_Medicine → fires AFTER INSERT trigger
        $ins = $pdo->prepare("
            INSERT INTO Order_Medicine (order_id, medicine_id, quantity)
            VALUES (:order_id, :medicine_id, :quantity)
        ");
        $ins->execute([
            ':order_id'    => $_POST['order_id'],
            ':medicine_id' => $_POST['medicine_id'],
            ':quantity'    => $_POST['quantity'],
        ]);

        // 2) Fetch updated stock
        $f = $pdo->prepare("
            SELECT medicine_id, stock_quantity
              FROM Pharmacy_Medicine
             WHERE medicine_id = ?
        ");
        $f->execute([ $_POST['medicine_id'] ]);
        $updated = $f->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $error = htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Trigger: update_stock_after_order</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    .success { color: green; }
    .error   { color: red; }
    button { margin-right: 10px; }
    fieldset { max-width: 400px; }
    pre { background: #f8f8f8; padding: 10px; border-radius: 4px; }
  </style>
</head>
<body>

  <h1>Trigger: <code>update_stock_after_order</code></h1>
  <p><em>Integrated by: <strong>Fikret Dara Aktaş</strong></em></p>

  <p>
    Fires <strong>AFTER INSERT</strong> on <code>Order_Medicine</code>.<br>
    Decrements <code>Pharmacy_Medicine.stock_quantity</code> by <code>NEW.quantity</code>.
  </p>

  <form method="post">
    <fieldset>
      <legend>Place an order</legend>

      <label>Order ID:
        <input name="order_id" type="number" id="oid3" value="22" min="1" required>
      </label><br><br>

      <label>Medicine ID:
        <input name="medicine_id" type="number" id="mid3" value="14" min="1" required>
      </label><br><br>

      <label>Quantity:
        <input name="quantity" type="number" id="qty3" value="5" min="1" required>
      </label><br><br>

      <!-- Case buttons -->
      <button type="button"
              onclick="document.getElementById('oid3').value=22;document.getElementById('mid3').value=14;document.getElementById('qty3').value=2; this.form.submit();">
        Case 1: Valid (quantity = 2)
      </button>
      <button type="button"
              onclick="document.getElementById('oid3').value=23;document.getElementById('mid3').value=15;document.getElementById('qty3').value=50; this.form.submit();">
        Case 2: Valid (quantity = 50)
      </button>
      <!-- Custom submit -->
      <button type="submit">Submit Custom</button>
    </fieldset>
  </form>

  <p><small><strong>Test Data:</strong>  
    Case 1 uses (22,14) — stock was 100, should go to 98.  
    Case 2 uses (23,15) — stock was 200, should go to 150.  
  </small></p>

  <?php if ($updated): ?>
    <h2 class="success">Updated Stock</h2>
    <pre><?= htmlspecialchars(json_encode($updated, JSON_PRETTY_PRINT)) ?></pre>
  <?php elseif ($error): ?>
    <p class="error">❌ Failed: <?= $error ?></p>
  <?php endif; ?>

  <p><a href="../index.php">← Back to homepage</a></p>
</body>
</html>
