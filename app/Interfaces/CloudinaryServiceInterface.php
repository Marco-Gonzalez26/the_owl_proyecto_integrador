<?php

namespace App\Interfaces;

interface CloudinaryServiceInterface
{
    public function uploadFile($file, array $options = [], $resourceType = 'image');
}
