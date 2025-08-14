<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_exception_handler(function($e){
  http_response_code(500);
  echo "<pre style='white-space:pre-wrap'>".$e."</pre>";
});
require __DIR__ . '/../app/db.php';
require __DIR__ . '/../app/helpers.php';

$page = $_GET['page'] ?? 'matches';

switch ($page) {
  case 'matches':
    require __DIR__ . '/../app/pages/matches_list.php';
    break;
  case 'match':
    require __DIR__ . '/../app/pages/match_show.php';
    break;
  default:
    require __DIR__ . '/../app/pages/not_found.php';
}