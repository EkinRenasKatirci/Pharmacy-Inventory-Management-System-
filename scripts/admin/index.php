<?php
// admin/index.php
require __DIR__ . '/mongo.php';   // your MongoDB setup, same as in user side

// fetch all active tickets
$cursor = $ticketsCol->find([ 'status' => true ], [
  'sort' => [ 'created_at' => -1 ]
]);
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><title>Admin — Ticket List</title>
  <style>body{font-family:sans-serif;} .ticket{border:1px solid #ccc;padding:10px;margin:10px 0;} </style>
</head>
<body>
  <h1>Admin Dashboard — Active Tickets</h1>
  <p><a href="../user/index.php">← Back to User Home</a></p>
  <?php if ($cursor->isDead()): ?>
    <p>No active tickets.</p>
  <?php else: ?>
    <?php foreach ($cursor as $t): ?>
      <div class="ticket">
        <h3>Ticket #<?= htmlspecialchars((string)$t['_id']) ?></h3>
        <p><strong>User:</strong> <?= htmlspecialchars($t['username']) ?></p>
        <p><strong>Created:</strong> <?= htmlspecialchars($t['created_at']) ?></p>
        <p><strong>Message:</strong><br><?= nl2br(htmlspecialchars($t['description'])) ?></p>
        <p><a href="detail.php?id=<?= htmlspecialchars((string)$t['_id']) ?>">→ View Details</a></p>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</body>
</html>
