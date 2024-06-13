<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Widgets\Skills;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    public function index(){
        $skills = Skills::all();
        return response()->json($skills);
    }
}
