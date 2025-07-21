<?php
require __DIR__ . '/../../config.php';

$success = null;
$error   = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("
            CALL CreateOrderWithStockUpdate(:cid, :mid, :qty)
        ");
        $stmt->execute([
            ':cid' => $_POST['customer_id'],
            ':mid' => $_POST['medicine_id'],
            ':qty' => $_POST['quantity']
        ]);
        $success = '✔️ Order created and stock updated.';
    } catch (PDOException $e) {
        $error = htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Stored Procedure: CreateOrderWithStockUpdate</title>
  <style>
    body { font-family: sans-serif; padding:20px; }
    .success { color: green; }
    .error   { color: red; }
    fieldset { max-width: 400px; }
    button { margin-right: 10px; }
  </style>
</head>
<body>

  <h1>Stored Procedure: <code>CreateOrderWithStockUpdate</code></h1>
  <p><em>Integrated by: <strong>Başar Zaim</strong></em></p>

  <p>
    Inserts a new order for a customer, adds to <code>Order_Medicine</code>,  
    and via triggers automatically updates stock.
  </p>

  <form method="post">
    <fieldset>
      <legend>Create order</legend>

      <label>Customer ID:
        <input name="customer_id" id="cid3" type="number" value="1" min="1" required>
      </label><br><br>

      <label>Medicine ID:
        <input name="medicine_id" id="mid3b" type="number" value="14" min="1" required>
      </label><br><br>

      <label>Quantity:
        <input name="quantity" id="qty3b" type="number" value="3" min="1" required>
      </label><br><br>

      <button type="button"
              onclick="document.getElementById('cid3').value=1;document.getElementById('mid3b').value=14;document.getElementById('qty3b').value=2; this.form.submit();">
        Case 1: Cust=1, Med=14, Qty=2
      </button>
      <button type="button"
              onclick="document.getElementById('cid3').value=2;document.getElementById('mid3b').value=17;document.getElementById('qty3b').value=5; this.form.submit();">
        Case 2: Cust=2, Med=17, Qty=5
      </button>
      <button type="submit">Submit Custom</button>
    </fieldset>
  </form>

  <p><small><strong>Test Data:</strong>
    Case 1 → customer 1 & medicine 14 (stock 100) → new orderId 22, stock→98.  
    Case 2 → customer 2 & medicine 17 (stock 250) → new orderId 23, stock→245.
  </small></p>

  <?php if ($error): ?>
    <p class="error">❌ Error: <?= $error ?></p>
  <?php elseif ($success): ?>
    <p class="success"><?= $success ?></p>
  <?php endif; ?>

  <p><a href="../index.php">← Back to homepage</a></p>
</body>
</html>
