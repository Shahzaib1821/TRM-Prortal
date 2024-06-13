<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HostingPlan;
use Illuminate\Http\Request;

class HostingPlanController extends Controller
{
    public function index()
    {
        $hosting_plans = HostingPlan::all();
        return response()->json($hosting_plans);
    }
}
