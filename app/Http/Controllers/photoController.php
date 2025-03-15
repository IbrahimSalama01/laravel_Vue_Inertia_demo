<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class photoController extends Controller
{
   public function show($filename)
    {
        $directory = storage_path("app/private/photos/");
        $extensions = ['jpg', 'jpeg', 'png','jfif'];

        // Check for any file that matches the filename with the given extensions
        foreach ($extensions as $ext) {
            $path = $directory . $filename . '.' . $ext;
            if (file_exists($path)) {
                return response()->file($path);
            }
        }

        // File not found
        abort(404);
    }

}
