<?php

namespace Services;

use Interfaces\CloudinaryServiceInterface;
use Config\CloudinaryConfig;

class CloudinaryService implements CloudinaryServiceInterface
{

  private $uploadApi;
  public function __construct()
  {
    $this->uploadApi = (new CloudinaryConfig())->getCloudinaryUploadAPI();
  }
  public function uploadImage($file, $options = [])
  {
    $defaultOptions = [
      'folder' => 'the_owl',
      'resource_type' => 'image',
      'overwrite' => true,
      'use_filename' => true
    ];

    $combinedOptions = array_merge($defaultOptions, $options);

    $result = $this->uploadApi->upload($file, $combinedOptions);

    return $result['secure_url'] ?? null;
  }
}
