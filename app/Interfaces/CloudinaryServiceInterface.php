<?php

namespace App\Interfaces;

interface CloudinaryServiceInterface
{
    public function uploadImage($file, array $options = []);
}
