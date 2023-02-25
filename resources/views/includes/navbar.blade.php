<nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top" data-aos="fade-down">
    <div class="container-fluid">
        <a href="{{ route('home') }}" class="navbar-brand">
                UMKM - Markisa
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">HOME</a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('categories') }}" class="nav-link"><strong>KATEGORI</strong></a>
                </li> --}}
            </ul>
            @guest
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="nav-link">DAFTAR</a>
                </li>
                <li class="nav-item">
                    <a
                    href="{{ route('login') }}"
                    class="btn btn-dark nav-link px-4 text-white rounded-0"
                    >MASUK</a
                >
                </li>
            </ul>
            @endguest

            @auth
                <ul class="navbar-nav d-none d-lg-flex">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" id="navbarDropdown" role="button" data-toggle="dropdown">
                            <img
                                src="{{ Avatar::create(Auth::user()->name)->setBackground('#454545')->toBase64() }}"
                                alt=""
                                class="rounded-circle mr-2 profile-picture"
                            />
                            Hi, {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu">
                            @can('isAdmin')
                                <a href="{{ route('admin-dashboard') }}" class="dropdown-item">Dasbor Admin</a>
                                <div class="dropdown-divider"></div>
                            @endcan
                            <a href="{{ route('dashboard') }}" class="dropdown-item">Dasbor</a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="dropdown-item">Keluar
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
                        <a href="{{ route('dashboard') }}" class="nav-link d-inline-block">DASBOR</a>
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
            @endauth
        </div>
    </div>
</nav>
