<?php
require __DIR__ . '/../../config.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Attempt to INSERT — BEFORE INSERT trigger will block if expired
        $stmt = $pdo->prepare("
            INSERT INTO Order_Medicine (order_id, medicine_id, quantity)
            VALUES (:order_id, :medicine_id, :quantity)
        ");
        $stmt->execute([
            ':order_id'    => $_POST['order_id'],
            ':medicine_id' => $_POST['medicine_id'],
            ':quantity'    => $_POST['quantity'],
        ]);
        $message = ['type'=>'success','text'=>'✔️ Order placed (medicine not expired).'];
    } catch (PDOException $e) {
        $message = ['type'=>'error','text'=>'❌ Failed: '.htmlspecialchars($e->getMessage())];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Trigger: prevent_expired_medicine_order</title>
  <style>
    body { font-family: sans-serif; padding: 20px; }
    .success { color: green; }
    .error   { color: red; }
    button { margin-right: 10px; }
    fieldset { max-width: 400px; }
  </style>
</head>
<body>

  <h1>Trigger: <code>prevent_expired_medicine_order</code></h1>
  <p><em>Integrated by: <strong>Ekin Renas Katirci</strong></em></p>

  <p>
    Fires <strong>BEFORE INSERT</strong> on <code>Order_Medicine</code>.<br>
    Rejects if the referenced medicine’s <code>expiration_date &lt; CURDATE()</code>.
  </p>

  <form method="post">
    <fieldset>
      <legend>Place an order</legend>

      <label>Order ID:
        <input name="order_id" type="number" id="oid2" value="22" min="1" required>
      </label><br><br>

      <label>Medicine ID:
        <input name="medicine_id" type="number" id="mid2" value="14" min="1" required>
      </label><br><br>

      <label>Quantity:
        <input name="quantity" type="number" id="qty2" value="1" min="1" required>
      </label><br><br>

      <!-- Case buttons -->
      <button type="button"
              onclick="document.getElementById('oid2').value=22;document.getElementById('mid2').value=14;document.getElementById('qty2').value=1; this.form.submit();">
        Case 1: Valid (non-expired)
      </button>
      <button type="button"
              onclick="document.getElementById('oid2').value=23;document.getElementById('mid2').value=7; /*7 is expired*/ document.getElementById('qty2').value=1; this.form.submit();">
        Case 2: Invalid (expired)
      </button>
      <!-- Custom submit -->
      <button type="submit">Submit Custom</button>
    </fieldset>
  </form>

  <p><small><strong>Test Data:</strong>  
    Case 1 uses medicine_id=14 (exp 2026-12-31) → allowed.  
    Case 2 uses medicine_id=7  (exp 2024-11-25) → blocked.  
  </small></p>

  <?php if ($message): ?>
    <p class="<?= $message['type'] ?>"><?= $message['text'] ?></p>
  <?php endif; ?>

  <p><a href="../index.php">← Back to homepage</a></p>
</body>
</html>
