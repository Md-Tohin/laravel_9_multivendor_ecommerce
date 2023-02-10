@extends('front.layout.layout')

@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>My Orders</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="javascript:0">orders</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Cart-Page -->
<div class="page-cart u-s-p-t-80">
    <div class="container">       
        <div class="row">
            <table class="table table-striped table-hover table-bordered">
                <tr class="table-danger">
                    <th>Order ID</th>
                    <th>Orderd Products</th>
                    <th>Payment Method</th>
                    <th>Grand Total</th>
                    <th>Created on</th>
                    <th>Details</th>
                </tr>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order['id'] }}</td>
                        <td>
                            @foreach ($order['orders_products'] as $product)                            
                                {{ $product['product_code'] }} <br>
                            @endforeach
                        </td>
                        <td>{{ $order['payment_method'] }}</td>
                        <td>{{ (int)$order['grand_total'] }}</td>
                        <td>{{ date("d-m-Y H:i:s", strtotime($order['created_at'])) }}</td>
                        <td><a href="{{ url('user/orders/'.$order['id']) }}" class="btn btn-success"><i class="fa fa-eye fa-solid" title="View Details"></i></a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
<!-- Cart-Page /- -->
@endsection