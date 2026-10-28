@extends('layouts.admin')
@section('title', $article->exists ? 'Sửa bài viết' : 'Viết bài mới')
@section('content')
<div class="mb-8"><a href="{{ route('admin.news.index') }}" class="eyebrow underline underline-offset-4">← Tin tức</a><p class="eyebrow mt-7">Nội dung cửa hàng</p><h1 class="mt-2 font-display text-4xl">{{ $article->exists ? 'Chỉnh sửa bài viết' : 'Viết bài mới' }}</h1></div>
<form method="POST" enctype="multipart/form-data" action="{{ $article->exists ? route('admin.news.update', $article) : route('admin.news.store') }}" class="max-w-3xl rounded-md border border-stone-300 bg-white p-5 sm:p-8">@csrf @if($article->exists)@method('PUT')@endif
    <label class="block"><span class="eyebrow">Tiêu đề *</span><input class="form-control mt-2" name="title" maxlength="180" required value="{{ old('title', $article->title) }}"></label>
    <label class="mt-6 block"><span class="eyebrow">Mô tả ngắn</span><textarea class="form-control mt-2" name="excerpt" rows="2" maxlength="320">{{ old('excerpt', $article->excerpt) }}</textarea></label>
    <label class="mt-6 block"><span class="eyebrow">Nội dung *</span><textarea class="form-control mt-2" name="body" rows="12" maxlength="20000" required>{{ old('body', $article->body) }}</textarea><span class="mt-1 block text-xs text-stone-500">Xuống dòng để chia đoạn; nội dung được hiển thị an toàn dưới dạng văn bản.</span></label>
    @if($article->cover_url)<div class="mt-6"><img src="{{ $article->cover_url }}" alt="Ảnh bìa {{ $article->title }}" class="aspect-[16/7] max-h-72 w-full rounded-md object-cover"></div>@endif
    <label class="mt-6 block"><span class="eyebrow">Ảnh bìa</span><input class="form-control mt-2" type="file" name="cover" accept="image/jpeg,image/png,image/webp"><span class="mt-1 block text-xs text-stone-500">JPEG, PNG hoặc WebP, tối đa 5 MB.</span></label>
    <label class="mt-6 block"><span class="eyebrow">Ngày đăng</span><input class="form-control mt-2" type="datetime-local" name="published_at" value="{{ old('published_at', $article->published_at?->format('Y-m-d\\TH:i')) }}"></label>
    <label class="mt-6 flex items-center gap-3 text-sm"><input class="rounded border-stone-300 text-ink focus:ring-clay" type="checkbox" name="is_published" value="1" @checked(old('is_published', $article->is_published))> Đăng bài lên cửa hàng</label>
    <div class="mt-8 flex flex-wrap gap-3"><button class="button-primary">{{ $article->exists ? 'Lưu thay đổi' : 'Lưu bài viết' }}</button><a class="button-outline" href="{{ route('admin.news.index') }}">Hủy</a></div>
</form>
@endsection
