<?php

namespace Config;


require_once __DIR__ . '/../vendor/autoload.php';
require_once dirname(__DIR__) . '/Config/env.php';


use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class CloudinaryConfig
{

  public function getCloudinaryUploadAPI()
  {

    Configuration::instance([
      'cloud' => [
        'cloud_name' => CLOUDINARY_CLOUD_NAME,
        'api_key' => CLOUDINARY_API_KEY,
        'api_secret' => CLOUDINARY_API_SECRET
      ],
      'url' => [
        'secure' => true
      ]
    ]);
    return new UploadApi();
  }
}
