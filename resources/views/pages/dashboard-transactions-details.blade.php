@extends('layouts.dashboard')

@section('title')
    Dasbor Detail Transaksi - UMKM Universitas Gunadarma
@endsection

@section('content')
    <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
        <div class="container-fluid">
            <div class="dashboard-heading">
            <h2 class="dashboard-title">{{ $transaction_data->transaction->code }}</h2>
            <p class="dashboard-subtitle">Detail Transaksi</p>
            </div>
            <div class="dashboard-content" id="transactionDetails">
            <div class="row">
                <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <img src="{{ Storage::url($transaction_data->product->galleries->first()->photos ?? '') }}" alt="" class="w-100 mb-3"/>
                        </div>
                        <div class="col-12 col-md-8">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="product-title">Kode Transaksi Detail</div>
                                <div class="product-subtitle">{{ $transaction_data->transaction->code }}</div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-title">Tanggal Transaksi</div>
                                <div class="product-subtitle">{{ date('d-m-Y', strtotime($transaction_data->created_at)) }}</div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-title">Nama Produk</div>
                                <div class="product-subtitle">{{ $transaction_data->product->name }}</div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-title">Ukuran</div>
                                <div class="product-subtitle">{{ $transaction_data->size }}</div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-title">Jumlah</div>
                                <div class="product-subtitle">{{ $transaction_data->qty }}</div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-title">Harga Produk</div>
                                <div class="product-subtitle">Rp. {{ number_format($transaction_data->price) }}</div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-title">Total Harga Produk</div>
                                <div class="product-subtitle">Rp. {{ number_format($transaction_data->total_price) }}</div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-title">Harga Pengiriman</div>
                                <div class="product-subtitle">Rp. {{ number_format($transaction_data->transaction->shipping_price) }}</div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-title">Total Harga Keseluruhan</div>
                                <div class="product-subtitle">Rp. {{ number_format($transaction_data->transaction->total_price) }}</div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="product-title">Status Pembayaran</div>
                                @if ($transaction_data->transaction->transaction_status == 'PENDING')
                                    <div class="product-subtitle text-danger">{{ $transaction_data->transaction->transaction_status }}</div>
                                @else
                                    <div class="product-subtitle text-success">{{ $transaction_data->transaction->transaction_status }}</div>
                                @endif
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-4">
                            <h5>Informasi Pengiriman</h5>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="product-title">Alamat I</div>
                                    <div class="product-subtitle">{{ $transaction_data->transaction->user->address_one }}</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="product-title">Alamat II</div>
                                    <div class="product-subtitle">{{ $transaction_data->transaction->user->address_two }}</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="product-title">Provinsi</div>
                                    <div class="product-subtitle">{{ $transaction_data->transaction->user->province->name ?? ''}}</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="product-title">Kota</div>
                                    <div class="product-subtitle">{{ $transaction_data->transaction->user->regencies->name ?? ''}}</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="product-title">Kode Pos</div>
                                    <div class="product-subtitle">{{ $transaction_data->transaction->user->zip_code }}</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="product-title">Negara</div>
                                    <div class="product-subtitle">{{ $transaction_data->transaction->user->country }}</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="product-title">Kurir</div>
                                    <div class="product-subtitle">{{ $transaction_data->courier }}</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="product-title">Service</div>
                                    <div class="product-subtitle">{{ $transaction_data->service }}</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="product-title">Status Pengiriman</div>
                                @if ($transaction_data->shipping_status == 'PENDING')
                                    <div class="product-subtitle text-danger">{{ $transaction_data->shipping_status }}</div>
                                @elseif ($transaction_data->shipping_status == 'SHIPPING')
                                    <div class="product-subtitle text-primary">{{ $transaction_data->shipping_status }}</div>
                                @else
                                    <div class="product-subtitle text-success">{{ $transaction_data->shipping_status }}</div>
                                @endif
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="product-title">Resi</div>
                                    <div class="product-subtitle">{{ $transaction_data->resi }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 text-right">
                            @if ($transaction_data->shipping_status == 'SHIPPING')
                                {{-- <a href="{{ route('received-order', $transaction_data->transactions_id) }}" class="btn btn-warning text-white btn-lg mt-4">
                                    Pesanan Diterima
                                </a> --}}
                                <form action="{{ route('received-order', $transaction_data->transactions_id) }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <button type="submit" class="btn btn-warning text-white btn-lg mt-4">
                                        Pesanan Diterima
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('dashboard-transaction') }}" class="btn btn-dark btn-lg mt-4">
                                Kembali
                            </a>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

{{-- @push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script>
      var transactionDetails = new Vue({
        el: "#transactionDetails",
        data: {
          status: "SHIPPING",
          resi: "0101010101",
        },
      });
    </script>
@endpush --}}