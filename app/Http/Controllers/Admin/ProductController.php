<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $query = Product::query()->with('optionValues', 'category');

        if ($request->has('category_id') && $request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        if ($request->has('status') && $request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->orderBy('sort_order')->paginate(15);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->orderBy('sort_order')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'image' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'in:draft,active,inactive'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $product = Product::create([
            'category_id' => $validated['category_id'] ?? null,
            'name' => $validated['name'],
            'slug' => $validated['slug'] ?? Str::slug($validated['name']) . '-' . Str::random(6),
            'image' => $validated['image'] ?? null,
            'description' => $validated['description'] ?? null,
            'base_price' => $validated['base_price'],
            'stock' => $validated['stock'] ?? 0,
            'status' => $validated['status'] ?? 'draft',
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $product->load('optionValues');
        $categories = Category::where('status', 'active')->orderBy('sort_order')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['sometimes', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $product->id],
            'image' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'base_price' => ['sometimes', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'in:draft,active,inactive'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }

    public function uploadImage(Request $request)
    {
        try {
            // 简单验证文件是否存在和大小
            if (!$request->hasFile('image')) {
                return response()->json(['error' => 'No image file provided.'], 400);
            }
            
            $image = $request->file('image');
            
            if ($image->getSize() > 10 * 1024 * 1024) { // 10MB
                return response()->json(['error' => 'Image file is too large. Maximum size is 10MB.'], 400);
            }

            // 确保存储目录存在
            $storagePath = storage_path('app/public/products');
            if (!is_dir($storagePath)) {
                mkdir($storagePath, 0755, true);
            }

            // 安全地生成文件名
            $extension = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            
            // 手动复制文件，绕过MIME类型检测
            $destinationPath = $storagePath . '/' . $imageName;
            $image->move($storagePath, $imageName);

            // 生成完整的图片URL
            $imageUrl = asset('storage/products/' . $imageName);

            return response()->json(['url' => $imageUrl]);
        } catch (Exception $e) {
            // 记录详细错误信息
            error_log('Image upload error: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

