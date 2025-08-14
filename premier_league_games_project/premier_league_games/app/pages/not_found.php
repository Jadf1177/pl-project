<?php
 ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Page Not Found</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      min-height: 100vh; 
      background-color: #f8f9fa;
    }
    .notfound-card {
      max-width: 420px;
      text-align: center;
      padding: 2rem;
      border-radius: .75rem;
      background: #fff;
      box-shadow: 0 0.5rem 1rem rgba(0,0,0,.1);
    }
    .notfound-code {
      font-size: 4rem;
      font-weight: 800;
      color: #dc3545;
    }
  </style>
</head>
<body>
  <div class="notfound-card">
    <div class="notfound-code">404</div>
    <h1 class="h4 mb-3">Page Not Found</h1>
    <p class="text-muted mb-4">
      Sorry, the page you’re looking for doesn’t exist or has been moved.
    </p>
    <a href="/index.php?page=matches" class="btn btn-primary">
      &larr; Back to Matches
    </a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>