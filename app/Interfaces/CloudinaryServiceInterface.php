<?php

namespace Interfaces;

interface CloudinaryServiceInterface
{
  public function uploadImage($file, array $options = []);
}
