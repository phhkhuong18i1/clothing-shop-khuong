<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreSlideController extends Controller
{
    public function index()
    {
        $slides = StoreSlide::orderBy('sort_order')->orderBy('id')->paginate(15);
        return view('admin.sliders.index', compact('slides'));
    }

    public function create() { return view('admin.sliders.form', ['slide' => new StoreSlide()]); }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);
        $data['image_path'] = $request->file('image')->store('slides', 'public');
        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');
        StoreSlide::create($data);
        return redirect()->route('admin.sliders.index')->with('status', 'Đã thêm slide.');
    }

    public function edit(StoreSlide $slider)
    {
        return view('admin.sliders.form', ['slide' => $slider]);
    }

    public function update(Request $request, StoreSlide $slider)
    {
        $data = $this->validated($request);
        $oldImage = $slider->image_path;
        if ($request->hasFile('image')) $data['image_path'] = $request->file('image')->store('slides', 'public');
        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');
        $slider->update($data);
        if ($request->hasFile('image') && $oldImage && ! Str::startsWith($oldImage, ['http://', 'https://'])) Storage::disk('public')->delete($oldImage);
        return redirect()->route('admin.sliders.index')->with('status', 'Đã cập nhật slide.');
    }

    public function destroy(StoreSlide $slider)
    {
        $image = $slider->image_path;
        $slider->delete();
        if ($image && ! Str::startsWith($image, ['http://', 'https://'])) Storage::disk('public')->delete($image);
        return redirect()->route('admin.sliders.index')->with('status', 'Đã xóa slide.');
    }

    private function validated(Request $request, bool $imageRequired = false): array
    {
        return $request->validate([
            'eyebrow' => ['nullable', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:500'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'link_label' => ['required', 'string', 'max:80'],
            'link_url' => ['nullable', 'url:http,https', 'max:2048'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
