<?php
require_once __DIR__ . '/../config/cloudinary.php';
class CloudinaryService
{

  private $uploadApi;
  public function __construct()
  {
    $this->uploadApi = require __DIR__ . '/../config/cloudinary.php';
  }
  public function uploadImage($file)
  {
    $result = $this->uploadApi->upload($file, [
      'folder' => 'the_owl',
      'resource_type' => 'image',
      'overwrite' => true,
      'use_filename' => true
    ]);

    return $result['secure_url'] ?? null;
  }
}
