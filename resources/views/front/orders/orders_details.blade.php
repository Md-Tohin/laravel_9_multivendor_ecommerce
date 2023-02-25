@extends('front.layout.layout')

@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Order #{{ $orderDetails['id'] }} Details</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="{{ url('user/orders') }}">orders</a>
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
            <table class="table table-striped">
                <tr class="table-danger">
                    <th colspan="2">Order Details</th>
                </tr>
                <tr>
                    <td>Order Date</td>
                    <td>{{ date("d-M-Y  H:i:s", strtotime($orderDetails['created_at'])) }}</td>
                </tr>
                <tr>
                    <td>Order Status</td>
                    <td>{{ $orderDetails['order_status'] }}</td>
                </tr>
                <tr>
                    <td>Order Total</td>
                    <td>{{ (int)$orderDetails['grand_total'] }}</td>
                </tr>
                <tr>
                    <td>Shipping Charges</td>
                    <td>{{ $orderDetails['shipping_charges'] }}</td>
                </tr>
                @if ($orderDetails['coupon_code'] != '')
                <tr>
                    <td>Coupon Code</td>
                    <td>{{ $orderDetails['coupon_code'] }}</td>
                </tr>  
                <tr>
                    <td>Coupon Amount</td>
                    <td>{{ (int)$orderDetails['coupon_amount'] }}</td>
                </tr>  
                @endif
                @if (!empty($orderDetails['courier_name']))
                    <tr>
                        <td>Courier Name</td>
                        <td>{{ $orderDetails['courier_name'] }}</td>
                    </tr>
                    <tr>
                        <td>Tracking Number</td>
                        <td>{{ $orderDetails['tracking_number'] }}</td>
                    </tr>
                @endif                
                <tr>
                    <td>Payment Method</td>
                    <td>{{ $orderDetails['payment_method'] }}</td>
                </tr>
            </table>
            <br>
            <table class="table table-striped table-bordered">
                <tr class="table-danger">
                    <th>Product Image</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Product Size</th>
                    <th>Product Color</th>
                    <th>Product Price</th>
                    <th>Product Qty</th>
                    <th>Courier Name</th>
                    <th>Tracking Number</th>
                </tr>      
                @foreach ($orderDetails['orders_products'] as $product)
                    <tr>
                        <td>
                            @php
                                $product_image = App\Models\Product::getProductImage($product['product_id']);
                            @endphp
                            <a href="{{ url('product/'.$product['product_id']) }}" target="blank">
                                <img width="70px" src="{{ asset('front/images/product_images/small/'.$product_image) }}" alt="Product Image">
                            </a>
                        </td>
                        <td>{{ $product['product_code'] }}</td>
                        <td>{{ $product['product_name'] }}</td>
                        <td>{{ $product['product_size'] }}</td>
                        <td>{{ $product['product_color'] }}</td>
                        <td>{{ $product['product_price'] }}</td>
                        <td>{{ $product['product_qty'] }}</td>                        
                        <td>{{ $orderDetails['courier_name'] }}</td>                        
                        <td>{{ $orderDetails['tracking_number'] }}</td>                        
                    </tr>
                @endforeach
            </table>
            <table class="table table-striped">
                <tr class="table-danger">
                    <th colspan="2">Delivery Address</th>
                </tr>
                <tr>
                    <td width="45%">Name</td>
                    <td >{{ $orderDetails['name'] }}</td>
                </tr>
                <tr>
                    <td>Mobile</td>
                    <td>{{ $orderDetails['mobile'] }}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>{{ $orderDetails['address'] }}</td>
                </tr>
                <tr>
                    <td>City</td>
                    <td>{{ $orderDetails['city'] }}</td>
                </tr>
                <tr>
                    <td>State</td>
                    <td>{{ $orderDetails['state'] }}</td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td>{{ $orderDetails['country'] }}</td>
                </tr>
                <tr>
                    <td>Pincode</td>
                    <td>{{ $orderDetails['pincode'] }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- Cart-Page /- -->
@endsection