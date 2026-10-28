@extends('layouts.admin')
@section('title', 'Cài đặt cửa hàng')
@section('content')
<div class="mb-8"><p class="eyebrow">Thông tin storefront</p><h1 class="mt-2 font-display text-4xl">Cài đặt cửa hàng</h1><p class="mt-2 text-sm text-stone-600">Các thông tin này xuất hiện ở chân trang và nút liên hệ nhanh.</p></div>
<form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-3xl rounded-md border border-stone-300 bg-white p-5 sm:p-8">@csrf @method('PUT')
    <h2 class="font-display text-2xl">Thông tin cửa hàng</h2><div class="mt-6 grid gap-5 sm:grid-cols-2">
        <label class="sm:col-span-2"><span class="eyebrow">Tên shop *</span><input class="form-control mt-2" name="shop_name" required maxlength="120" value="{{ old('shop_name', $settings->shop_name) }}" placeholder="Tên hiển thị trên cửa hàng"></label>
        <label><span class="eyebrow">Số điện thoại</span><input class="form-control mt-2" name="phone" maxlength="40" value="{{ old('phone', $settings->phone) }}" placeholder="+84 ..."></label>
        <label><span class="eyebrow">Email</span><input class="form-control mt-2" type="email" name="email" maxlength="180" value="{{ old('email', $settings->email) }}" placeholder="hello@example.com"></label>
        <label class="sm:col-span-2"><span class="eyebrow">Địa chỉ</span><input class="form-control mt-2" name="address" maxlength="255" value="{{ old('address', $settings->address) }}"></label>
        <label class="sm:col-span-2"><span class="eyebrow">Instagram URL</span><input class="form-control mt-2" type="url" name="instagram_url" maxlength="2048" value="{{ old('instagram_url', $settings->instagram_url) }}" placeholder="https://instagram.com/..."></label>
    </div>
    <h2 class="mt-10 border-t border-stone-200 pt-8 font-display text-2xl">Nút liên hệ nổi</h2><p class="mt-2 text-sm leading-6 text-stone-600">Để trống nếu không muốn hiện nút ở ngoài cửa hàng. Dán liên kết Zalo OA hoặc liên kết Messenger của cửa hàng.</p>
    <div class="mt-6 grid gap-5"><label><span class="eyebrow">Liên kết Zalo</span><input class="form-control mt-2" type="url" name="zalo_url" maxlength="2048" value="{{ old('zalo_url', $settings->zalo_url) }}" placeholder="https://zalo.me/..."></label><label><span class="eyebrow">Liên kết Messenger</span><input class="form-control mt-2" type="url" name="messenger_url" maxlength="2048" value="{{ old('messenger_url', $settings->messenger_url) }}" placeholder="https://m.me/..."></label></div>
    <h2 class="mt-10 border-t border-stone-200 pt-8 font-display text-2xl">Nhãn sản phẩm</h2><p class="mt-2 text-sm leading-6 text-stone-600">Sửa chữ trên các nhãn nổi bật, bán chạy và sản phẩm đang giảm giá. Để trống một ô nếu muốn ẩn nhãn đó.</p>
    <div class="mt-6 grid gap-5 sm:grid-cols-3"><label><span class="eyebrow">Nhãn nổi bật</span><input class="form-control mt-2" name="badge_featured" maxlength="60" value="{{ old('badge_featured', $settings->badge_featured) }}"></label><label><span class="eyebrow">Nhãn bán chạy</span><input class="form-control mt-2" name="badge_best_seller" maxlength="60" value="{{ old('badge_best_seller', $settings->badge_best_seller) }}"></label><label><span class="eyebrow">Nhãn Sale</span><input class="form-control mt-2" name="badge_sale" maxlength="60" value="{{ old('badge_sale', $settings->badge_sale) }}"></label></div>
    <div class="mt-8"><button class="button-primary">Lưu cài đặt</button></div>
</form>
@endsection
