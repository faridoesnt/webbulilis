@extends('layouts.app')

@section('title')
    Seeowrens
@endsection

@section('content')
    <div class="page-content page-home">
        <section class="store-carousel">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12" data-aos="zoom-in">
                        <div class="carousel slide" id="storeCarousel" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li class="active" data-target="#storeCarousel" data-slide-to="0"></li>
                                <li data-target="#storeCarousel" data-slide-to="1"></li>
                                <li data-target="#storeCarousel" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="/images/baner1.png" alt="Carousel Image" class="d-block w-100"/>
                                </div>
                                <div class="carousel-item">
                                    <img src="/images/baner2.png" alt="Carousel Image" class="d-block w-100"/>
                                </div>
                                <div class="carousel-item">
                                    <img src="/images/baner3.png" alt="Carousel Image" class="d-block w-100"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="store-new-products mt-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12" data-aos="fade-up">
                        <h1 class="mb-3">PRODUK TERBARU</h1>
                    </div>
                </div>
                <div class="row">
                    @php $incrementProduct = 0 @endphp
                    @forelse ($products as $product)
                        <div
                        class="col-12 col-md-4 col-lg-3"
                        data-aos="fade-up"
                        data-aos-delay="{{ $incrementProduct += 100 }}"
                        >
                            <a href="{{ route('detail', $product->slug) }}" class="component-products d-block">
                            <div class="products-thumbnail">
                                <div
                                class="products-image"
                                style="
                                    @if($product->galleries->count())
                                        background-image: url('{{ Storage::url($product->galleries->first()->photos) }}')
                                    @else
                                        background-color: #eee
                                    @endif
                                "
                                ></div>
                            </div>
                            <div class="products-text">{{ $product->name }}</div>
                            <div class="products-price">{{ number_format($product->price) }}</div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5" data-aos="fade-up">
                            <h5>Tidak ada produk.</h5>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection