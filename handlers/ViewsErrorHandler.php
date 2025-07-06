<?php
class ViewsErrorHandler
{

  public function handleNotFound()
  {
    require_once BASE_PATH . '/views/error/404.php';
  }

  public function handleInternalServerError()
  {
    require_once BASE_PATH . '/views/error/500.php';
  }
}
