<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(){
        $services = Services::where('status', 1)->get();
        return response()->json($services);
    }
}
