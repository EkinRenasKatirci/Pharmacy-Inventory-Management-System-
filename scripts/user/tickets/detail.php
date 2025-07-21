<?php
// user/tickets/detail.php
require __DIR__ . '/../../admin/mongo.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("No ticket ID provided.");
}

// fetch the ticket document
$ticket = $ticketsCol->findOne([
    '_id' => new MongoDB\BSON\ObjectId($id)
]);
if (!$ticket) {
    die("Ticket not found.");
}

// Handle new comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment'], $_POST['name'])) {
        // push comment under 'username' for all comments
        $ticketsCol->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$push' => ['comments' => [
                'username' => trim($_POST['name']),
                'text'     => trim($_POST['comment']),
                'at'       => date('c')
            ]]]
        );
        // reload to show new comment
        header("Location: detail.php?id=$id");
        exit;
    }

    // Handle resolve button
    if (isset($_POST['resolve'])) {
        $ticketsCol->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => ['status' => false]]
        );
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Ticket Detail</title>
  <style>
    body { font-family: sans-serif; padding: 1rem; max-width: 600px; margin:; }
    hr { margin: 2rem 0; }
    ul { list-style: disc inside; padding-left: 0; }
    li { margin-bottom: 1rem; }
    blockquote { margin: .5rem 0 0 .5rem; }
    form > * { margin: .75rem 0; display: block; }
    textarea { width: 100%; height: 100px; }
    input[type="text"] { width: 100%; }
  </style>
</head>
<body>
  <h1>Ticket Details</h1>
  <p><a href="index.php">← Back to list</a></p>

  <p><strong>Username:</strong>
    <?= htmlspecialchars($ticket['username']) ?>
  </p>
  <p><strong>Created at:</strong>
    <?= htmlspecialchars($ticket['created_at']) ?>
  </p>
  <p><strong>Status:</strong>
    <?= $ticket['status'] ? 'Active' : 'Resolved' ?>
  </p>
  <p><strong>Description:</strong><br>
    <?= nl2br(htmlspecialchars($ticket['description'])) ?>
  </p>

  <hr>
  <h2>Comments</h2>
  <?php if (empty($ticket['comments'])): ?>
    <p><em>No comments yet.</em></p>
  <?php else: ?>
    <ul>
      <?php foreach ($ticket['comments'] as $c): ?>
        <li>
          <strong>
            <?= htmlspecialchars(
                 $c['username']    // our unified key
              ?? $c['name']        // fallback if you had any old entries
              ?? '–'
            ) ?>
          </strong> wrote:
          <blockquote>
            <?= nl2br(htmlspecialchars($c['text'] ?? '')) ?>
          </blockquote>
          <em>at <?= htmlspecialchars($c['at']) ?></em>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <?php if ($ticket['status']): ?>
    <hr>
    <h3>Add Comment</h3>
    <form method="post">
      <label>
        Name:<br>
        <input type="text" name="name" required>
      </label>
      <label>
        Comment:<br>
        <textarea name="comment" required></textarea>
      </label>
      <button type="submit">Submit Comment</button>

    </form>
  <?php endif; ?>
</body>
</html>
