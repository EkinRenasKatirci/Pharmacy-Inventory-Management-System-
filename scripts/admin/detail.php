<?php
// admin/ticket_details.php
require __DIR__ . '/mongo.php';

$id = $_GET['id'] ?? null;
if (!$id) die("No ticket ID provided.");

$oid    = new MongoDB\BSON\ObjectId($id);
$ticket = $ticketsCol->findOne([ '_id' => $oid ]);
if (!$ticket) die("Ticket not found.");

// Handle POST: either add admin comment or mark resolved
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 1) Add comment
  if (!empty($_POST['comment'])) {
    $ticketsCol->updateOne(
      ['_id' => $oid],
      ['$push' => ['comments' => [
         'username' => 'admin',           // admin always writes under "username"
         'text'     => $_POST['comment'],
         'at'       => date('c'),
      ]]]
    );
  }

  // 2) Mark as resolved
  if (isset($_POST['resolve'])) {
    $ticketsCol->updateOne(
      ['_id' => $oid],
      ['$set' => ['status' => false]]
    );
    header("Location: index.php");
    exit;
  }

  // reload to show updated list
  header("Location: detail.php?id=$id");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin — Ticket Details</title>
  <style>
    body { font-family: sans-serif; padding: 1rem; max-width: 800px; margin: 0; }
    h1,h2,h3 { margin-top: 1.5rem; }
    p { margin: .5rem 0; }
    hr { margin: 2rem 0; }
    .comment { border-bottom:1px solid #ddd; padding: .5rem 0; }
    textarea { width: 100%; min-height: 80px; }
    button { margin-right: .5rem; }
    .meta { color: #555; font-size: .9em; }
  </style>
</head>
<body>
  <h1>Admin — Ticket Details</h1>
  <p>
    <a href="index.php">← Back to Ticket List</a>
    &nbsp;|&nbsp;
    <a href="../user/index.php">← Back to User Home</a>
  </p>

  <h2>Ticket #<?= htmlspecialchars($id) ?></h2>
  <p><strong>User:</strong> <?= htmlspecialchars($ticket['username'] ?? '—') ?></p>
  <p><strong>Created:</strong> <?= htmlspecialchars($ticket['created_at'] ?? '—') ?></p>
  <p><strong>Status:</strong>
    <?= $ticket['status'] ? 'Active' : 'Resolved' ?>
  </p>
  <p><strong>Message:</strong><br>
    <?= nl2br(htmlspecialchars($ticket['description'] ?? '')) ?>
  </p>

  <hr>
  <h3>Comments</h3>
  <?php if (empty($ticket['comments'])): ?>
    <p><em>No comments yet.</em></p>
  <?php else: ?>
    <?php foreach ($ticket['comments'] as $c): 
      // pick whichever field they used:
      $author = $c['username'] ?? $c['name'] ?? '—';
      $text   = $c['text']     ?? '';
      $at     = $c['at']       ?? '';
    ?>
      <div class="comment">
        <p><strong><?= htmlspecialchars($author) ?></strong> <span class="meta">at <?= htmlspecialchars($at) ?></span></p>
        <p><?= nl2br(htmlspecialchars($text)) ?></p>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <?php if ($ticket['status']): ?>
    <hr>
    <h3>Add Admin Comment or Resolve</h3>
    <!-- comment form -->
    <form method="post">
      <textarea name="comment" rows="4" placeholder="Your comment…" required></textarea><br>
      <button type="submit">Add Comment</button>
    </form>

    <!-- separate resolve form -->
    <form method="post" style="margin-top:.5rem">
      <button type="submit" name="resolve" value="1">Mark as Resolved</button>
    </form>

  <?php endif; ?>
</body>
</html>
