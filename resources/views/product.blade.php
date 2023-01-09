@extends('master')

@section('title')
    Products | Creative Item
@endsection


@section('body')

    <section class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if(Request::RouteIs('edit.product'))
                        <h3 class="card-title mb-4">Edit Product Form</h3>
                        <form action="{{ route('update.product',$product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row mb-4">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Product Name</label>
                                <div class="col-sm-8">
                                    <input type="text" name="product_name" class="form-control" id="horizontal-firstname-input" value="{{ $product->product_name }}">
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <div class="col-sm-6">
                                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Category</label>
                                    <div class="col-sm-9">
                                        <select name="category_id" class="form-control" id="">
                                            <option value="">-- Select Category --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }} >{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Product Price</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="price" class="form-control" id="horizontal-firstname-input" value="{{ $product->price }}" >
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="horizontal-email-input" class="col-sm-3 col-form-label">Image</label>
                                <div class="col-sm-9">
                                    <img src="{{ asset($product->image) }}" height="200px" width="200px" alt="">
                                    <input type="file" name="image" accept="image/*" class="form-control" id="horizontal-email-input">
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label for="horizontal-password-input" class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea name="description" class="form-control" cols="30" rows="5">{!! $product->description !!}</textarea>
                                </div>
                            </div>

                            <div class="form-group row justify-content-end">
                                <div class="col-sm-9">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">Update Product</button>
                                    </div>
                                </div>
                            </div>
                        </form
                    @else
                    <h3 class="card-title mb-4">Create Product Form</h3>
                    <form action="{{ route('store.product') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mb-4">
                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Product Name</label>
                            <div class="col-sm-8">
                                <input type="text" name="product_name" class="form-control" id="horizontal-firstname-input">
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <div class="col-sm-6">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Category</label>
                                <div class="col-sm-9">
                                    <select name="category_id" class="form-control" id="">
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="horizontal-firstname-input" class="col-sm-3 col-form-label">Product Price</label>
                                <div class="col-sm-9">
                                    <input type="number" name="price" class="form-control" id="horizontal-firstname-input">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="horizontal-email-input" class="col-sm-3 col-form-label">Image</label>
                            <div class="col-sm-9">
                                <input type="file" name="image" accept="image/*" class="form-control" id="horizontal-email-input">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label for="horizontal-password-input" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="form-group row justify-content-end">
                            <div class="col-sm-9">
                                <div>
                                    <button type="submit" class="btn btn-primary w-md">Create New Product</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif

                </div>
            </div>
        </div>
    </section>



    <section class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manage Products</h4>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">

                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>
                                        <img src="{{ asset($product->image) }}" alt="" height="60px" width="60px">
                                    </td>
                                    <td>{{$product->product_name}}</td>
                                    <td>{{$product->category->category_name}}</td>
                                    <td>{{ number_format($product->price) }} Tk</td>
                                    <td>
                                        <a href="{{ route('edit.product',$product->id) }}" class="btn btn-success btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('destroy.product',$product->id) }}" id="delete" class="btn btn-danger btn-sm ">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
