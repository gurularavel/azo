<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::query()->latest()->paginate(12);

        return view('admin.blogs.index', [
            'blogs' => $blogs,
        ]);
    }

    public function create()
    {
        return view('admin.blogs.form', [
            'blog' => new Blog(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data = $this->prepareBlogData($data);

        Blog::create($data);

        return redirect()->route('admin.blogs.index')->with('status', __('messages.blog_saved'));
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.form', [
            'blog' => $blog,
        ]);
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $this->validateData($request, $blog);
        $data = $this->prepareBlogData($data, $blog);

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('status', __('messages.blog_saved'));
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('status', __('messages.blog_deleted'));
    }

    private function validateData(Request $request, ?Blog $blog = null): array
    {
        $blogId = $blog?->id;

        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:180', 'unique:blogs,slug'.($blogId ? ','.$blogId : '')],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'cover_image_path' => ['nullable', 'string', 'max:255'],
            'cover_image_file' => ['nullable', 'image', 'max:4096'],
            'is_published' => ['nullable', 'boolean'],
            'show_on_home' => ['nullable', 'boolean'],
        ]);
    }

    private function prepareBlogData(array $data, ?Blog $blog = null): array
    {
        $coverFile = request()->file('cover_image_file');
        if ($coverFile instanceof UploadedFile && $coverFile->isValid()) {
            $data['cover_image_path'] = $this->storeUploadedFile($coverFile, 'blogs/covers');
        }

        $slug = $data['slug'] ?? '';
        if (!$slug) {
            $slug = Blog::generateSlug($data['title']);
        } else {
            $slug = Str::slug($slug);
        }

        $data['slug'] = $this->uniqueSlug($slug, $blog?->id);
        $data['is_published'] = (bool) ($data['is_published'] ?? false);
        $data['show_on_home'] = (bool) ($data['show_on_home'] ?? false);
        $data['published_at'] = $data['is_published'] ? ($blog?->published_at ?? now()) : null;

        return $data;
    }

    private function uniqueSlug(string $slug, ?int $blogId = null): string
    {
        $baseSlug = $slug ?: 'blog';
        $candidate = $baseSlug;
        $counter = 1;

        while (
            Blog::query()
                ->where('slug', $candidate)
                ->when($blogId, fn ($query) => $query->where('id', '!=', $blogId))
                ->exists()
        ) {
            $counter++;
            $candidate = $baseSlug.'-'.$counter;
        }

        return $candidate;
    }

    private function storeUploadedFile(UploadedFile $file, string $directory): string
    {
        $path = $file->getPathname();
        $name = $file->hashName();

        $stream = fopen($path, 'r');
        if (!$stream) {
            throw new \RuntimeException('Failed to open upload stream.');
        }

        Storage::disk('public')->put(trim($directory.'/'.$name, '/'), $stream);

        if (is_resource($stream)) {
            fclose($stream);
        }

        return trim($directory.'/'.$name, '/');
    }
}
