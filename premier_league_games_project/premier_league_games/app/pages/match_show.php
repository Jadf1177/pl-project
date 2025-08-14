<?php
$pdo = DB::pdo();
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { require __DIR__ . '/not_found.php'; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  csrf_check();
  $user_name  = trim($_POST['user_name'] ?? '');
  $user_email = trim($_POST['user_email'] ?? '');
  $comment    = trim($_POST['comment'] ?? '');

  $errors = [];
  if ($user_name === '') $errors[] = 'Name is required.';

  if (!$errors) {
    $stmt = $pdo->prepare("INSERT INTO feedbacks (match_id, user_name, user_email, comment) VALUES (?, ?, ?, ?)");
    $stmt->execute([$id, $user_name, $user_email, $comment]);

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
  }
}

$stmt = $pdo->prepare("
  SELECT m.*, 
         ht.name AS home_name, at.name AS away_name,
         ht.logo_url AS home_logo, at.logo_url AS away_logo
  FROM matches m
  JOIN teams ht ON ht.id = m.home_team_id
  JOIN teams at ON at.id = m.away_team_id
  WHERE m.id = ?
");
$stmt->execute([$id]);
$match = $stmt->fetch();
if (!$match) { require __DIR__ . '/not_found.php'; exit; }

$fb = $pdo->prepare("SELECT user_name, comment, created_at FROM feedbacks WHERE match_id = ? ORDER BY created_at DESC");
$fb->execute([$id]);
$feedbacks = $fb->fetchAll();

$csrf = csrf_token();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= esc($match['home_name']) ?> vs <?= esc($match['away_name']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .logo { width:64px; height:64px; object-fit:contain; background:#f8f9fa; border-radius:.5rem; padding:8px; }
    .score { font-size:2rem; font-weight:800; }
  </style>
</head>
<body class="container py-4">

  <a href="./index.php" class="btn btn-sm btn-outline-secondary mb-3">&larr; Back</a>

  <div class="card mb-4">
    <div class="card-body">
      <div class="d-flex justify-content-between mb-2">
        <div>GW <?= (int)$match['gameweek'] ?> • <?= esc($match['match_date']) ?> <?= $match['kickoff_time'] ? esc(substr($match['kickoff_time'],0,5)) : '' ?></div>
        <span class="badge bg-secondary"><?= esc($match['status']) ?></span>
      </div>

      <div class="row align-items-center text-center g-3">
        <div class="col-5">
          <?php if (!empty($match['home_logo'])): ?>
            <img class="logo mb-2" src="<?= esc($match['home_logo']) ?>" alt="">
          <?php endif; ?>
          <div class="fw-bold"><?= esc($match['home_name']) ?></div>
        </div>

        <div class="col-2">
          <?php if ($match['status'] === 'FINISHED'): ?>
            <div style="font-size:24px;" class="score"><?= (int)$match['home_score'] ?>–<?= (int)$match['away_score'] ?></div>
          <?php else: ?>
            <div class="score text-muted">vs</div>
          <?php endif; ?>
        </div>

        <div class="col-5">
          <?php if (!empty($match['away_logo'])): ?>
            <img class="logo mb-2" src="<?= esc($match['away_logo']) ?>" alt="">
          <?php endif; ?>
          <div class="fw-bold"><?= esc($match['away_name']) ?></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-md-6">
      <h4 class="h5 mb-3">Leave your feedback</h4>
      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger"><?= esc(implode(' ', $errors)) ?></div>
      <?php endif; ?>

      <form method="post">
        <input type="hidden" name="csrf" value="<?= esc($csrf) ?>">
        <div class="mb-3">
          <label class="form-label">Name *</label>
          <input class="form-control" name="user_name" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="user_email">
        </div>
        <div class="mb-3">
          <label class="form-label">Comment</label>
          <textarea class="form-control" name="comment" rows="3"></textarea>
        </div>
        <button class="btn btn-primary">Submit</button>
      </form>
    </div>

    <div class="col-md-6">
      <h4 class="h5 mb-3">Recent feedback</h4>
      <?php if (!$feedbacks): ?>
        <p class="text-muted">No feedback yet.</p>
      <?php else: ?>
        <ul class="list-group">
          <?php foreach ($feedbacks as $f): ?>
            <li class="list-group-item">
              <div class="d-flex justify-content-between">
                <strong><?= esc($f['user_name']) ?></strong>
              </div>
              <?php if ($f['comment']): ?>
                <div class="mt-2"><?= nl2br(esc($f['comment'])) ?></div>
              <?php endif; ?>
              <small class="text-muted"><?= esc($f['created_at']) ?></small>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>