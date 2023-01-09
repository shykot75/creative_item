<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        $products = Product::with('category')->latest()->get();
        return view('product', compact('categories', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'product_name' => 'required|min:3|max:50',
            'category_id' => 'required',
            'price' => 'required',
        ]);

       try {
           DB::beginTransaction();

           // IMAGE SECTION
           $image = $request->file('image');
           if($image != null){

               $name = Str::random(5).'.'.$image->getClientOriginalExtension();
               $destinationPath = public_path('/uploads/product-image');
               if (!File::exists($destinationPath)) {
                   File::makeDirectory($destinationPath, 0777, true);
               }
               Image::make($image->getRealPath())->resize(200, 200, function ($constraint) {
                   $constraint->aspectRatio();
               })->save($destinationPath.'/'.$name);
               $destinationPath = 'uploads/product-image/';
           }
           // IMAGE SECTION

           $product = new Product();
           $product->product_name = $request->product_name;
           $product->category_id = $request->category_id;
           $product->price = $request->price;
           $product->image = $destinationPath.$name;
           $product->description = $request->description;
           $product->save();
           DB::commit();
           Alert::success('Product Created Successfully..');
           return back();

       }
       catch(\Exception $e){
           DB::rollBack();
           Alert::error($e->getMessage());
           return redirect()->back();
       }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::latest()->get();
        $product = Product::findOrFail($id);

        $products = Product::with('category')->where('id', '!=', $product->id)->latest()->get();


        return view('product', compact('categories', 'products', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'product_name' => 'required|min:3|max:50',
            'category_id' => 'required',
            'price' => 'required',
        ]);

        $product = Product::findOrFail($id);
        try {
            DB::beginTransaction();

            // IMAGE SECTION
            $image = $request->file('image');
            if($image != null){
                if($product->image != null){
                    unlink(public_path($product->image));
                }
                $name = Str::random(5).'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/product-image');
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true);
                }
                Image::make($image->getRealPath())->resize(200, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$name);
                $destinationPath = 'uploads/product-image/';
                $product->image = $destinationPath.$name;
            }
            // IMAGE SECTION

            $product->product_name = $request->product_name;
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->save();
            DB::commit();
            Alert::success('Product Updated Successfully..');
            return redirect()->route('all.product');

        }
        catch(\Exception $e){
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if($product->image != null) {
            unlink(public_path($product->image));
        }
        $product->delete();
        Alert::success('Product Deleted Successfully..');
        return back();

    }
}
