<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function beranda()
    {
        $rows = Post::orderby('updated_at', 'desc')->get();
        return view('frontend/beranda', ['rows' => $rows]);
    }

    public function detail($id)
    {
        $row = Post::where('id', $id)->first();
        return view('frontend/detail', ['row' => $row]);
    }
}
