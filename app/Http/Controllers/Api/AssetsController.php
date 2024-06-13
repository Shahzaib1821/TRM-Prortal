<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AssetsController extends Controller
{

    public function showLogo($filename)
    {
        $path = storage_path('app/public/uploads/logos/' . $filename);
    
        if (!Storage::exists($path)) {
            abort(404);
        }
    
        $file = Storage::get($path);
        $type = Storage::mimeType($path);
    
        $response = response()->make($file, 200);
        $response->header("Content-Type", $type);
    
        return $response;
    }
    
}
