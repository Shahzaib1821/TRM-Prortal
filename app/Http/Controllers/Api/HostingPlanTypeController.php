<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HostingPlanType;
use Illuminate\Http\Request;

class HostingPlanTypeController extends Controller
{
    public function index(){
        $hosting_plan_types = HostingPlanType::all();
        return response()->json($hosting_plan_types);
    }
}
