@extends('user.layouts.master')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle" id="tableBody">
                        @foreach ($cartList as $cartProducts)
                            <tr>
                                <input type="hidden" id="productPrice" value="{{ $cartProducts->product_price }}">
                                <input type="hidden" id="cartId" value="{{ $cartProducts->id }}">
                                <input type="hidden" class="userId" value="{{ $cartProducts->user_id }}">
                                <input type="hidden" class="productId" value="{{ $cartProducts->product_id }}">
                                <td><img src="{{ asset('storage/' . $cartProducts->product_image) }}" alt=""
                                        style="width: 50px;" class="img-thumbnail"></td>
                                <td class="align-middle">
                                    {{ $cartProducts->product_name }}</td>
                                <td class="align-middle">{{ $cartProducts->product_price }} Kyats</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus" type="button">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text"
                                            class="form-control form-control-sm bg-secondary border-0 text-center"
                                            value="{{ $cartProducts->qty }}" id="orderQty">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus" type="button">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle totalPrice">{{ $cartProducts->product_price * $cartProducts->qty }}
                                    Kyats</td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger removeBtn"><i
                                            class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotal">{{ $subTotal }} Kyats</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">3000 Kyats</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalTotal">{{ $subTotal + 3000 }} Kyats</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3 rounded-2"
                            id="makeAnOrder">Proceed To
                            Checkout</button>

                        <button class="btn btn-block btn-danger font-weight-bold my-3 py-3 rounded-2"
                            id="clearCartData">Clear Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('scripting')
    <script>
        $(document).ready(function() {

            //plus button
            $('.btn-plus').click(function() {
                $parents = $(this).parents('tr');
                $qty = parseInt($parents.find('#orderQty').val());
                $price = parseInt($parents.find('#productPrice').val());
                $parents.find('.totalPrice').html(`${ $qty*$price } Kyats`);
                calculateSummaryPrice()
            });

            //minus button
            $('.btn-minus').click(function() {
                $parents = $(this).parents('tr');
                $qty = parseInt($parents.find('#orderQty').val());
                $price = parseInt($parents.find('#productPrice').val());
                $parents.find('.totalPrice').html(`${ $qty*$price } Kyats`);
                calculateSummaryPrice()
            });

            //remove button
            $('.removeBtn').click(function() {
                $parents = $(this).parents('tr');
                $cartId = $parents.find('#cartId').val();

                $.ajax({
                    type : 'get',
                    url : 'http://127.0.0.1:8000/user/ajax/removeCartItem',
                    data : {'cartId' : $cartId},
                    dataType : 'json',
                });

                $parents.remove();
                calculateSummaryPrice()
            });

            //make an order button
            $('#makeAnOrder').click(function() {

                $arrayData = [];

                $randomCode = Math.floor(Math.random() * 100000001);

                $('#tableBody tr').each(function(index, row) {

                    $objectData = {};

                    $objectData['user_id'] = $(row).find('.userId').val();
                    $objectData['product_id'] = $(row).find('.productId').val();
                    $objectData['qty'] = $(row).find('#orderQty').val();
                    $objectData['total'] = parseInt($(row).find('.totalPrice').text().replace(
                        'Kyats', ''));
                    $objectData['order_code'] = 'GP000' + $randomCode + 'codeX';

                    $arrayData.push($objectData);
                });

                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/user/ajax/listOrder',
                    data: Object.assign({}, $arrayData),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            window.location.href = 'http://127.0.0.1:8000/user/home';
                        }
                    }
                });
            });

            //celar cart data button
            $('#clearCartData').click(function() {
                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/user/ajax/clearCart',
                    dataType: 'json',
                });

                $('#tableBody tr').remove();
                calculateSummaryPrice();
            });

            //calculate summary price
            function calculateSummaryPrice() {
                $summaryPrice = 0;

                $('#tableBody tr').each(function(index, row) {
                    $totalPrice = parseInt($(row).find('.totalPrice').html().replace(' Kyats', ''));
                    $summaryPrice += $totalPrice;
                });

                $('#subTotal').html(`${ $summaryPrice } Kyats`);
                $('#finalTotal').html(`${ $summaryPrice+3000 } Kyats`);
            };
        });
    </script>
@endsection
