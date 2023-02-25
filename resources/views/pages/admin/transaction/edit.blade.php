@extends('layouts.admin')

@section('title')
    Admin - Transaksi - UMKM Universitas Gunadarma
@endsection

@section('content')
    <div
            class="section-content section-dashboard-home"
            data-aos="fade-up"
          >
        <div class="container-fluid">
            <div class="dashboard-heading">
            <h2 class="dashboard-title">Transaksi</h2>
            <p class="dashboard-subtitle">Sunting Transaksi</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('transactions.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Kode</label>
                                                <input class="form-control" value="{{ $item->transaction->code }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Produk</label>
                                                <input class="form-control" value="{{ $item->product->name }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Ukuran</label>
                                                <input class="form-control" value="{{ $item->size }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Jumlah</label>
                                                <input class="form-control" value="{{ $item->qty }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Harga Produk</label>
                                                <input class="form-control" value="{{ number_format($item->price) }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Total Harga Produk</label>
                                                <input class="form-control" value="{{ number_format($item->total_price) }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Harga Pengiriman</label>
                                                <input class="form-control" value="{{ number_format($item->transaction->shipping_price) }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Total Harga</label>
                                                <input class="form-control" value="{{ number_format($item->transaction->total_price) }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Kurir</label>
                                                <input class="form-control" value="{{ $item->courier }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Service</label>
                                                <input class="form-control" value="{{ $item->service }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Status Pembayaran</label>
                                                <input class="form-control" value="{{ $item->transaction->transaction_status }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Resi</label>
                                                @if ($item->shipping_status == 'PENDING')
                                                    <input type="text" name="resi" class="form-control" value="{{ $item->resi }}">
                                                @elseif ($item->shipping_status == 'SHIPPING')
                                                    <input class="form-control" value="{{ $item->resi }}" disabled>
                                                @else
                                                    <input class="form-control" value="{{ $item->resi }}" disabled>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Status Pengiriman</label>
                                                <select name="shipping_status" class="form-control">
                                                    @if ($item->shipping_status == 'PENDING')
                                                        <option value="{{ $item->shipping_status }}" selected>{{ $item->shipping_status }}</option>
                                                        <option value="SHIPPING">SHIPPING</option>
                                                    @elseif ($item->shipping_status == 'SHIPPING')
                                                        <option value="{{ $item->shipping_status }}" selected>{{ $item->shipping_status }}</option>
                                                        <option value="SUCCESS">SUCCESS</option>
                                                    @else
                                                        <option selected disabled>{{ $item->shipping_status }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-dark px-5">
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection