@extends('layouts.app')


@section('content')
    @if(isset($cartItems) && $cartItems->count()>0)
    <div>
        {{-- In work, do what you enjoy. --}}

        <div class="cart-main-area pt-95 pb-100">
            <div class="container">

                <div class="row">
                    <div class="cart col-lg-10 col-md-10 col-sm-12 col-xs-12 pulled-right" style="text-align: right;direction: rtl">
                        <h1 class="cart-heading ">سلة المشتريات</h1>
                        <div class="table-content table-responsive table-bordered ">
                            <table class="table-responsive table-bordered table-danger table-hover" style="text-align: right;direction: rtl;width: 100%">
                                <thead>
                                <tr>

                                    <th>الصورة</th>
                                    <th>اسم المنتج</th>
                                    <th>سعر القطعة</th>
                                    <th>الكمية</th>
                                    <th> السعر الكلي</th>
                                    <th>#</th>
                                </tr>
                                </thead>
                                <tbody>


                                @foreach ($cartItems as $item)
                                    <tr>


                                        <td class="product-thumbnail">
                                            <a href="#"><img src="assets/img/cart/1.jpg" alt=""></a>
                                        </td>
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
                                    <td colspan="2"></td>
                                    <td colspan="2">الاجمالي</td>
                                    <td >{{$price=\Cart::session(auth()->id())->getTotal()}}</td>
                                    <td> <a id="checkout" href="{{route('offers.checkout',$price)}}"
                                            role="button" class="btn  btn-success px-3 waves-effect waves-light"> شراء المنتج
                                        </a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>

                </div>
            </div>
        </div>


        <div id="showPayForm"></div>

    </div>

    <div class="col-md-4 mb-4">




        @if(isset($success))
            <div class="alert alert-success text-center">
                تم الدفع بنجاح
            </div>
        @endif


        @if(isset($fail))
            <div class="alert alert-danger text-center">
                فشلت عملية الدفع
            </div>
        @endif

    </div>

@section('scripts')

    <script>
        $(document).on('click', '#checkout', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'get',
                url: "{{route('offers.checkout')}}",
                data: {
                    price: '{{$price}}',
                    offer_id: '{{$item['id']}}',
                },
                success: function (data) {
                    if (data.status == true) {

                        $('#showPayForm').empty().html(data.content);

                    } else {
                    }
                }, error: function (reject) {
                }
            });
        });
    </script>
@stop
@else
<div class="alert alert-info "style="text-align: right;">
    <strong></strong> لا يوجد عناصر للبيع
</div>
@endif
@endsection


