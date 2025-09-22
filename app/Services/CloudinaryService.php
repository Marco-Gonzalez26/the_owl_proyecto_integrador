<?php

namespace App\Services;

use App\Config\CloudinaryConfig;
use App\Interfaces\CloudinaryServiceInterface;

class CloudinaryService implements CloudinaryServiceInterface
{
    private $uploadApi;
    public function __construct(CloudinaryConfig $config)
    {
        $this->uploadApi = $config->getCloudinaryUploadAPI();
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
        $filePath = is_string($file) ? $file : $file->getRealPath();
        $result = $this->uploadApi->upload($filePath, $combinedOptions);

        return $result['secure_url'] ?? null;
    }
}
