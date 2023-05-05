@extends('user.layouts.master')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5" style="height:500px;">
            <div class="col-lg-8 offset-2 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($orderData as $order)
                            <tr>
                                <td class="align-middle">{{ $order->created_at }}</td>
                                <td class="align-middle">{{ $order->order_code }}</td>
                                <td class="align-middle">{{ $order->total_price }} Kyats</td>
                                <td class="align-middle">
                                    @if ($order->status == 0)
                                        <span class="btn btn-sm btn-warning shadow-lg rounded-2 fw-bold"><i class="fa-solid fa-clock-rotate-left me-2"></i>Pending</span>
                                    @elseif ($order->status == 1)
                                        <span class="btn btn-sm btn-success shadow-lg rounded-2 fw-bold"><i class="fa-solid fa-check me-2"></i>Success</span>
                                    @elseif ($order->status == 2)
                                        <span class="btn btn-sm btn-danger shadow-lg rounded-2 fw-bold"><i class="fa-solid fa-xmark me-2"></i>Reject</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $orderData->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
