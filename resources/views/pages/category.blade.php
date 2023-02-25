@extends('layouts.app')

@section('title')
UMKM Universitas Gunadarma
@endsection

@section('content')
    <div class="page-content page-home">
		<section class="store-trend-categories navbar-fixed-top">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 text-center" data-aos="fade-up">
						<h3>KATEGORI</h3>
					</div>
				</div>
				<div class="row align-items-center justify-content-center">
					@php $incrementCategory = 0 @endphp
					@forelse ($categories as $category)
					<div class="col-6 col-md-3 col-lg-2" data-aos="fade-up" data-aos-delay="{{ $incrementCategory += 100 }}">
						<a href="{{ route('categories-detail', $category->slug) }}" class="component-categories d-block">
							<div class="categories-image">
								<p class="categories-text">{{ $category->name }}</p>
							</div>
						</a>
					</div>
					@empty
					<div class="col-12 text-center py-5" data-aos="fade-up">
						<h5>Tidak ada kategori.</h5>
					</div>
					@endforelse
				</div>
			</div>
		</section>

		<section class="store-new-products">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12" data-aos="fade-up">
						<h2 class="mb-3">SEMUA PRODUK</h2>
					</div>
				</div>
				<div class="row">
					@php $incrementProduct = 0 @endphp
					@forelse ($products as $product)
						<div class="col-12 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $incrementProduct += 100 }}">
							<a href="{{ route('detail', $product->slug) }}" class="component-products d-block">
								<div class="products-thumbnail">
									<div class="products-image"
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
				<div class="row">
					<div class="col-12 mt-4">
						{{ $products->links() }}
					</div>
				</div>
			</div>
		</section>
    </div>
@endsection