@extends('layouts.store')
@section('title', 'Sale')
@section('content')
<section class="container-page py-10 sm:py-16"><div class="mb-9 border-b border-stone-300 pb-8"><p class="eyebrow text-clay">Ưu đãi có chọn lọc</p><h1 class="mt-2 font-display text-5xl sm:text-6xl">Sale</h1><p class="mt-3 max-w-lg text-sm leading-6 text-stone-600">Những thiết kế đang có giá ưu đãi. Giá giảm được cập nhật trực tiếp theo từng sản phẩm.</p></div>
@if($products->isNotEmpty())<p class="mb-5 text-sm text-stone-600">{{ number_format($products->total()) }} sản phẩm ưu đãi</p><div class="grid grid-cols-2 gap-x-4 gap-y-10 md:grid-cols-3 md:gap-x-6 lg:grid-cols-4">@foreach($products as $product)@include('storefront._product-card', ['product' => $product])@endforeach</div><div class="mt-12">{{ $products->links() }}</div>@else<div class="rounded-md border border-stone-300 bg-white py-20 text-center"><p class="font-display text-3xl">Chưa có ưu đãi nào.</p><p class="mt-3 text-sm text-stone-600">Khám phá các thiết kế mới trong cửa hàng.</p><a href="{{ route('products.index') }}" class="button-primary mt-6">Xem sản phẩm</a></div>@endif</section>
@endsection
