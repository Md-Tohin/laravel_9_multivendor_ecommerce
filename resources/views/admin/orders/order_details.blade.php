@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Order #{{ $orderDetails['id'] }} Details</h3>
                <a href="{{ url('admin/orders') }}">Back to Orders</a>
            </div>
        </div>
        <br><br> 
        @if (Session::has('success_message'))
            {{-- <p style="margin-bottom: 30px"></p> --}}
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success:</strong> {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif              
        <div class="row">            
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Order Details</h4>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th style="font-weight: 550; font-size: 14px;">Order ID:</th>
                                <td>{{ $orderDetails['id'] }}</td>
                            </tr>
                            <tr>
                                <th style="font-weight: 550; font-size: 14px;">Order Date:</th>
                                <td>{{ date("d-m-Y H:i:s", strtotime($orderDetails['created_at'])) }}</td>
                            </tr>
                            <tr>
                                <th style="font-weight: 550; font-size: 14px;">Order Status:</th>
                                <td>{{ $orderDetails['order_status'] }}</td>
                            </tr>
                            <tr>
                                <th style="font-weight: 550; font-size: 14px;">Order Total:</th>
                                <td>Tk. {{ (int)$orderDetails['grand_total'] }}</td>
                            </tr>
                            <tr>
                                <th style="font-weight: 550; font-size: 14px;">Shipping Charges:</th>
                                <td>Tk. {{ $orderDetails['shipping_charges'] }}</td>
                            </tr>
                            <tr>
                                <th style="font-weight: 550; font-size: 14px;">Order Total:</th>
                                <td>Tk. {{ (int)$orderDetails['grand_total'] }}</td>
                            </tr>
                            @if (!empty($orderDetails['coupon_code']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">Coupon Code:</th>
                                    <td>{{ $orderDetails['coupon_code'] }}</td>
                                </tr>
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">Coupon Amount:</th>
                                    <td>Tk. {{ (int)$orderDetails['coupon_amount'] }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th style="font-weight: 550; font-size: 14px;">Payment Method:</th>
                                <td>{{ $orderDetails['payment_method'] }}</td>
                            </tr>
                            <tr>
                                <th style="font-weight: 550; font-size: 14px;">Payment Gateway:</th>
                                <td>{{ $orderDetails['payment_gateway'] }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Customer Details</h4>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th style="font-weight: 550; font-size: 14px;">Name:</th>
                                <td>{{ $userDetails['name'] }}</td>
                            </tr>
                            @if (!empty($userDetails['mobile']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">Mobile:</th>
                                    <td>{{ $userDetails['mobile'] }}</td>
                                </tr>
                            @endif
                            @if (!empty($userDetails['email']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">Email:</th>
                                    <td>{{ $userDetails['email'] }}</td>
                                </tr>
                            @endif
                            @if (!empty($userDetails['address']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">Address:</th>
                                    <td>{{ $userDetails['address'] }}</td>
                                </tr>
                            @endif
                            @if (!empty($userDetails['city']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">City:</th>
                                    <td>{{ $userDetails['city'] }}</td>
                                </tr>
                            @endif
                            @if (!empty($userDetails['state']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">State:</th>
                                    <td>{{ $userDetails['state'] }}</td>
                                </tr>
                            @endif
                            @if (!empty($userDetails['country']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">Country:</th>
                                    <td>{{ $userDetails['country'] }}</td>
                                </tr>
                            @endif
                            @if (!empty($userDetails['pincode']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">Pincode:</th>
                                    <td>{{ $userDetails['pincode'] }}</td>
                                </tr>
                            @endif
                        </table>                            
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Delivery Address</h4>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th style="font-weight: 550; font-size: 14px;">Name:</th>
                                <td>{{ $orderDetails['name'] }}</td>
                            </tr>
                            @if (!empty($orderDetails['mobile']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">Mobile:</th>
                                    <td>{{ $orderDetails['mobile'] }}</td>
                                </tr>
                            @endif
                            @if (!empty($orderDetails['email']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">Email:</th>
                                    <td>{{ $orderDetails['email'] }}</td>
                                </tr>
                            @endif
                            @if (!empty($orderDetails['address']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">Address:</th>
                                    <td>{{ $orderDetails['address'] }}</td>
                                </tr>
                            @endif
                            @if (!empty($orderDetails['city']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">City:</th>
                                    <td>{{ $orderDetails['city'] }}</td>
                                </tr>
                            @endif
                            @if (!empty($orderDetails['state']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">State:</th>
                                    <td>{{ $orderDetails['state'] }}</td>
                                </tr>
                            @endif
                            @if (!empty($orderDetails['country']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">Country:</th>
                                    <td>{{ $orderDetails['country'] }}</td>
                                </tr>
                            @endif
                            @if (!empty($orderDetails['pincode']))
                                <tr>
                                    <th style="font-weight: 550; font-size: 14px;">Pincode:</th>
                                    <td>{{ $orderDetails['pincode'] }}</td>
                                </tr>
                            @endif
                        </table>                            
                    </div>
                </div>
            </div>
           
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Order Status</h4>  
                        @if (Auth::guard('admin')->user()->type != "vendor")
                            <form class="form-inline" action="{{ url('admin/update-order-status') }}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                                <select class="form-control mb-2 mr-sm-2 w-75" id="order_status" name="order_status"  style="color: #878686 !important"> 
                                    <option value="">Choose One</option>
                                    @foreach ($orderStatuses as $status)                                    
                                        <option value="{{ $status['name'] }}" {{ $orderDetails['order_status'] == $status['name'] ? 'selected' : '' }}>{{ $status['name'] }}</option>
                                    @endforeach
                                </select>
                                <input type="text" class="form-control mb-2 mr-2" name="courier_name" id="courier_name" placeholder="Courier Name">
                                <input type="text" class="form-control mb-2" name="tracking_number" id="tracking_number" placeholder="Tracking Number">
                                <button type="submit" class="btn btn-primary mb-2">Update</button>
                            </form>
                            <br>
                            <table class="table table-bordered table-striped">
                                @foreach ($orderLog as $key => $log)    
                                   
                                    <tr>
                                        {{-- @php
                                            echo "<pre>" ; print_r($log['orders_products'][$key]['product_code']);
                                        @endphp --}}
                                        {{-- <th style="font-weight: 550; font-size: 14px;">{{ $log['order_status'] }}:</th> --}}
                                        <th style="font-weight: 550; font-size: 14px;">{{ $log['order_status'] }}:
                                            @if ($log['order_status'] == 'Shipped')
                                                @if (isset($log['order_item_id']) && $log['order_item_id'] > 0)
                                                    @php
                                                        $getItemDetails = App\Models\OrdersLog::getItemDetails($log['order_item_id'])
                                                    @endphp
                                                    @if (isset($getItemDetails['product_code']))
                                                        <p style="color: #878686; margin-top: 0.6rem; margin-bottom: 0.2rem;">
                                                            - for item <br> -- {{ $getItemDetails['product_code'] }}
                                                        </p>
                                                    @endif
                                                @endif
                                                
                                            @endif
                                        </th>
                                        <td>
                                            @if ($log['order_status'] == 'Shipped')
                                                {{-- @if (isset($log['orders_products'][$key]['product_code']))
                                                    <p style="margin-bottom: 0.2rem;">
                                                        - for item {{ $log['orders_products'][$key]['product_code'] }}
                                                    </p>
                                                @endif --}}
                                                <p style="margin-bottom: 0.2rem;">{{ date("d-m-Y H:i:s", strtotime($log['created_at'])) }} </p>
                                                @if (isset($log['order_item_id']) && $log['order_item_id'] > 0)
                                                    @php
                                                        $getItemDetails = App\Models\OrdersLog::getItemDetails($log['order_item_id'])
                                                    @endphp
                                                    @if (!empty($getItemDetails['courier_name']))
                                                        <p style="margin-bottom: 0.2rem;">Courier Name:- {{ $getItemDetails['courier_name'] }}</p>
                                                    @endif
                                                    @if (!empty($getItemDetails['tracking_number']))
                                                        <p style="margin-bottom: 0rem;">Tracking Number:- {{ $getItemDetails['tracking_number'] }}</p>
                                                    @endif
                                                @endif                                              
                                                
                                            @else
                                                {{ date("d-m-Y H:i:s", strtotime($log['created_at'])) }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                
                            </table>                            
                        @else
                            This Feature is restricted.
                        @endif                      
                        
                    </div>
                </div>
            </div>

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ordered Products</h4>
                        <div class="table-responsive pt-3">
                            <table class="table table-striped table-bordered table-responsive nowrap">
                                <tr class="table-danger">
                                    <th>Image</th>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Product Size</th>
                                    <th>Color</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Item Status</th>
                                </tr>      
                                @foreach ($orderDetails['orders_products'] as $product)
                                    <tr>
                                        <td>
                                            @php
                                                $product_image = App\Models\Product::getProductImage($product['product_id']);
                                            @endphp
                                            <a href="{{ url('product/'.$product['product_id']) }}" target="blank">
                                                <img style="width: 50px; height: 50px;" src="{{ asset('front/images/product_images/small/'.$product_image) }}" alt="Product Image">
                                            </a>
                                        </td>
                                        <td>{{ $product['product_code'] }}</td>
                                        <td>{{ $product['product_name'] }}</td>
                                        <td>{{ $product['product_size'] }}</td>
                                        <td>{{ $product['product_color'] }}</td>
                                        <td>Tk. {{ $product['product_price'] }}</td>
                                        <td>{{ $product['product_qty'] }}</td>   
                                        <td>
                                            <form class="form-inline" action="{{ url('admin/update-order-item-status') }}" method="POST" id="">
                                                @csrf
                                                <input type="hidden" name="order_item_id" value="{{ $product['id'] }}">
                                                <div class="form-group">
                                                    <select class="form-control mb-2 mr-sm-2" name="order_item_status" style="color: #878686 !important"> 
                                                        <option value="">Choose One</option>
                                                        @foreach ($orderItemStatuses as $status)
                                                            <option value="{{ $status['name'] }}" @if (!empty($product['item_status']) && $product['item_status'] == $status['name']) selected @endif>{{ $status['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="btn btn-primary mb-2">Update</button>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control mb-2 mr-2" name="item_courier_name" id="item_courier_name" placeholder="Courier Name" style="width: 32%;" @if(!empty($product['courier_name'])) value="{{ $product['courier_name'] }}" @endif>
                                                    <input type="text" class="form-control mb-2" name="item_tracking_number" id="item_tracking_number" placeholder="Tracking Number" style="width: 30%;" @if(!empty($product['tracking_number'])) value="{{ $product['tracking_number'] }}" @endif>
                                                </div>
                                            </form>
                                        </td>                     
                                    </tr>
                                @endforeach
                            </table>  
                        </div>                                                 
                    </div>
                </div>
            </div>
           
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection