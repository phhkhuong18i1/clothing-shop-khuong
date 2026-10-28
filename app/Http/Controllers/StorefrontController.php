<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\NewsArticle;
use App\Models\Product;
use App\Models\StoreSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StorefrontController extends Controller
{
    public function home()
    {
        return view('storefront.home', [
            'slides' => StoreSlide::active()->get(),
            'categories' => Category::with(['children' => fn ($q) => $q->whereHas('products', fn ($products) => $products->where('is_published', true)), 'children.products' => fn ($q) => $q->where('is_published', true)->with('images')->latest(), 'products' => fn ($q) => $q->where('is_published', true)->with('images')->latest()])
                ->whereNull('parent_id')
                ->where(fn ($q) => $q->whereHas('products', fn ($products) => $products->where('is_published', true))->orWhereHas('children.products', fn ($products) => $products->where('is_published', true)))
                ->withCount(['products' => fn ($q) => $q->where('is_published', true)])->orderBy('name')->get(),
            'featured' => Product::with(['category', 'images'])->where('is_published', true)->where('is_featured', true)->latest()->take(4)->get(),
            'newArrivals' => Product::with(['category', 'images'])->where('is_published', true)->latest()->take(4)->get(),
            'bestSellers' => Product::with(['category', 'images'])->where('is_published', true)->where('is_best_seller', true)->latest()->take(4)->get(),
            'saleProducts' => $this->saleQuery()->take(4)->get(),
            'latestNews' => NewsArticle::published()->latest('published_at')->take(3)->get(),
        ]);
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->query(), [
            'q' => ['nullable', 'string', 'max:100'], 'category' => ['nullable', 'integer', 'exists:categories,id'],
            'min_price' => ['nullable', 'numeric', 'min:0', 'max:1000000'], 'max_price' => ['nullable', 'numeric', 'min:0', 'max:1000000'],
            'size' => ['nullable', 'string', 'max:20'], 'sort' => ['nullable', 'in:newest,price_asc,price_desc'],
        ]);
        $validator->after(function ($validator) use ($request): void {
            $min = $request->query('min_price'); $max = $request->query('max_price');
            if (is_numeric($min) && is_numeric($max) && (float) $max < (float) $min) $validator->errors()->add('max_price', 'The maximum price must be at least the minimum price.');
        });
        $filters = $validator->validate();
        $products = Product::with(['category', 'images'])->where('is_published', true)
            ->when($filters['q'] ?? null, fn ($q, $term) => $q->where('name', 'like', '%'.$term.'%'))
            ->when($filters['category'] ?? null, function ($query, $id): void {
                $category = Category::with('children')->findOrFail($id);
                $query->whereIn('category_id', $category->children->pluck('id')->push($category->id));
            })
            ->when($filters['min_price'] ?? null, fn ($q, $price) => $q->whereRaw('COALESCE(sale_price, price) >= ?', [$price]))
            ->when($filters['max_price'] ?? null, fn ($q, $price) => $q->whereRaw('COALESCE(sale_price, price) <= ?', [$price]))
            ->when($filters['size'] ?? null, fn ($q, $size) => $q->whereJsonContains('sizes', $size));
        match ($filters['sort'] ?? 'newest') {
            'price_asc' => $products->orderByRaw('COALESCE(sale_price, price) asc'),
            'price_desc' => $products->orderByRaw('COALESCE(sale_price, price) desc'),
            default => $products->latest(),
        };
        return view('storefront.index', [
            'products' => $products->paginate(12)->withQueryString(),
            'categories' => Category::with('parent')->where(fn ($q) => $q->whereHas('products', fn ($products) => $products->where('is_published', true))->orWhereHas('children.products', fn ($products) => $products->where('is_published', true)))->orderByRaw('COALESCE(parent_id, id)')->orderByRaw('parent_id is not null')->orderBy('name')->get(),
            'filters' => $filters,
            'selectedCategoryId' => $filters['category'] ?? null,
        ]);
    }

    public function category(Category $category)
    {
        $categoryIds = $category->children()->whereHas('products', fn ($query) => $query->where('is_published', true))->pluck('id')->push($category->id);
        $products = Product::with(['category', 'images'])->whereIn('category_id', $categoryIds)->where('is_published', true)->latest()->paginate(12);
        abort_if($products->total() === 0, 404);
        $category->load(['children' => fn ($query) => $query->whereHas('products', fn ($products) => $products->where('is_published', true))]);
        return view('storefront.index', [
            'products' => $products,
            'categories' => Category::with('parent')->where(fn ($q) => $q->whereHas('products', fn ($products) => $products->where('is_published', true))->orWhereHas('children.products', fn ($products) => $products->where('is_published', true)))->orderByRaw('COALESCE(parent_id, id)')->orderByRaw('parent_id is not null')->orderBy('name')->get(),
            'filters' => [],
            'activeCategory' => $category,
            'selectedCategoryId' => $category->getKey(),
        ]);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_published, 404);
        $product->load(['category', 'images']);
        $related = Product::with(['category', 'images'])->where('is_published', true)->where('category_id', $product->category_id)->whereKeyNot($product->id)->latest()->take(4)->get();
        return view('storefront.show', compact('product', 'related'));
    }

    public function sale()
    {
        $products = $this->saleQuery()->paginate(12);
        return view('storefront.sale', compact('products'));
    }

    public function about()
    {
        return view('storefront.about');
    }

    public function news()
    {
        $articles = NewsArticle::published()->latest('published_at')->paginate(9);
        return view('storefront.news.index', compact('articles'));
    }

    public function newsShow(NewsArticle $article)
    {
        abort_unless($article->is_published && $article->published_at && $article->published_at->lte(now()), 404);
        $relatedArticles = NewsArticle::published()->whereKeyNot($article->id)->latest('published_at')->take(3)->get();
        return view('storefront.news.show', compact('article', 'relatedArticles'));
    }

    private function saleQuery()
    {
        return Product::with(['category', 'images'])->where('is_published', true)->whereNotNull('sale_price')->whereColumn('sale_price', '<', 'price')->latest();
    }
}
