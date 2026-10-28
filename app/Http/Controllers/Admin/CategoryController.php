<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate(['q' => ['nullable', 'string', 'max:100']]);
        $categories = Category::with('parent')->withCount(['products', 'children'])->when($filters['q'] ?? null, fn ($q, $term) => $q->where('name', 'like', '%'.str_replace(['%', '_'], ['\\%', '\\_'], $term).'%'))->orderByRaw('COALESCE(parent_id, id)')->orderByRaw('parent_id is not null')->orderBy('name')->paginate(15)->withQueryString();
        return view('admin.categories.index', compact('categories'));
    }
    public function create() { return view('admin.categories.form', ['category' => new Category(), 'parents' => Category::whereNull('parent_id')->orderBy('name')->get()]); }
    public function store(Request $request)
    {
        $data = $this->validated($request);
        Category::create([...$data, 'slug' => $this->uniqueSlug($data['name'])]);
        return redirect()->route('admin.categories.index')->with('status', 'Đã tạo danh mục.');
    }
    public function edit(Category $category) { return view('admin.categories.form', ['category' => $category, 'parents' => Category::whereNull('parent_id')->whereKeyNot($category->id)->orderBy('name')->get()]); }
    public function update(Request $request, Category $category)
    {
        $data = $this->validated($request, $category);
        $category->update([...$data, 'slug' => $this->uniqueSlug($data['name'], $category->id)]);
        return redirect()->route('admin.categories.index')->with('status', 'Đã cập nhật danh mục.');
    }
    public function destroy(Category $category)
    {
        if ($category->products()->exists()) return back()->withErrors(['category' => 'Hãy chuyển hoặc xóa sản phẩm trong danh mục này trước khi xóa danh mục.']);
        if ($category->children()->exists()) return back()->withErrors(['category' => 'Hãy chuyển các danh mục con sang danh mục cha khác trước khi xóa danh mục.']);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('status', 'Đã xóa danh mục.');
    }
    private function validated(Request $request, ?Category $category = null): array
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:120'], 'description' => ['nullable', 'string', 'max:2000'], 'parent_id' => ['nullable', 'integer', 'exists:categories,id']]);
        if (! empty($data['parent_id'])) {
            $parent = Category::findOrFail($data['parent_id']);
            if ($parent->parent_id !== null || $parent->is($category)) {
                throw \Illuminate\Validation\ValidationException::withMessages(['parent_id' => 'Chỉ chọn danh mục gốc làm danh mục cha.']);
            }
        }
        return $data;
    }
    private function uniqueSlug(string $name, ?int $ignore = null): string
    {
        $slug = Str::slug($name) ?: 'category'; $base = $slug; $i = 2;
        while (Category::where('slug', $slug)->when($ignore, fn ($q) => $q->whereKeyNot($ignore))->exists()) $slug = $base.'-'.$i++;
        return $slug;
    }
}
