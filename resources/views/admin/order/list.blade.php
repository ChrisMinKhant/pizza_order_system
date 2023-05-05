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
                                <h2 class="title-1 fs-1 fw-bolder">Order List</h2>
                            </div>
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

                            {{-- Search With Keywords --}}
                            <form class="form-header" action="{{ route('admin#order#searchData') }}" method="get">
                                @csrf
                                <input class="au-input au-input--xl" type="text" name="searchData"
                                    placeholder="Search for datas..."
                                    value="{{ old('searchData', request('searchData')) }}" />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                            {{-- Search With Status --}}
                            <form action="{{ route('admin#order#searchWithStatus') }}" method="post" class="my-3">
                                @csrf
                                <div class="input-group">
                                    <select name="searchWithStatus" id="searchWithStatus"
                                        class="form-control text-center border-0 shadow-sm" aria-describedby="button-addon2">
                                        <option value="">Search With Status</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Success</option>
                                        <option value="2">Reject</option>
                                    </select>
                                    <button type="submit"
                                        class="btn btn-primary shadow-sm" id="button-addon2">Search</button>
                                </div>
                            </form>
                            <p class="text-muted mt-3 fs-6 fw-bold">Total Order - <span class="text-primary">
                                    {{ $orderListData->count() }}<i class="ms-2 fa-solid fa-database"></i></span></p>
                        </div>
                        {{-- Search Bar and Total End --}}
                    </div>

                    <div class="table-responsive table-responsive-data2">
                        @if (count($orderListData) == 0)
                            <h3 class="text-muted text-center mt-5">THERE IS NO ORDER LIST HERE!</h3>
                        @else
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Order Code</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderListData as $orderList)
                                        <tr class="tr-shadow" id="orderListTable">
                                            <input type="hidden" class="order_id" value="{{ $orderList->id }}">
                                            <td>{{ $orderList->created_at->format('F-d-Y') }}</td>
                                            <td>{{ $orderList->user_id }}</td>
                                            <td>{{ $orderList->user_name }}</td>
                                            <td><a href="{{ route('admin#order#productList',$orderList->order_code) }}" class="text-decoration-none fw-bolder text-primary">
                                                {{ $orderList->order_code }}
                                            </a></td>
                                            <td>{{ $orderList->total_price }} Kyats</td>
                                            <td>
                                                <select name="status"
                                                    class="form-control text-center border-0 shadow-sm changeStatus">
                                                    <option value="0" @selected($orderList->status == 0)>Pending</option>
                                                    <option value="1" @selected($orderList->status == 1)>Success</option>
                                                    <option value="2" @selected($orderList->status == 2)>Reject</option>
                                                </select>
                                            </td>
                                            <td
                                                @switch($orderList->status)
                                                    @case(0)
                                                        class="text-warning"
                                                    @break

                                                    @case(1)
                                                        class="text-success"
                                                    @break

                                                    @case(2)
                                                        class="text-danger"
                                                    @break
                                                @endswitch>
                                                <i class="fa-solid fa-circle"></i>
                                            </td>
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

@section('scriptSection')
    <script>
        $(document).ready(function() {

            //searching with order status
            // $('#searchWithStatus').change(function() {
            //     $status = $('#searchWithStatus').val();

            //     $.ajax({
            //         type: 'get',
            //         url: 'http://127.0.0.1:8000/admin/order/searchWithStatus',
            //         data: {
            //             'searchStatus': $status
            //         },
            //         dataType: 'json',
            //         success: function(Response) {

            //             $searchedOrderList = '';

            //             for ($i = 0; $i < Response.length; $i++) {
            //                 //Date Format
            //                 $monthArray = ['January', 'February', 'March', 'April', 'May',
            //                     'Jun', 'July', 'August', 'September', 'October', 'November',
            //                     'December'
            //                 ];
            //                 $date = new Date(Response[$i].created_at);

            //                 //Select Status
            //                 $selectedStatus = ``;

            //                 switch (Response[$i].status) {
            //                     case 0:
            //                         $selectedStatus += `<select name="status" class="form-control text-center border-0 shadow-sm changeStatus">
        //                                             <option value="0" selected>Pending</option>
        //                                             <option value="1">Success</option>
        //                                             <option value="2">Reject</option>
        //                                         </select>`;
            //                     break;

            //                     case 1:
            //                         $selectedStatus += `<select name="status" class="form-control text-center border-0 shadow-sm changeStatus">
        //                                             <option value="0">Pending</option>
        //                                             <option value="1" selected>Success</option>
        //                                             <option value="2">Reject</option>
        //                                         </select>`;
            //                     break;

            //                     case 2:
            //                         $selectedStatus += `<select name="status" class="form-control text-center border-0 shadow-sm changeStatus">
        //                                             <option value="0">Pending</option>
        //                                             <option value="1">Success</option>
        //                                             <option value="2" selected>Reject</option>
        //                                         </select>`;
            //                     break;
            //                 }

            //                 //status indicator
            //                 $statusIndicator = ``;

            //                 switch(Response[$i].status) {
            //                     case 0:
            //                         $statusIndicator +=`class = "text-warning"`;
            //                     break;

            //                     case 1:
            //                         $statusIndicator +=`class = "text-success"`;
            //                     break;

            //                     case 2:
            //                         $statusIndicator +=`class = "text-danger"`;
            //                     break;
            //                 }

            //                 //append to the document
            //                 $searchedOrderList += `
        //                     <tr class="tr-shadow" id="orderListTable">
        //                         <td>${ $monthArray[$date.getMonth()] }-${ $date.getDate() }-${ $date.getFullYear() }</td>
        //                         <input type="hidden" class="order_id" value="${ Response[$i].id }">
        //                         <td>${ Response[$i].user_id }</td>
        //                         <td>${ Response[$i].user_name }</td>
        //                         <td>${ Response[$i].order_code }</td>
        //                         <td>${ Response[$i].total_price } Kyats</td>
        //                         <td>${ $selectedStatus }</td>
        //                         <td ${ $statusIndicator }><i class="fa-solid fa-circle"></i></td>
        //                     </tr>`
            //             };
            //             $('tbody').html($searchedOrderList);
            //         }
            //     });
            // });

            $('.changeStatus').change(function() {
                $parentNode = $(this).parents('#orderListTable');

                $dataToPass = {
                    'order_id': $parentNode.find('.order_id').val(),
                    'order_status': $parentNode.find('.changeStatus').val()
                };

                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/admin/order/changeStatus',
                    data: $dataToPass,
                    dataType: 'json'
                });

                location.reload();
            });
        });
    </script>
@endsection
