@extends('layouts.store')
@section('title', $product->name)
@section('content')
<section class="container-page py-8 sm:py-14">
    <nav class="mb-7 text-[10px] uppercase tracking-[.16em] text-stone-500" aria-label="Đường dẫn"><a href="{{ route('home') }}">Trang chủ</a><span class="px-2">/</span><a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a><span class="px-2">/</span><span class="text-ink">{{ $product->name }}</span></nav>
    <div class="grid gap-9 lg:grid-cols-[1.15fr_.85fr] lg:gap-16">
        <div data-gallery>
            @if($product->images->isNotEmpty())
                <img data-gallery-main data-fallback-image class="aspect-[4/5] w-full bg-[#e8e4dc] object-cover" src="{{ $product->images->first()->url }}" alt="{{ $product->images->first()->alt_text ?: $product->name }}">
                @if($product->images->count() > 1)<div class="mt-3 flex gap-3 overflow-x-auto">@foreach($product->images as $image)<button type="button" data-gallery-thumb data-src="{{ $image->url }}" data-alt="{{ $image->alt_text ?: $product->name }}" aria-label="Xem ảnh {{ $loop->iteration }} trong {{ $product->images->count() }} ảnh" aria-pressed="{{ $loop->first ? 'true' : 'false' }}" class="w-16 shrink-0 border border-transparent p-0.5 transition-colors hover:border-ink focus-visible:outline focus-visible:outline-2 focus-visible:outline-ink aria-pressed:border-ink"><img data-fallback-image class="aspect-[4/5] w-full object-cover" src="{{ $image->url }}" alt="" loading="lazy"></button>@endforeach</div>@endif
            @else<div class="grid aspect-[4/5] place-items-center bg-[#e8e4dc]"><span class="font-display text-4xl text-stone-400">A·8</span></div>@endif
        </div>
        <div class="lg:sticky lg:top-8 lg:self-start lg:py-8"><p class="eyebrow">{{ $product->category->name }}@if($product->sku) <span class="mx-2">·</span> Mã {{ $product->sku }}@endif</p><h1 class="mt-3 font-display text-4xl leading-tight sm:text-5xl">{{ $product->name }}</h1><p class="mt-5 text-lg">@if($product->sale_price)<span class="text-clay">{{ number_format((float) $product->sale_price, 0, ',', '.') }}₫</span><span class="ml-3 text-sm text-stone-400 line-through">{{ number_format((float) $product->price, 0, ',', '.') }}₫</span>@else{{ number_format((float) $product->price, 0, ',', '.') }}₫@endif</p>
            <div class="mt-7 border-y border-stone-300 py-5"><p class="text-sm leading-7 text-stone-600">{{ $product->description ?: 'Một thiết kế tinh giản, dễ mặc và được tạo nên để đồng hành cùng bạn mỗi ngày.' }}</p></div>
            @if($product->sizes)<div class="mt-6"><p class="eyebrow mb-3">Kích cỡ hiện có</p><div class="flex flex-wrap gap-2">@foreach($product->sizes as $size)<span class="border border-stone-300 bg-white px-4 py-2 text-xs">{{ $size }}</span>@endforeach</div></div>@endif
            @if($product->colors)<div class="mt-5"><p class="eyebrow mb-2">Màu sắc</p><p class="text-sm">{{ implode(' · ', $product->colors) }}</p></div>@endif
            <p class="mt-7 text-xs {{ $product->stock_quantity > 0 ? 'text-olive' : 'text-stone-500' }}">{{ $product->stock_quantity > 0 ? 'Còn hàng · '.$product->stock_quantity.' sản phẩm' : 'Tạm hết hàng' }}</p>
            <p class="mt-4 text-[10px] uppercase tracking-[.12em] text-stone-500">Danh mục sản phẩm · Liên hệ studio để được tư vấn đặt hàng</p>
        </div>
    </div>
</section>
@if($related->isNotEmpty())<section class="container-page border-t border-stone-300 py-14 sm:py-20"><p class="eyebrow">Dành cho bạn</p><h2 class="mb-8 mt-2 font-display text-3xl">Có thể bạn cũng thích</h2><div class="grid grid-cols-2 gap-x-4 gap-y-9 md:grid-cols-4 md:gap-6">@foreach($related as $item)@include('storefront._product-card', ['product' => $item])@endforeach</div></section>@endif
@endsection
