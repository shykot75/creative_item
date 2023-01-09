<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $products = Product::with('category')->latest()->get();
        return view('home', compact('products'));
    }

    public function search(Request $request){
        $search = $request->search;
        $categories = Category::latest()->get();

        $products = Product::query()->with(['category'])
            ->where('product_name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->latest()->get();
//        $products = Product::where('category_id', $category->id)->get();

        if($request->filter){
            if($request->category_id){
                $products = Product::where('category_id',$request->category_id)->get();
                dd($products);
            }

            if($request->price == 'asc'){
                $products = Product::orderBy('price', 'ASC')->get();
                return $products;
            }
            if($request->price == 'desc'){
                $products = Product::orderBy('price', 'DESC')->get();
                return $products;
            }


//            $category = $request->category_id;
//            $price = $request->price;
//            return $category.' --'.$price;
        }


        return view('search', compact('products', 'categories'));

    }




}
