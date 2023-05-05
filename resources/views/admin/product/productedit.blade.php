@extends('admin.layouts.master')

@section('title', 'Category - Create Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-9">
                    @if (session('accountUpdate'))
                        <div class="alert alert-success alert-dismissible fade show col-5 offset-7" role="alert">
                            {{ session('accountUpdate') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                {{-- Product Card Start --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2 fs-2 fw-bold">Product Details</h3>
                            </div>

                            <hr>
                            {{-- Account Image and Data Open --}}
                            <div class="row justify-content-center">
                                <div class="col-4">
                                        <img src="{{ asset('storage/' . $productData->image) }}" class="img-thumbnail">
                                </div>
                                <div class="col-6">
                                    <h3 class="my-3 text-uppercase">{{ $productData->name }} </h3>
                                    <span class="my-3 me-2 btn-sm btn-primary rounded-3"><i class="fa-solid fa-money-bill-wave me-2"></i>{{ $productData->price }} </span>
                                    <span class="my-3 me-2 btn-sm btn-primary rounded-3"><i class="fa-solid fa-clock me-2"></i>{{ $productData->waiting_time }} </span>
                                    <span class="my-3 me-2 btn-sm btn-primary rounded-3"><i class="fa-solid fa-eye me-2"></i>{{ $productData->view_count }} </span>
                                    <span class="my-3 me-2 btn-sm btn-primary rounded-3"><i class="fa-solid fa-rectangle-list me-2"></i>{{ $productData->category_name }} </span>
                                    <span class="my-3 me-2 btn-sm btn-primary rounded-3"><i class="fa-solid fa-calendar-check me-2"></i>{{ $productData->created_at->format('j-F-Y') }} </span>
                                    <div>
                                        <h5 class="mt-3 mb-1"><i class="fa-solid fa-clipboard me-2"></i>Description</h5>
                                        <p class="text-muted"> {{$productData->description}} </p>
                                    </div>
                                </div>
                            </div>
                            {{-- Account Image and Data Close --}}

                            {{-- Edit Button Open --}}
                            <div class="row mt-3">
                                <div class="col-2 offset-1">
                                   <div class="btn btn-primary">
                                        <i class="fa-solid fa-chevron-left me-2" onclick="history.back()"></i>Back
                                   </div>
                                </div>
                                <div class="col-3 offset-6">
                                    <a href="{{ route('admin#product#editPage',$productData->id) }}" class="btn btn-primary">
                                        <i class="fa-solid fa-pen me-2"></i>Edit Profile
                                    </a>
                                </div>
                            </div>
                            {{-- Edit Button Close --}}
                        </div>
                    </div>
                    {{-- Product Card End --}}
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
