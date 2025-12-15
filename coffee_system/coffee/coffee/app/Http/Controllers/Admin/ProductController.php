<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Import File for deleting images

class ProductController extends Controller
{
    public function index()
    {
        // Eager load the categoryData relationship
        $products = Product::with('categoryData')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all(); 
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // --- NEW IMAGE UPLOAD LOGIC (Public Folder) ---
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            // Create a unique name: time + original extension
            $filename = time() . '.' . $file->getClientOriginalExtension();
            
            // Move file to public/images
            $file->move(public_path('images'), $filename);
            
            // Save ONLY the filename to the database
            $validated['image'] = $filename;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); 
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        if ($request->hasFile('image')) {
            // 1. Delete old image from public/images if it exists
            if ($product->image) {
                $oldPath = public_path('images/' . $product->image);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            // 2. Upload new image
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $validated['image'] = $filename;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Delete image from public/images
        if ($product->image) {
            $imagePath = public_path('images/' . $product->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product removed successfully.');
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->status = !$product->status;
        $product->save();
        return back();
    }
}