<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title')</title>

    @stack('prepend-style')
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
        <link href="/style/main.css" rel="stylesheet" />
    @stack('addon-style')
  </head>

  <body>
    <div class="page-dashboard">
      <div class="d-flex" id="wrapper" data-aos="fade-right">
        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
          {{-- <div class="sidebar-heading text-center" style="font-size: 100px; font-weight: 700;"> --}}
            {{-- <img src="/images/dashboard-store-logo.svg" alt="" class="my-4" /> --}}
              {{-- B --}}
          {{-- </div> --}}
          <div class="list-group list-group-flush">
            <a
              href="{{ route('home') }}"
              class="list-group-item list-group-item-action"
            >
              HOME
            </a>
            <a
              href="{{ route('info-bidang-lain-teknik-arsitek') }}"
              class="list-group-item list-group-item-action {{ (request()->is('info-bidang-lain-teknik-arsitek')) ? 'active' : '' }}"
            >
              TEKNIK ARSITEKTUR
            </a>
            <a
              href="{{ route('info-bidang-lain-teknik-sipil') }}"
              class="list-group-item list-group-item-action {{ (request()->is('info-bidang-lain-teknik-sipil')) ? 'active' : '' }}"
            >
              TEKNIK SIPIL
            </a>
            <a
              href="{{ route('info-bidang-lain-ilmu-komputer') }}"
              class="list-group-item list-group-item-action {{ (request()->is('info-bidang-lain-ilmu-komputer')) ? 'active' : '' }}"
            >
              ILMU KOMPUTER
            </a>
            <a
              href="{{ route('info-bidang-lain-ilmu-ekonomi-manajemen') }}"
              class="list-group-item list-group-item-action {{ (request()->is('info-bidang-lain-ilmu-ekonomi-manajemen')) ? 'active' : '' }}"
            >
              ILMU EKONOMI - MANAJEMEN
            </a>
            <a
              href="{{ route('info-bidang-lain-ilmu-ekonomi-akuntansi') }}"
              class="list-group-item list-group-item-action {{ (request()->is('info-bidang-lain-ilmu-ekonomi-akuntansi')) ? 'active' : '' }}"
            >
              ILMU EKONOMI - AKUNTANSI
            </a>
            <a
              href="{{ route('info-bidang-lain-agroteknologi') }}"
              class="list-group-item list-group-item-action {{ (request()->is('info-bidang-lain-agroteknologi')) ? 'active' : '' }}"
            >
              AGROTEKNOLOGI
            </a>
            <a
              href="{{ route('info-bidang-lain-ilmu-komunikasi') }}"
              class="list-group-item list-group-item-action {{ (request()->is('info-bidang-lain-ilmu-komunikasi')) ? 'active' : '' }}"
            >
              ILMU KOMUNIKASI
            </a>
            <a
              href="{{ route('info-bidang-lain-teknik-elektro') }}"
              class="list-group-item list-group-item-action {{ (request()->is('info-bidang-lain-teknik-elektro')) ? 'active' : '' }}"
            >
              TEKNIK ELEKTRO
            </a>
            <a
              href="{{ route('info-bidang-lain-teknik-industri') }}"
              class="list-group-item list-group-item-action {{ (request()->is('info-bidang-lain-teknik-industri')) ? 'active' : '' }}"
            >
              TEKNIK INDUSTRI
            </a>
          </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
          <nav
            class="navbar navbar-expand-lg navbar-light navbar-store fixed-top"
            data-aos="fade-down"
          >
            <div class="container-fluid">
              <button
                class="btn btn-secondary d-md-none mr-auto mr-2"
                id="menu-toggle"
              >
                &laquo; Menu
              </button>
              <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarSupportedContent"
              >
                <span class="navbar-toggler-icon"></span>
              </button>
              @auth
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Desktop Menu -->
                <ul class="navbar-nav d-none d-lg-flex ml-auto">
                  <li class="nav-item dropdown">
                    <a
                      href="#"
                      class="nav-link"
                      id="navbarDropdown"
                      role="button"
                      data-toggle="dropdown"
                    >
                      <img
                        src="{{ Avatar::create(Auth::user()->name)->setBackground('#454545')->toBase64() }}"
                        alt=""
                        class="rounded-circle mr-2 profile-picture"
                      />
                      Halo, {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu">
                      <a href="{{ route('cart') }}" class="dropdown-item">KERANJANG</a>
                      <div class="dropdown-divider"></div>
                      <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" class="dropdown-item">KELUAR
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                    </div>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('cart') }}" class="nav-link d-inline-block mt-2">
                        @php
                            $carts = \App\Models\Cart::where('users_id', Auth::user()->id)->count();
                        @endphp
                        @if ($carts > 0)
                            <img src="/images/icon-cart-filled.svg" alt="" />
                            <div class="card-badge">{{ $carts }}</div>
                        @else
                            <img src="/images/icon-cart-empty.svg" alt="" />
                        @endif
                    </a>
                  </li>
                </ul>

                <!-- Mobile Menu -->
                <ul class="navbar-nav d-block d-lg-none">
                  <li class="nav-item">
                    <a href="" class="nav-link text-uppercase"> Halo, {{ Auth::user()->name }} </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('cart') }}" class="nav-link d-inline-block">KERANJANG</a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();" class="nav-link d-inline-block">KELUAR
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                          @csrf
                      </form>
                  </li>
                </ul>
              </div>
              @endauth
            </div>
          </nav>

        <!-- Content -->
        @yield('content')
        
        </div>
      </div>
    </div> 

    <!-- Bootstrap core JavaScript -->
    @stack('prepend-script')
        <script src="/vendor/jquery/jquery.slim.min.js"></script>
        <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
        AOS.init();
        </script>
        <script>
        $("#menu-toggle").click(function (e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
        </script>
    @stack('addon-script')
  </body>
</html>