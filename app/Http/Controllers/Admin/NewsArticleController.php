<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsArticleController extends Controller
{
    public function index()
    {
        $articles = NewsArticle::latest()->paginate(15);
        return view('admin.news.index', compact('articles'));
    }

    public function create() { return view('admin.news.form', ['article' => new NewsArticle()]); }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        if ($request->hasFile('cover')) $data['cover_image'] = $request->file('cover')->store('news', 'public');
        unset($data['cover']);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['published_at'] = $data['is_published'] ? ($data['published_at'] ?? now()) : null;
        NewsArticle::create($data);
        return redirect()->route('admin.news.index')->with('status', 'Đã tạo bài viết.');
    }

    public function edit(NewsArticle $news)
    {
        return view('admin.news.form', ['article' => $news]);
    }

    public function update(Request $request, NewsArticle $news)
    {
        $data = $this->validated($request);
        $oldCover = $news->cover_image;
        if ($request->hasFile('cover')) $data['cover_image'] = $request->file('cover')->store('news', 'public');
        unset($data['cover']);
        $data['slug'] = $news->slug;
        $data['published_at'] = $data['is_published'] ? ($data['published_at'] ?? $news->published_at ?? now()) : null;
        $news->update($data);
        if ($request->hasFile('cover') && $oldCover && ! Str::startsWith($oldCover, ['https://', 'http://'])) Storage::disk('public')->delete($oldCover);
        return redirect()->route('admin.news.index')->with('status', 'Đã cập nhật bài viết.');
    }

    public function destroy(NewsArticle $news)
    {
        $cover = $news->cover_image;
        $news->delete();
        if ($cover && ! Str::startsWith($cover, ['https://', 'http://'])) Storage::disk('public')->delete($cover);
        return redirect()->route('admin.news.index')->with('status', 'Đã xóa bài viết.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'excerpt' => ['nullable', 'string', 'max:320'],
            'body' => ['required', 'string', 'max:20000'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]) + ['is_published' => $request->boolean('is_published')];
    }

    private function uniqueSlug(string $title, ?int $ignore = null): string
    {
        $base = Str::slug($title) ?: 'bai-viet';
        $slug = $base; $i = 2;
        while (NewsArticle::where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore))->exists()) $slug = $base.'-'.$i++;
        return $slug;
    }
}
