@extends('layouts.dashboard')

@section('title')
    Dasbor - UMKM Universitas Gunadarma
@endsection

@section('content')
    <div class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Dasbor</h2>
                <p class="dashboard-subtitle">Lihat apa yang telah kamu buat hari ini!</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-6">
                    <div class="card mb-2">
                        <div class="card-body">
                        <div class="dashboard-card-title">Total Pembelian</div>
                        <div class="dashboard-card-subtitle">Rp. {{ number_format($revenue ?? 0) }}</div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="card mb-2">
                        <div class="card-body">
                        <div class="dashboard-card-title">Total Transaksi</div>
                        <div class="dashboard-card-subtitle">{{ $transactions_count }}</div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 mt-2">
                        <h5 class="mb-3">Transaksi Terakhir</h5>
                        @foreach ($transactions_data as $transaction)
                            <a
                            href="{{ route('dashboard-transaction-details', $transaction->id) }}"
                            class="card card-list d-block"
                            >
                                <div class="card-body">
                                <div class="row">
                                    <div class="col-md-1">
                                    <img
                                        src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}"
                                        class="w-75"
                                    />
                                    </div>
                                    <div class="col-md-4">{{ $transaction->product->name ?? '' }}</div>
                                    @if ($transaction->transaction->transaction_status == 'PENDING')
                                        <div class="col-md-3 text-danger">{{ $transaction->transaction->transaction_status }}</div>
                                    @elseif ($transaction->transaction->transaction_status == 'CANCELLED')
                                        <div class="col-md-3 text-danger">{{ $transaction->transaction->transaction_status }}</div>
                                    @else
                                        <div class="col-md-3 text-success">{{ $transaction->transaction->transaction_status }}</div>
                                    @endif
                                    <div class="col-md-3">{{ $transaction->transaction->code ?? '' }}</div>
                                    <div class="col-md-1">
                                    <img src="/images/arrow.svg" alt="" />
                                    </div>
                                </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection