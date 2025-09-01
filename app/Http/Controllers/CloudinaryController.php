<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Cloudinary;

class CloudinaryController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $cloudinary = new Cloudinary();
        $result = $cloudinary->uploadApi()->upload($file->getRealPath(), [
            'folder' => 'your_folder_name' 
        ]);
        return response()->json($result);
    }
}
