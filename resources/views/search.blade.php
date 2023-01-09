@extends('website-master')

@section('title')
    Search | Creative Item
@endsection

@section('website-content')
    <div class="col-md-12 py-3">
        <h2 class="text-center my-4">Our Products</h2>

        <div class="row">

            @if($products->isNotEmpty())
                    <div class="row">
                        <div class="col-md-12 my-2">
                            <form  method="GET">
                                @csrf
                                <div class="row form-group">
                                    <div class="col-md-3">
                                       <p>Filter By: </p>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="" class="">Category</label>
                                        <select name="category_id" id="">
                                            <option disabled selected>--Select Category--</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class="">Price</label>
                                        <select name="price" id="">
                                            <option disabled selected>--Select Price--</option>
                                            <option value="asc">Low to High</option>
                                            <option value="desc">High to Low</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="" class=""></label>
                                        <input type="submit" name="filter" value="Filter" class="btn btn-info" />
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

            @foreach($products as $item)
                <div class="col-md-4 my-2">
                    <div class="card" style="width: 18rem;">
                        <img src="{{ asset($item->image) }}" class="card-img-top" alt="Product Image" height="200px" width="150px">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->product_name }}</h5>
                            <p class="card-text">{{ number_format($item->price)  }} Tk</p>
                            <p class="card-text">{{ Str::limit($item->description, 80)  }} </p>
                            <a href="#" class="btn btn-success mr-3">Order</a>
                            <a href="#" class="btn btn-primary float-end">Details</a>
                        </div>
                    </div>
                </div>
            @endforeach

            @else
                <div class="col-md-12 mx-auto my-4 text-center text-danger">
                    <h2>No Product Found!!</h2>
                </div>
            @endif
        </div>


    </div>

@endsection
