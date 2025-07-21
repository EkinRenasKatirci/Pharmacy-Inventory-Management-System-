<?php
require __DIR__ . '/../../config.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Attempt to INSERT — BEFORE INSERT trigger will block if quantity = 0
        $stmt = $pdo->prepare("
            INSERT INTO Order_Medicine (order_id, medicine_id, quantity)
            VALUES (:order_id, :medicine_id, :quantity)
        ");
        $stmt->execute([
            ':order_id'    => $_POST['order_id'],
            ':medicine_id' => $_POST['medicine_id'],
            ':quantity'    => $_POST['quantity'],
        ]);
        $message = ['type' => 'success', 'text' => '✔️ Order placed (quantity > 0).'];
    } catch (PDOException $e) {
        $message = ['type' => 'error', 'text' => '❌ Failed: ' . htmlspecialchars($e->getMessage())];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Trigger: prevent_zero_quantity_orders</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    .success { color: green; }
    .error   { color: red; }
    button { margin-right: 10px; }
    fieldset { max-width: 400px; }
  </style>
</head>
<body>

  <h1>Trigger: <code>prevent_zero_quantity_orders</code></h1>
  <p><em>Integrated by: <strong>Başar Zaim</strong></em></p>

  <p>
    Fires <strong>BEFORE INSERT</strong> on <code>Order_Medicine</code>.<br>
    Rejects any new row where <code>NEW.quantity = 0</code> by signalling SQLSTATE <code>45000</code>.
  </p>

  <form method="post">
    <fieldset>
      <legend>Place an order</legend>

      <label>Order ID:
        <input name="order_id" type="number" id="oid" value="22" min="1" required>
      </label><br><br>

      <label>Medicine ID:
        <input name="medicine_id" type="number" id="mid" value="14" min="1" required>
      </label><br><br>

      <label>Quantity:
        <input name="quantity" type="number" id="qty" value="1" min="0" required>
      </label><br><br>

      <!-- Case buttons -->
      <button type="button"
              onclick="document.getElementById('oid').value=22;document.getElementById('mid').value=14;document.getElementById('qty').value=5; this.form.submit();">
        Case 1: Valid (quantity = 5)
      </button>
      <button type="button"
              onclick="document.getElementById('oid').value=23;document.getElementById('mid').value=15;document.getElementById('qty').value=0; this.form.submit();">
        Case 2: Invalid (quantity = 0)
      </button>
      <!-- Custom submit -->
      <button type="submit">Submit Custom</button>
    </fieldset>
  </form>

  <p><small><strong>Test Data:</strong>  
    Case 1 uses (order_id=22, medicine_id=14) — stock must go down.  
    Case 2 uses (order_id=23, medicine_id=15) — blocked by trigger.  
  </small></p>

  <?php if ($message): ?>
    <p class="<?= $message['type'] ?>"><?= $message['text'] ?></p>
  <?php endif; ?>

  <p><a href="../index.php">← Back to homepage</a></p>
</body>
</html>
