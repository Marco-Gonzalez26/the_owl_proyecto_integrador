<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cloudinary\Cloudinary;

class CloudinaryController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $cloudinary = new Cloudinary();
        $result = $cloudinary->uploadApi()->upload($file->getRealPath(), [
            'folder' => 'the-owl',
        ]);
        return response()->json($result);
    }
}
