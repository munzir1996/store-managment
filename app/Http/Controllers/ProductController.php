<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Product;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with(['category', 'subcategory'])->get();

        return inertia()->render('Dashboard/products/index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return inertia()->render('Dashboard/products/create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {

        $data = $request->validated();

        $product = new Product();

        $product->name = $data['name'];
        $product->weight = $data['weight'];
        $product->category_id = $data['category_id'];
        $product->subcategory_id = $data['subcategory_id'];
        $product->added_value = $data['added_value'];
        $product->deducted_value = $data['deducted_value'];
        $product->total_price = $product->setTotalPrice($data['weight'], $data['added_value'], $data['deducted_value']);
        $product->code = $data['code'];
        $product->stock = $data['stock'];

        if ($request->has('image')) {

            $product->addMedia($data['image'])->preservingOriginal()->toMediaCollection('products');
        }

        $product->save();

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'تم أضافة المنتج'
        ]);

        return redirect()->route('products.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return inertia()->render('Dashboard/products/edit', [
            'product' => $product,
            'categories' => $categories,
            'image' => $product->getFirstMedia('products')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $data = $request->validated();

        $product->update([
            'name' => $data['name'],
            'weight' => $data['weight'],
            'category_id' => $data['category_id'],
            'subcategory_id' => $data['subcategory_id'],
            'added_value' => $data['added_value'],
            'deducted_value' => $data['deducted_value'],
            'total_price' => $product->setTotalPrice($data['weight'], $data['added_value'], $data['deducted_value']),
            'code' => $data['code'],
            'stock' => $data['stock'],
        ]);

        if ($request->has('image')) {

            $mediaItems = $product->getMedia();
            $mediaItems[0]->delete();
            $product->addMedia($data['image'])->preservingOriginal()->toMediaCollection('products');

        }


        session()->flash('toast', [
            'type' => 'success',
            'message' => 'تم تعديل المنتج'
        ]);

        return redirect()->route('products.create');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        session()->flash('toast', [
            'type' => 'success',
            'message' => 'تم حذف المنتج'
        ]);

        return redirect()->route('categories.index');
    }
}
