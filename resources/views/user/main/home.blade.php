@extends('user.layouts.master')

@section('content')
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter By
                        Category</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div
                            class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 shadow-sm p-2 rounded-2">
                            <label class="fw-bold text-dark">CATEGORIES</label>
                            <span class="badge bg-primary px-2">{{ count($categories) }}</span>
                        </div>
                        <div
                            class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 shadow-sm p-2 rounded-2">
                            <a href="{{ route('user#homepage') }}" class="text-dark text-decoration-none">All</a>
                        </div>
                        @foreach ($categories as $category)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 shadow-sm p-2 rounded-2">
                                <a href="{{ route('user#categoryfilter', $category->id) }}"
                                    class="text-dark text-decoration-none">{{ $category->name }}</a>
                            </div>
                        @endforeach
                    </form>
                </div>
                <!-- Price End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                {{-- Your Cart Badge --}}
                                <a href="{{ route('user#cart#list') }}"
                                    class="btn btn-primary position-relative rounded-2 fw-bold">
                                    Your Cart<i class="fa-solid fa-cart-plus ms-2"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cart->count() }}
                                    </span>
                                </a>

                                {{-- Your History Badge --}}
                                <a href="{{ route('user#historypage') }}"
                                    class="btn btn-primary position-relative rounded-2 fw-bold ms-3">
                                    Your History<i class="fa-solid fa-clock-rotate-left ms-2"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $history->count() }}
                                    </span>
                                </a>
                            </div>
                            <div class="ml-2">
                                <select name="sortingOption" id="sorting"
                                    class="form-control border-0 shadow-sm rounded-2 px-4">
                                    <option value="">Choose Option...</option>
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <span class="row" id="productList">
                        @foreach ($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" style="height:250px;"
                                            src="{{ asset('storage/' . $product->image) }}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square detailButton"
                                                href="{{ route('user#product#detailpage', $product->id) }}">
                                                <i class="fa-solid fa-circle-info"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate"
                                            href="">{{ $product->name }}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>{{ $product->price }} kyats</h5>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </span>
                </div>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
    </div>
    <!-- Shop End -->
@endsection

@section('scripting')
    <script>
        $(document).ready(function() {

            //Details Button
            $('.detailButton').click(function(){
                console.log('Detail Button Had Been Clicked!');
            });

            //sorting
            $('#sorting').change(function() {
                $sortingOrder = $('#sorting').val();

                if ($sortingOrder == 'asc') {
                    $.ajax({
                        type: 'get',
                        url: 'http://127.0.0.1:8000/user/ajax/productlist',
                        data: {
                            'order': 'ascending'
                        },
                        datatype: 'JSON',
                        success: function(response) {
                            $list = '';
                            for ($i = 0; $i < response.length; $i++) {
                                $list += `
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" style="height:250px;"
                                                src="{{ asset('storage/${response[$i].image}') }}" alt="">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square" href=""><i
                                                        class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href=""><i
                                                        class="fa-solid fa-circle-info"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>${response[$i].price} kyats</h5>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center mb-1">
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                            }
                            $('#productList').html($list);
                        }
                    });
                } else if ($sortingOrder == 'desc') {
                    $.ajax({
                        type: 'get',
                        url: 'http://127.0.0.1:8000/user/ajax/productlist',
                        data: {
                            'order': 'descending'
                        },
                        datatype: 'JSON',
                        success: function(response) {
                            $list = '';
                            for ($i = 0; $i < response.length; $i++) {
                                $list += `
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" style="height:250px;"
                                                src="{{ asset('storage/${response[$i].image}') }}" alt="">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square" href=""><i
                                                        class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href=""><i
                                                        class="fa-solid fa-circle-info"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>${response[$i].price} kyats</h5>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center mb-1">
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                            }
                            $('#productList').html($list);
                        }
                    });
                }
            });
        });
    </script>
@endsection
