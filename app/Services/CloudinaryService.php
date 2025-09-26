<?php

namespace App\Services;

use App\Config\CloudinaryConfig;
use App\Interfaces\CloudinaryServiceInterface;
use Illuminate\Support\Facades\Log;

class CloudinaryService implements CloudinaryServiceInterface
{
    private $uploadApi;
    public function __construct(CloudinaryConfig $config)
    {
        $this->uploadApi = $config->getCloudinaryUploadAPI();
    }
    public function uploadFile($file, $options = [], $resourceType = 'image')
    {
        $defaultOptions = [
            'folder' => 'the_owl',
            'overwrite' => true,
            'use_filename' => true,
        ];

        $combinedOptions = array_merge($defaultOptions, $options);
        $combinedOptions['resource_type'] = $resourceType;

        $filePath = is_string($file) ? $file : $file->getRealPath();
        $result = $this->uploadApi->upload(
            $filePath,
            $combinedOptions
        );
        Log::info($result['secure_url']);
        return $result['secure_url'] ?? null;
    }
}
