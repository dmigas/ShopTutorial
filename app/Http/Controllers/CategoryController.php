<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategory;
use App\Http\Requests\StoreProduct;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(){
        return view('categories.create');
    }

    public function store(StoreCategory $request){
        $category = new Category([
            'name' => $request->name
        ]);

        $category->save();

        return redirect('/products');
    }
}
