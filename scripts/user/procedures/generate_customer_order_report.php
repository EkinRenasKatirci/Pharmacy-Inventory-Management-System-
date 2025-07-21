<?php
require __DIR__ . '/../../config.php';

$report = null;
$error  = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("CALL GenerateCustomerOrderReport(:cid)");
        $stmt->execute([':cid' => $_POST['customer_id']]);
        $report = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error = htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Stored Procedure: GenerateCustomerOrderReport</title>
  <style>
    body { font-family: sans-serif; padding:20px; }
    dl { margin-top: 20px; }
    .error { color: red; }
    fieldset { max-width: 300px; }
    button { margin-right: 10px; }
  </style>
</head>
<body>

  <h1>Stored Procedure: <code>GenerateCustomerOrderReport</code></h1>
  <p><em>Integrated by: <strong>Ekin Renas Katırcı</strong></em></p>

  <p>
    Returns total orders, total spent, and date of last order for a given customer.
  </p>

  <form method="post">
    <fieldset>
      <legend>Select Customer</legend>
      <label>
        Customer ID:
        <input name="customer_id" id="cid" type="number" value="1" min="1" required>
      </label><br><br>

      <button type="button"
              onclick="document.getElementById('cid').value=1; this.form.submit();">
        Case 1: Customer 1
      </button>
      <button type="button"
              onclick="document.getElementById('cid').value=5; this.form.submit();">
        Case 2: Customer 5
      </button>
      <button type="submit">Submit Custom</button>
    </fieldset>
  </form>

  <p><small><strong>Test Data:</strong>
    Case 1 (ID 1) has 3 orders, spent $150, last on 2025-05-01.  
    Case 2 (ID 5) has 2 orders, spent $90, last on 2025-02-05.
  </small></p>

  <?php if ($error): ?>
    <p class="error">❌ Error: <?= $error ?></p>
  <?php elseif ($report): ?>
    <h2>Report</h2>
    <dl>
      <dt>Total Orders:</dt>       <dd><?= htmlspecialchars($report['total_orders']) ?></dd>
      <dt>Total Amount Spent:</dt><dd><?= htmlspecialchars($report['total_amount']) ?></dd>
      <dt>Last Order Date:</dt>   <dd><?= htmlspecialchars($report['last_order_date']) ?></dd>
    </dl>
  <?php endif; ?>

  <p><a href="../index.php">← Back to homepage</a></p>
</body>
</html>
