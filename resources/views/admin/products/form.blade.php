@extends('layouts.admin')
@section('title', $product->exists ? 'Sửa sản phẩm' : 'Thêm sản phẩm')
@section('content')
<div class="mb-8"><a href="{{ route('admin.products.index') }}" class="eyebrow underline underline-offset-4">← Sản phẩm</a><p class="eyebrow mt-7">Quản lý cửa hàng</p><h1 class="mt-2 font-display text-4xl">{{ $product->exists ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới' }}</h1></div>
<form method="POST" enctype="multipart/form-data" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_320px]">@csrf @if($product->exists)@method('PUT')@endif
    <div class="space-y-7">
        <section class="border border-stone-300 bg-white p-5 sm:p-7"><h2 class="font-display text-2xl">Thông tin sản phẩm</h2><div class="mt-6 grid gap-5 sm:grid-cols-2">
            <label class="block sm:col-span-2"><span class="eyebrow">Tên sản phẩm *</span><input class="form-control mt-2" name="name" maxlength="180" required value="{{ old('name', $product->name) }}"></label>
            <label class="block">
                <span class="eyebrow">Danh mục *</span>
                <select class="form-control mt-2" name="category_id" required>
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            @selected(old('category_id', $product->category_id) == $category->id)
                        >
                            {{ $category->parent ? '— '.$category->name : $category->name }}
                        </option>
                    @endforeach
                </select>
            </label>
            <label class="block">
                <span class="eyebrow">Mã sản phẩm</span>
                <input class="form-control mt-2" name="sku" maxlength="80" value="{{ old('sku', $product->sku) }}">
            </label>
            <label class="block">
                <span class="eyebrow">Giá bán (₫) *</span>
                <input class="form-control mt-2" type="number" min="0" step="1000" name="price" required value="{{ old('price', $product->price) }}">
            </label>
            <label class="block">
                <span class="eyebrow">Giá ưu đãi (₫)</span>
                <input class="form-control mt-2" type="number" min="0" step="1000" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}">
            </label>
            <label class="block">
                <span class="eyebrow">Số lượng tồn kho *</span>
                <input class="form-control mt-2" type="number" min="0" name="stock_quantity" required value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}">
            </label>
            <label class="block">
                <span class="eyebrow">Kích cỡ</span>
                <input class="form-control mt-2" name="sizes" placeholder="XS, S, M, L" value="{{ old('sizes', implode(', ', $product->sizes ?? [])) }}">
                <span class="mt-1 block text-xs text-stone-500">Ngăn cách các kích cỡ bằng dấu phẩy.</span>
            </label>
            <label class="block">
                <span class="eyebrow">Màu sắc</span>
                <input class="form-control mt-2" name="colors" placeholder="Trắng ngà, Nâu đất" value="{{ old('colors', implode(', ', $product->colors ?? [])) }}">
                <span class="mt-1 block text-xs text-stone-500">Ngăn cách các màu bằng dấu phẩy.</span>
            </label>
            <label class="block sm:col-span-2"><span class="eyebrow">Mô tả</span><textarea class="form-control mt-2" rows="5" name="description" maxlength="10000">{{ old('description', $product->description) }}</textarea></label>
        </div></section>
        <section class="border border-stone-300 bg-white p-5 sm:p-7">
            <h2 class="font-display text-2xl">Hình ảnh sản phẩm</h2>
            <p class="mt-2 text-sm text-stone-600">Tải tối đa sáu ảnh JPEG, PNG hoặc WebP. Mỗi ảnh tối đa 5 MB.</p>
            @if($product->exists && $product->images->isNotEmpty())
                <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-3">
                    @foreach($product->images as $image)
                        <label class="border border-stone-200 p-2">
                            <img class="aspect-[4/5] w-full object-cover" src="{{ $image->url }}" alt="{{ $image->alt_text ?: $product->name }}">
                            <span class="mt-2 flex items-center gap-2 text-xs">
                                <input type="radio" name="primary_choice" value="existing:{{ $image->id }}" @checked(old('primary_choice', $image->is_primary ? 'existing:'.$image->id : null) === 'existing:'.$image->id)> Ảnh đại diện</span><span class="mt-2 flex items-center gap-2 text-xs text-red-700">
                                <input type="checkbox" name="remove_images[]" value="{{ $image->id }}"> Xóa ảnh
                            </span>
                        </label>
                    @endforeach
                </div>
            @endif
            <label class="mt-5 block">
                <span class="eyebrow">Thêm ảnh</span>
                <input class="form-control mt-2" type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple data-image-upload>
                <span class="mt-1 block text-xs text-stone-500">Sau khi chọn ảnh, hãy chọn ảnh đại diện.</span>
            </label><div class="mt-4 flex flex-wrap gap-3" data-image-preview data-has-existing="{{ $product->images->isNotEmpty() ? '1' : '0' }}" aria-live="polite"></div>
        </section>
    </div>
    <aside class="h-fit border border-stone-300 bg-white p-5 sm:p-7">
        <p class="eyebrow">Trạng thái</p>
        <label class="mt-5 flex items-start gap-3">
            <input class="mt-1 border-stone-400 text-ink focus:ring-ink" type="checkbox" name="is_published" value="1" @checked(old('is_published', $product->is_published))>
            <span>
                <span class="block text-sm font-medium">Hiển thị sản phẩm</span>
                <span class="mt-1 block text-xs leading-5 text-stone-500">Sản phẩm sẽ xuất hiện trên cửa hàng.</span>
            </span>
        </label>
        <label class="mt-5 flex items-start gap-3">
            <input class="mt-1 border-stone-400 text-ink focus:ring-ink" type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))>
            <span>
                <span class="block text-sm font-medium">Sản phẩm nổi bật</span>
                <span class="mt-1 block text-xs leading-5 text-stone-500">Đánh dấu sản phẩm nổi bật.</span>
            </span>
        </label>
        <label class="mt-5 flex items-start gap-3">
            <input class="mt-1 border-stone-400 text-ink focus:ring-ink" type="checkbox" name="is_best_seller" value="1" @checked(old('is_best_seller', $product->is_best_seller))>
            <span>
                <span class="block text-sm font-medium">Sản phẩm bán chạy</span>
                <span class="mt-1 block text-xs leading-5 text-stone-500">Hiển thị trong mục sản phẩm bán chạy.</span>
            </span>
        </label>
        <div class="mt-7 space-y-3">
            <button class="button-primary w-full">{{ $product->exists ? 'Lưu thay đổi' : 'Tạo sản phẩm' }}</button>
            <a class="button-outline w-full" href="{{ route('admin.products.index') }}">Hủy</a>
        </div>
    </aside>
</form>
@endsection
