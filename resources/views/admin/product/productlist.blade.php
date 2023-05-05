@extends('admin.layouts.master')

@section('title', 'Admin - Category Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Product List</h2>
                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('admin#product#createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>Add Product
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        {{-- Search Keyword --}}
                        <div>
                            <h4 class="text-muted mt-3">Search Keyword -
                                <span class="text-primary">{{ request('searchData') }}</span>
                            </h4>
                        </div>
                        {{-- Search Keyword End --}}
                        {{-- Search Bar and Total --}}
                        <div class="my-5 d-flex flex-column align-items-end">
                            <form class="form-header" action="{{ route('admin#product#listPage') }}" method="get">
                                @csrf
                                <input class="au-input au-input--xl" type="text" name="searchData"
                                    placeholder="Search for datas..."
                                    value="{{ old('searchData',request('searchData')) }}" />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                            <h4 class="text-muted mt-3">Total Products - {{$productData->total()}}<span class="text-primary">
                                    <i class="fa-solid fa-database"></i></span></h4>
                        </div>
                        {{-- Search Bar and Total End --}}
                    </div>
                    @if (session('createdCategory'))
                        <div class="alert alert-success alert-dismissible fade show col-5 offset-7" role="alert">
                            {{ session('createdCategory') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('deletedCategory'))
                        <div class="alert alert-warning alert-dismissible fade show col-5 offset-7" role="alert">
                            {{ session('deletedCategory') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive table-responsive-data2">

                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Cateogry</th>
                                    <th>Views</th>
                                    <th>Operation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productData as $product )
                                    <tr class="tr-shadow">
                                        <td class="col-2"><img src="{{asset('storage/'.$product->image)}}" class="img-thumbnail"></td>
                                        <td class="col-3">{{ $product->name }}</td>
                                        <td class="col-2">{{ $product->price }}</td>
                                        <td class="col-3">{{ $product->category_name }}</td>
                                        <td class="col-2"><i class="fa-regular fa-eye me-2"></i>{{ $product->view_count }}</td>

                                        <td class="col-2">
                                            <div class="table-data-feature">
                                                <a href="{{route('admin#product#editPage',$product->id)}}" class="me-2">
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Edit">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                </a>
                                                <a href="{{route('admin#product#delete',$product->id)}}" class="me-2">
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Delete">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </a>
                                                <a href="{{route('admin#product#detailPage',$product->id)}}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Detail">
                                                        <i class="fa-solid fa-info"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{$productData->links()}}
                        </div>

                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
