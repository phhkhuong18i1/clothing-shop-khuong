@extends('layouts.store')
@section('title', 'Giới thiệu')
@section('content')
<article>
    <section class="container-page py-10 sm:py-16">
        <div class="grid overflow-hidden rounded-md bg-[#e9e5dc] md:grid-cols-[.9fr_1.1fr]">
            <div class="flex flex-col justify-center p-7 sm:p-12 lg:p-16">
                <p class="eyebrow">Câu chuyện của chúng tôi</p>
                <h1 class="mt-4 font-display text-4xl leading-tight sm:text-6xl">{{ $storeSettings->shop_name }}<br><span class="text-clay">Mặc theo cách của bạn.</span></h1>
                <p class="mt-6 max-w-lg text-sm leading-7 text-stone-600">Chúng tôi tin quần áo nên khiến bạn thấy thoải mái, tự tin và là chính mình. Vì vậy, {{ $storeSettings->shop_name }} tuyển chọn những thiết kế tinh giản, dễ kết hợp và phù hợp với nhịp sống hằng ngày.</p>
                <a href="{{ route('products.index') }}" class="button-primary mt-8 w-fit">Khám phá bộ sưu tập <span class="ml-4" aria-hidden="true">↗</span></a>
            </div>
            <div class="relative min-h-[340px] bg-[#d8d1c4] sm:min-h-[520px]"><img data-fallback-image src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1400&q=85" alt="Những trang phục tông màu tự nhiên được tuyển chọn cho tủ đồ hằng ngày" class="absolute inset-0 h-full w-full object-cover" fetchpriority="high"></div>
        </div>
    </section>

    <section class="container-page py-12 sm:py-20">
        <div class="mx-auto max-w-2xl text-center"><p class="eyebrow">Điều chúng tôi theo đuổi</p><h2 class="mt-3 font-display text-3xl leading-tight sm:text-5xl">Một tủ đồ tốt bắt đầu từ những lựa chọn có chủ đích.</h2><p class="mt-5 text-sm leading-7 text-stone-600">Thay vì chạy theo thật nhiều xu hướng, chúng tôi muốn giúp bạn tìm thấy những món đồ có thể phối cùng nhau, mặc trong nhiều dịp và muốn chọn lại mỗi ngày.</p></div>
        <div class="mt-10 grid border-y border-stone-300 md:grid-cols-3 md:divide-x md:divide-stone-300">
            <div class="py-7 md:px-7 md:first:pl-0"><span class="eyebrow text-clay">01 · Chất liệu</span><h3 class="mt-3 font-display text-2xl">Dễ chịu khi mặc</h3><p class="mt-3 text-sm leading-6 text-stone-600">Ưu tiên cảm giác thoải mái và tính ứng dụng cho những ngày thường.</p></div>
            <div class="border-t border-stone-200 py-7 md:border-0 md:px-7"><span class="eyebrow text-clay">02 · Phom dáng</span><h3 class="mt-3 font-display text-2xl">Tự nhiên, linh hoạt</h3><p class="mt-3 text-sm leading-6 text-stone-600">Những phom dáng dễ kết hợp để bạn tự tạo nên phong cách của mình.</p></div>
            <div class="border-t border-stone-200 py-7 md:border-0 md:px-7 md:pr-0"><span class="eyebrow text-clay">03 · Màu sắc</span><h3 class="mt-3 font-display text-2xl">Mặc được qua nhiều mùa</h3><p class="mt-3 text-sm leading-6 text-stone-600">Bảng màu tinh giản giúp các món đồ tìm thấy nhau trong tủ quần áo.</p></div>
        </div>
    </section>

    <section class="bg-[#eeece6] py-12 sm:py-16"><div class="container-page grid gap-8 md:grid-cols-2 md:items-center"><div><p class="eyebrow">Luôn sẵn sàng trò chuyện</p><h2 class="mt-3 font-display text-3xl sm:text-4xl">Tìm món đồ phù hợp với bạn.</h2><p class="mt-4 max-w-lg text-sm leading-7 text-stone-600">Nếu bạn cần thêm thông tin về sản phẩm, chất liệu hoặc kích cỡ, hãy liên hệ với {{ $storeSettings->shop_name }}. Chúng tôi rất vui được hỗ trợ.</p></div><div class="flex flex-wrap gap-3 md:justify-end">@if($storeSettings->email)<a class="button-outline" href="mailto:{{ $storeSettings->email }}">Gửi email</a>@endif @if($storeSettings->phone)<a class="button-primary" href="tel:{{ preg_replace('/[^0-9+]/', '', $storeSettings->phone) }}">Gọi {{ $storeSettings->phone }}</a>@endif @if(!$storeSettings->email && !$storeSettings->phone)<a class="button-primary" href="{{ route('news.index') }}">Đọc câu chuyện của chúng tôi</a>@endif</div></div></section>
</article>
@endsection
