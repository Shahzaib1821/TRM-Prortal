<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index(){
        $aboutPage = About::first();
        return response()->json($aboutPage);
    }
}
