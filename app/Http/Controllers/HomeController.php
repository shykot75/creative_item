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

        $categoryByProduct = Category::query()
            ->where('category_name', 'LIKE', "%{$search}%")->with(['products'])->get();

        $products = Product::query()->with(['category'])
            ->where('product_name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->latest()->get();
        $searchProduct = $products->pluck('id')->toArray();
//        return $searchProduct;

        if($request->filter){
            if($request->category_id){
                $products = Product::whereIn('id',$searchProduct)->where('category_id',$request->category_id)->get();
            }
            if($request->price == 'asc'){
                $products = Product::whereIn('id',$searchProduct)->orderBy('price', 'ASC')->get();
            }
            if($request->price == 'desc'){
                $products = Product::whereIn('id',$searchProduct)->orderBy('price', 'DESC')->get();
            }
        }

        return view('search', compact('products', 'categories', 'categoryByProduct'));

    }

    public function filter(Request $request){
        return $request;
    }




}
