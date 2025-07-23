<?php
// get the url

function renderLayout($content, $data = [])
{
  $current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $isAdminRoute = str_contains($current_path, '/admin');
  $header = $isAdminRoute ? "admin_header.php" : "header.php";
  extract($data);
  $footer = $isAdminRoute ? "admin_footer.php" : "footer.php";
  require __DIR__ . '/' . $header;
  echo $content;
  require __DIR__ . '/' . $footer;
}
renderLayout($content, $layoutData);
