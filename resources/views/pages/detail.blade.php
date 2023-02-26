@extends('layouts.app')

@section('title')
    Detail Produk - UMKM Universitas Gunadarma
@endsection

@section('content')
    <div class="page-content page-details">
      <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <nav>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                  </li>
                  <li class="breadcrumb-item active">Detail Produk</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </section>

      <section class="store-gallery mb-3" id="gallery">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-8" data-aos="zoom-in">
              <transition name="slide-fade" mode="out-in">
                <img
                  :src="photos[activePhoto].url"
                  :key="photos[activePhoto].id"
                  class="w-100 main-image"
                  alt=""
                />
              </transition>
            </div>
            <div class="col-lg-4">
              <div class="row">
                <div
                  class="col-3 col-lg-6 mt-2 mt-lg-0"
                  v-for="(photo, index) in photos"
                  :key="photo.id"
                  data-aos="zoom-in"
                  data-aos-delay="100"
                >
                  <a href="#" @click="changeActive(index)">
                    <div class="products-image">
                        <img
                        :src="photo.url"
                        class="w-100 products-thumbnail"
                        :class="{ active: index == activePhoto }"
                        alt=""
                      />
                    </div>

                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="store-details-container" data-aos="fade-up">
        <section class="store-heading">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-12">
                <h1>{{ $products->name }}</h1>
                <div class="price">Rp. {{ number_format($products->price) }}</div>
              </div>
            </div>
          </div>
        </section>

        <section class="store-description">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12 col-lg-8">
                {!! $products->description !!}
              </div>
            </div>
          </div>
        </section>

        <section class="store-cart">
          <form method="POST" action="{{ route('detail-add-to-cart', $products->id) }}" enctype="multipart/form-data">
          @csrf
          <div class="container-fluid">
            @auth
              <div class="row">
                <div class="col-12 col-lg-6 mb-3">
                  <strong>PILIH UKURAN :</strong><br>
                  <select name="size" class="form-control rounded-0">
                    @foreach ($products_quantity as $item)
                      <option value="{{ $item->size }}">{{ $item->size }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-12 col-lg-6 mb-3">
                  <strong>Jumlah :</strong><br>
                  <input type="number" name="qty" class="form-control rounded-0" min="1" value="1">
                  @if (session('error'))
                      <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                          {{ session('error') }}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                  @endif
                </div>
              </div>
            @endauth
            <div class="row">
              <div class="col-lg-3" data-aos="zoom-in">
                @auth
                    <button
                      type="submit"
                      class="btn btn-warning px-4 text-white btn-black mb-3"
                    >
                      Masukkan ke Keranjang
                    </button>
                @else
                  <a
                    href="{{ route('login') }}"
                    class="btn btn-warning px-4 text-white btn-black mb-3"
                  >
                    Masuk
                  </a>
                @endauth
              </div>
            </div>
          </div>
          </form>
        </section>

      </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script>
      var gallery = new Vue({
        el: "#gallery",
        mounted() {
          AOS.init();
        },
        data: {
          activePhoto: 0,
          photos: [
            @foreach ($products->galleries as $gallery)
              {
                id: {{ $gallery->id }},
                url: "{{ Storage::url($gallery->photos) }}",
              },
            @endforeach
          ],
        },
        methods: {
          changeActive(id) {
            this.activePhoto = id;
          },
        },
      });
    </script>
@endpush
