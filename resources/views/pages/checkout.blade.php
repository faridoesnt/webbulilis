@extends('layouts.app')

@section('title')
    Checkout - UMKM Universitas Gunadarma
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
                                <li class="breadcrumb-item active">Checkout</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        @if ($carts->count())
            <section class="store-cart">
                <form action="{{ route('checkout-proses') }}" id="locations" enctype="multipart/form-data" method="POST">
                @csrf
                    <div class="container-fluid">
                        @php
                            $productPrice = 0
                        @endphp
                        <div class="row" data-aos="fade-up" data-aos-delay="200">
                            <div class="col-12 col-lg-6">
                                <div class="row">
                                    <div class="col-12">
                                        <h2>Detail Pengiriman</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="adress_one">Alamat I</label>
                                                    <input
                                                        type="text"
                                                        class="form-control rounded-0"
                                                        id="address_one"
                                                        name="address_one"
                                                        value="{{ Auth::user()->address_one }}"
                                                        required
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="address_two">Alamat II</label>
                                                    <input
                                                        type="text"
                                                        class="form-control rounded-0"
                                                        id="address_two"
                                                        name="address_two"
                                                        value="{{ Auth::user()->address_two }}"
                                                        required
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label for="provinces_id">Provinsi</label>
                                                <select class="form-control provinsi-asal" name="province_origin" required>
                                                    <option selected disabled>-- Pilih Provinsi --</option>
                                                    @foreach ($provinces as $province => $value)
                                                        <option value="{{ $province  }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label for="regencies_id">Kota</label>
                                                <select class="form-control kota-asal" id="select-kota" name="city_origin" required>
                                                    <option selected disabled>-- Pilih Kota --</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                <label for="zip_code">Kode Pos</label>
                                                <input
                                                    type="text"
                                                    class="form-control rounded-0"
                                                    id="zip_code"
                                                    name="zip_code"
                                                    value="{{ Auth::user()->zip_code }}"
                                                    required
                                                />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="country">Negara</label>
                                                <input
                                                    type="text"
                                                    class="form-control rounded-0"
                                                    id="country"
                                                    name="country"
                                                    value="{{ Auth::user()->country }}"
                                                    required
                                                />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="phone_number">Nomor HP</label>
                                                <input
                                                    type="text"
                                                    class="form-control rounded-0"
                                                    id="phone_number"
                                                    name="phone_number"
                                                    value="{{ Auth::user()->phone_number }}"
                                                    required
                                                />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group d-none">
                                                    <label>PROVINSI TUJUAN</label>
                                                    <select class="form-control provinsi-tujuan" name="province_destination">
                                                        @foreach ($provinces2 as $province)
                                                            <option value="{{ $province->province_id  }}">{{ $province->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group d-none">
                                                    <label>KOTA / KABUPATEN TUJUAN</label>
                                                    <select class="form-control kota-tujuan" name="city_destination">
                                                        @foreach ($cities2 as $city)
                                                            <option value="{{ $city->city_id  }}">{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="row">
                                    <div class="col-12">
                                        <h2>Detail Produk</h2>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-borderless table-cart">
                                            <thead>
                                                <tr>
                                                    <td>Nama</td>
                                                    <td>Ukuran</td>
                                                    <td class="text-center">Jumlah</td>
                                                    <td class="text-center">Harga Produk</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $productPrice = 0
                                                @endphp
                                                @foreach ($carts as $cart)
                                                    <tr>
                                                        <td style="width: 20%">
                                                            <div class="product-title">{{ $cart->product->name }}</div>
                                                            <div class="product-subtitle">{{ $cart->product->category->name }}</div>
                                                        </td>
                                                        <td style="width: 10%">
                                                            <div class="product-title">{{ $cart->size }}</div>
                                                        </td>
                                                        <td style="width: 20%" class="text-center">
                                                            <div class="product-title">{{ $cart->qty }}</div>
                                                        </td>
                                                        <td style="width: 20%" class="text-center">
                                                            <div class="product-title">{{ number_format($cart->product->price) }}</div>
                                                            <div class="product-subtitle">Rupiah</div>
                                                        </td>
                                                    </tr>
                                                    @php
                                                    $productPrice += $cart->product->price * $cart->qty
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" data-aos="fade-up" data-aos-delay="150">
                            <div class="col-12">
                                <h2>Opsi Pengiriman</h2>
                            </div>
                            <div class="col-12 mb-2">
                                <hr>
                            </div>
                        </div>
                        <div class="row"  data-aos="fade-up" data-aos-delay="150">
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <select class="form-control kurir" id="select_kurir" name="courier" required>
                                        <option selected disabled>-- Pilih Opsi Pengiriman --</option>
                                        <option value="jne">JNE</option>
                                        <option value="pos">POS</option>
                                        <option value="tiki">TIKI</option>
                                        <option value="COD">Datang Ke Lokasi Kami</option>
                                        <option value="GOJEK">Gojek</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 d-none">
                                <div class="form-group">
                                    <label>Weight (GRAM)</label>
                                    <input type="number" class="form-control" name="weight" id="weight" value="1000" placeholder="Masukkan Berat (GRAM)">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row plans" id="ongkir">

                                </div>
                            </div>
                        </div>
                        <div class="row" data-aos="fade-up" data-aos-delay="150">
                            <div class="col-12">
                                <h2>Informasi Pembayaran</h2>
                            </div>
                            <div class="col-12 mb-2">
                                <hr>
                            </div>
                        </div>
                        <div class="row" data-aos="fade-up" data-aos-delay="150">
                            <input type="hidden" name="product_price" id="product_price" value="{{ $productPrice }}">
                            <div class="col-4 col-md-3">
                                <div class="product-title" name="product_price">Rp. {{ number_format($productPrice ?? 0) }}</div>
                                <div class="product-subtitle">Total Harga Produk</div>
                            </div>
                            <div class="col-4 col-md-2">
                                <input type="hidden" name="shipping_price" id="shipping_price">
                                <div class="product-title" id="shipping">Rp. 0</div>
                                <div class="product-subtitle">Harga Pengiriman</div>
                            </div>
                            <div class="col-4 col-md-6 text-right">
                                <input type="hidden" name="total_price" id="total_price">
                                <div class="product-title text-success" id="total">Rp. {{ number_format($productPrice ?? 0) }}</div>
                                <div class="product-subtitle">Total Harga</div>
                            </div>
                            <div class="col-12">
                                <div id="service"></div>
                            </div>
                            <div class="col-12">
                                <button type="submit" id="btn-checkout" class="btn btn-warning mt-4 px-4 btn-block rounded-0">
                                Lanjutkan Pembayaran
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        @else
            <section class="store-cart">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 text-center p-5 mt-5" data-aos="fade-up" data-aos-delay="100">
                            <h1>Tidak ada data.</h1>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){

            document.getElementById("select-kota").disabled=true
            document.getElementById("select_kurir").disabled=true
            document.getElementById("btn-checkout").disabled=true

            //ajax select kota asal
            $('select[name="province_origin"]').on('change', function () {
                document.getElementById("select-kota").disabled=false
                let provindeId = $(this).val();
                if (provindeId) {
                    jQuery.ajax({
                        url: '/cities/'+provindeId,
                        // url: '{!!URL::to('cities')!!}',
                        // data: {'id':provindeId},
                        type: "GET",
                        dataType: "json",
                        success: function (response) {
                            $('select[name="city_origin"]').empty();
                            $('select[name="city_origin"]').append('<option selected disabled>-- Pilih Kota --</option>');
                            $.each(response, function (key, value) {
                                $('select[name="city_origin"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    $('select[name="city_origin"]').append('<option value="">-- pilih kota asal --</option>');
                }
            });

            $('select[name="city_origin"]').on('change', function () {
                document.getElementById("select_kurir").disabled=false
            });


            //ajax check ongkir
            let isProcessing     = false;
            $('.kurir').change(function (e) {
                e.preventDefault();
                // document.getElementById("btn-checkout").disabled=false

                let token            = $("meta[name='csrf-token']").attr("content");
                let city_origin      = $('select[name=city_origin]').val();
                let city_destination = $('select[name=city_destination]').val();
                let courier          = $('select[name=courier]').val();
                let weight           = $('#weight').val();

                if(isProcessing){
                    return ;
                }

                if(courier == 'jne')
                {
                    document.getElementById("btn-checkout").disabled=true

                    let shipping_price = 0
                    let product_price = $('#product_price').val();

                    document.getElementById("shipping").innerHTML = shipping_price;
                    document.getElementById("shipping_price").value = shipping_price;
                    document.getElementById("total_price").value = product_price;
                    document.getElementById("total").innerHTML = product_price;

                    isProcessing = true;
                    jQuery.ajax({
                        url: '/ongkir',
                        data: {
                            _token:              token,
                            city_origin:         city_origin,
                            city_destination:    city_destination,
                            courier:             courier,
                            weight:              weight,
                        },
                        dataType: "JSON",
                        type: "POST",
                        success: function (response) {
                            isProcessing = false;
                            if (response) {
                                $('#ongkir').empty();
                                $('.ongkir').addClass('d-block');
                                var html = "";
                                $.each(response[0]['costs'], function (key, value) {
                                    html += `
                                            <label class="col-12 col-md-6 col-lg-4 plan basic-plan" for="${value.service}">
                                                <input type="radio" name="cost" id="${value.service}" class="cost" value="${value.cost[0].value}" required>
                                                <input type="radio" class="service" name="service" data-index="0" value="${value.service}" required>
                                                <div class="plan-content">
                                                    <div class="plan-details">
                                                        <span>${value.service}</span>
                                                        <p>${value.description}<br>Rp. ${value.cost[0].value}<br>${value.cost[0].etd} Hari</p>
                                                    </div>
                                                </div>
                                            </label>
                                            `;
                                    $('#ongkir').html(html);

                                    jQuery(document).ready(function () {

                                        jQuery('.cost').on('click',function(){

                                            var indx = jQuery(this).index('.cost');

                                            jQuery('.service')[indx].click();

                                            document.getElementById("btn-checkout").disabled=false

                                            var product_price = $("input[name='product_price']").val();
                                            var shipping_price = $("input[name='cost']:checked").val();
                                            var total_price = parseInt(product_price) + parseInt(shipping_price);

                                            if(total_price){
                                                document.getElementById("shipping").innerHTML = shipping_price;
                                                document.getElementById("shipping_price").value = shipping_price;
                                                document.getElementById("total").innerHTML = total_price;
                                                document.getElementById("total_price").value = total_price;
                                            }
                                        })
                                    });

                                });
                            }
                        }
                    });
                }
                else
                {
                    if(courier == 'pos')
                    {

                        document.getElementById("btn-checkout").disabled=true

                        let shipping_price = 0
                        let product_price = $('#product_price').val();

                        document.getElementById("shipping").innerHTML = shipping_price;
                        document.getElementById("shipping_price").value = shipping_price;
                        document.getElementById("total_price").value = product_price;
                        document.getElementById("total").innerHTML = product_price;

                        isProcessing = true;
                        jQuery.ajax({
                            url: '/ongkir',
                            data: {
                                _token:              token,
                                city_origin:         city_origin,
                                city_destination:    city_destination,
                                courier:             courier,
                                weight:              weight,
                            },
                            dataType: "JSON",
                            type: "POST",
                            success: function (response) {
                                isProcessing = false;
                                if (response) {
                                    $('#ongkir').empty();
                                    $('.ongkir').addClass('d-block');
                                    var html = "";
                                    $.each(response[0]['costs'], function (key, value) {
                                        html += `
                                            <label class="col-12 col-md-6 col-lg-4 plan basic-plan" for="${value.service}">
                                                <input type="radio" name="cost" id="${value.service}" class="cost" value="${value.cost[0].value}" required>
                                                <input type="radio" class="service" name="service" data-index="0" value="${value.service}" required>
                                                <div class="plan-content">
                                                    <div class="plan-details">
                                                        <span>${value.service}</span>
                                                        <p>${value.description}<br>Rp. ${value.cost[0].value}<br>${value.cost[0].etd} Hari</p>
                                                    </div>
                                                </div>
                                            </label>
                                            `;
                                        $('#ongkir').html(html);

                                        jQuery(document).ready(function () {

                                            jQuery('.cost').on('click',function(){

                                                var indx = jQuery(this).index('.cost');

                                                jQuery('.service')[indx].click();

                                                document.getElementById("btn-checkout").disabled=false

                                                var product_price = $("input[name='product_price']").val();
                                                var shipping_price = $("input[name='cost']:checked").val();
                                                var total_price = parseInt(product_price) + parseInt(shipping_price);

                                                if(total_price){
                                                    document.getElementById("shipping").innerHTML = shipping_price;
                                                    document.getElementById("shipping_price").value = shipping_price;
                                                    document.getElementById("total").innerHTML = total_price;
                                                    document.getElementById("total_price").value = total_price;
                                                }
                                            })
                                        });

                                    });
                                }
                            }
                        });
                    }
                    else
                    {
                        if(courier == 'tiki')
                        {

                            document.getElementById("btn-checkout").disabled=true

                            let shipping_price = 0
                            let product_price = $('#product_price').val();

                            document.getElementById("shipping").innerHTML = shipping_price;
                            document.getElementById("shipping_price").value = shipping_price;
                            document.getElementById("total_price").value = product_price;
                            document.getElementById("total").innerHTML = product_price;


                            isProcessing = true;
                            jQuery.ajax({
                                url: '/ongkir',
                                data: {
                                    _token:              token,
                                    city_origin:         city_origin,
                                    city_destination:    city_destination,
                                    courier:             courier,
                                    weight:              weight,
                                },
                                dataType: "JSON",
                                type: "POST",
                                success: function (response) {
                                    isProcessing = false;
                                    if (response) {
                                        $('#ongkir').empty();
                                        $('.ongkir').addClass('d-block');
                                        var html = "";
                                        $.each(response[0]['costs'], function (key, value) {
                                            html += `
                                                <label class="col-12 col-md-6 col-lg-4 plan basic-plan" for="${value.service}">
                                                    <input type="radio" name="cost" id="${value.service}" class="cost" value="${value.cost[0].value}" required>
                                                    <input type="radio" class="service" name="service" data-index="0" value="${value.service}" required>
                                                    <div class="plan-content">
                                                        <div class="plan-details">
                                                            <span>${value.service}</span>
                                                            <p>${value.description}<br>Rp. ${value.cost[0].value}<br>${value.cost[0].etd} Hari</p>
                                                        </div>
                                                    </div>
                                                </label>
                                                `;
                                            $('#ongkir').html(html);

                                            jQuery(document).ready(function () {

                                                jQuery('.cost').on('click',function(){

                                                    var indx = jQuery(this).index('.cost');

                                                    jQuery('.service')[indx].click();

                                                    document.getElementById("btn-checkout").disabled=false

                                                    var product_price = $("input[name='product_price']").val();
                                                    var shipping_price = $("input[name='cost']:checked").val();
                                                    var total_price = parseInt(product_price) + parseInt(shipping_price);

                                                    if(total_price){
                                                        document.getElementById("shipping").innerHTML = shipping_price;
                                                        document.getElementById("shipping_price").value = shipping_price;
                                                        document.getElementById("total").innerHTML = total_price;
                                                        document.getElementById("total_price").value = total_price;
                                                    }
                                                })
                                            });

                                        });
                                    }
                                }
                            });
                        }
                        else
                        {
                            if(courier == 'COD')
                            {
                                let shipping_price = 0
                                let product_price = $('#product_price').val();

                                document.getElementById("btn-checkout").disabled=false

                                document.getElementById("shipping").innerHTML = shipping_price;
                                document.getElementById("shipping_price").value = shipping_price;
                                document.getElementById("total_price").value = product_price;
                                document.getElementById("total").innerHTML = product_price;
                                $('#ongkir').empty();

                                var html = "";
                                html += `
                                        <div class="col-12 text-center mt-2">
                                            Setelah pembayaran berhasil, silahkan datang ke lokasi kami dengan menunjukkan kode transaksi.
                                        </div>`
                                $('#ongkir').html(html);
                            }
                            else
                            {
                                if(courier == 'GOJEK')
                                {
                                    let shipping_price = 0
                                    let product_price = $('#product_price').val();

                                    document.getElementById("btn-checkout").disabled=false

                                    document.getElementById("shipping").innerHTML = shipping_price;
                                    document.getElementById("shipping_price").value = shipping_price;
                                    document.getElementById("total_price").value = product_price;
                                    document.getElementById("total").innerHTML = product_price;
                                    $('#ongkir').empty();

                                    var html = "";
                                    html += `
                                            <div class="col-12 text-center mt-2">
                                                Setelah pembayaran berhasil, kami akan mengirimkan pesan kepada Anda melalui WhatsApp untuk menginformasikan tentang kurir Gojek.<br>
                                                <strong>Catatan : Biaya kurir Gojek di tanggung pembeli.<br></strong>
                                                <div class="text-warning"><strong>Peringatan : Maksimal 15km dari lokasi kami.</strong></div>
                                            </div>`
                                    $('#ongkir').html(html);
                                }
                            }
                        }
                    }
                }
            });

        });
    </script>
@endpush
