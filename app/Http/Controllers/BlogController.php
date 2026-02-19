<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::query()
            ->published()
            ->latest('published_at')
            ->paginate(9);

        return view('blogs.index', [
            'blogs' => $blogs,
        ]);
    }

    public function show(Blog $blog)
    {
        if (!$blog->is_published) {
            abort(404);
        }

        return view('blogs.show', [
            'blog' => $blog,
        ]);
    }
}
