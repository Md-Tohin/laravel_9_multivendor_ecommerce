<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <table style="width: 700px;">
        <tr><td>&nbsp;</td></tr>
        <tr><td><img src="{{ asset('front/images/main-logo/stack-developers-logo.png') }}" alt="Logo"></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Hello {{ $name }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Your Order #{{ $order_id }} Item status has been updated to {{ $order_status }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        @if (!empty($courier_name) && !empty($tracking_number))
        <tr><td>
            Courier Name is {{ $courier_name }} and Tracking Number is {{ $tracking_number }}
        </td></tr>
        <tr><td>&nbsp;</td></tr>
        @endif
        <tr><td>Your Order Item details are as below :- </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>
            <table style="width: 95%;" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
                <tr bgcolor="#cccccc">
                    <td>Product Name</td>
                    <td>Product Code</td>
                    <td>Product Size</td>
                    <td>Product Color</td>
                    <td>Product Price</td>
                    <td>Product Quantity</td>
                </tr>
                @foreach ($orderDetails['orders_products'] as $product)
                    <tr bgcolor="#f9f9f9">
                        <td>{{ $product['product_name'] }}</td>
                        <td>{{ $product['product_code'] }}</td>
                        <td>{{ $product['product_size'] }}</td>
                        <td>{{ $product['product_color'] }}</td>
                        <td>{{ $product['product_price'] }}</td>
                        <td>{{ $product['product_qty'] }}</td>
                    </tr>                    
                @endforeach
            </table>
        </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>
            <table>
                <tr>
                    <td><strong>Delivery Address: </strong></td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['name'] }},</td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['mobile'] }}</td>
                </tr>
                <tr>
                    <td>Pincode: {{ $orderDetails['pincode'] }}</td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['address'] }}</td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['city'] }}, {{ $orderDetails['state'] }}</td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['country'] }}</td>
                </tr>
            </table>
        </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>For any queries, you can contact us at <a href="mdtohin8585@gmail.com">info@shopmama.bd</a></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Regards,<br>Team Shopmama E-commerce</td></tr>
        <tr><td>&nbsp;</td></tr>
    </table>
</body>
</html>