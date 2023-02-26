@extends('layouts.auth')

@section('title')
    Daftar - UMKM Universitas Gunadarma
@endsection

@section('content')

    <div class="page-content page-auth" id="register">
      <div class="section-store-auth" data-aos="fade-up">
        <div class="container">
          <div class="row align-items-center justify-content-center row-login">
            <div class="col-10 col-md-4 col-lg-6">
              <div class="card shadow">
                <div class="card-header bg-dark">
                  <h2 class="text-center text-white mt-2"><strong>Daftar</strong></h2>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                      <label>Nama Lengkap</label>
                      <input id="name"
                            type="text"
                            v-model="name"
                            class="form-control rounded-0 @error('name') is-invalid @enderror"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autofocus>
                      @error('name')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input id="email"
                            v-model="email"
                            @change="checkForEmailAvailability()"
                            type="email"
                            class="form-control rounded-0 @error('email') is-invalid @enderror"
                            :class="{ 'is-valid' : this.email_unavailable }"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email">
                      @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input id="password"
                            type="password"
                            class="form-control rounded-0 @error('password') is-invalid @enderror"
                            name="password"
                            required
                            autocomplete="new-password">
                      @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label>Konfirmasi Password</label>
                      <input id="password-confirm"
                            type="password"
                            class="form-control rounded-0 @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation"
                            required
                            autocomplete="new-password">
                      @error('password_confirmation')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <button
                      type="submit"
                      class="btn btn-warning btn-block mt-4 rounded-0"
                      :disabled="this.email_unavailable"
                    >
                      Daftar
                    </button>
                    <small class="btn btn-block" style="font-size: 13px; color: #aaa; cursor: text;">
                          Sudah punya akun? <a href="{{ route('login') }}" style="text-decoration: none; color: black;">Masuk</a>
                    </small>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
      Vue.use(Toasted);

      var register = new Vue({
        el: "#register",
        mounted() {
          AOS.init();
        },
        methods: {
          checkForEmailAvailability: function() {
            var self = this;
            axios.get('{{ route('api-register-check') }}', {
                    params: {
                      email: this.email
                    }
                  })
                  .then(function (response) {
                    if(response.data == 'Available'){
                        self.$toasted.error(
                          "Email anda tersedia!",
                          {
                            position: "top-center",
                            className: "rounded",
                            duration: 1000,
                          }
                        );
                        self.email_unavailable = false;
                    } else {
                        self.$toasted.error(
                          "Maaf, email sudah terdaftar",
                          {
                            position: "top-center",
                            className: "rounded",
                            duration: 1000,
                          }
                        );
                        self.email_unavailable = true;
                    }
                  });
          }
        },
        data() {
          return {
            email_unavailable: false,
          }
        },
      });
    </script>
@endpush
