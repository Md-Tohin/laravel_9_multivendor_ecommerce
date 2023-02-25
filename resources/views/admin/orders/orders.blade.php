@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <h4 style="float: left;" class="card-title">Orders</h4>
                            </div>
                            <br>
                            <div class="messege">
                                @if (Session::has('success_message'))
                                    <p style="margin-bottom: 30px"></p>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success:</strong> {{ Session::get('success_message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>                            
                            <div class="table-responsive pt-3">
                                <table id="orders" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Order Date</th>
                                            <th>Customer Name</th>
                                            <th>Customer Email</th>
                                            <th>Ordered Products</th>
                                            <th>Order Amount</th>
                                            <th>Order Status</th>
                                            <th>Payment Method</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $order)
                                            @if ($order['orders_products'])
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ date("d-m-Y H:i:s", strtotime($order['created_at'])) }}</td>
                                                <td>{{ $order['name'] }}</td>
                                                <td>{{ $order['email'] }}</td>
                                                <td>
                                                    @foreach ($order['orders_products'] as $product)
                                                        {{ $product['product_code'] }} ({{ $product['product_qty'] }}) <br>
                                                    @endforeach
                                                </td>
                                                <td>{{ $order['grand_total'] }}</td>
                                                <td>{{ $order['order_status'] }}</td>
                                                <td>{{ $order['payment_method'] }}</td>
                                                <td>
                                                    <a href="{{ url('admin/orders/'.$order['id']) }}" title="View Order Details">
                                                        <i style="font-size: 25px;" class="mdi mdi-file-document"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a target="_blank" href="{{ url('admin/orders/invoice/'.$order['id']) }}" title="View Order Invoice">
                                                        <i style="font-size: 25px;" class="mdi mdi-printer"></i>
                                                    </a>
                                                    &nbsp;
                                                    <a href="{{ url('admin/orders/invoice/pdf/'.$order['id']) }}" title="Print PDF Invoice">
                                                        <i style="font-size: 25px;" class="mdi mdi-file-pdf"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach                                      
                                    </tbody>
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
