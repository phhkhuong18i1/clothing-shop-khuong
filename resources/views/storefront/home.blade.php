@extends('layouts.store')
@section('title', 'Thời trang tinh giản cho mỗi ngày')
@section('content')
@if($slides->isNotEmpty())
<section class="container-page pt-5 sm:pt-8">
    <div class="relative min-h-[520px] overflow-hidden bg-[#ded8cd] sm:min-h-[650px]" x-data="{ slide: 0, count: {{ count($slides) }}, timer: null, start() { if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) this.timer = setInterval(() => this.slide = (this.slide + 1) % this.count, 5000); }, goTo(index) { this.slide = index; if (this.timer) { clearInterval(this.timer); this.start(); } }, next() { this.goTo((this.slide + 1) % this.count); }, previous() { this.goTo((this.slide + this.count - 1) % this.count); } }" x-init="start()" aria-roledescription="băng chuyền" aria-label="Bộ sưu tập nổi bật">
        <div class="flex transition-transform duration-700 ease-in-out motion-reduce:transition-none" :style="'width: ' + (count * 100) + '%; transform: translateX(-' + (slide * 100 / count) + '%)'">
            @foreach($slides as $index => $item)
                <article class="relative min-h-[520px] shrink-0 sm:min-h-[650px]" :style="'width: ' + (100 / count) + '%'" :aria-hidden="slide !== {{ $index }}" :inert="slide !== {{ $index }}" aria-roledescription="trang chiếu">
                    <img data-fallback-image src="{{ $item->image_url }}" alt="{{ $item->title }}" class="absolute inset-0 h-full w-full object-cover object-center" loading="eager" decoding="async" @if($index === 0) fetchpriority="high" @endif>
                    <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/25 to-transparent"></div>
                    <div class="relative flex min-h-[520px] max-w-3xl flex-col justify-end px-7 pb-24 pt-7 text-white sm:min-h-[650px] sm:p-14 sm:pb-24 lg:p-20 lg:pb-24">
                        @if($item->eyebrow)<p class="eyebrow text-white/80">{{ $item->eyebrow }}</p>@endif
                        <h1 class="mt-5 max-w-2xl font-display text-4xl leading-[1.08] sm:text-7xl">{{ $item->title }}</h1>
                        @if($item->description)<p class="mt-5 max-w-lg text-sm leading-6 text-white/90 sm:text-base">{{ $item->description }}</p>@endif
                        <a href="{{ $item->link_url ?: route('products.index') }}" class="mt-8 inline-flex min-h-12 w-fit max-w-full flex-wrap items-center gap-x-3 rounded-md border border-white px-4 py-3 text-left text-xs font-semibold uppercase tracking-[.12em] transition-colors hover:bg-white hover:text-ink sm:px-6 sm:tracking-[.15em]">{{ $item->link_label }} <span aria-hidden="true">↗</span></a>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="absolute bottom-4 left-1/2 z-10 flex -translate-x-1/2 items-center justify-center gap-1.5 sm:bottom-8 sm:gap-2">
                <button type="button" class="grid h-8 w-8 place-items-center border border-white/70 text-white hover:bg-white hover:text-ink focus-visible:outline focus-visible:outline-2 focus-visible:outline-white sm:h-10 sm:w-10" aria-label="Ảnh trước" @click="previous()">←</button>
            @foreach($slides as $index => $item)
                <button type="button" class="h-8 min-w-8 border px-2 text-[10px] focus-visible:outline focus-visible:outline-2 focus-visible:outline-white sm:h-10 sm:min-w-10 sm:px-3 sm:text-xs" :class="slide === {{ $index }} ? 'border-white bg-white text-ink' : 'border-white/70 text-white hover:bg-white/20'" :aria-pressed="slide === {{ $index }}" aria-label="Chuyển đến ảnh {{ $index + 1 }}" @click="goTo({{ $index }})">0{{ $index + 1 }}</button>
            @endforeach
                <button type="button" class="grid h-8 w-8 place-items-center border border-white/70 text-white hover:bg-white hover:text-ink focus-visible:outline focus-visible:outline-2 focus-visible:outline-white sm:h-10 sm:w-10" aria-label="Ảnh tiếp theo" @click="next()">→</button>
        </div>
    </div>
</section>
@endif

<section class="container-page pt-8 sm:pt-10" aria-label="Điểm nổi bật của {{ $storeSettings->shop_name }}">
    <div class="grid border-y border-stone-300 sm:grid-cols-3 sm:divide-x sm:divide-stone-300">
        <div class="flex items-start gap-4 border-b border-stone-200 py-5 sm:border-0 sm:px-5 sm:py-7 first:sm:pl-0">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full border border-clay/30 font-display text-sm text-clay">01</span>
            <div><h2 class="font-display text-xl">Chất liệu dễ chịu</h2><p class="mt-1 text-xs leading-5 text-stone-600">Linen, cotton và len mềm cho những ngày thật thoải mái.</p></div>
        </div>
        <div class="flex items-start gap-4 border-b border-stone-200 py-5 sm:border-0 sm:px-5 sm:py-7">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full border border-clay/30 font-display text-sm text-clay">02</span>
            <div><h2 class="font-display text-xl">Phom dáng dễ mặc</h2><p class="mt-1 text-xs leading-5 text-stone-600">Thiết kế thoải mái, dễ kết hợp theo cách của bạn.</p></div>
        </div>
        <div class="flex items-start gap-4 py-5 sm:px-5 sm:py-7 sm:pr-0">
            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full border border-clay/30 font-display text-sm text-clay">03</span>
            <div><h2 class="font-display text-xl">Gam màu dễ phối</h2><p class="mt-1 text-xs leading-5 text-stone-600">Sắc độ tinh giản để mặc qua nhiều mùa.</p></div>
        </div>
    </div>
</section>

@if($featured->isNotEmpty())
    @php($studioPick = $featured->first())
    <section class="container-page py-12 sm:py-20" aria-labelledby="studio-pick-title">
        <div class="overflow-hidden rounded-md bg-[#e9e5dc] md:grid md:grid-cols-2">
            <a href="{{ route('products.show', $studioPick) }}" class="group relative block min-h-[360px] overflow-hidden bg-[#d8d1c4] sm:min-h-[500px]" aria-label="Xem {{ $studioPick->name }}">
                @if($studioPick->images->first())
                    <img data-fallback-image src="{{ $studioPick->images->first()->url }}" alt="{{ $studioPick->images->first()->alt_text ?: $studioPick->name }}" class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-[1.03]" loading="lazy">
                @else
                    <div class="absolute inset-0 grid place-items-center font-display text-4xl text-stone-500 sm:text-5xl">{{ mb_strtoupper($storeSettings->shop_name) }}</div>
                @endif
                <span class="absolute left-5 top-5 rounded-full bg-paper/95 px-4 py-2 text-[9px] font-semibold uppercase tracking-[.16em]">Sản phẩm nổi bật</span>
            </a>
            <div class="flex flex-col justify-center p-7 sm:p-12 lg:p-16">
                <p class="eyebrow">Một món đồ, nhiều ngày yêu thích</p>
                <h2 id="studio-pick-title" class="mt-4 font-display text-4xl leading-tight sm:text-5xl">Lựa chọn dành riêng cho bạn.</h2>
                <p class="mt-8 text-xs uppercase tracking-[.16em] text-stone-500">{{ $studioPick->category->name }}</p>
                <h3 class="mt-2 font-display text-2xl sm:text-3xl">{{ $studioPick->name }}</h3>
                @if($studioPick->description)
                    <p class="mt-3 line-clamp-3 max-w-md text-sm leading-6 text-stone-600">{{ $studioPick->description }}</p>
                @endif
                <p class="mt-5 text-sm font-medium">
                    @if($studioPick->sale_price)
                        <span class="text-clay">{{ number_format((float) $studioPick->sale_price, 0, ',', '.') }}₫</span>
                        <span class="ml-2 text-xs text-stone-400 line-through">{{ number_format((float) $studioPick->price, 0, ',', '.') }}₫</span>
                    @else
                        {{ number_format((float) $studioPick->price, 0, ',', '.') }}₫
                    @endif
                </p>
                <a href="{{ route('products.show', $studioPick) }}" class="button-primary mt-7 w-fit">Khám phá thiết kế <span class="ml-4" aria-hidden="true">↗</span></a>
            </div>
        </div>
    </section>
