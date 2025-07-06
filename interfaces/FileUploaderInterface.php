<?php
interface FileUploaderInterface
{
  public function uploadImage($file, array $options = []);
}
