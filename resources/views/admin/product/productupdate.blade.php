@extends('admin.layouts.master')

@section('title', 'Category - Create Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                {{-- Product Update Card Start --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit Product Detail</h3>
                            </div>
                            <hr>
                            {{-- Account Info Edit Input Open --}}
                            <form action="{{ route('admin#product#update') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="productId" value="{{$productData->id}}">
                                <div class="row">
                                    <div class="col-6">
                                            <img src="{{ asset('storage/' . $productData->image) }}" class="img-thumbnail">
                                        <div class="mt-3">
                                            <input type="file" name="productImage" class="form-control @error('productImage') is-invalid @enderror">
                                            @error('productImage')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn btn-primary col-12" type="submit">
                                                Update<i class="fa-solid fa-arrow-turn-up ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="productName" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="productName" type="text"
                                                class="@error('productName') is-invalid @enderror form-control"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Product Name"
                                                value="{{ old('productName', $productData->name) }}">
                                            @error('productName')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="productDescription" class="control-label mb-1">Description</label>
                                            <textarea name="productDescription" cols="30" rows="10" class=" form-control @error('productDescription') is-invalid @enderror"> {{old('productDescription',$productData->description)}} </textarea>
                                            @error('productDescription')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="productPrice" class="control-label mb-1">Price</label>
                                            <input id="cc-pament" name="productPrice" type="number"
                                                class=" @error('productPrice') is-invalid @enderror form-control"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Product Price"
                                                value="{{ old('productPrice', $productData->price) }}">
                                            @error('productPrice')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="productWaitingTime" class="control-label mb-1">Wiating Time</label>
                                            <input id="cc-pament" name="productWaitingTime" type="number"
                                                class=" @error('productWaitingTime') is-invalid @enderror form-control"
                                                aria-required="true" aria-invalid="false" placeholder="Enter product waiting time"
                                                value="{{ old('productWaitingTime', $productData->waiting_time) }}">
                                            @error('productWaitingTime')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="productCategory" class="control-label mb-1">Category</label>
                                            <select name="productCategory"
                                                class=" @error('productCategory') is-invalid @enderror form-control">
                                                <option value="">Choose Your Gender</option>
                                                @foreach ($categoryData as $categories )
                                                    <option value="{{$categories->id}}" @if ($categories->id == $productData->category_id) selected @endif>{{$categories->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('productCategory')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="viewCount" class="control-label mb-1">View Count</label>
                                            <input id="cc-pament" name="viewCount" type="number" class="form-control"
                                                aria-required="true" aria-invalid="false"
                                                value="{{ old('viewCount', $productData->view_count) }}" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="createdAt" class="control-label mb-1">Created At</label>
                                            <input id="cc-pament" name="createdAt" type="text" class="form-control"
                                                aria-required="true" aria-invalid="false"
                                                value="{{ old('createdAt', $productData->created_at->format('j-F-Y')) }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                {{-- Accoutn Info Edit Input Close --}}
                            </form>
                        </div>
                    </div>
                    {{-- Product Update Card End --}}
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