@endif

<section class="container-page py-12 sm:py-20">
    <div class="mb-9 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-end"><div><p class="eyebrow">Tìm phong cách của bạn</p><h2 class="mt-2 font-display text-3xl sm:text-4xl">Danh mục sản phẩm</h2></div><a href="{{ route('products.index') }}" class="eyebrow self-end underline underline-offset-4 sm:self-auto">Xem tất cả <span aria-hidden="true">↗</span></a></div>
    <div class="grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-5">
        @forelse($categories as $category)
            @php($categoryProducts = $category->products->concat($category->children->flatMap->products))
            @php($categoryImage = $categoryProducts->first()?->images->first())
            @php($categoryProductCount = $category->products_count + $category->children->sum(fn ($child) => $child->products->count()))
            <div>
            <a href="{{ route('categories.show', $category) }}" class="group relative flex aspect-[4/5] items-end overflow-hidden rounded-md bg-[#e6e0d6] p-5 sm:p-7">
                @if($categoryImage)<img data-fallback-image src="{{ $categoryImage->url }}" alt="" class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.03]" loading="lazy">@endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/65 via-black/10 to-transparent"></div><div class="relative text-white"><p class="font-display text-2xl sm:text-3xl">{{ $category->name }}</p><p class="mt-1 text-[10px] uppercase tracking-[.15em]">{{ $categoryProductCount }} sản phẩm <span aria-hidden="true">↗</span></p></div>
            </a>
            @if($category->children->isNotEmpty())<div class="mt-3 flex flex-wrap gap-x-4 gap-y-2">@foreach($category->children as $child)<a href="{{ route('categories.show', $child) }}" class="text-xs text-stone-600 underline decoration-stone-300 underline-offset-4 transition-colors hover:text-clay">{{ $child->name }}</a>@endforeach</div>@endif
            </div>
        @empty
            <div class="col-span-full border border-stone-300 py-16 text-center"><p class="font-display text-2xl">Bộ sưu tập mới đang được chuẩn bị.</p><p class="mt-2 text-sm text-stone-600">Hãy quay lại để khám phá những thiết kế tiếp theo.</p></div>
        @endforelse
    </div>
</section>

@if($newArrivals->isNotEmpty())
<section class="container-page pb-14 sm:pb-20"><div class="mb-9 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-end"><div><p class="eyebrow">Vừa có mặt tại studio</p><h2 class="mt-2 font-display text-3xl sm:text-4xl">Sản phẩm mới</h2></div><a href="{{ route('products.index') }}" class="eyebrow self-end underline underline-offset-4 sm:self-auto">Xem tất cả <span aria-hidden="true">↗</span></a></div><div class="grid grid-cols-2 gap-x-4 gap-y-9 md:grid-cols-4 md:gap-6">@foreach($newArrivals as $product)@include('storefront._product-card', ['product' => $product])@endforeach</div></section>
@endif

@if($bestSellers->isNotEmpty())
<section class="bg-[#eeece6] py-14 sm:py-20"><div class="container-page"><div class="mb-9 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-end"><div><p class="eyebrow">Được khách hàng yêu thích</p><h2 class="mt-2 font-display text-3xl sm:text-4xl">Sản phẩm bán chạy</h2></div><a href="{{ route('products.index') }}" class="eyebrow self-end underline underline-offset-4 sm:self-auto">Khám phá thêm <span aria-hidden="true">↗</span></a></div><div class="grid grid-cols-2 gap-x-4 gap-y-9 md:grid-cols-4 md:gap-6">@foreach($bestSellers as $product)@include('storefront._product-card', ['product' => $product])@endforeach</div></div></section>
@endif

