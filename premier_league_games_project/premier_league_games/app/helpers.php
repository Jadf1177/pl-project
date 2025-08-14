<?php 
function esc(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

function redirect(string $url): never {
  header("Location: $url"); exit;
}

function csrf_token(): string {
  if (session_status() !== PHP_SESSION_ACTIVE) session_start();
  if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
  return $_SESSION['csrf'];
}

function csrf_check(): void {
  if (session_status() !== PHP_SESSION_ACTIVE) session_start();
  if (($_POST['csrf'] ?? '') !== ($_SESSION['csrf'] ?? '_')) {
    http_response_code(419); exit('CSRF validation failed');
  }
}