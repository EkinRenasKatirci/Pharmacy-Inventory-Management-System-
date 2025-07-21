<?php
require __DIR__ . '/../../admin/mongo.php';

// 1. Fetch all distinct usernames who have active tickets
$usernames = $ticketsCol->distinct(
    'username',
    ['status' => true]
);

// 2. Figure out which user (if any) was selected
$selectedUser = $_GET['username'] ?? null;

// 3. If a user is selected, pull *all* of their active tickets into an array
$tickets = [];
if ($selectedUser) {
    $cursor = $ticketsCol->find([
        'username' => $selectedUser,
        'status'   => true
    ]);
    $tickets = iterator_to_array($cursor);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Support Tickets</title>

  <p><a href="/cs306_hw3/user/index.php">← Back to Home</a></p>

  <style>
    body { font-family: sans-serif; margin: 20px; }
    select, button { font-size: 1rem; }
    .ticket { border-bottom: 1px solid #ccc; padding: 8px 0; }
    .ticket h3 { margin: 0; }
  </style>
</head>
<body>
  <h1>Support Tickets</h1>

  <!-- User selector -->
  <form method="get">
    <label>
      Select user:
      <select name="username">
        <option value="">— Select —</option>
        <?php foreach ($usernames as $u): ?>
          <option value="<?= htmlspecialchars($u) ?>"
            <?= $u === $selectedUser ? 'selected' : '' ?>>
            <?= htmlspecialchars($u) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
    <button type="submit">View</button>
  </form>

  <p><a href="create.php">Create a Ticket</a></p>

  <hr>

  <h2>Results:</h2>

  <?php if (!$selectedUser): ?>
    <p><em>Please select a user to view their active tickets.</em></p>

  <?php elseif (count($tickets) === 0): ?>
    <p><strong>No active tickets found for “<?= htmlspecialchars($selectedUser) ?>”.</strong></p>

  <?php else: ?>
    <?php foreach ($tickets as $t): ?>
      <div class="ticket">
        <h3>Ticket #<?= htmlspecialchars($t['_id']) ?></h3>
        <p><strong>Status:</strong> <?= $t['status'] ? 'Active' : 'Resolved' ?></p>
        <p><strong>Created at:</strong> <?= htmlspecialchars($t['created_at']) ?></p>
        <p><strong>Description:</strong><br>
  <?= nl2br(htmlspecialchars($t['description'])) ?></p>
        <p><a href="detail.php?id=<?= htmlspecialchars($t['_id']) ?>">View Details</a></p>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

</body>
</html>
