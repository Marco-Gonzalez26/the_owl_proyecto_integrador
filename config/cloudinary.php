<?php

namespace App\Config;


use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class CloudinaryConfig
{

    public function getCloudinaryUploadAPI()
    {

        Configuration::instance([
            'cloud' => [
                'cloud_name' => env("CLOUDINARY_CLOUD_NAME"),
                'api_key' => env("CLOUDINARY_API_KEY"),
                'api_secret' => env("CLOUDINARY_API_SECRET")
            ],
            'url' => [
                'secure' => true
            ]
        ]);
        return new UploadApi();
    }
}
