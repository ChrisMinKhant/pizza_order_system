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
                                <h2 class="title-1 fs-1 fw-bolder">Product List</h2>
                            </div>
                        </div>
                    </div>
                    {{-- Order Details --}}
                    <div class="row">
                        <div class="card col-5 shadow-sm rounded-2">
                            <div class="card-body">
                                <p class="card-title mb-3 fs-3 fw-bold">
                                    Order Details
                                </p>
                                <div class="row">
                                    <div class="mb-2 col-6 d-flex flex-column">
                                        <span class="me-3"><i class="fa-solid fa-id-card me-2"></i>User ID</span>
                                        <span class="me-3"><i class="fa-solid fa-user me-2"></i>Username</span>
                                        <span class="me-3"><i class="fa-solid fa-barcode me-2"></i>Order Code</span>
                                        <span class="me-3"><i class="fa-solid fa-clock me-2"></i>Ordered Date</span>
                                        <span class="me-3"><i class="fa-solid fa-receipt me-2"></i>Total Amount</span>
                                    </div>
                                    <div class="mb-2 col-6 d-flex flex-column">
                                        <span class="fw-bold">{{ $productListData[0]->user_id }}</span>
                                        <span class="fw-bold">{{ $productListData[0]->user_name }}</span>
                                        <span class="fw-bold">{{ $orders->order_code }}</span>
                                        <span class="fw-bold">{{ $orders->created_at->format('F-d-Y') }}</span>
                                        <span class="fw-bold">{{ $orders->total_price }} Kyats</span>
                                    </div>
                                </div>
                                <div>
                                    <small class="text-warning fs-6 fw-bold">*Include Delivery Charges*</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Product Table --}}
                    <div class="table-responsive table-responsive-data2">
                        @if (count($productListData) == 0)
                            <h3 class="text-muted text-center mt-5">THERE IS NO ORDER LIST HERE!</h3>
                        @else
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Product Name</th>
                                        <th>Product Image</th>
                                        <th>Quantity</th>
                                        <th>Total price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productListData as $productList)
                                        <tr class="tr-shadow" id="orderListTable">
                                            <td></td>
                                            <td>{{ $productList->product_name }}</td>
                                            <td class="col-2"><img src="{{ asset('storage/'.$productList->product_image) }}" class="img-thumbnail"></td>
                                            <td>{{ $productList->qty }}</td>
                                            <td>{{ $productList->total }} Kyats</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
