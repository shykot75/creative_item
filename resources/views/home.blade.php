@extends('website-master')

@section('title')
    Home | Creative Item
@endsection

@section('website-content')
    <div class="col-md-12 py-3">
        <h2 class="text-center my-4">Our Products</h2>

            <div class="row">
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
            </div>


    </div>

@endsection
