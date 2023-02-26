@extends('layouts.app')

@section('title')
    Keranjang - UMKM Universitas Gunadarma
@endsection

@section('content')
    <div class="page-content page-cart">
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active">Keranjang</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        @if ($carts->count())
            <section class="store-cart">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            @if (session('gagal'))
                                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                    {{ session('gagal') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <p class="success text-success text-center mb-2"></p>
                            <p class="failed text-danger text-center mb-2"></p>
                        </div>
                    </div>
                    <div class="row" data-aos="fade-up" data-aos-delay="100">
                        <div class="col-12 table-responsive">
                            <table class="table table-borderless table-cart">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td>Nama</td>
                                        <td>Ukuran</td>
                                        <td class="text-center">Jumlah</td>
                                        <td class="text-center">Harga Produk</td>
                                        <td class="text-center">Total Harga</td>
                                        <td class="text-center"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalPrice = 0
                                    @endphp
                                    @foreach ($carts as $cart)
                                        <tr>
                                            <td style="width: 10%">
                                                @if ($cart->product->galleries->count())
                                                    <img
                                                    src="{{ Storage::url($cart->product->galleries->first()->photos) }}"
                                                    alt=""
                                                    class="cart-image w-100"
                                                    />
                                                @endif
                                            </td>
                                            <td style="width: 20%">
                                                <div class="product-title">{{ $cart->product->name }}</div>
                                                <div class="product-subtitle">{{ $cart->product->category->name }}</div>
                                            </td>
                                            <td style="width: 10%">
                                                <div class="product-title">{{ $cart->size }}</div>
                                            </td>
                                            <td style="width: 20%">
                                                @if ($cart->product->quantity->quantity >= $cart->qty)
                                                    <div class="input-group text-center product-data product-title">
                                                        <button type="submit" class="input-group-text bg-white rounded-0 changeQuantity decrement-btn">-</button>
                                                        <input type="hidden" class="size" value="{{ $cart->size }}">
                                                        <input type="hidden" class="cart_id" value="{{ $cart->id }}">
                                                        <input type="hidden" class="products_id" value="{{ $cart->products_id }}">
                                                        <input type="text" class="form-control bg-white rounded-0 text-center qty-input" value="{{ $cart->qty }}">
                                                        <button type="submit" class="input-group-text bg-white rounded-0 changeQuantity increment-btn">+</button>
                                                    </div>
                                                @elseif ($cart->product->quantity->quantity == '0')
                                                    <p class="text-danger text-center product-title">Persediaan habis.</p>
                                                @else
                                                    <p class="text-danger text-center product-title">Maaf, stok tidak cukup.</p>
                                                @endif
                                            </td>
                                            <td style="width: 20%" class="text-center">
                                                <div class="product-title">{{ number_format($cart->product->price) }}</div>
                                                <div class="product-subtitle">Rupiah</div>
                                            </td>
                                            <td style="width: 20%" class="text-center">
                                                <div class="product-title">{{ number_format($cart->product->price * $cart->qty) }}</div>
                                                <div class="product-subtitle">Rupiah</div>
                                            </td>
                                            <td>
                                                <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning"> Hapus </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @php
                                        $totalPrice += $cart->product->price * $cart->qty
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row" data-aos="fade-up" data-aos-delay="150">
                        <div class="col-12">
                            <div class="row" data-aos="fade-up" data-aos-delay="150">
                                <div class="col-12">
                                    <hr />
                                </div>
                            </div>
                            <div class="row" data-aos="fade-up" data-aos-delay="200">
                                <div class="col-6 col-md-4">
                                    <div class="product-title">Total :</div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div style="font-size: 22px; font-weight: bold;">Rp. {{ number_format($totalPrice ?? 0) }}</div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <a href="{{ route('checkout') }}" class="btn btn-warning mt-4 px-4 btn-block rounded-0">
                                    Checkout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <section class="store-cart">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 text-center p-5 mt-5" data-aos="fade-up" data-aos-delay="100">
                            <h2>Tidak ada produk di Keranjang.</h2>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    })

    $('.increment-btn').click(function (e) {
      e.preventDefault();

      var inc_value = $(this).closest('.product-data').find('.qty-input').val();
      var value = parseInt(inc_value, 10);
      value = isNaN(value) ? 0 : value;
      if(value < 10) {
        value++;
        $(this).closest('.product-data').find('.qty-input').val(value);
      }
    })

     $('.decrement-btn').click(function (e) {
      e.preventDefault();

      var dec_value = $(this).closest('.product-data').find('.qty-input').val();
      var value = parseInt(dec_value, 10);
      value = isNaN(value) ? 0 : value;

      value--;
      $(this).closest('.product-data').find('.qty-input').val(value);

    })

    $('.qty-input').change(function() {
        var size        = $(this).closest('.product-data').find('.size').val();
        var cart_id     = $(this).closest('.product-data').find('.cart_id').val();
        var products_id = $(this).closest('.product-data').find('.products_id').val();
        var quantity    = $(this).closest('.product-data').find('.qty-input').val();

        data = {
            'size' : size,
            'cart_id' : cart_id,
            'products_id' : products_id,
            'quantity' : quantity,
        }

        $.ajax({
            method: 'POST',
            url: 'update-cart',
            data: data,
            success: function (response) {
                if(response.status == 200){

                    $('.success').html(response.message)

                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }

                if(response.status == 400){

                    $('.failed').html(response.message)

                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            }
        })
    })

    $('.changeQuantity').click(function (e) {
      e.preventDefault();

      var size        = $(this).closest('.product-data').find('.size').val();
      var cart_id     = $(this).closest('.product-data').find('.cart_id').val();
      var products_id = $(this).closest('.product-data').find('.products_id').val();
      var quantity    = $(this).closest('.product-data').find('.qty-input').val();

      data = {
        'size' : size,
        'cart_id' : cart_id,
        'products_id' : products_id,
        'quantity' : quantity,
      }

      $.ajax({
        method: 'POST',
        url: 'update-cart',
        data: data,
        success: function (response) {
            if(response.status == 200){

                $('.success').html(response.message)

                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }

            if(response.status == 400){

                $('.failed').html(response.message)

                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        }
      })
    })
  </script>
@endpush
