@extends('admin.layouts.master')

@section('title', 'Category - Create Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-3 offset-8">
                        <a href="{{ route('admin#product#listPage') }}"><button
                                class="btn bg-dark text-white my-3">List</button></a>
                    </div>
                </div>
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Create Product Form</h3>
                            </div>
                            <hr>
                            <form action="{{ route('admin#product#create') }}" enctype="multipart/form-data" method="post"
                                novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label for="categoryName" class="control-label mb-1">Product Name</label>
                                    <input id="cc-pament" name="productName" type="text"
                                        class="form-control @error('productName') is-invalid @enderror" aria-required="true"
                                        aria-invalid="false" placeholder="Product Name...">
                                    @error('productName')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="categoryName" class="control-label mb-1">Product Category</label>
                                    <select name="productCategory"
                                        class="form-control @error('productCategory') is-invalid @enderror">
                                        <option value="">Choose Product Category</option>
                                        @foreach ($categoryData as $categories)
                                            <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('productCategory')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="categoryName" class="control-label mb-1">Product Description</label>
                                    <textarea name="productDescription" class="form-control @error('productDescription') is-invalid @enderror"
                                        cols="30" rows="10"></textarea>
                                    @error('productDescription')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="categoryName" class="control-label mb-1">Product Image</label>
                                    <input type="file" name="productImage"
                                        class="form-control @error('productImage') is-invalid @enderror">
                                    @error('productImage')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="categoryName" class="control-label mb-1">Product Waiting Time</label>
                                    <input type="number" name="productWaitingTime" class="form-control @error('productWaitingTime') is-invalid @enderror" placeholder="Product Waiting Time">
                                    @error('productWaitingTime')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="categoryName" class="control-label mb-1">Product Price</label>
                                    <input id="cc-pament" name="productPrice" type="number"
                                        class="form-control @error('productPrice') is-invalid @enderror"
                                        aria-required="true" aria-invalid="false" placeholder="Product Price">
                                    @error('productPrice')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <span id="payment-button-amount">Confirm Create</span>
                                        <i class="fa-solid fa-circle-right"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
