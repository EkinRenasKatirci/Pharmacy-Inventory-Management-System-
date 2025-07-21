<?php
// user/tickets/create.php
require __DIR__ . '/../../admin/mongo.php';

$message = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $doc = [
    'username'   => $_POST['username'],
    'description'=> $_POST['description'],
    'created_at' => date('c'),
    'status'     => true,
    'comments'   => []
  ];
  $result = $ticketsCol->insertOne($doc);
  if ($result->getInsertedCount()===1) {
    $message = "✔️ Ticket created successfully!";
  } else {
    $message = "❌ Failed to create ticket.";
  }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Create Ticket</title></head>
<body>
  <h1>Create a Ticket</h1>
  <p><a href="index.php">← Back to list</a></p>

  <?php if ($message): ?>
    <p><?= htmlspecialchars($message) ?></p>
    <?php if (strpos($message,'✔️')===0): ?>
      <p><a href="create.php">Create another</a></p>
    <?php endif; ?>
  <?php endif; ?>

  <?php if (!$message || strpos($message,'❌')===0): ?>
  <form method="post">
    <label>Username:<br>
      <input name="username" required>
    </label><br><br>
    <label>Description:<br>
      <textarea name="description" rows="5" cols="40" required></textarea>
    </label><br><br>
    <button type="submit">Create Ticket</button>
  </form>
  <?php endif; ?>
</body>
</html>
