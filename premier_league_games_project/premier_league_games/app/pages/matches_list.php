<?php
$pdo = DB::pdo();

$stmt = $pdo->query("
  SELECT
    m.id, m.season, m.gameweek, m.match_date, m.kickoff_time, m.status,
    m.home_score, m.away_score,
    ht.name AS home_name, at.name AS away_name,
    ht.logo_url AS home_logo, at.logo_url AS away_logo,
    COUNT(f.id) AS feedback_count
  FROM matches m
  JOIN teams ht ON ht.id = m.home_team_id
  JOIN teams at ON at.id = m.away_team_id
  LEFT JOIN feedbacks f ON f.match_id = m.id
  GROUP BY m.id
  ORDER BY m.match_date ASC, m.kickoff_time ASC
");
$matches = $stmt->fetchAll();

function status_badge_class(string $s): string {
  return match ($s) {
    'FINISHED'  => 'bg-success',
    'LIVE'      => 'bg-danger',
    'SCHEDULED' => 'bg-secondary',
    'POSTPONED' => 'bg-warning text-dark',
    'CANCELLED' => 'bg-dark',
    default     => 'bg-secondary'
  };
}

function time_hhmm($t): string {
  return $t ? substr($t,0,5) : '';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Premier League Matches</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <style>
    .match-card { transition: transform .06s ease-in-out, box-shadow .06s; }
    .match-card:hover { transform: translateY(-2px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.08); }
    .team {
      display: grid; grid-template-columns: 42px 1fr; gap: .5rem; align-items: center;
    }
    .team-logo {
      width: 42px; height: 42px; object-fit: contain;
      background: #f8f9fa; border-radius: .35rem; padding: 6px;
    }
    .vs {
      font-weight: 600; letter-spacing: .5px;
    }
    .score-pill {
      font-weight: 700; border: 1px solid rgba(0,0,0,.1);
    }
    .meta {
      font-size: .9rem; color: #6c757d;
    }
  </style>
</head>
<body class="container py-4">
  <div class="d-flex align-items-center justify-content-between mb-3 text-center">
    <img width="150px" src="https://upload.wikimedia.org/wikipedia/en/thumb/f/f2/Premier_League_Logo.svg/1200px-Premier_League_Logo.svg.png">
    <h1 class="h3 m-0">Matches</h1>
    <div class="text-muted">Season <strong>2025/2026</strong></div>
  </div>

  <?php if (!$matches): ?>
    <div class="alert alert-warning">No matches found. Seed your database and reload.</div>
  <?php else: ?>
    <div class="row g-3 g-md-4">
      <?php foreach ($matches as $m): ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="card match-card h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="meta">
                  GW <?= esc($m['gameweek']) ?> • <?= esc($m['match_date']) ?> <?= esc(time_hhmm($m['kickoff_time'])) ?>
                </div>
                <span class="badge <?= esc(status_badge_class($m['status'])) ?>">
                  <?= esc($m['status']) ?>
                </span>
              </div>

              <div class="d-grid gap-2">
                <div class="team">
                  <?php if (!empty($m['home_logo'])): ?>
                    <img class="team-logo" src="<?= esc($m['home_logo']) ?>" alt="<?= esc($m['home_name']) ?> logo" loading="lazy">
                  <?php else: ?>
                    <div class="team-logo d-flex align-items-center justify-content-center">🏟️</div>
                  <?php endif; ?>
                  <div class="text-truncate"><strong><?= esc($m['home_name']) ?></strong></div>
                </div>

                <div class="d-flex align-items-center justify-content-between">
                  <div class="vs text-muted">vs</div>
                  <?php if ($m['status']==='FINISHED'): ?>
                    <span class="badge rounded-pill score-pill text-dark">
                      <?= (int)$m['home_score'] ?>–<?= (int)$m['away_score'] ?>
                    </span>
                  <?php else: ?>
                    <span class="badge rounded-pill bg-light text-muted border">—</span>
                  <?php endif; ?>
                </div>

                <div class="team">
                  <?php if (!empty($m['away_logo'])): ?>
                    <img class="team-logo" src="<?= esc($m['away_logo']) ?>" alt="<?= esc($m['away_name']) ?> logo" loading="lazy">
                  <?php else: ?>
                    <div class="team-logo d-flex align-items-center justify-content-center">🏟️</div>
                  <?php endif; ?>
                  <div class="text-truncate"><strong><?= esc($m['away_name']) ?></strong></div>
                </div>
              </div>
            </div>

            <div class="card-footer d-flex justify-content-between align-items-center">
              <a class="btn btn-sm btn-primary" href="../public/index.php?page=match&id=<?= (int)$m['id'] ?>">Details</a>
              <?php if ($m['feedback_count'] > 0): ?>
                <span class="text-muted small">
                  Feedbacks : (<?= (int)$m['feedback_count'] ?>)
                </span>
              <?php else: ?>
                <span class="text-muted small">No feedbacks</span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>