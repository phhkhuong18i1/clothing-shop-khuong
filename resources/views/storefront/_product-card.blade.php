@php($isOnSale = $product->sale_price && (float) $product->sale_price < (float) $product->price)
<article class="group min-w-0">
    <a href="{{ route('products.show', $product) }}" class="block rounded-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-ink" aria-label="Xem {{ $product->name }}">
        <div class="relative aspect-[4/5] overflow-hidden rounded-md bg-[#e8e4dc]">
            @if($product->images->first())
                <img data-fallback-image class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.035]" src="{{ $product->images->first()->url }}" alt="{{ $product->images->first()->alt_text ?: $product->name }}" loading="lazy">
            @else
                <div class="grid h-full place-items-center"><span class="font-display text-3xl text-stone-400">{{ $storeSettings->shop_name }}</span></div>
            @endif

            <div class="absolute left-3 top-3 flex max-w-[calc(100%-1.5rem)] flex-wrap gap-1.5 sm:left-4 sm:top-4 sm:gap-2">
                @if($isOnSale && $storeSettings->badge_sale)<span class="max-w-full rounded-sm bg-clay px-2 py-1.5 text-[8px] font-semibold uppercase leading-tight tracking-[.1em] text-white sm:px-3 sm:py-2 sm:text-[9px] sm:tracking-[.14em]">{{ $storeSettings->badge_sale }}</span>@endif
                @if($product->is_best_seller && $storeSettings->badge_best_seller)<span class="max-w-full rounded-sm bg-paper/95 px-2 py-1.5 text-[8px] font-semibold uppercase leading-tight tracking-[.08em] text-ink sm:px-3 sm:py-2 sm:text-[9px] sm:tracking-[.12em]">{{ $storeSettings->badge_best_seller }}</span>
                @elseif($product->is_featured && $storeSettings->badge_featured)<span class="max-w-full rounded-sm bg-paper/95 px-2 py-1.5 text-[8px] font-semibold uppercase leading-tight tracking-[.08em] text-ink sm:px-3 sm:py-2 sm:text-[9px] sm:tracking-[.12em]">{{ $storeSettings->badge_featured }}</span>@endif
            </div>

            <span class="absolute bottom-3 right-3 grid h-10 w-10 translate-y-1 place-items-center rounded-full bg-paper text-ink opacity-100 transition-all duration-200 group-hover:translate-y-0 group-hover:bg-ink group-hover:text-white group-focus-visible:translate-y-0 sm:bottom-4 sm:right-4 sm:opacity-0 sm:group-hover:opacity-100 sm:group-focus-visible:opacity-100" aria-hidden="true">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 10h12m-5-5 5 5-5 5"/></svg>
            </span>
        </div>

        <div class="pt-4">
            <p class="eyebrow">{{ $product->category->name }}</p>
            <h3 class="mt-2 line-clamp-2 min-h-11 font-display text-base leading-snug text-ink transition-colors group-hover:text-clay sm:text-lg">{{ $product->name }}</h3>
            <div class="mt-2 flex flex-wrap items-baseline gap-x-2 gap-y-1">
                @if($isOnSale)
                    <span class="text-sm font-semibold text-clay sm:text-base">{{ number_format((float) $product->sale_price, 0, ',', '.') }}₫</span>
                    <span class="text-xs text-stone-400 line-through">{{ number_format((float) $product->price, 0, ',', '.') }}₫</span>
                    @if((float) $product->price > 0)<span class="ml-auto text-[10px] font-semibold uppercase tracking-wider text-clay">−{{ (int) round((1 - (float) $product->sale_price / (float) $product->price) * 100) }}%</span>@endif
                @else
                    <span class="text-sm font-medium sm:text-base">{{ number_format((float) $product->price, 0, ',', '.') }}₫</span>
                @endif
            </div>
        </div>
    </a>
</article>
