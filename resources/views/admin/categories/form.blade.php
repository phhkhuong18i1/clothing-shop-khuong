@extends('layouts.admin')
@section('title', $category->exists ? 'Sửa danh mục' : 'Thêm danh mục')
@section('content')
<div class="mb-8"><a href="{{ route('admin.categories.index') }}" class="eyebrow underline underline-offset-4">← Danh mục</a><p class="eyebrow mt-7">Cấu trúc bộ sưu tập</p><h1 class="mt-2 font-display text-4xl">{{ $category->exists ? 'Chỉnh sửa danh mục' : 'Thêm danh mục mới' }}</h1></div>
<form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" class="max-w-2xl border border-stone-300 bg-white p-5 sm:p-8">@csrf @if($category->exists)@method('PUT')@endif
    <label class="block"><span class="eyebrow">Tên danh mục *</span><input class="form-control mt-2" name="name" maxlength="120" required value="{{ old('name', $category->name) }}"></label>
    <label class="mt-6 block"><span class="eyebrow">Danh mục cha</span><select class="form-control mt-2" name="parent_id"><option value="">Danh mục gốc</option>@foreach($parents as $parent)<option value="{{ $parent->id }}" @selected((string) old('parent_id', $category->parent_id) === (string) $parent->id)>{{ $parent->name }}</option>@endforeach</select><span class="mt-2 block text-xs text-stone-500">Danh mục con sẽ xuất hiện bên dưới danh mục cha trên cửa hàng.</span></label>
    <label class="mt-6 block"><span class="eyebrow">Mô tả</span><textarea class="form-control mt-2" name="description" rows="5" maxlength="2000">{{ old('description', $category->description) }}</textarea></label>
    <div class="mt-7 flex flex-wrap gap-3"><button class="button-primary">{{ $category->exists ? 'Lưu thay đổi' : 'Tạo danh mục' }}</button><a class="button-outline" href="{{ route('admin.categories.index') }}">Hủy</a></div>
</form>
@endsection
