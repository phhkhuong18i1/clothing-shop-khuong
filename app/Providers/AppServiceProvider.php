<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Lang;
use App\Models\Category;
use App\Models\StoreSetting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}
    public function boot(): void
    {
        $validationLines = [
            'accepted' => ':attribute phải được chấp nhận.',
            'array' => ':attribute phải là một danh sách.',
            'boolean' => ':attribute không hợp lệ.',
            'email' => ':attribute phải là địa chỉ email hợp lệ.',
            'exists' => ':attribute đã chọn không hợp lệ.',
            'image' => ':attribute phải là tệp hình ảnh.',
            'in' => ':attribute đã chọn không hợp lệ.',
            'integer' => ':attribute phải là số nguyên.',
            'max.array' => ':attribute không được có quá :max mục.',
            'max.file' => ':attribute không được lớn hơn :max KB.',
            'max.numeric' => ':attribute không được lớn hơn :max.',
            'max.string' => ':attribute không được dài quá :max ký tự.',
            'mimes' => ':attribute phải có định dạng: :values.',
            'min.array' => ':attribute phải có ít nhất :min mục.',
            'min.file' => ':attribute phải có dung lượng tối thiểu :min KB.',
            'min.numeric' => ':attribute phải lớn hơn hoặc bằng :min.',
            'min.string' => ':attribute phải có ít nhất :min ký tự.',
            'numeric' => ':attribute phải là một số.',
            'regex' => ':attribute không đúng định dạng.',
            'required' => 'Vui lòng nhập :attribute.',
            'string' => ':attribute phải là văn bản.',
            'unique' => ':attribute đã được sử dụng.',
            'lt.numeric' => ':attribute phải nhỏ hơn :value.',
            'lt.string' => ':attribute phải ngắn hơn :value ký tự.',
            'attributes.name' => 'tên',
            'attributes.category_id' => 'danh mục',
            'attributes.description' => 'mô tả',
            'attributes.email' => 'email',
            'attributes.images' => 'hình ảnh',
            'attributes.max_price' => 'giá cao nhất',
            'attributes.min_price' => 'giá thấp nhất',
            'attributes.price' => 'giá bán',
            'attributes.sale_price' => 'giá ưu đãi',
            'attributes.sku' => 'mã sản phẩm',
            'attributes.stock_quantity' => 'số lượng tồn kho',
        ];
        Lang::addLines(collect($validationLines)->mapWithKeys(fn ($line, $key) => ['validation.'.$key => $line])->all(), 'vi');
        Lang::addLines(['pagination.previous' => '&laquo; Trước', 'pagination.next' => 'Tiếp &raquo;'], 'vi');

        View::composer('layouts.store', function ($view): void {
            $hasPublishedProducts = fn ($products) => $products->where('is_published', true);
            $categories = Category::whereNull('parent_id')
                ->where(fn ($query) => $query->whereHas('products', $hasPublishedProducts)->orWhereHas('children.products', $hasPublishedProducts))
                ->with(['children' => fn ($query) => $query->whereHas('products', $hasPublishedProducts)])
                ->orderBy('name')->get();
            $view->with('navCategories', $categories);
        });
        View::composer(['layouts.store', 'layouts.admin', 'storefront.*', 'admin.auth.*'], function ($view): void {
            $view->with('storeSettings', StoreSetting::query()->first() ?? new StoreSetting(StoreSetting::defaults()));
        });
    }
}
