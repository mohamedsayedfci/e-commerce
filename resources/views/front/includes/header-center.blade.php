<div class="header-center hidden-sm-down">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div id="_desktop_logo" class="contentsticky_logo d-flex align-items-center justify-content-start col-lg-3 col-md-3">
                <a href="http://demo.bestprestashoptheme.com/savemart/">
                    <img class="logo img-fluid" src="/savemart/modules/novthemeconfig/images/logos/logo-1.png" alt="Prestashop_Savemart">
                </a>
            </div>
            <div class="col-lg-9 col-md-9 header-menu d-flex align-items-center justify-content-end">
                <div class="data-contact d-flex align-items-center">
                    <div class="title-icon">support<i class="icon-support icon-address"></i></div>
                    <div class="content-data-contact">
                        <div class="support">Call customer services :</div>
                        <div class="phone-support">
                            1234 567 899
                        </div>
                    </div>
                </div>
                <div class="contentsticky_group d-flex justify-content-end">
                    <div class="header_link_myaccount">
                        <a class="login" href="http://demo.bestprestashoptheme.com/savemart/ar/الحساب الشخصي" rel="nofollow" title="تسجيل الدخول إلى حسابك"><i class="header-icon-account"></i></a>
                    </div>
                    <div class="header_link_wishlist">
                        <a href="http://demo.bestprestashoptheme.com/savemart/ar/module/novblockwishlist/mywishlist" title="My Wishlists">
                            <i class="header-icon-wishlist"></i>
                        </a>
                    </div>

                    <!-- begin module:ps_shoppingcart/ps_shoppingcart.tpl -->
                    <!-- begin /var/www/demo.bestprestashoptheme.com/public_html/savemart/themes/vinova_savemart/modules/ps_shoppingcart/ps_shoppingcart.tpl --><div id="_desktop_cart">
                        <div class="blockcart cart-preview active" data-refresh-url="//demo.bestprestashoptheme.com/savemart/ar/module/ps_shoppingcart/ajax">
                            <div class="header-cart">

                                    <a class="nav-link p-0 m-0" href="{{ route('cart.index') }}">
                                        <div class="cart-left">

                                    <div class="shopping-cart"><i class="zmdi zmdi-shopping-cart"></i></div>


                                            @auth
                                                {{Cart::session(auth()->id())->getContent()->count()}}
                                            @else
                                                0
                                            @endauth



                                </div>
                                </a>
                                <div class="cart-right d-flex flex-column align-self-end ">
                                    <span class="title-cart">سلة الشراء</span>


                                </div>
                            </div>
                            <div class="cart_block ">
                                <div class="cart-block-content">
                                    <div class="no-items">
                                        @auth
                                        <table class="table-responsive table-bordered table-danger table-hover" style="text-align: right;direction: rtl;width: 100%">
                                            <thead>
                                            <tr>


                                                <th> المنتج</th>
                                                <th>سعر القطعة</th>
                                                <th>الكمية</th>
                                                <th> السعر الكلي</th>
                                                <th>#</th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                            @foreach ($cartItems as $item)
                                                <tr>


                                                    <td class="product-name"><a href="#">{{ $item['name'] }} </a></td>
                                                    <td class="product-price-cart"><span
                                                                class="amount">${{Cart::session(auth()->id())->get($item['id'])->getPriceSum()/$item['quantity']}}</span>
                                                    </td>
                                                    <td class="product-quantity">
                                                        <form action="{{route('cart.update', $item['id'])}}">

                                                            <div class="form-group">

                                                                <select class="form-control" id="pwd" name="quantity" onchange="this.form.submit()">

                                                                    <option>{{ $item['quantity'] }}</option>
                                                                    @for($i=1;$i<=100;$i++)
                                                                        <option>  {{ $i }}</option>

                                                                    @endfor>
                                                                </select>

                                                            </div>


                                                        </form>
                                                    </td>
                                                    <td class="product-price-cart"><span
                                                                class="amount">${{Cart::session(auth()->id())->get($item['id'])->getPriceSum()}}</span>
                                                    </td>
                                                    <td class="product-remove">
                                                        <a href="{{ route('cart.destroy', $item['id']) }}"><i
                                                                    class="pe-7s-close"></i>حذف</a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="1"></td>
                                                <td colspan="2">الاجمالي</td>
                                                <td colspan="2" >{{$price=\Cart::session(auth()->id())->getTotal()}}</td>

                                            </tr>
                                            <tr><td colspan="3"> <a id="checkout" href="{{ route('cart.index') }}"
                                                        role="button" class="btn  btn-success px-3 waves-effect waves-light"> تفاصيل عربة المشتريات
                                                    </a></td></tr>
                                            </tbody>
                                        </table>
                                        @endauth

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end /var/www/demo.bestprestashoptheme.com/public_html/savemart/themes/vinova_savemart/modules/ps_shoppingcart/ps_shoppingcart.tpl -->
                    <!-- end module:ps_shoppingcart/ps_shoppingcart.tpl -->

                </div>
            </div>
        </div>
    </div>
</div>
