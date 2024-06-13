<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Navbar;
use Illuminate\Http\Request;

class NavbarController extends Controller
{
    public function index()
    {
        $menus = Menu::with('subMenus')->get();
        return response()->json($menus);
    }

}
