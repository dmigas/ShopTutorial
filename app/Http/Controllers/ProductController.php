<?php

namespace App\Http\Controllers;

use App\Http\Filter\ProductFilter;
use App\Http\Requests\StoreProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct(){
        #$this->middleware('auth')->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProductFilter $filter
     * @return Response
     */
    public function index(ProductFilter $filter)
    {
        $products = Product::filter($filter)->get();

        return view('products.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = \App\Models\Category::all();

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProduct $request
     * @return Response
     */
    public function store(StoreProduct $request)
    {
        #dd($request->all());

        $path = $request->file('img')->store('public/images');

        $product = new Product([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'amount' => $request->amount
        ]);

        $product->save();

        $product->productImages()->create([
            'path' => $path
        ]);

        $product->categories()->attach(
            $request->input('categories')
        );

        return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return Response
     */
    public function show(Product $product)
    {
        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return Response
     */
    public function edit(Product $product)
    {
        return view('products.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Product $product
     * @return Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'required|max:255',
            'price' => 'required',
            'amount' => 'required'
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->amount = $request->amount;

        $product->save();

        return redirect('product/' . $product->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }
}