@if($saleProducts->isNotEmpty())
<section class="container-page py-14 sm:py-20"><div class="mb-9 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-end"><div><p class="eyebrow text-clay">Ưu đãi có chọn lọc</p><h2 class="mt-2 font-display text-3xl sm:text-4xl">Sale</h2><p class="mt-2 text-sm text-stone-600">Một vài thiết kế yêu thích, nay với mức giá dễ chịu hơn.</p></div><a href="{{ route('sale.index') }}" class="eyebrow self-end underline underline-offset-4 sm:self-auto">Xem tất cả ưu đãi <span aria-hidden="true">↗</span></a></div><div class="grid grid-cols-2 gap-x-4 gap-y-9 md:grid-cols-4 md:gap-6">@foreach($saleProducts as $product)@include('storefront._product-card', ['product' => $product])@endforeach</div></section>
@endif

@if($latestNews->isNotEmpty())
<section class="border-y border-stone-300 bg-white py-14 sm:py-20"><div class="container-page"><div class="mb-9 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-end"><div><p class="eyebrow">Nhật ký của Atelier</p><h2 class="mt-2 font-display text-3xl sm:text-4xl">Tin tức & cảm hứng</h2></div><a href="{{ route('news.index') }}" class="eyebrow self-end underline underline-offset-4 sm:self-auto">Đọc thêm <span aria-hidden="true">↗</span></a></div><div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3">@foreach($latestNews as $article)<article class="group"><a href="{{ route('news.show', $article) }}" class="block"><div class="aspect-[16/10] overflow-hidden rounded-md bg-[#e8e4dc]">@if($article->cover_url)<img src="{{ $article->cover_url }}" alt="{{ $article->title }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.025]">@endif</div><p class="eyebrow mt-4">{{ $article->published_at->format('d.m.Y') }}</p><h3 class="mt-2 font-display text-2xl">{{ $article->title }}</h3><p class="mt-2 line-clamp-2 text-sm leading-6 text-stone-600">{{ $article->excerpt }}</p><span class="mt-4 inline-block text-xs font-semibold uppercase tracking-[.12em]">Đọc câu chuyện ↗</span></a></article>@endforeach</div></div></section>
@endif

<section class="container-page py-16 sm:py-24" aria-labelledby="atelier-story-title">
    <div class="overflow-hidden rounded-md bg-[#e9e5dc] md:grid md:grid-cols-[1.05fr_.95fr]">
        <div class="relative min-h-[320px] overflow-hidden bg-[#d8d1c4] sm:min-h-[480px]"><img data-fallback-image src="https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=1200&q=80" alt="Trang phục tinh giản trong ánh sáng dịu" class="absolute inset-0 h-full w-full object-cover" loading="lazy"><span class="absolute bottom-5 left-5 rounded-full bg-paper/95 px-4 py-2 text-[9px] font-semibold uppercase tracking-[.16em]">Một studio, nhiều câu chuyện</span></div>
        <div class="flex flex-col justify-center p-7 sm:p-12 lg:p-16"><p class="eyebrow">Về {{ $storeSettings->shop_name }}</p><h2 id="atelier-story-title" class="mt-4 font-display text-4xl leading-tight sm:text-5xl">Tủ đồ của bạn nên giống chính bạn.</h2><p class="mt-5 text-sm leading-7 text-stone-600">{{ $storeSettings->shop_name }} bắt đầu từ một ý niệm giản dị: quần áo nên khiến bạn cảm thấy thoải mái và tự tin trong ngày thường. Chúng tôi tuyển chọn những thiết kế tinh giản, dễ kết hợp và có thể trở thành món đồ bạn muốn mặc lại.</p><div class="mt-7 grid gap-4 border-t border-stone-300 pt-6 sm:grid-cols-2"><div><p class="eyebrow">Chọn kỹ</p><p class="mt-2 text-sm text-stone-600">Tập trung vào chất liệu, phom dáng và tính ứng dụng.</p></div><div><p class="eyebrow">Mặc lâu</p><p class="mt-2 text-sm text-stone-600">Ưu tiên thiết kế vượt qua những thay đổi theo mùa.</p></div></div><a href="{{ route('products.index') }}" class="button-primary mt-8 w-fit">Gặp gỡ bộ sưu tập <span class="ml-4" aria-hidden="true">↗</span></a></div>
    </div>
</section>
@endsection
