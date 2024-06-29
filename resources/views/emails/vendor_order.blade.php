<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<table style="width:700px;">
		<tr><td>&nbsp;</td></tr>
		<tr><td><img src="{{ asset('front/images/eddie.jpeg') }}"></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Hello {{$vendorEmail}}</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Customer {{$name}} Just placed an Order:-</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Order no. {{$order_id}}</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>
			<table style="width:95%" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
				<tr bgcolor="#cccccc">
					<td>Product Name</td>
					<td>Product Code</td>
					<td>Product Size</td>
					<td>Product Color</td>
					<td>Product Quantity</td>
					<td>Product Price</td>
				</tr>
				@foreach($orderDetails['orders_products'] as $order)
				<tr bgcolor="#f9f9f9">
					<td>{{ $order['product_name'] }}</td>
					<td>{{ $order['product_code'] }}</td>
					<td>{{ $order['product_size'] }}</td>
					<td>{{ $order['product_color'] }}</td>
					<td>{{ $order['product_qty'] }}</td>
					<td>{{ $order['product_price'] }}</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="5" align="right">Shipping Charges</td>
					<td>UGX {{ $orderDetails['shipping_charges']}}</td>
				</tr>
				<tr>
					<td colspan="5" align="right">Coupon Discount</td>
					<td>UGX 
						@if($orderDetails['coupon_amount']>0)
							{{ $orderDetails['coupon_amount']}}
						@else
							0
						@endif
					</td>
				</tr>
				<tr>
					<td colspan="5" align="right">Grand Total</td>
					<td>UGX {{ $orderDetails['grand_total']}}</td>
				</tr>
			</table>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>
			<table>
				<tr>
					<td><strong>Delivery Address:</strong></td>
				</tr>
				<tr>
					<td>{{ $orderDetails['name'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['address'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['city'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['state'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['country'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['pincode'] }}</td>
				</tr>
				<tr>
					<td>{{ $orderDetails['mobile'] }}</td>
				</tr>
			</table>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Download Order Invoice at <a href="{{ url('orders/invoice/download/'.$orderDetails['id'].'') }}">{{ url('orders/invoice/download/'.$orderDetails['id'].'') }}</a><br>
		(Copy & Paste to open if link does not work)
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>For any queries, you can contact us at <a href="edsonkusemererwa2000@gmail.com">edsonkusemererwa2000@gmail.com</a></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Regards,<br>Team Hakateq Solutions</td></tr>
		<tr><td>&nbsp;</td></tr>
	</table>
</body>
</html>