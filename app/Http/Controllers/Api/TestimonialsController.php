<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialsController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::all();
        return response()->json($testimonials);
    }
}
