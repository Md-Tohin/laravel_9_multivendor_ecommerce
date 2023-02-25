<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<link rel="stylesheet" href="{{ asset('admin/css/order_invoice.css') }}">
<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Invoice</h2><h3 class="pull-right">Order # {{ $orderDetails['id'] }}
                    @php
                        echo DNS1D::getBarcodeHTML($orderDetails['id'], 'C39');
                    @endphp                    
                </h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Billed To:</strong><br>
                        {{ $userDetails['name'] }}<br>
                        @if (!empty($userDetails['address']))
                            {{ $userDetails['address'] }}<br>
                        @endif
                        @if (!empty($userDetails['city']))
                            {{ $userDetails['city'] }}, 
                        @endif
                        @if (!empty($userDetails['state']))
                            {{ $userDetails['state'] }}<br>
                        @endif
                        @if (!empty($userDetails['country']))
                            {{ $userDetails['country'] }} - 
                        @endif
                        @if (!empty($userDetails['pincode']))
                            ({{ $userDetails['pincode'] }})<br>
                        @endif
                        {{ $userDetails['mobile'] }}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Shipped To:</strong><br>
                        {{ $orderDetails['name'] }}<br>
                        @if (!empty($orderDetails['address']))
                            {{ $orderDetails['address'] }}<br>
                        @endif
                        @if (!empty($orderDetails['city']))
                            {{ $orderDetails['city'] }}, 
                        @endif
                        @if (!empty($orderDetails['state']))
                            {{ $orderDetails['state'] }}<br>
                        @endif
                        @if (!empty($orderDetails['country']))
                            {{ $orderDetails['country'] }} - 
                        @endif
                        @if (!empty($orderDetails['pincode']))
                            ({{ $orderDetails['pincode'] }})<br>
                        @endif
                        {{ $orderDetails['mobile'] }}
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    					{{ $orderDetails['payment_method'] }}    					
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Order Date:</strong><br>
    					{{ date("M d, Y H:i:s", strtotime($orderDetails['created_at'])) }}
                        <br>
                        <br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Code</th>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
    						</thead>
    						<tbody>
                                @php $totalPrice = 0 @endphp
                                @foreach ($orderDetails['orders_products'] as $product)
                                    <tr>
                                        <td>
                                            @php
                                                $product_image = App\Models\Product::getProductImage($product['product_id']);
                                            @endphp                                            
                                            <img style="width: 50px; height: 50px;" src="{{ asset('front/images/product_images/small/'.$product_image) }}" alt="Product Image">
                                        </td>
                                        <td>{{ $product['product_code'] }}
                                            <?php
                                                echo DNS1D::getBarcodeHTML( $product['product_code'], 'C39');
                                                // echo DNS2D::getBarcodeHTML( $product['product_code'], 'QRCODE');
                                            ?>
                                        </td>
                                        <td>{{ $product['product_size'] }}</td>
                                        <td>{{ $product['product_color'] }}</td>
                                        <td>Tk. {{ $product['product_price'] }}</td>
                                        <td>{{ $product['product_qty'] }}</td>   
                                        <td>
                                            Tk. {{ $product['product_price'] * $product['product_qty'] }}
                                        </td>                     
                                    </tr>
                                    @php
                                        $totalPrice = $totalPrice + $product['product_price'] * $product['product_qty'];
                                    @endphp
                                @endforeach  
                               
                                <tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>    								
    								<td class="thick-line text-right" colspan="2"><strong>Subtotal:</strong></td>
                                    <td class="thick-line"></td>
    								<td class="thick-line text-left">Tk. {{ $totalPrice }}</td>
    							</tr>
                                <tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
                                    <td class="no-line text-right" colspan="2"><strong>Shipping Charges:</strong></td>
                                    <td class="no-line"></td>
    								<td class="no-line text-left">Tk. {{ $orderDetails['shipping_charges'] }}</td>
    							</tr>
                                @if (!empty($orderDetails['coupon_amount']))
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-right" colspan="2"><strong>Coupon Discount:</strong></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-left">Tk. {{ $orderDetails['coupon_amount'] }}</td>
                                    </tr>  
                                @endif    							
    							
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
                                    <td class="no-line text-right" colspan="2"><strong>Grand Total:</strong></td>
                                    <td class="no-line"></td>
    								<td class="no-line text-left"><strong>Tk. {{ $orderDetails['grand_total'] }}
                                    @if ($orderDetails['payment_method'] == "COD")
                                    <br>
                                    <font color="green">(Already Paid)</font>
                                    @endif</strong></td>
    							</tr>					
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>