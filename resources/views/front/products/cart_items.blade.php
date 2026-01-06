<?php use App\Models\Product; 
use App\Models\Currency; 
?>
<!-- Products-List-Wrapper -->
<div class="table-wrapper u-s-m-b-60">
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $total_price = 0 @endphp
            @foreach($getCartItems as $item)
            @if(isset($item['product']) && $item['product'])
            <?php $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
            ?>
            <tr>
                <td>
                    <div class="cart-anchor-image">
                        <a href="{{ url('product/'.$item['product_id'])}}">
                            <img src="{{ asset('front/images/product_images/small/'.$item['product']['product_image']) }}" alt="Product">
                            <h6>
                                {{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }}) - {{ $item['size'] }}<br>
                                Color: {{ $item['product']['product_color'] }}<br>

                            </h6>
                        </a>
                    </div>
                </td>
                <td>
                    <div class="cart-price">
                        @if(isset($currency))
                            @php $_GET['cy']=$currency @endphp
                        @endif
                        @if(isset($_GET['cy'])&&$_GET['cy']!="UGX")
                            @php 
                                $getCurrency = Currency::where('currency_code',$_GET['cy'])->first();
                                if($getCurrency){
                                    $getCurrency = $getCurrency->toArray();
                                } else {
                                    $getCurrency = null;
                                }
                            @endphp
                            @if($getCurrency && $getDiscountAttributePrice['discount']>0)
                                <div class="price-template">
                                    <div class="item-new-price">
                                        {{$_GET['cy']}} {{ round($getDiscountAttributePrice['final_price']/$getCurrency['exchange_rate'],2) }}
                                    </div>
                                    <div class="item-old-price" style="margin-left:-40px;">
                                        {{$_GET['cy']}}
                                        {{ round($getDiscountAttributePrice['product_price']/$getCurrency['exchange_rate'],2) }}
                                    </div>
                                </div>
                                @else
                                <div class="price-template">
                                    <div class="item-new-price">
                                        {{$_GET['cy']}} 
                                        {{ round($getDiscountAttributePrice['final_price']/$getCurrency['exchange_rate'],2) }}
                                    </div>
                                </div>
                            @endif
                        @else
                            @if($getDiscountAttributePrice['discount']>0)
                                <div class="price-template">
                                    <div class="item-new-price">
                                        shs.{{ $getDiscountAttributePrice['final_price'] }}
                                    </div>
                                    <div class="item-old-price" style="margin-left:-40px;">
                                        shs.{{ $getDiscountAttributePrice['product_price'] }}
                                    </div>
                                </div>
                                @else
                                <div class="price-template">
                                    <div class="item-new-price">
                                        shs.{{ $getDiscountAttributePrice['final_price'] }}
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </td>
                <td>
                    <div class="cart-quantity">
                        <div class="quantity">
                            <input type="text" class="quantity-text-field" value="{{ $item['quantity'] }}">
                            <a class="plus-a updateCartItem" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}" data-max="1000" @if(isset($_GET['cy'])) currency="{{ $_GET['cy'] }}" @endif>&#43;</a>
                            <a class="minus-a updateCartItem" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}" data-min="1" @if(isset($_GET['cy'])) currency="{{ $_GET['cy'] }}" @endif>&#45;</a>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="cart-price">
                        @if(isset($currency))
                            @php $_GET['cy']=$currency @endphp
                        @endif
                        @if(isset($_GET['cy'])&&$_GET['cy']!="UGX")
                            {{$_GET['cy']}} {{ round($getDiscountAttributePrice['final_price']* $item['quantity']/$getCurrency['exchange_rate'],2) }}
                        @else
                            shs.{{ $getDiscountAttributePrice['final_price'] * $item['quantity'] }}
                        @endif
                    </div>
                </td>
                <td>
                    <div class="action-wrapper">
                        <!-- <button class="button button-outline-secondary fas fa-sync"></button> -->
                        <button class="button button-outline-secondary fas fa-trash deleteCartitem" data-cartid="{{ $item['id'] }}" @if(isset($_GET['cy'])) currency="{{ $_GET['cy'] }}" @endif></button>
                    </div>
                </td>
            </tr>
            @php $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity']) @endphp
            @endif
            @endforeach
        </tbody>
    </table>
</div>
<!-- Products-List-Wrapper /- -->
<!-- Billing -->
<div class="calculation u-s-m-b-60">
    <div class="table-wrapper-2">
        <table>
            <thead>
                <tr>
                    <th colspan="2">Cart Totals</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <h3 class="calc-h3 u-s-m-b-0">Sub Total</h3>
                    </td>
                    <td>
                        @if(isset($_GET['cy'])&&$_GET['cy']!="UGX")
                            <span class="calc-text">{{$_GET['cy']}} {{ round($total_price/$getCurrency['exchange_rate'],2) }}</span>
                        @else
                            <span class="calc-text">shs.{{ $total_price }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3 class="calc-h3 u-s-m-b-0">Coupon Discount</h3>
                    </td>
                    <td>
                        <span class="calc-text couponAmount">
                            @if(Session::has('couponAmount'))
                                shs.{{ Session::get('couponAmount') }}
                            @else
                                shs.0
                            @endif
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3 class="calc-h3 u-s-m-b-0">Grand Total</h3>
                    </td>
                    <td>
                        <span class="calc-text grand_total">
                            @php $grand_total = $total_price - Session::get('couponAmount') @endphp
                            @if(isset($_GET['cy'])&&$_GET['cy']!="UGX")
                                {{$_GET['cy']}} {{ round($grand_total/$getCurrency['exchange_rate'],2) }}
                            @else
                                shs.{{ $grand_total }}
                            @endif
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Billing /- -->